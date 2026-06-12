<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundraiserRequest;
use App\Models\Fundraiser;
use Illuminate\Support\Str;

// Controller, ktory zarzadza wyswietlaniem - w skrocie

// Wyświetlanie
class FundraiserController extends Controller
{
    public function index()
    {
        // Taki entity framework ale w laravelu
        $fundraisers = Fundraiser::with('animal')
            ->where('status', 1)
            ->latest()
            ->paginate(12);

        // Zwrot vidoku blade
        return view('fundraisers.index', compact('fundraisers'));
    }

    // Towrzenie
    public function store(StoreFundraiserRequest $request)
    {
        // petla ktora sprawdza czy dany qrkod juz nie jest w bazie, generuje dopoki nie bedzie unikalny, taki o smaczek
        do {
            $qrToken = Str::random(32);
        } while (Fundraiser::where('qr_token', $qrToken)->exists());

        // tworzymy nowa zbiore piekna
        $fundraiser = Fundraiser::create([
            'animal_id' => $request->animal_id,
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'collected_amount' => 0.00,
            'qr_token' => $qrToken,
            'status' => 1,
            'end_date' => $request->end_date,
        ]);

        // Tak jak wczesniej papka dla przegladarki z kodem 201
        return response()->json([
            'message' => 'Zbiórka została utworzona pomyślnie',
            'fundraiser' => $fundraiser,
        ], 201);
    }

    // Pojedyncz zbiorka w sumie
    public function show(Fundraiser $fundraiser)
    {
        // Sciaganie Eager
        $fundraiser->load(['animal', 'donations.user']);

        // compact to jak prasa hydrauliczna, bierze se obiekt i se go wrzuca do widoku
        return view('fundraisers.show', compact('fundraiser'));
    }
}
