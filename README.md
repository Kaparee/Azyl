# Azyl — system zarządzania schroniskiem

Webowa aplikacja CMS/ERP dla schronisk: katalog zwierząt, adopcje, zbiórki, kartoteki medyczne i wolontariat.

---

## 1. Autorzy, podział ról

| Osoba | Zakres odpowiedzialności |
|-------|--------------------------|
| **Jakub Płocica** | Infrastruktura, auth, medyczne, wolontariat, dashboard admin |
| **Kacper Ręczak** | Adopcje, fundraising, finanse |
| **Kamil Szopniewski** | CRUD zwierząt, zdjęcia, QR, polubienia |

---

## 2. Użyte technologie

| Warstwa | Stack |
|---------|-------|
| Backend | PHP 8.5 (kontener Sail), Laravel 13, MySQL 8.4 |
| Frontend | Blade, Tailwind CSS, Alpine.js, Vite |
| Auth | Laravel Breeze, middleware ról |
| DevOps | Laravel Sail (Docker), Mailpit, phpMyAdmin |
| Biblioteki | Chart.js (dashboard), DomPDF, Laravel Sanctum, L5-Swagger |

---

## 3. Przeznaczenie aplikacji

**Azyl** cyfryzuje codzienną pracę schroniska: centralny katalog zwierząt z kodami QR, obieg wniosków adopcyjnych, zbiórki celowe i rejestr darowizn, kartoteki medyczne oraz planowanie zadań wolontariuszy. System łączy moduły operacyjne, finansowe i medyczne w jednym panelu z rozróżnieniem ról (Admin, Pracownik, Weterynarz, Wolontariusz, Adoptujący).

---

## 4. Opis funkcjonalności

Moduły pogrupowane według obszaru biznesowego; szczegółowy przepływ krok po kroku — w sekcji 8.

| Obszar | Zakres | Role |
|--------|--------|------|
| Strona publiczna | Strona główna, katalog, zbiórki, aktualności, wejście QR | Gość |
| Adopcje | Wnioski, polubienia, darowizny | Adoptujący |
| Operacje | CRUD zwierząt, wnioski, zbiórki, aktualności | Pracownik, Admin |
| Medycyna | Kartoteki, eksport PDF | Weterynarz, Admin |
| Wolontariat | Plan dnia, panel zwierząt (odczyt) | Wolontariusz, Pracownik |
| Administracja | Użytkownicy, słowniki gatunków/ras, dashboard | Admin |
| Integracje | REST API read-only, Swagger UI | Zewnętrzne systemy |

- **Katalog zwierząt** — CRUD (`Admin\AnimalController`), filtry, profile publiczne (`AnimalCatalogController`), kody QR (`qr_token`), licznik odwiedzin (`animal_clicks`), polubienia (`AnimalLikeController`).
- **Multimedia** — upload wielu zdjęć, tabela pośrednia `animal_images`, sortowanie.
- **Adopcje** — składanie wniosków (`AdoptionApplicationController`), walidacja duplikatów `(user_id, animal_id)`, synchronizacja statusu zwierzęcia (dostępny → w trakcie → adoptowany).
- **Fundraising** — zbiórki przypisane do zwierząt (`FundraiserController`), darowizny anonimowe i zalogowane (`DonationController`), pasek postępu `collected_amount` / `target_amount`.
- **Medycyna** — historia leczenia, koszty, typy zabiegów (`MedicalRecordController`).
- **Wolontariat** — zadania z terminem (`VolunteerTaskController`), przypisanie użytkownika, status i flaga pilności.
- **Panel admina** — statystyki adopcji i gatunków (`DashboardController`, Chart.js), zarządzanie użytkownikami (`UserController`), aktualności (`Admin\NewsController`).
- **API** — dziesięć publicznych endpointów GET z dokumentacją Swagger pod `/api/documentation`.

---

## 5. Schemat ERD

Wizualizacja wygenerowana w projekcie:

![Schemat ERD bazy danych](docs/baza.png)

---

## 6. Przewodnik po aplikacji

Szczegółowy opis przepływów użytkownika według ról (Gość, Adoptujący, Wolontariusz, Pracownik, Weterynarz, Admin), proces adopcji end-to-end, API oraz zrzuty ekranu: **[docs/PRZEWODNIK_APLIKACJI.md](docs/PRZEWODNIK_APLIKACJI.md)**.

---

## 7. Kierunki dalszego rozwoju

**Przechowywanie zdjęć (Windows)** — pliki lądują w `storage/app/public/animals`; bez `php artisan storage:link` i poprawnych uprawnień WSL/Docker obrazy z seedera (`ImageAndLikeSeeder`) nie będą widoczne. Rozważyć S3/Cloudinary zamiast lokalnego dysku na produkcji.

**Powiadomienia e-mail** — Mailpit jest w Sail, ale brak maili transakcyjnych (nowy wniosek, decyzja admina, darowizna). Kolejny krok: kolejki + szablony Mailable.

**Płatności** — darowizny są symulowane; integracja Stripe / Przelewy24 i wirtualne adopcje (subskrypcje).

**API i dokumentacja** — rozszerzyć API o operacje zapisu z autoryzacją Sanctum (obecnie publiczne GET).

**Raporty medyczne** — eksport PDF (DomPDF już w zależnościach), ewentualny magazyn leków.

**Realtime** — WebSocket (Laravel Reverb) przy dużej liczbie równoległych wniosków lub zadań wolontariatu.

**Testy** — pokrycie ścieżek krytycznych: adopcja w transakcji, aktualizacja `collected_amount`, unikalność wniosków.

---

## 8. Instrukcja krok po kroku uruchomienia

### Wymagania

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (+ **WSL2** na Windows)
- Git

> Nie jest wymagana lokalna instalacja PHP ani Composer — cały stack działa w kontenerach Docker Compose (`compose.yaml` → `docker/8.5`, PHP 8.5). Wymaganie projektu: PHP **8.4+**.

### Windows — uwagi

- Uruchamiaj komendy w terminalu WSL2 lub Git Bash; unikaj mieszania ścieżek `C:\` z `/var/www/html`.
- Nie uruchamiaj Dockera jako `root` / `sudo` — `WWWUSER` domyślnie ustawia się na `1000`.
- `ImageAndLikeSeeder` kopiuje pliki z `public/images/seed/animals/` do `storage/app/public/animals/` — upewnij się, że katalog seed istnieje w repozytorium.

### Kroki

```bash
git clone https://github.com/Kaparee/Azyl.git
cd Azyl
docker compose up -d --build
```

Przy pierwszym uruchomieniu kontener automatycznie: tworzy `.env`, instaluje zależności (Composer + npm), buduje assety Vite, czeka na MySQL, uruchamia migracje, seeduje dane demo i tworzy `storage:link`. Kolejne restarty są szybkie (pomijają pełny setup). Jeśli wyczyścisz tylko wolumen MySQL (`docker compose down -v`), marker `storage/.setup-done` na hoście może zostać — przy następnym starcie kontener wykryje pustą tabelę `animals` i ponownie uruchomi seed.

> **Baza danych w Dockerze:** przy każdym starcie kontener synchronizuje `DB_HOST`, `DB_DATABASE`, `DB_USERNAME` i `DB_PASSWORD` w `.env` z wartościami z `compose.yaml` (`mysql` / `azyl` / `root` / puste hasło). Jeśli masz lokalny `.env` ze starymi domyślnymi Sail (`sail` / `laravel` / `password`), wystarczy `docker compose restart laravel.test` — nie trzeba ręcznie edytować pliku.

**Aplikacja:** [http://localhost](http://localhost)

**Dokumentacja API (Swagger UI):** [http://localhost/api/documentation](http://localhost/api/documentation) — publiczne endpointy GET do integracji i demonstracji (np. `/api/animals`, `/api/stats`).

**Konta testowe** (hasło: `password`): `admin@azyl.pl`, `pracownik@azyl.pl`, `weterynarz@azyl.pl`, `wolontariusz@azyl.pl`, `adoptujacy@azyl.pl`

**Pomocnicze usługi Sail:** Mailpit `http://localhost:8025`, phpMyAdmin `http://localhost:8081`, Swagger `http://localhost/api/documentation`

---

## 9. Przebieg działania aplikacji

Poniżej szczegółowo opisano ścieżki i przebieg działania aplikacji w podziale na role użytkowników. Każdy zalogowany użytkownik po uwierzytelnieniu trafia na główny pulpit `/dashboard` (`DashboardController`), którego zawartość dopasowuje się automatycznie do posiadanej roli.

---

### 9.1. Gość (użytkownik niezalogowany)
Użytkownik bez zalogowania ma dostęp wyłącznie do warstwy prezentacyjnej serwisu.

1. **Strona główna**
   - **URL**: `/`
   - **Kontroler**: `HomeController@index`
   - **Opis**: Podgląd wyróżnionych zwierząt, aktywnych zbiórek finansowych oraz skrótów do głównych sekcji strony.
2. **Katalog zwierząt**
   - **URL**: `/animals`
   - **Kontroler**: `AnimalCatalogController@index`
   - **Opis**: Przeglądanie zwierząt; domyślnie tylko **do adopcji** (AVAILABLE), z filtrami po gatunku, rasie, płci i statusie (w tym adoptowane — parametr `status`).
3. **Profil zwierzęcia**
   - **URL**: `/animals/{animal}`
   - **Kontroler**: `AnimalCatalogController@show`
   - **Opis**: Szczegółowe informacje o wybranym zwierzęciu, galeria zdjęć, skrócona historia leczenia (ostatnie 3 wpisy z kartoteki) oraz przycisk złożenia wniosku o adopcję (wymaga zalogowania). Każde wyświetlenie zwiększa licznik `animal_clicks`.
4. **Skan kodu QR zwierzęcia**
   - **URL**: `/a/{qr_token}`
   - **Kontroler**: `AnimalCatalogController@qr`
   - **Opis**: Szybkie przekierowanie bezpośrednio na profil zwierzęcia po zeskanowaniu fizycznego kodu QR na klatce.
5. **Katalog zbiórek**
   - **URL**: `/fundraisers`
   - **Kontroler**: `FundraiserController@index`
   - **Opis**: Lista aktywnych i zakończonych zbiórek finansowych na leczenie i utrzymanie zwierząt.
6. **Profil zbiórki**
   - **URL**: `/fundraisers/{fundraiser}`
   - **Kontroler**: `FundraiserController@show`
   - **Opis**: Szczegóły zbiórki, pasek postępu celu finansowego oraz lista ostatnich 5 wpłat.
7. **Aktualności**
   - **URL**: `/aktualnosci`
   - **Kontroler**: `PublicNewsController@index`
   - **Opis**: Lista publicznych artykułów i ogłoszeń publikowanych przez schronisko.
8. **Rejestracja i Logowanie**
   - **URL**: `/register` i `/login`
   - **Kontroler**: `Auth\RegisteredUserController` i `Auth\AuthenticatedSessionController`
   - **Opis**: Rejestracja nowego konta (domyślnie z rolą Adoptujący) lub logowanie na istniejące konto.

---

### 9.2. Adoptujący
Rola przeznaczona dla osób zainteresowanych adopcją lub wsparciem finansowym zwierząt.

1. **Rejestracja użytkownika**
   - **URL**: `/register`
   - **Kontroler**: `Auth\RegisteredUserController@store`
   - **Opis**: Założenie konta przez formularz rejestracji z automatycznym przypisaniem roli Adoptujący.
2. **Polubienie zwierzęcia**
   - **URL**: POST `/animals/{animal}/like`
   - **Kontroler**: `AnimalLikeController@toggle`
   - **Opis**: Dodanie lub usunięcie zwierzęcia z listy ulubionych.
3. **Lista polubionych zwierząt**
   - **URL**: `/polubione-zwierzeta`
   - **Kontroler**: `AnimalLikeController@index`
   - **Opis**: Przeglądanie spersonalizowanej listy zwierząt oznaczonych jako polubione.
4. **Złożenie wniosku adopcyjnego**
   - **URL**: POST `/adoption-applications`
   - **Kontroler**: `AdoptionApplicationController@store`
   - **Opis**: Wysłanie wniosku o adopcję wybranego zwierzęcia. Zmienia status zwierzęcia na `w trakcie` (PENDING), uniemożliwiając innym wysłanie wniosku.
5. **Moje wnioski**
   - **URL**: `/moje-wnioski`
   - **Kontroler**: `AdoptionApplicationController@myApplications`
   - **Opis**: Podgląd listy złożonych wniosków wraz z ich bieżącym statusem (oczekujący, zaakceptowany, odrzucony).
6. **Szczegóły wniosku**
   - **URL**: `/moje-wnioski/{application}`
   - **Kontroler**: `AdoptionApplicationController@showMyApplication`
   - **Opis**: Karta szczegółowa wybranego wniosku adopcyjnego.
7. **Wycofanie wniosku**
   - **URL**: DELETE `/moje-wnioski/{application}`
   - **Kontroler**: `AdoptionApplicationController@destroy`
   - **Opis**: Usunięcie oczekującego wniosku adopcyjnego. Jeśli brak innych wniosków oczekujących, status zwierzęcia wraca na `dostępny`.
8. **Przekazanie darowizny**
   - **URL**: POST `/donations`
   - **Kontroler**: `DonationController@store`
   - **Opis**: Dokonanie wpłaty na wybraną zbiórkę (jako zalogowany lub anonimowo). Kwota natychmiast zwiększa `collected_amount` zbiórki.

---

### 9.3. Wolontariusz
Rola wspierająca codzienne funkcjonowanie schroniska poprzez realizację wyznaczonych zadań.

1. **Dashboard wolontariusza**
   - **URL**: `/dashboard`
   - **Kontroler**: `DashboardController@index` (wywołuje wewnętrznie widok wolontariusza)
   - **Opis**: Zestawienie przypisanych do zalogowanego wolontariusza pilnych zadań na dany dzień.
2. **Plan dnia (Lista zadań)**
   - **URL**: `/volunteer-tasks`
   - **Kontroler**: `VolunteerTaskController@index`
   - **Opis**: Lista wszystkich zadań przypisanych do zalogowanego wolontariusza z podziałem na statusy.
3. **Zmiana statusu zadania**
   - **URL**: PATCH `/volunteer-tasks/{task}`
   - **Kontroler**: `VolunteerTaskController@update`
   - **Opis**: Szybka zmiana statusu zadania (np. do zrobienia -> w trakcie -> ukończone).
4. **Katalog zwierząt (odczyt)**
   - **URL**: `/panel/zwierzeta`
   - **Kontroler**: `AnimalCatalogController@panelIndex`
   - **Opis**: Odczytowa lista zwierząt w schronisku z filtrami, przeznaczona dla wolontariuszy do weryfikacji ich statusów.

---

### 9.4. Pracownik
Rola odpowiedzialna za bieżącą opiekę, ewidencję zwierząt i procesy adopcyjne.

1. **Dashboard pracownika**
   - **URL**: `/dashboard`
   - **Kontroler**: `DashboardController@index`
   - **Opis**: Statystyki aktywności adopcyjnej, stan zwierząt w schronisku oraz zadania bieżącego miesiąca.
2. **Ewidencja zwierząt (CRUD)**
   - **URL**: `/admin/animals` (oraz podstrony create/edit)
   - **Kontroler**: `Admin\AnimalController` (metody index, create, store, edit, update, destroy)
   - **Opis**: Pełne zarządzanie katalogiem zwierząt, w tym dodawanie profili z przesyłaniem wielu zdjęć oraz automatyczne generowanie unikalnych tokenów QR.
3. **Zarządzanie gatunkami i rasami**
   - **URL**: `/admin/species` i `/admin/breeds`
   - **Kontroler**: `Admin\SpeciesController` i `Admin\BreedController`
   - **Opis**: Zarządzanie słownikami gatunków oraz przypisanych do nich ras zwierząt.
4. **Zarządzanie wnioskami adopcyjnymi**
   - **URL**: `/admin/adoption-applications`
   - **Kontroler**: `AdoptionApplicationController@index`
   - **Opis**: Lista wszystkich wniosków adopcyjnych złożonych przez użytkowników z opcją wyszukiwania.
5. **Decyzja adopcyjna**
   - **URL**: PATCH `/admin/adoption-applications/{application}`
   - **Kontroler**: `AdoptionApplicationController@update`
   - **Opis**: Akceptacja lub odrzucenie wniosku w ramach transakcji DB. Akceptacja zmienia status zwierzęcia na `adoptowane` i anuluje pozostałe oczekujące wnioski dla tego zwierzęcia.
6. **Usunięcie wniosku (Pracownik/Admin)**
   - **URL**: DELETE `/admin/adoption-applications/{application}`
   - **Kontroler**: `AdoptionApplicationController@adminDestroy`
   - **Opis**: Usunięcie karty wniosku z bazy danych wraz z ewentualnym przywróceniem dostępności zwierzęcia.
7. **Utworzenie zbiórki finansowej**
   - **URL**: `/admin/fundraisers/create` (formularz) oraz POST `/admin/fundraisers`
   - **Kontroler**: `FundraiserController@create` i `@store`
   - **Opis**: Tworzenie nowej zbiórki powiązanej z konkretnym zwierzęciem i określeniem kwoty docelowej.
8. **Edycja i zamknięcie zbiórki**
   - **URL**: `/admin/fundraisers/{fundraiser}/edit` oraz PATCH `/admin/fundraisers/{fundraiser}`
   - **Kontroler**: `FundraiserController@edit` i `@update`
   - **Opis**: Modyfikacja opisu, tytułu, kwoty docelowej lub daty zakończenia zbiórki.
9. **Zlecanie zadań wolontariuszom**
   - **URL**: POST `/volunteer-tasks`
   - **Kontroler**: `VolunteerTaskController@store`
   - **Opis**: Tworzenie nowego zadania w planie dnia i przypisywanie go do wybranego wolontariusza.
10. **Zarządzanie aktualnościami (CRUD)**
    - **URL**: `/admin/news`
    - **Kontroler**: `Admin\NewsController`
    - **Opis**: Dodawanie, edycja i usuwanie wpisów na blogu/aktualnościach schroniska.

---

### 9.5. Weterynarz
Rola dedykowana dla personelu medycznego schroniska.

1. **Dashboard weterynarza**
   - **URL**: `/dashboard`
   - **Kontroler**: `DashboardController@index`
   - **Opis**: Podsumowanie kosztów leczenia w bieżącym miesiącu oraz lista ostatnio dodanych kartotek.
2. **Kartoteki medyczne (Zarządzanie)**
   - **URL**: `/medical-records`
   - **Kontroler**: `MedicalRecordController@index`
   - **Opis**: Lista zwierząt wraz z ich historią leczenia. Filtrowanie po typie zabiegu.
3. **Dodanie wpisu medycznego**
   - **URL**: POST `/medical-records`
   - **Kontroler**: `MedicalRecordController@store`
   - **Opis**: Zarejestrowanie nowego zabiegu, diagnozy, daty i kosztu leczenia dla zwierzęcia.
4. **Modyfikacja i usuwanie kartoteki**
   - **URL**: PATCH `/medical-records/{record}` i DELETE `/medical-records/{record}`
   - **Kontroler**: `MedicalRecordController@update` i `@destroy`
   - **Opis**: Poprawianie błędów we wpisach medycznych bądź ich usuwanie.
5. **Eksport karty medycznej do PDF**
   - **URL**: `/medical-records/{animal}/pdf`
   - **Kontroler**: `MedicalRecordController@exportPdf`
   - **Opis**: Generowanie i pobranie pliku PDF zawierającego kompletną historię medyczną danego zwierzęcia.

---

### 9.6. Administrator (Admin)
Rola o najwyższych uprawnieniach, łącząca funkcjonalności pracownika i weterynarza z zarządzaniem systemem.

1. **Dashboard główny**
   - **URL**: `/dashboard`
   - **Kontroler**: `DashboardController@index`
   - **Opis**: Kompleksowe statystyki finansowe, wykresy rozkładu gatunków oraz wskaźniki efektywności adopcji (KPI) z użyciem Chart.js.
2. **Zarządzanie użytkownikami (CRUD)**
   - **URL**: `/users` (oraz powiązane akcje POST/PATCH/DELETE)
   - **Kontroler**: `UserController` (metody index, store, update, destroy)
   - **Opis**: Dodawanie kont pracowników, weterynarzy i wolontariuszy, edycja ich uprawnień oraz usuwanie kont.
3. **Eksport bazy użytkowników do CSV**
   - **URL**: `/users/export-csv`
   - **Kontroler**: `UserController@exportCsv`
   - **Opis**: Generowanie i pobranie pliku CSV z listą zarejestrowanych w systemie użytkowników.

---

### 9.7. API i dokumentacja Swagger
Publiczne endpointy REST API (metoda GET, format JSON) przeznaczone do integracji z zewnętrznymi systemami. Warstwa webowa (`/animals`, formularze POST) obsługuje pełny obieg adopcji; API służy głównie do odczytu danych (zapis — planowany z Sanctum).

Dokumentacja interaktywna Swagger UI dostępna jest pod adresem: [http://localhost/api/documentation](http://localhost/api/documentation).

| # | Metoda | Endpoint | Kontroler | Opis |
|---|--------|----------|-----------|------|
| 1 | GET | `/api/animals` | `Api\AnimalController@index` | Paginowana lista zwierząt ze statusem **AVAILABLE** (do adopcji); bez filtrów query |
| 2 | GET | `/api/animals/{id}` | `Api\AnimalController@show` | Szczegóły zwierzęcia (dowolny status) z rasą i gatunkiem |
| 3 | GET | `/api/animals/{id}/medical-records` | `Api\AnimalController@medicalRecords` | Pełna historia medyczna wybranego zwierzęcia |
| 4 | GET | `/api/fundraisers` | `Api\FundraiserController@index` | Lista aktywnych zbiórek (`status = 1`) |
| 5 | GET | `/api/fundraisers/{id}` | `Api\FundraiserController@show` | Szczegółowe dane o zbiórce |
| 6 | GET | `/api/news` | `Api\NewsController@index` | Lista opublikowanych aktualności |
| 7 | GET | `/api/news/{id}` | `Api\NewsController@show` | Treść pojedynczego wpisu (tylko opublikowane) |
| 8 | GET | `/api/species` | `Api\SpeciesController@index` | Lista gatunków zwierząt |
| 9 | GET | `/api/breeds` | `Api\BreedController@index` | Lista ras; opcjonalnie `?species_id=` |
| 10 | GET | `/api/stats` | `Api\StatsController@index` | Zbiorcze statystyki operacyjne schroniska |

---

### 9.8. Testowanie API z konsoli przeglądarki

W celu ręcznego przetestowania poprawności zwracanych kodów statusu HTTP (np. walidacja, autoryzacja, CSRF) bez używania formularzy Blade, można wywołać zapytanie `fetch` bezpośrednio z konsoli deweloperskiej przeglądarki (będąc zalogowanym na odpowiednie konto).

Przykładowe zapytanie testujące walidację (oczekiwany kod `422 Unprocessable Content` zamiast przekierowania i kodu `200`):

```javascript
fetch('/adoption-applications', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({ animal_id: 99999, message: 'Testowe zapytanie API' })
}).then(async response => {
  console.log("Status HTTP:", response.status);
  console.log("Dane JSON:", await response.json());
});
```

Dzięki nagłówkowi `Accept: application/json` lub middleware `PreferJsonForFetchRequests`, błędy autoryzacji (`401`), uprawnień ról (`403`), wygaśnięcia sesji/CSRF (`419`) oraz walidacji formularzy (`422`) zostaną zwrócone w czystym formacie JSON z poprawnym kodem statusu.

