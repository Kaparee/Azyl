<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(15);
        $roles = Role::all();

        return view('users.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update(['role_id' => $validated['role_id']]);

        return back()->with('success', 'Rola użytkownika została zaktualizowana.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Nie możesz usunąć własnego konta!');
        }
        
        $user->delete();

        return back()->with('success', 'Użytkownik został usunięty.');
    }

    public function exportCsv()
    {
        $users = User::with('role')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=uzytkownicy_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Imie / Nazwa', 'Email', 'Rola', 'Data Rejestracji'];

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, $columns, ';');

            foreach ($users as $user) {
                $row['ID']  = $user->id;
                $row['Imie / Nazwa']    = $user->name;
                $row['Email']    = $user->email;
                $row['Rola']  = $user->role->name ?? 'Brak';
                $row['Data Rejestracji']  = $user->created_at->format('Y-m-d');

                fputcsv($file, array($row['ID'], $row['Imie / Nazwa'], $row['Email'], $row['Rola'], $row['Data Rejestracji']), ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
