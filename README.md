# Dokumentacja Techniczna – Azyl

## 1. Wstęp
### 1.1 Przeznaczenie aplikacji
"Azyl" to kompleksowy system klasy CMS/ERP wspierający codzienne funkcjonowanie schronisk dla zwierząt. Aplikacja ma na celu cyfryzację zasobów placówki, automatyzację obiegu wniosków adopcyjnych oraz zarządzanie zbiórkami celowymi. System integruje zarządzanie bazą zwierząt z modułami logistycznymi (wolontariat, dokumentacja medyczna) i finansowymi (fundraising), kładąc nacisk na przejrzystość procesów.

### 1.2 Użyte technologie
- **Język i Framework:** PHP 8.2, Laravel 11
- **Baza danych:** MySQL (uruchamiana za pomocą Docker / Laravel Sail)
- **Frontend / UI:** Tailwind CSS, Blade Templates, Alpine.js
- **Autoryzacja:** Laravel Breeze (architektura MVC, Middleware)
- **Wykresy i planowanie:** Chart.js, FullCalendar.js

## 2. Autorzy i podział ról
Projekt został zrealizowany przez zespół 3-osobowy. Role i odpowiedzialności podzielono następująco:

- **Jakub Płocica (Infrastruktura, Analityka i Logistyka)**
  - Architektura bazy danych i precyzyjne mapowanie relacji kaskadowych (ON DELETE CASCADE).
  - Wdrożenie systemu autoryzacji (Laravel Breeze) i Middleware dla różnych ról.
  - Moduł medyczny, system zadań wolontariatu oraz Dashboard administratora ze statystykami.
- **Kacper Ręczak (Logika Biznesowa i Finanse)**
  - Procesor adopcyjny: logika walidacji wniosków i automatyczna zmiana statusów po adopcji.
  - System fundraisingowy: tworzenie zbiórek przypisanych do zwierząt.
  - UI Biznesowe: widok zbiórek z paskami postępu oraz panel historii operacji.
- **Kamil Szopniewski (Multimedia i Katalog)**
  - Pełny CRUD dla zwierząt oraz słowników (rasy, gatunki).
  - Moduł asynchronicznego uploadu wielu zdjęć i generowania unikalnych tokenów QR.
  - System interakcji (polubienia, licznik odwiedzin profilu).

## 3. Opis funkcjonalności

1. **Inteligentny Katalog z kodami QR**
   Przeglądarka zintegrowana z generatorami kodów QR. Fizyczne zeskanowanie kodu np. na klatce zwierzaka prowadzi bezpośrednio do jego profilu w aplikacji.
2. **Procesor Adopcyjny**
   Zautomatyzowany obieg wniosków adopcyjnych. Użytkownik wysyła zgłoszenie, system sprawdza duplikaty, a decyzja Administratora automatycznie modyfikuje dostępność zwierzaka w katalogu.
3. **Engine Finansowy (Zbiórki celowe)**
   Administratorzy mogą zakładać zbiórki na konkretne cele medyczne lub bytowe wybranych zwierząt. Paski postępu wypełniają się w czasie rzeczywistym. Darowizny mogą być anonimowe.
4. **Elektroniczna Kartoteka Medyczna**
   Moduł dedykowany Weterynarzom – rejestracja historii leczenia, szczepień i poniesionych na ten cel kosztów.
5. **System zadań (Wolontariat)**
   Pracownicy mogą przydzielać zadania wybranym wolontariuszom (np. wyprowadzenie psa o danej godzinie). Wolontariusze mogą oznaczać zadania jako ukończone.

## 4. Schemat Bazy Danych (ERD)

Poniżej znajduje się zrzut ekranu ze schematem bazy danych (ERD):

`[TUTAJ WSTAW SCREENSHOT: Schemat Bazy Danych ERD (z dbdiagram.io, DataGrip lub MySQL Workbench)]`

## 5. Przebieg logiki biznesowej (Cykl życia adopcji i zbiórek)

*W tej sekcji przedstawiono flagowy przypadek użycia systemu, od momentu dodania zwierzęcia, przez proces wpłat, aż do udanej adopcji.*

1. **Rejestracja i logowanie (Moduł Kuby):**
   Użytkownik wypełnia formularz i zostaje zautoryzowany z rolą `Adopter`. Od tego momentu ma dostęp do własnego panelu historii wniosków.
   
   ![Widok rejestracji/logowania (Laravel Breeze)](docs/screenshot_2_register.png)

2. **Katalogowanie i media (Moduł Kamila):**
   Pracownik schroniska dodaje nowe zwierzę do bazy (np. pies Burek, rasa Mieszaniec). Wgrywa 3 zdjęcia. System generuje w tle unikalny `qr_token` i zapisuje go w bazie, przypisując kod kreskowy/QR dla Burka.
   
   ![Panel Pracownika - formularz dodawania zwierzęcia](docs/screenshot_3_worker_animal_form.png)
   
   ![Karta psa w publicznym katalogu z widocznym kodem QR](docs/screenshot_4_animal_card.png)

3. **Tworzenie zbiórki celowej (Moduł Kacpra):**
   Pies Burek wymaga drogiej operacji. Pracownik wchodzi w moduł zbiórek i zakłada zbiórkę na kwotę 2000 zł powiązaną z Burkiem.
   
   ![Formularz tworzenia zbiórki w panelu Pracownika](docs/screenshot_5_worker_fundraiser_form.png)

4. **Finansowanie zbiórki (Moduł Kacpra):**
   Użytkownicy wchodzą na profil zbiórki i dokonują darowizn. System atomowo aktualizuje `collected_amount`. Pasek postępu dynamicznie się wypełnia.
   
   ![Publiczny profil zbiórki pokazujący pasek postępu i listę najnowszych wpłat](docs/screenshot_6_fundraiser_profile.png)

5. **Wniosek Adopcyjny (Moduł Kacpra):**
   Pies Burek zdrowieje, a Użytkownik wysyła wniosek o adopcję. System waliduje wniosek (brak duplikatów).
   
   ![Panel użytkownika - zakładka "Moje Wnioski"](docs/screenshot_7_user_applications.png)

6. **Akceptacja i zmiana statusu (Moduł Kacpra):**
   Administrator w swoim panelu przegląda wniosek. Klika "Akceptuj". Status psa Burek automatycznie zmienia się na "ADOPTOWANY", co powoduje, że zwierzę ukrywa się w katalogu zwierząt dostępnych do adopcji.
   
   ![Panel Administratora - Zarządzanie Wnioskami Adopcyjnymi](docs/screenshot_8_admin_applications.png)

7. **Zlecenie zadania Wolontariuszowi (Moduł Kuby):**
   Po udanej adopcji pracownik zleca wolontariuszowi zadanie "Przygotowanie psa Burka do wydania" na konkretny termin. Wolontariusz widzi to u siebie na liście i oznacza po wykonaniu.
   
   ![Panel Wolontariusza - Lista Zadań](docs/screenshot_9_volunteer_tasks.png)


## 6. Instrukcja uruchomienia (Krok po kroku)

Aplikacja "Azyl" wykorzystuje wbudowane mechanizmy Docker-a (Laravel Sail) dla najwyższej spójności środowiska deweloperskiego.

**Wymagania:**
- Docker Desktop i WSL2 (na systemie Windows)
- PHP / Composer zainstalowany globalnie (opcjonalnie do pobrania vendorów)

**Kroki uruchomienia:**
1. Sklonuj repozytorium z kodem źródłowym:
   ```bash
   git clone <adres_repozytorium>
   cd Azyl
   ```
2. Zainstaluj zależności kompozytora:
   ```bash
   docker run --rm \
     -u "$(id -u):$(id -g)" \
     -v "$(pwd):/var/www/html" \
     -w /var/www/html \
     laravelsail/php82-composer:latest \
     composer install --ignore-platform-reqs
   ```
3. Skopiuj plik środowiskowy i wygeneruj klucz aplikacji:
   ```bash
   cp .env.example .env
   ./vendor/bin/sail php artisan key:generate
   ```
4. Uruchom maszyny Dockerowe w tle:
   ```bash
   ./vendor/bin/sail up -d
   ```
5. Przebuduj bazę danych i wgraj dane testowe (seedery):
   ```bash
   ./vendor/bin/sail artisan migrate:fresh --seed
   ```
6. Zbuduj i połącz symlinki do pamięci masowej (dla zdjęć):
   ```bash
   ./vendor/bin/sail artisan storage:link
   ```
7. Uruchom serwer developerski dla assetów frontendowych (Vite):
   ```bash
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run dev
   ```
Gotowe! Aplikacja jest dostępna pod adresem: `http://localhost`.

## 7. Kierunki dalszego rozwoju
* **Wirtualne Adopcje:** Moduł dedykowany stałym donatorom z opcją subskrypcji miesięcznych wsparć za pomocą zewnętrznych bramek płatności (np. Stripe/Przelewy24).
* **Integracja z kalendarzem Google:** Możliwość eksportowania wizyt weterynaryjnych oraz zadań wolontariatu do zewnetrznych aplikacji.
* **Rozbudowa modułu medycznego:** Generowanie raportów PDF dla historii leczenia poszczególnych zwierząt oraz magazyn leków (śledzenie stanów magazynowych schroniska).
* **Powiadomienia w czasie rzeczywistym:** Wdrożenie technologii WebSocket (np. Laravel Reverb lub Pusher) w celu natychmiastowego powiadamiania administratorów o nowym wniosku.
