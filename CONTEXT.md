# 🎓 EVENT MANAGEMENT SYSTEM (EMS)

## Campus Event & Registration Management

> **Laravel 13 + Tailwind CSS v4 + SQLite**
> Tugas Kuliah Framework PHP & CRUD

---

# 📋 PRODUCT REQUIREMENTS DOCUMENT (PRD)

## 1. Product Overview

| Item | Deskripsi |
|---|---|
| **Nama Produk** | Campus Event Management System (EMS) |
| **Tujuan** | Mengelola event kampus dan pendaftaran peserta secara digital |
| **Target User** | Admin kampus / panitia event |
| **Platform** | Web (Laravel 13.x + Tailwind CSS 4) |
| **Estimasi Demo** | 10-15 menit |

## 2. User Stories

| ID | Sebagai | Saya ingin | Sehingga |
|---|---|---|---|
| US-01 | Admin | Membuat event baru | Peserta dapat mendaftar |
| US-02 | Admin | Melihat daftar event | Memonitor semua event |
| US-03 | Admin | Mengedit event | Data event selalu akurat |
| US-04 | Admin | Menghapus event | Event kadaluarsa tidak tampil |
| US-05 | Admin | Menambah peserta | Data peserta tersimpan |
| US-06 | Admin | Melihat daftar peserta | Tahu siapa saja yang terdaftar |
| US-07 | Admin | Mengedit data peserta | Koreksi data salah |
| US-08 | Admin | Menghapus peserta | Data tidak diperlukan dihapus |
| US-09 | Admin | Mendaftarkan peserta ke event | Relasi peserta-event tercatat |
| US-10 | Admin | Melihat dashboard statistik | Tahu gambaran sistem sekilas |
| US-11 | Admin | Mencari event/peserta | Navigasi data besar |
| US-12 | Admin | Melihat notifikasi validasi error | Tahu apa yang salah saat input |

## 3. Functional Requirements

| ID | Fitur | Prioritas |
|---|---|---|
| FR-01 | Dashboard: 4 stat cards + recent registrations + upcoming events | HIGH |
| FR-02 | CRUD Event (Create, Read, Update, Delete) | HIGH |
| FR-03 | CRUD Participant (Create, Read, Update, Delete) | HIGH |
| FR-04 | CRUD Registration (Create, Read, Update, Delete) | HIGH |
| FR-05 | Validasi server-side (Form Request Validation) | HIGH |
| FR-06 | Pencarian + Pagination di list page | MEDIUM |
| FR-07 | Responsive design (Tailwind CSS) | HIGH |
| FR-08 | Foreign key constraint enforcement | HIGH |
| FR-09 | Unique constraint: no duplicate registration | HIGH |

## 4. Non-Functional Requirements

| ID | Requirement | Detail |
|---|---|---|
| NFR-01 | Tech Stack | Laravel 13, PHP 8.5, SQLite, Tailwind CSS v4, Blade |
| NFR-02 | MVC Pattern | Strict Model-Controller-View separation |
| NFR-03 | ORM | 100% Eloquent, no raw SQL |
| NFR-04 | Design | Modern aesthetic (Linear/Vercel/Notion inspired) |
| NFR-05 | Code Quality | Clean, well-structured, presentable |
| NFR-06 | Demo-ready | Smooth flow for 10-15 min class presentation |

---

# 📐 SOFTWARE REQUIREMENTS SPECIFICATION (SRS)

## 1. Tech Stack

| Komponen | Teknologi |
|---|---|
| Bahasa | PHP 8.5 |
| Framework | Laravel 13.x |
| ORM | Eloquent |
| Database | SQLite |
| Frontend | Blade + Tailwind CSS v4 |
| Bundler | Vite |
| Package Manager | Composer (PHP), npm (JS) |

## 2. System Architecture (MVC)

```
                             BROWSER
                                |
          Blade Templates (.blade.php) + Tailwind CSS
                                |
              CONTROLLERS (Dashboard, Event, Participant, Registration)
                                |
              FORM REQUESTS (StoreEventRequest, UpdateEventRequest, ...)
                                |
              MODELS (Event, Participant, Registration) → Eloquent
                                |
              DATABASE (SQLite: database/database.sqlite)
```

## 3. Entity Relationship Diagram (ERD)

```
┌──────────────┐       ┌──────────────────┐       ┌──────────────┐
│   events     │       │  registrations   │       │ participants │
├──────────────┤       ├──────────────────┤       ├──────────────┤
│ id (PK)      │──1:N──│ id (PK)          │──N:1──│ id (PK)      │
│ title        │       │ event_id (FK)     │       │ name         │
│ description  │       │ participant_id(FK)│       │ email (UQ)   │
│ event_date   │       │ registration_date │       │ phone        │
│ location     │       │ created_at        │       │ created_at   │
│ quota        │       │ updated_at        │       │ updated_at   │
│ status       │       └──────────────────┘       └──────────────┘
│ created_at   │
│ updated_at   │
└──────────────┘

RELASI:
- Event 1 : N Registration     (hasMany)
- Participant 1 : N Registration (hasMany)
- Registration N : 1 Event       (belongsTo)
- Registration N : 1 Participant (belongsTo)
- UNIQUE(event_id, participant_id) mencegah registrasi ganda
```

## 4. Database Schema Detail

### Table: events

| Column | Type | Constraints |
|---|---|---|
| id | bigInteger (PK) | auto_increment |
| title | string(255) | NOT NULL |
| description | text | nullable |
| event_date | datetime | NOT NULL |
| location | string(255) | NOT NULL |
| quota | integer | NOT NULL, min:1 |
| status | enum(upcoming,ongoing,completed,cancelled) | default: upcoming |
| created_at | timestamp | |
| updated_at | timestamp | |

### Table: participants

| Column | Type | Constraints |
|---|---|---|
| id | bigInteger (PK) | auto_increment |
| name | string(255) | NOT NULL |
| email | string(255) | NOT NULL, UNIQUE |
| phone | string(20) | nullable |
| created_at | timestamp | |
| updated_at | timestamp | |

### Table: registrations

| Column | Type | Constraints |
|---|---|---|
| id | bigInteger (PK) | auto_increment |
| event_id | bigInteger (FK) | references events(id), cascadeOnDelete |
| participant_id | bigInteger (FK) | references participants(id), cascadeOnDelete |
| registration_date | datetime | default: now() |
| created_at | timestamp | |
| updated_at | timestamp | |

Unique constraint: `UNIQUE(event_id, participant_id)`

## 5. Route List (25 Routes)

| Method | URI | Controller | Action | Name |
|---|---|---|---|---|
| GET | / | DashboardController | __invoke | dashboard |
| GET | /events | EventController | index | events.index |
| GET | /events/create | EventController | create | events.create |
| POST | /events | EventController | store | events.store |
| GET | /events/{event} | EventController | show | events.show |
| GET | /events/{event}/edit | EventController | edit | events.edit |
| PUT/PATCH | /events/{event} | EventController | update | events.update |
| DELETE | /events/{event} | EventController | destroy | events.destroy |
| GET | /participants | ParticipantController | index | participants.index |
| GET | /participants/create | ParticipantController | create | participants.create |
| POST | /participants | ParticipantController | store | participants.store |
| GET | /participants/{participant} | ParticipantController | show | participants.show |
| GET | /participants/{participant}/edit | ParticipantController | edit | participants.edit |
| PUT/PATCH | /participants/{participant} | ParticipantController | update | participants.update |
| DELETE | /participants/{participant} | ParticipantController | destroy | participants.destroy |
| GET | /registrations | RegistrationController | index | registrations.index |
| GET | /registrations/create | RegistrationController | create | registrations.create |
| POST | /registrations | RegistrationController | store | registrations.store |
| GET | /registrations/{registration} | RegistrationController | show | registrations.show |
| GET | /registrations/{registration}/edit | RegistrationController | edit | registrations.edit |
| PUT/PATCH | /registrations/{registration} | RegistrationController | update | registrations.update |
| DELETE | /registrations/{registration} | RegistrationController | destroy | registrations.destroy |

## 6. Validation Rules (Form Requests)

| Form Request | Field | Rules |
|---|---|---|
| **StoreEventRequest** | title | required, string, max:255 |
| | description | nullable, string |
| | event_date | required, date, after:now |
| | location | required, string, max:255 |
| | quota | required, integer, min:1 |
| | status | required, in:upcoming,ongoing,completed,cancelled |
| **UpdateEventRequest** | (same, without after:now) | |
| **StoreParticipantRequest** | name | required, string, max:255 |
| | email | required, email, unique:participants,email |
| | phone | nullable, string, max:20 |
| **UpdateParticipantRequest** | email | unique:participants,email,{currentID} |
| **StoreRegistrationRequest** | event_id | required, exists:events,id |
| | participant_id | required, exists:participants,id |
| | | Rule::unique('registrations')->where(...) |
| **UpdateRegistrationRequest** | (same, ignore current ID) | |

## 7. Eloquent Relationship Mapping

```php
// Event.php
public function registrations(): HasMany
{
    return $this->hasMany(Registration::class);
}

public function participants(): BelongsToMany
{
    return $this->belongsToMany(Participant::class, 'registrations')
        ->withPivot('registration_date')
        ->withTimestamps();
}

// Participant.php
public function registrations(): HasMany
{
    return $this->hasMany(Registration::class);
}

public function events(): BelongsToMany
{
    return $this->belongsToMany(Event::class, 'registrations')
        ->withPivot('registration_date')
        ->withTimestamps();
}

// Registration.php
public function event(): BelongsTo
{
    return $this->belongsTo(Event::class);
}

public function participant(): BelongsTo
{
    return $this->belongsTo(Participant::class);
}
```

### Penggunaan Eloquent di Controller:

```php
// Dashboard - statistik
Event::count();
Participant::count();
Registration::count();
Event::where('status', 'upcoming')->where('event_date', '>', now())->count();

// Dashboard - recent + upcoming
Registration::with(['event', 'participant'])->latest()->take(5)->get();
Event::where('status', 'upcoming')->withCount('registrations')->orderBy('event_date')->take(5)->get();

// Event index - eager loading + search + pagination
Event::withCount('registrations')
    ->when(request('search'), fn($q) => $q->where('title', 'like', '%...%'))
    ->latest()
    ->paginate(10);

// Registration index - nested eager loading + search
Registration::with(['event', 'participant'])
    ->when(request('search'), function($q) {
        $q->whereHas('participant', fn($sub) => $sub->where('name', 'like', '%...%'))
          ->orWhereHas('event', fn($sub) => $sub->where('title', 'like', '%...%'));
    })
    ->latest()
    ->paginate(10);
```

---

# 📁 STRUKTUR FOLDER PROJECT

```
ems/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── DashboardController.php
│   │   │   ├── EventController.php
│   │   │   ├── ParticipantController.php
│   │   │   └── RegistrationController.php
│   │   └── Requests/
│   │       ├── StoreEventRequest.php
│   │       ├── UpdateEventRequest.php
│   │       ├── StoreParticipantRequest.php
│   │       ├── UpdateParticipantRequest.php
│   │       ├── StoreRegistrationRequest.php
│   │       └── UpdateRegistrationRequest.php
│   └── Models/
│       ├── Event.php
│       ├── Participant.php
│       └── Registration.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_events_table.php
│   │   ├── ..._create_participants_table.php
│   │   └── ..._create_registrations_table.php
│   ├── seeders/
│   │   └── DatabaseSeeder.php
│   └── database.sqlite
├── resources/
│   ├── css/
│   │   └── app.css
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── components/
│       │   └── sidebar.blade.php
│       ├── dashboard.blade.php
│       ├── events/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── participants/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       └── registrations/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
├── routes/
│   └── web.php
├── package.json
├── vite.config.js
├── composer.json
├── DOKUMENTASI.md
├── CONTEXT.md (file ini)
└── README.md
```

---

# 🚀 FULL SETUP GUIDE

## Prasyarat

| Tool | Status |
|---|---|
| PHP 8.5 | ✅ Terinstal |
| Composer | ✅ Terinstal (`php ../composer.phar`) |
| Node.js + npm | ✅ Terinstal (v26 + npm 11) |
| SQLite | ✅ Terinstal (custom module) |

## ⚠️ CATATAN PENTING

Karena modul SQLite di-install secara manual (tidak bisa sudo), semua command `php artisan` WAJIB dikasih prefix environment variable:

```bash
PHP_INI_SCAN_DIR="$HOME/.php/conf.d"
```

Kalau lupa, PHP gak bisa konek database → error.

---

## Setup Pertama Kali

### 1. Masuk folder project
```bash
cd "/home/faiz/Semester 4/Rekayasa Web/slide22/ems"
```

### 2. Install PHP dependencies
```bash
php ../composer.phar install
```
*(Composer ada di parent folder karena gak bisa install global)*

### 3. Install JS dependencies
```bash
npm install
```

### 4. Setup SQLite database
```bash
touch database/database.sqlite
```

### 5. Jalankan migration (bikin tabel)
```bash
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan migrate
```
Output yang diharapkan:
```
Migration table created successfully.
...create_events_table .... DONE
...create_participants_table .... DONE
...create_registrations_table .... DONE
```

### 6. Isi data sample
```bash
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan db:seed
```
Output: `Seeding database.`

Data yang di-seed:
- 7 Events (5 upcoming, 2 completed)
- 15 Participants
- 30 Registrations

### 7. Build CSS Tailwind
```bash
npm run build
```
Output: `✓ built in Xms`

### 8. Jalankan server
```bash
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan serve --port=8080
```
Output: `Server running on http://localhost:8080`

### 9. Buka browser
```
http://localhost:8080
```

---

## Cara Cepat (Copy-Paste Semua Sekaligus)

```bash
cd "/home/faiz/Semester 4/Rekayasa Web/slide22/ems"

php ../composer.phar install
npm install
touch database/database.sqlite
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan migrate
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan db:seed
npm run build
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan serve --port=8080
```

---

## Menjalankan Ulang (Setelah Setup)

Kalau udah pernah setup, tinggal:

```bash
cd "/home/faiz/Semester 4/Rekayasa Web/slide22/ems"
npm run build
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan serve --port=8080
```

---

## Reset Database (Kalau Mau Mulai Ulang)

```bash
cd "/home/faiz/Semester 4/Rekayasa Web/slide22/ems"
rm database/database.sqlite
touch database/database.sqlite
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan migrate
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan db:seed
```

---

# 🎮 SKENARIO DEMO (10-15 Menit)

| Menit | Aktivitas | Yang Ditunjukkin |
|---|---|---|
| **0-2** | Buka Dashboard | 4 stat cards (Total Events, Participants, Registrations, Active Events). Scroll ke Recent Registrations & Upcoming Events dengan progress bar. |
| **2-4** | Navigasi Events | Klik sidebar "Events" → tabel responsif (title, date, location, quota, status badge warna-warni, registrations count). Coba fitur search. |
| **4-6** | Create Event | Klik "Add Event" → isi form. Kosongin title buat tunjukkin validasi server-side. Isi bener → submit → lihat success alert hijau + event baru di tabel. |
| **6-7** | View Event Detail | Klik judul event → lihat detail event (deskripsi, tanggal, lokasi, status badge, progress bar registrasi "X / Y", daftar peserta terdaftar). |
| **7-9** | CRUD Participants | Klik "Participants" → tabel peserta + search. Klik "Add Participant" → tambah 1 peserta baru → submit → lihat di list. |
| **9-11** | CRUD Registrations | Klik "Registrations" → lihat semua registrasi. Klik "New Registration" → pilih event + peserta dari dropdown → submit. Coba daftarin peserta yang sama ke event yang sama → error "Peserta sudah terdaftar". |
| **11-13** | Edit & Delete | Edit event → ubah status jadi "completed". Edit registrasi → ubah event. Delete registration → confirmation dialog → success. |
| **13-15** | Wrap-up | Dashboard updated, tunjukkin responsive design (resize browser kecilin lebar). Sidebar auto-collapse di mobile. |

---

# 🔑 KONSEP YANG DIDEMOKAN

| Konsep | Dimana | Detail |
|---|---|---|
| **MVC Pattern** | Seluruh project | Model di `app/Models/`, View di `resources/views/`, Controller di `app/Http/Controllers/` |
| **Eloquent ORM** | Semua Controller | `with()`, `withCount()`, `whereHas()`, `paginate()`, relationship methods |
| **Relasi Database** | Models | `hasMany` (Event→Registration), `belongsTo` (Registration→Event), `belongsToMany` (Event↔Participant) |
| **Form Request Validation** | `app/Http/Requests/` | 6 kelas: Store/Update untuk Event, Participant, Registration |
| **Route Model Binding** | Controller | `public function show(Event $event)` → auto-resolve dari URL |
| **Resource Controllers** | Routes | `Route::resource('events', EventController::class)` |
| **CSRF Protection** | Semua form | `@csrf` + `@method('PUT/DELETE')` |
| **Flash Messages** | Layout | `->with('success', '...')` → alert hijau otomatis |
| **Error Handling** | Semua form | `@error('field')` + `$errors->has()` conditional styling |
| **Search** | Index pages | `->when(request('search'), ...)` + query string di pagination |
| **Pagination** | Index pages | `->paginate(10)` + `->links()` |
| **Eager Loading** | Controller | `->with('registrations.participant')` → N+1 prevention |
| **Responsive Design** | Semua view | Tailwind breakpoints: `sm:`, `lg:`, `max-w-*` |
| **Empty State** | Index pages | "Belum ada data" + icon SVG |
| **Delete Confirmation** | List pages | JavaScript modal atau `onsubmit="return confirm(...)"` |
| **Status Badges** | Event views | Upcoming=blue, Ongoing=green, Completed=gray, Cancelled=red |

---

# 📊 DATA SAMPLE

Semua data ini otomatis terisi setelah `php artisan db:seed`.

### Events (7)

| # | Title | Date | Location | Quota | Status |
|---|---|---|---|---|---|
| 1 | Workshop Web Development | 15 Jul 2026 | Lab Komputer A | 30 | upcoming |
| 2 | Seminar Cyber Security | 20 Jul 2026 | Auditorium Utama | 100 | upcoming |
| 3 | Lomba Debat Bahasa Inggris | 25 Jun 2026 | Ruang Seminar Lt 3 | 20 | completed |
| 4 | Pameran Proyek Mahasiswa | 05 Agu 2026 | Lobby Utama | 50 | upcoming |
| 5 | Pelatihan Public Speaking | 12 Agu 2026 | Ruang 401 | 25 | upcoming |
| 6 | Hackathon 2026 | 10 Jun 2026 | Lab Komputer B & C | 60 | completed |
| 7 | Career Fair Kampus | 01 Sep 2026 | Lapangan Parkir | 200 | upcoming |

### Participants (15)

Semua dengan email format `nama@student.edu` dan nomor telepon.

### Registrations (30)

Tersebar di semua event dengan distribusi yang bervariasi — beberapa event hampir penuh, beberapa masih sepi.

---

# 💻 COMMANDS REFERENCE

| Command | Fungsi |
|---|---|
| `php artisan serve --port=8080` | Jalankan dev server |
| `php artisan migrate` | Buat/perbarui tabel |
| `php artisan migrate:fresh` | Hapus semua tabel + migrate ulang |
| `php artisan migrate:fresh --seed` | Hapus + migrate + seed ulang |
| `php artisan db:seed` | Isi data sample |
| `php artisan route:list` | Lihat semua route |
| `php artisan tinker` | Interactive PHP shell |
| `npm run build` | Build CSS/JS untuk production |
| `npm run dev` | Watch mode (auto-build saat edit) |
| `Ctrl + C` | Stop server |

---

# 📝 FILE PENTING UNTUK PRESENTASI

| File | Isi |
|---|---|
| `routes/web.php` | Semua route definitions |
| `app/Models/Event.php` | Model Event + relationships |
| `app/Models/Participant.php` | Model Participant + relationships |
| `app/Models/Registration.php` | Model Registration + relationships |
| `app/Http/Controllers/EventController.php` | Event CRUD logic |
| `app/Http/Controllers/ParticipantController.php` | Participant CRUD logic |
| `app/Http/Controllers/RegistrationController.php` | Registration CRUD logic |
| `app/Http/Controllers/DashboardController.php` | Dashboard statistics |
| `app/Http/Requests/StoreEventRequest.php` | Validasi input event |
| `app/Http/Requests/StoreRegistrationRequest.php` | Validasi unique constraint |
| `resources/views/layouts/app.blade.php` | Layout utama (sidebar + content) |
| `resources/views/dashboard.blade.php` | Dashboard UI |
| `database/migrations/` | Struktur database (3 file) |
| `database/seeders/DatabaseSeeder.php` | Data sample |

---

# ✅ CHECKLIST KETENTUAN TUGAS

| # | Ketentuan | Status |
|---|---|---|
| 1 | Laravel terbaru (v13) | ✅ |
| 2 | Eloquent ORM | ✅ 100%, no raw SQL |
| 3 | MVC jelas (Model, Controller, View, Route) | ✅ |
| 4 | Validasi server-side (Form Request) | ✅ 6 Form Request classes |
| 5 | Responsive (Tailwind CSS) | ✅ |
| 6 | CRUD penuh (Create, Read, Update, Delete) | ✅ 3 resource controllers |
| 7 | Minimal 1 relasi database | ✅ 3 relasi (1:N, N:1, M:N) |
| 8 | Struktur kode rapi | ✅ |
| 9 | Cocok untuk demo 10-15 menit | ✅ |
| 10 | Tidak terlihat seperti tutorial CRUD biasa | ✅ Modern UI + unique constraints |
