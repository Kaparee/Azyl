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

- **Katalog zwierząt** — CRUD, filtry, profile publiczne, kody QR (`qr_token`), licznik odwiedzin (`animal_clicks`), polubienia.
- **Multimedia** — upload wielu zdjęć, tabela pośrednia `animal_images`, sortowanie.
- **Adopcje** — składanie wniosków, walidacja duplikatów, synchronizacja statusu zwierzęcia (dostępny → w trakcie → adoptowany).
- **Fundraising** — zbiórki przypisane do zwierząt, darowizny (także anonimowe), pasek postępu `collected_amount` / `target_amount`.
- **Medycyna** — historia leczenia, koszty, typy zabiegów (rola Weterynarz).
- **Wolontariat** — zadania z terminem, przypisanie użytkownika, status i flaga pilności.
- **Panel admina** — statystyki adopcji i gatunków (Chart.js), zarządzanie wnioskami, aktualności (`news`).
- **API** — publiczne endpointy GET (`/api/animals`, `/api/fundraisers`, `/api/news` itd.) z dokumentacją Swagger pod `/api/documentation`.

---

## 5. Schemat ERD

Diagram DBML (wklej na [dbdiagram.io](https://dbdiagram.io)):

Wizualizacja wygenerowana w projekcie:

![Schemat ERD bazy danych](docs/baza.png)

---

## 6. Kierunki dalszego rozwoju

**Przechowywanie zdjęć (Windows)** — pliki lądują w `storage/app/public/animals`; bez `php artisan storage:link` i poprawnych uprawnień WSL/Docker obrazy z seedera (`ImageAndLikeSeeder`) nie będą widoczne. Rozważyć S3/Cloudinary zamiast lokalnego dysku na produkcji.

**Powiadomienia e-mail** — Mailpit jest w Sail, ale brak maili transakcyjnych (nowy wniosek, decyzja admina, darowizna). Kolejny krok: kolejki + szablony Mailable.

**Płatności** — darowizny są symulowane; integracja Stripe / Przelewy24 i wirtualne adopcje (subskrypcje).

**API i dokumentacja** — rozszerzyć API o operacje zapisu z autoryzacją Sanctum (obecnie publiczne GET).

**Raporty medyczne** — eksport PDF (DomPDF już w zależnościach), ewentualny magazyn leków.

**Realtime** — WebSocket (Laravel Reverb) przy dużej liczbie równoległych wniosków lub zadań wolontariatu.

**Testy** — pokrycie ścieżek krytycznych: adopcja w transakcji, aktualizacja `collected_amount`, unikalność wniosków.

---

## 7. Instrukcja krok po kroku uruchomienia

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
git clone <adres_repozytorium>
cd Azyl
docker compose up -d --build
```

Przy pierwszym uruchomieniu kontener automatycznie: tworzy `.env`, instaluje zależności (Composer + npm), buduje assety Vite, czeka na MySQL, uruchamia migracje (seed tylko przy pierwszym setupie) i tworzy `storage:link`. Kolejne restarty są szybkie (pomijają setup).

**Aplikacja:** [http://localhost](http://localhost)

**Dokumentacja API (Swagger UI):** [http://localhost/api/documentation](http://localhost/api/documentation) — publiczne endpointy GET do integracji i demonstracji (np. `/api/animals`, `/api/stats`).

**Konta testowe** (hasło: `password`): `admin@azyl.pl`, `pracownik@azyl.pl`, `weterynarz@azyl.pl`, `wolontariusz@azyl.pl`, `adoptujacy@azyl.pl`

**Pomocnicze usługi Sail:** Mailpit `http://localhost:8025`, phpMyAdmin `http://localhost:8081`, swagger `ttp://localhost/api/documentation`

---

### Kroki w aplikacji

1. **Rejestracja** — użytkownik otrzymuje rolę *Adoptujący* i dostęp do „Moje wnioski”.  
   ![Rejestracja](docs/screenshot_2_register.png)

2. **Katalogowanie** — pracownik dodaje zwierzę, wgrywa zdjęcia; system generuje `qr_token`.  
   ![Formularz zwierzęcia](docs/screenshot_3_worker_animal_form.png)  
   ![Karta z QR](docs/screenshot_4_animal_card.png)

3. **Zbiórka (opcjonalnie)** — pracownik zakłada fundraiser na leczenie zwierzęcia; użytkownicy wpłacają darowizny.  
   ![Formularz zbiórki](docs/screenshot_5_worker_fundraiser_form.png)  
   ![Profil zbiórki](docs/screenshot_6_fundraiser_profile.png)

4. **Wniosek** — adoptujący składa wniosek; unikalny constraint `(user_id, animal_id)` blokuje duplikat.  
   ![Moje wnioski](docs/screenshot_7_user_applications.png)

5. **Decyzja admina** — akceptacja w transakcji DB zmienia status wniosku i zwierzęcia; odrzucenie przywraca dostępność, gdy nie ma innych oczekujących wniosków.  
   ![Panel wniosków](docs/screenshot_8_admin_applications.png)

6. **Wolontariat (po adopcji)** — pracownik zleca zadanie (np. przygotowanie do wydania); wolontariusz oznacza wykonanie.  
   ![Zadania wolontariusza](docs/screenshot_9_volunteer_tasks.png)
