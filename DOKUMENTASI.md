# EVENT MANAGEMENT SYSTEM — DOKUMENTASI LENGKAP

> Tugas Kuliah Framework PHP & CRUD — Semester 4 Rekayasa Web

---

## DAFTAR ISI

1. [Struktur Folder Laravel](#1-struktur-folder-laravel)
2. [Penjelasan MVC](#2-penjelasan-mvc)
3. [Penjelasan Relasi Database](#3-penjelasan-relasi-database)
4. [Penjelasan Eloquent ORM](#4-penjelasan-eloquent-orm)
5. [Langkah Instalasi](#5-langkah-instalasi)
6. [ERD Database](#6-erd-database)
7. [Daftar Route](#7-daftar-route)
8. [Daftar Controller](#8-daftar-controller)
9. [Daftar Model](#9-daftar-model)
10. [Skenario Demo Presentasi](#10-skenario-demo-presentasi)

---

## 1. STRUKTUR FOLDER LARAVEL

```
ems/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php              # Base Controller
│   │   │   ├── DashboardController.php     # Dashboard + Statistik
│   │   │   ├── EventController.php         # CRUD Event
│   │   │   ├── ParticipantController.php   # CRUD Participant
│   │   │   └── RegistrationController.php  # CRUD Registration
│   │   └── Requests/
│   │       ├── StoreEventRequest.php       # Validasi Create Event
│   │       ├── UpdateEventRequest.php      # Validasi Update Event
│   │       ├── StoreParticipantRequest.php
│   │       ├── UpdateParticipantRequest.php
│   │       ├── StoreRegistrationRequest.php
│   │       └── UpdateRegistrationRequest.php
│   └── Models/
│       ├── Event.php           # Model Event + Relasi
│       ├── Participant.php     # Model Participant + Relasi
│       └── Registration.php    # Model Registration + Relasi
├── database/
│   ├── migrations/
│   │   ├── create_events_table.php
│   │   ├── create_participants_table.php
│   │   └── create_registrations_table.php
│   └── seeders/
│       └── DatabaseSeeder.php   # 7 Events, 15 Participants, 30 Registrations
├── resources/
│   ├── css/
│   │   └── app.css              # Tailwind CSS v4 Entry
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php    # Main Layout (Sidebar + Header + Content)
│       ├── components/
│       │   └── sidebar.blade.php
│       ├── dashboard.blade.php  # Dashboard Page
│       ├── events/              # 4 Views: index, create, edit, show
│       ├── participants/        # 4 Views: index, create, edit, show
│       └── registrations/       # 4 Views: index, create, edit, show
├── routes/
│   └── web.php                  # Semua route aplikasi
├── .env                         # Konfigurasi environment (SQLite)
└── vite.config.js               # Vite + Tailwind CSS v4
```

---

## 2. PENJELASAN MVC

### Model

Model merepresentasikan data dan logika bisnis. Setiap tabel database memiliki satu Model:

| Model | Tabel | Fungsi |
|-------|-------|--------|
| `Event` | `events` | Data event kampus, validasi, relasi |
| `Participant` | `participants` | Data peserta, validasi email unik |
| `Registration` | `registrations` | Pivot data pendaftaran, foreign key |

**Ciri khas Model:**
- `$fillable` — Menentukan field mana yang boleh diisi massal (mass assignment protection)
- `$casts` — Mengubah tipe data (misal `event_date` jadi `datetime`)
- Relasi — Method `registrations()`, `event()`, `participant()`

### View (Blade)

View bertanggung jawab pada tampilan. Menggunakan Blade template engine:

```
layouts/app.blade.php    → Template utama
    ├── sidebar.blade.php    → Navigasi sidebar
    └── @yield('content')    → Konten dinamis
        ├── dashboard.blade.php
        ├── events/index.blade.php
        ├── events/create.blade.php
        └── ... (12 view lainnya)
```

### Controller

Controller menjembatani Model dan View. Menerima HTTP request, memproses data via Model, mengembalikan View atau redirect:

```
HTTP Request → Route → Controller → Model (Eloquent) → View/Redirect
```

**4 Controller:**
- `DashboardController` — 1 method (`__invoke`) — Statistik dashboard
- `EventController` — 7 methods (index, create, store, show, edit, update, destroy)
- `ParticipantController` — 7 methods
- `RegistrationController` — 7 methods

### Route

Route mendefinisikan URL mana yang dipetakan ke Controller mana:

```php
Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('events', EventController::class);
Route::resource('participants', ParticipantController::class);
Route::resource('registrations', RegistrationController::class);
```

`Route::resource` otomatis membuat 7 rute CRUD: index, create, store, show, edit, update, destroy.

---

## 3. PENJELASAN RELASI DATABASE

```
┌────────────┐          ┌──────────────────┐          ┌──────────────┐
│   events   │          │  registrations   │          │ participants │
├────────────┤          ├──────────────────┤          ├──────────────┤
│ id (PK)    │──1:N────→│ event_id (FK)    │←────N:1──│ id (PK)      │
│ title      │          │ participant_id(FK)│          │ name         │
│ description│          │ registration_date │          │ email (UNIQUE)│
│ event_date │          │ created_at       │          │ phone        │
│ location   │          │ updated_at       │          │ created_at   │
│ quota      │          └──────────────────┘          │ updated_at   │
│ status     │
│ created_at │
│ updated_at │
└────────────┘
```

### Jenis Relasi

| Relasi | Tipe | Keterangan |
|--------|------|------------|
| Event → Registration | **One to Many** | 1 Event punya banyak Registration |
| Participant → Registration | **One to Many** | 1 Participant punya banyak Registration |
| Registration → Event | **Belongs To** | Setiap Registration punya 1 Event |
| Registration → Participant | **Belongs To** | Setiap Registration punya 1 Participant |
| Event → Participant | **Many to Many** (via registrations) | Event memiliki banyak Participant melalui tabel pivot registrations |

### Foreign Key Constraints

```sql
event_id     → FK REFERENCES events(id) ON DELETE CASCADE
participant_id → FK REFERENCES participants(id) ON DELETE CASCADE
UNIQUE(event_id, participant_id)  ← Mencegah registrasi ganda
```

`ON DELETE CASCADE`: Jika event dihapus, semua registrasi terkait juga terhapus otomatis.

---

## 4. PENJELASAN ELOQUENT ORM YANG DIGUNAKAN

### 4.1 Model Definition

```php
// Event.php
protected $fillable = ['title', 'description', 'event_date', 'location', 'quota', 'status'];
protected $casts = ['event_date' => 'datetime', 'quota' => 'integer'];
```

`$fillable` → Mass assignment protection. Hanya field yang terdaftar yang bisa diisi via `Event::create()`.

`$casts` → Otomatis konversi tipe. `event_date` akan selalu dikembalikan sebagai objek `Carbon` (datetime).

### 4.2 Relationship Methods

```php
// Event.php
public function registrations(): HasMany
{
    return $this->hasMany(Registration::class);
}

// Registration.php
public function event(): BelongsTo
{
    return $this->belongsTo(Event::class);
}
```

**HasMany** → Event "memiliki banyak" Registration. Eloquent otomatis mencari `event_id` di tabel `registrations`.

**BelongsTo** → Registration "milik" satu Event. Invers dari HasMany.

### 4.3 Eager Loading

```php
// Di DashboardController — Menghindari N+1 Query Problem
$recentRegistrations = Registration::with(['event', 'participant'])
    ->latest()
    ->take(5)
    ->get();

// Di EventController@show — Memuat relasi sekaligus
$event->load(['registrations.participant']);
```

`with()` dan `load()` → Eager loading. Mengambil semua data relasi dalam 3 query (bukan 1 + N query).

### 4.4 Aggregat Queries

```php
// Menghitung jumlah registrasi per event
Event::withCount('registrations')->get();

// Dashboard statistik
Event::count();                          // Total event
Event::where('status', 'upcoming')->count();  // Event aktif
Registration::count();                   // Total registrasi
```

### 4.5 Query Scoping (Search)

```php
// Di EventController@index — Pencarian dinamis
Event::withCount('registrations')
    ->when(request('search'), fn($q) =>
        $q->where('title', 'like', '%'.request('search').'%')
          ->orWhere('location', 'like', '%'.request('search').'%')
    )
    ->latest()
    ->paginate(10);
```

`when()` → Conditional clause. Hanya menambah WHERE jika parameter search diisi.

### 4.6 Pagination

```php
->paginate(10)          // 10 item per halaman
->withQueryString()     // Mempertahankan query string di link pagination
```

### 4.7 Mass Assignment (Create/Update)

```php
// Create — menggunakan validated data dari Form Request
Event::create($request->validated());

// Update — Route Model Binding otomatis
$event->update($request->validated());

// Delete
$event->delete();
```

### 4.8 Route Model Binding

```php
// Controller method menerima Model, Laravel otomatis query by ID
public function show(Event $event): View  // $event sudah di-query otomatis
```

---

## 5. LANGKAH INSTALASI

### Prasyarat

- PHP 8.2+ dengan ekstensi: PDO, SQLite/MySQL
- Composer 2.x
- Node.js 18+ & npm
- Git

### Step 1: Clone & Install Dependencies

```bash
cd ems
composer install
npm install
```

### Step 2: Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` untuk database:

```
DB_CONNECTION=sqlite
# Jika MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=ems
# DB_USERNAME=root
# DB_PASSWORD=
```

### Step 3: Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

### Step 4: Build Frontend

```bash
npm run build
```

### Step 5: Jalankan Server

```bash
php artisan serve --port=8080
```

Buka browser: `http://localhost:8080`

---

## 6. ERD DATABASE

```
┌─────────────────────────────────────────────────────────────────────────┐
│                          EVENT MANAGEMENT SYSTEM                         │
│                              Entity Relationship Diagram                 │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  ┌───────────────────────┐       ┌───────────────────────┐              │
│  │       EVENTS          │       │    PARTICIPANTS       │              │
│  ├───────────────────────┤       ├───────────────────────┤              │
│  │ PK │ id        (BIGINT)│      │ PK │ id        (BIGINT)│              │
│  │    │ title    (STRING) │      │    │ name     (STRING) │              │
│  │    │ description(TEXT) │      │    │ email   (STRING)  │ UNIQUE      │
│  │    │ event_date(DATETIME)│    │    │ phone   (STRING)  │ NULLABLE    │
│  │    │ location (STRING) │      │    │ created_at(TIMESTAMP)│           │
│  │    │ quota    (INT)    │      │    │ updated_at(TIMESTAMP)│           │
│  │    │ status   (ENUM)   │      │                       │              │
│  │    │ created_at(TIMESTAMP)│   │                       │              │
│  │    │ updated_at(TIMESTAMP)│   │                       │              │
│  └───────┬───────────────┘       └───────────┬───────────┘              │
│          │ 1                                 │ 1                        │
│          │                                   │                          │
│          │ ┌─────────────────────────────┐   │                          │
│          └─│     REGISTRATIONS           │───┘                          │
│            ├─────────────────────────────┤                               │
│            │ PK │ id              (BIGINT)│                              │
│            │ FK │ event_id        (BIGINT)│── REFERENCES events(id)     │
│            │ FK │ participant_id  (BIGINT)│── REFERENCES participants(id)│
│            │    │ registration_date(DATETIME)│                          │
│            │    │ created_at    (TIMESTAMP)│                             │
│            │    │ updated_at    (TIMESTAMP)│                             │
│            │    └─────────────────────────┘                              │
│            │ UNIQUE(event_id, participant_id)                            │
│            └────────────────────────────────────────────────             │
│                                                                          │
│  RELASI:                                                                 │
│  ├── Event 1 ──── N Registration                                        │
│  ├── Participant 1 ──── N Registration                                  │
│  ├── Registration N ──── 1 Event                                        │
│  └── Registration N ──── 1 Participant                                  │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 7. DAFTAR ROUTE

### Dashboard

| Method | URI | Controller | Name |
|--------|-----|-----------|------|
| GET | `/` | DashboardController | `dashboard` |

### Events

| Method | URI | Controller Method | Name |
|--------|-----|-------------------|------|
| GET | `/events` | EventController@index | `events.index` |
| GET | `/events/create` | EventController@create | `events.create` |
| POST | `/events` | EventController@store | `events.store` |
| GET | `/events/{event}` | EventController@show | `events.show` |
| GET | `/events/{event}/edit` | EventController@edit | `events.edit` |
| PUT/PATCH | `/events/{event}` | EventController@update | `events.update` |
| DELETE | `/events/{event}` | EventController@destroy | `events.destroy` |

### Participants

| Method | URI | Controller Method | Name |
|--------|-----|-------------------|------|
| GET | `/participants` | ParticipantController@index | `participants.index` |
| GET | `/participants/create` | ParticipantController@create | `participants.create` |
| POST | `/participants` | ParticipantController@store | `participants.store` |
| GET | `/participants/{participant}` | ParticipantController@show | `participants.show` |
| GET | `/participants/{participant}/edit` | ParticipantController@edit | `participants.edit` |
| PUT/PATCH | `/participants/{participant}` | ParticipantController@update | `participants.update` |
| DELETE | `/participants/{participant}` | ParticipantController@destroy | `participants.destroy` |

### Registrations

| Method | URI | Controller Method | Name |
|--------|-----|-------------------|------|
| GET | `/registrations` | RegistrationController@index | `registrations.index` |
| GET | `/registrations/create` | RegistrationController@create | `registrations.create` |
| POST | `/registrations` | RegistrationController@store | `registrations.store` |
| GET | `/registrations/{registration}` | RegistrationController@show | `registrations.show` |
| GET | `/registrations/{registration}/edit` | RegistrationController@edit | `registrations.edit` |
| PUT/PATCH | `/registrations/{registration}` | RegistrationController@update | `registrations.update` |
| DELETE | `/registrations/{registration}` | RegistrationController@destroy | `registrations.destroy` |

> **Total: 22 rute aplikasi + 1 dashboard = 23 rute**

---

## 8. DAFTAR CONTROLLER

### DashboardController

| Method | Type | Fungsi |
|--------|------|--------|
| `__invoke()` | Single Action | Menampilkan dashboard dengan 4 stat cards, recent registrations, upcoming events |

**Eloquent digunakan:**
- `Event::count()` — Total event
- `Participant::count()` — Total peserta
- `Registration::count()` — Total registrasi
- `Event::where('status', 'upcoming')->where('event_date', '>', now())->count()` — Event aktif
- `Registration::with(['event', 'participant'])->latest()->take(5)->get()` — 5 registrasi terbaru
- `Event::where('status', 'upcoming')->withCount('registrations')->orderBy('event_date')->take(5)->get()` — 5 event mendatang

### EventController

| Method | Fungsi | Eloquent |
|--------|--------|----------|
| `index()` | List event + search + pagination | `Event::withCount('registrations')` + `when(request('search'))` + `paginate(10)` |
| `create()` | Form create event | — |
| `store()` | Simpan event baru | `Event::create($request->validated())` |
| `show()` | Detail event + list peserta | `$event->load(['registrations.participant'])` + `loadCount('registrations')` |
| `edit()` | Form edit event | Route Model Binding |
| `update()` | Update event | `$event->update($request->validated())` |
| `destroy()` | Hapus event | `$event->delete()` |

### ParticipantController

| Method | Fungsi | Eloquent |
|--------|--------|----------|
| `index()` | List peserta + search + pagination | `Participant::withCount('registrations')` + `when(request('search'))` + `paginate(10)` |
| `create()` | Form tambah peserta | — |
| `store()` | Simpan peserta | `Participant::create($request->validated())` |
| `show()` | Detail peserta + list event | `$participant->load(['registrations.event'])` |
| `edit()` | Form edit peserta | Route Model Binding |
| `update()` | Update peserta | `$participant->update($request->validated())` |
| `destroy()` | Hapus peserta | `$participant->delete()` |

### RegistrationController

| Method | Fungsi | Eloquent |
|--------|--------|----------|
| `index()` | List registrasi + search + pagination | `Registration::with(['event', 'participant'])` + `when(request('search'))` + `paginate(10)` |
| `create()` | Form registrasi (pilih event + peserta) | `Event::where('status', 'upcoming')->get()` + `Participant::orderBy('name')->get()` |
| `store()` | Simpan registrasi | `Registration::create(...)` |
| `show()` | Detail registrasi | `$registration->load(['event', 'participant'])` |
| `edit()` | Form edit registrasi | Route Model Binding + list events + list participants |
| `update()` | Update registrasi | `$registration->update(...)` |
| `destroy()` | Hapus registrasi | `$registration->delete()` |

---

## 9. DAFTAR MODEL

### Event

```php
class Event extends Model
{
    protected $fillable = ['title', 'description', 'event_date', 'location', 'quota', 'status'];
    protected $casts = ['event_date' => 'datetime', 'quota' => 'integer'];

    public function registrations(): HasMany      // 1:N
    public function participants(): BelongsToMany  // M:N via registrations
}
```

### Participant

```php
class Participant extends Model
{
    protected $fillable = ['name', 'email', 'phone'];

    public function registrations(): HasMany      // 1:N
    public function events(): BelongsToMany       // M:N via registrations
}
```

### Registration

```php
class Registration extends Model
{
    protected $fillable = ['event_id', 'participant_id', 'registration_date'];
    protected $casts = ['registration_date' => 'datetime'];

    public function event(): BelongsTo            // N:1
    public function participant(): BelongsTo      // N:1
}
```

---

## 10. SKENARIO DEMO PRESENTASI (10–15 MENIT)

### Menit 0–2: Pembukaan & Dashboard

> "Saya telah membangun Event Management System menggunakan Laravel. Aplikasi ini digunakan oleh admin kampus untuk mengelola event dan pendaftaran peserta."

1. Buka browser, arahkan ke `http://localhost:8080`
2. **Tunjukkan Dashboard:**
   - 4 stat cards: 7 Events, 15 Participants, 30 Registrations, 5 Active Events
   - Recent Registrations table (5 data terbaru)
   - Upcoming Events list dengan progress bar
3. **Jelaskan:** Statistik real-time dari Eloquent aggregation queries (`count()`, `withCount()`)

### Menit 2–4: CRUD Event — Create & Read

1. Klik **Events** di sidebar → tampil list event dengan status badge
2. **Tunjukkan Search:** Ketik "Workshop" → hasil filter real-time
3. Klik **Add Event** → Form create event
4. Isi form (title: "Demo Event", date, location, quota: 50, status: upcoming)
5. **Submit** → Redirect ke events list dengan flash message "Event berhasil dibuat."
6. **Jelaskan:** Form Request Validation (`StoreEventRequest`) — validasi server-side

### Menit 4–6: CRUD Event — Edit & Delete

1. Klik event yang baru dibuat → Detail page
2. Tampilkan detail + progress bar + list peserta (kosong)
3. Klik **Edit** → Form pre-filled dengan data event
4. Ubah quota menjadi 75 → Submit → Update sukses
5. Kembali ke index → Klik **Delete** pada event demo → Konfirmasi → Hapus
6. **Jelaskan:** Route Model Binding otomatis, Eloquent `update()` dan `delete()`

### Menit 6–8: CRUD Participant

1. Klik **Participants** di sidebar → List peserta dengan jumlah event joined
2. Tampilkan search ("andi") → filter by name/email
3. Klik **Add Participant** → Form
4. Isi: Nama, Email, Phone → Submit
5. Klik nama peserta → Detail + list event yang diikuti
6. **Jelaskan:** Email unique validation, `Rule::unique()->ignore()` untuk update

### Menit 8–10: CRUD Registration

1. Klik **Registrations** → List semua registrasi dengan nama peserta + judul event
2. Klik **New Registration** → Form dengan 2 dropdown select
3. Pilih event (upcoming only) + participant → Submit
4. Coba daftarkan peserta yang sama ke event yang sama → **ERROR: "Peserta sudah terdaftar di event ini."**
5. **Jelaskan:** Unique constraint di database + validasi Form Request `Rule::unique('registrations')->where('participant_id', ...)` — mencegah registrasi ganda

### Menit 10–12: Relasi Database & Eloquent

1. Buka detail event (event dengan peserta terdaftar)
2. Tampilkan **Registered Participants** table — data dari Eloquent eager loading
3. **Jelaskan relasi:**
   ```
   Event → hasMany → Registration → belongsTo → Participant
   ```
4. Tampilkan kode di controller:
   ```php
   $event->load(['registrations.participant']);
   $event->loadCount('registrations');
   ```
5. Jelaskan `withCount()` untuk menghitung jumlah registrasi tanpa query tambahan

### Menit 12–14: Arsitektur MVC

1. Buka struktur folder — tunjukkan pemisahan Model, View, Controller
2. Buka `routes/web.php` — tunjukkan `Route::resource()` 3 baris
3. Buka satu Form Request — tunjukkan rules validation
4. Buka Blade view — tunjukkan `@extends`, `@section`, `@error`
5. **Jelaskan alur:**
   ```
   Browser → Route → Controller → Form Request (validation) → Model (Eloquent) → View (Blade) → Browser
   ```

### Menit 14–15: Penutup

1. Kembali ke Dashboard
2. **Summarize fitur:**
   - 3 CRUD modules (Event, Participant, Registration)
   - Server-side validation
   - Database relationships (1:N, N:1, M:N)
   - Search + Pagination
   - Responsive Tailwind CSS
   - 100% Eloquent ORM (0 raw SQL)
3. **Q&A**

---

## TEKNOLOGI

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| Laravel | 13.x | Framework PHP MVC |
| PHP | 8.5 | Runtime |
| SQLite | 3 | Database |
| Eloquent ORM | — | Object-Relational Mapping |
| Tailwind CSS | 4.x | Utility-first CSS Framework |
| Vite | 8.x | Frontend build tool |
| Blade | — | Laravel Template Engine |

---

> **Dibuat untuk presentasi tugas kuliah Framework PHP & CRUD — Semester 4 Rekayasa Web**
