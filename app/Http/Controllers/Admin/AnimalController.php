<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AnimalStatus;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalImage;
use App\Models\Breed;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnimalController extends Controller
{
    /**
     * Lista w panelu admina — liczniki statusów są tu, żeby kafelki nie robiły osobnych zapytań w widoku.
     */
    public function index(Request $request)
    {
        $query = Animal::with(['breed.species', 'animalImages.image']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('breed', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhereHas('species', function($q2) use ($request) {
                            $q2->where('name', 'like', '%' . $request->search . '%');
                        });
                  });
        }

        $animals = $query->paginate(10)->withQueryString();

        $animals->getCollection()->transform(function (Animal $animal) {
            $animal->setAttribute('photo_url', \App\Support\AnimalPresenter::photoUrl($animal));

            return $animal;
        });

        return view('admin.animals.index', [
            'animals' => $animals,
            'availableCount' => Animal::where('status', AnimalStatus::AVAILABLE)->count(),
            'pendingCount' => Animal::where('status', AnimalStatus::PENDING)->count(),
            'adoptedCount' => Animal::where('status', AnimalStatus::ADOPTED)->count(),
            'unavailableCount' => Animal::where('status', AnimalStatus::UNAVAILABLE)->count(),
        ]);
    }

    /** Formularz dodawania — enum statusów przekazujemy z PHP, żeby Blade nie hardkodował wartości. */
    public function create()
    {
        return view('admin.animals.create', [
            'breeds' => Breed::with('species')->get(),
            'statuses' => AnimalStatus::cases(),
        ]);
    }

    public function store(Request $request)
    {
        // Walidacja w kontrolerze — na razie bez osobnej klasy Request, żeby nie mnożyć plików.
        $data = $request->validate([
            'name' => 'required|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'age_months' => 'required|integer|min:0',
            'genders' => 'required|integer|in:0,1',
            'height' => 'required|integer|min:0',
            'color' => 'required|max:255',
            'description' => 'required',
            'medical_info' => 'nullable',
            'adoption_fee' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1,2,3',
            'arrival_date' => 'required|date',
            'images.*' => 'nullable|image|max:5120',
        ]);

        unset($data['images']);

        // Token QR od razu przy tworzeniu — bez niego link do profilu ze skanera by nie działał.
        do {
            $token = Str::random(16);
        } while (Animal::where('qr_token', $token)->exists());

        $data['qr_token'] = $token;

        $animal = Animal::create($data);

        // Zdjęcia po utworzeniu zwierzęcia — najpierw musi istnieć rekord, żeby powiązać pliki.
        if ($request->hasFile('images')) {
            $nr = 1;

            foreach ($request->file('images') as $file) {
                $path = $file->store('animals', 'public');

                $image = Image::create([
                    'animal_id' => $animal->id,
                    'file_name' => $path,
                    'original_file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);

                AnimalImage::create([
                    'animal_id' => $animal->id,
                    'image_id' => $image->id,
                    'sort_order' => $nr,
                ]);

                $nr++;
            }
        }

        return redirect()->route('admin.animals.index')->with('status', 'Dodano zwierzę.');
    }

    /** Edycja ładuje powiązane zdjęcia — widok potrzebuje ich do podglądu i zmiany kolejności. */
    public function edit(Animal $animal)
    {
        $animal->load('animalImages.image');

        return view('admin.animals.edit', [
            'animal' => $animal,
            'breeds' => Breed::with('species')->get(),
            'statuses' => AnimalStatus::cases(),
        ]);
    }

    public function update(Request $request, Animal $animal)
    {
        // Te same pola co przy dodawaniu — jeden zestaw reguł, mniej rozjazdów między formularzami.
        $data = $request->validate([
            'name' => 'required|max:255',
            'breed_id' => 'required|exists:breeds,id',
            'age_months' => 'required|integer|min:0',
            'genders' => 'required|integer|in:0,1',
            'height' => 'required|integer|min:0',
            'color' => 'required|max:255',
            'description' => 'required',
            'medical_info' => 'nullable',
            'adoption_fee' => 'required|numeric|min:0',
            'status' => 'required|integer|in:0,1,2,3',
            'arrival_date' => 'required|date',
            'images.*' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|array',
            'sort_order.*' => 'nullable|integer|min:0',
        ]);

        unset($data['images'], $data['sort_order']);

        if ($data['status'] != $animal->status->value) {
            // Nie wracamy na „dostępne”, gdy są oczekujące wnioski — unikamy podwójnej adopcji.
            $pendingApplicationsCount = $animal->adoptionApplications()->where('status', \App\Enums\AdoptionStatus::PENDING)->count();
            if ($pendingApplicationsCount > 0 && $data['status'] == \App\Enums\AnimalStatus::AVAILABLE->value) {
                return redirect()->back()->withErrors(['status' => 'Nie można zmienić na Dostępne - zwierzę ma oczekujące wnioski o adopcję.']);
            }
        }

        $animal->update($data);

        // Kolejność zdjęć z formularza — użytkownik ustawia ją ręcznie, nie po dacie uploadu.
        if ($request->sort_order) {
            foreach ($request->sort_order as $animalImageId => $order) {
                AnimalImage::where('animal_id', $animal->id)
                    ->where('id', $animalImageId)
                    ->update(['sort_order' => $order ?: 0]);
            }
        }

        // Nowe pliki dopisujemy na koniec — nie nadpisujemy istniejących zdjęć w galerii.
        if ($request->hasFile('images')) {
            $nr = AnimalImage::where('animal_id', $animal->id)->max('sort_order');
            $nr = $nr ? $nr + 1 : 1;

            foreach ($request->file('images') as $file) {
                $path = $file->store('animals', 'public');

                $image = Image::create([
                    'animal_id' => $animal->id,
                    'file_name' => $path,
                    'original_file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                ]);

                AnimalImage::create([
                    'animal_id' => $animal->id,
                    'image_id' => $image->id,
                    'sort_order' => $nr,
                ]);

                $nr++;
            }
        }

        return redirect()->route('admin.animals.index')->with('status', 'Zapisano zwierzę.');
    }

    /** Usunięcie rekordu — relacje w bazie (zdjęcia, wnioski) obsługuje model przez cascade. */
    public function destroy(Animal $animal)
    {
        $animal->delete();

        return redirect()->route('admin.animals.index')->with('status', 'Usunięto zwierzę.');
    }
}
