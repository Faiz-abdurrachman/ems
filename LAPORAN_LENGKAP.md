# LAPORAN PROYEK
# SISTEM MANAJEMEN EVENT KAMPUS (EVENT MANAGEMENT SYSTEM)
# TUGAS MATA KULIAH FRAMEWORK PHP DAN CRUD

## DAFTAR ISI
1. BAB 1 Pendahuluan
2. BAB 2 Framework yang Digunakan
3. BAB 3 Analisis Sistem
4. BAB 4 Database
5. BAB 5 Implementasi
6. BAB 6 Implementasi CRUD
7. BAB 7 Tampilan Sistem
8. BAB 8 Pengujian
9. BAB 9 Kesimpulan
Lampiran A — Daftar Route
Lampiran B — Daftar Model
Lampiran C — Daftar Controller
Lampiran D — Daftar View Blade
Lampiran E — Daftar Form Request

## DAFTAR GAMBAR
Gambar 3.1 Use Case Diagram
Gambar 3.2 Alur MVC
Gambar 4.1 Entity Relationship Diagram
Gambar 5.1 Struktur Folder Project
Gambar 7.1 Tampilan Dashboard
Gambar 7.2 Tampilan Halaman Data
Gambar 7.3 Tampilan Form Tambah
Gambar 7.4 Tampilan Form Edit
Gambar 7.5 Tampilan Detail Data

## DAFTAR TABEL
Tabel 4.1 Struktur Tabel events
Tabel 4.2 Struktur Tabel participants
Tabel 4.3 Struktur Tabel registrations
Tabel 6.1 Form Request Event
Tabel 6.2 Form Request Participant
Tabel 6.3 Form Request Registration
Tabel 8.1 Hasil Pengujian CRUD
Tabel A.1 Daftar Route
Tabel B.1 Daftar Model
Tabel C.1 Daftar Controller
Tabel D.1 Daftar View Blade
Tabel E.1 Daftar Form Request

---

## BAB 1 PENDAHULUAN

### 1.1 Latar Belakang

Perkembangan teknologi informasi telah mendorong digitalisasi di berbagai bidang, termasuk manajemen kegiatan di lingkungan kampus. Universitas dan institusi pendidikan tinggi secara rutin menyelenggarakan berbagai acara seperti workshop, seminar, kompetisi, pameran proyek mahasiswa, dan career fair. Setiap acara memerlukan sistem pendaftaran peserta yang tertib dan terorganisir.

Selama ini, pendaftaran peserta event kampus masih dilakukan secara konvensional, seperti mengisi formulir kertas, menyebarkan Google Form yang berbeda-beda untuk setiap acara, atau melalui pesan WhatsApp yang tidak terstruktur. Metode ini menimbulkan beberapa permasalahan, antara lain:

1. **Data Tersebar** — Informasi event dan peserta tersimpan di berbagai platform sehingga menyulitkan rekapitulasi.
2. **Registrasi Ganda** — Tanpa validasi otomatis, seorang peserta dapat mendaftar dua kali di event yang sama.
3. **Tidak Ada Dashboard** — Panitia kesulitan memantau jumlah event, peserta, dan status registrasi secara real-time.
4. **Keterbatasan Akses** — Data tidak tersedia dalam satu sistem terpadu yang dapat diakses kapan saja.

Berdasarkan permasalahan tersebut, penulis membangun **Sistem Manajemen Event Kampus (EMS)** — sebuah aplikasi web berbasis Laravel yang menyediakan fitur pengelolaan event, pendaftaran peserta, dan dashboard statistik dalam satu platform terpadu.

### 1.2 Rumusan Masalah

1. Bagaimana merancang dan membangun sistem manajemen event kampus yang terintegrasi?
2. Bagaimana mengelola data event, peserta, dan registrasi dalam satu aplikasi berbasis web?
3. Bagaimana mencegah registrasi ganda pada event yang sama oleh peserta yang sama?
4. Bagaimana menyajikan informasi statistik melalui dashboard yang informatif?

### 1.3 Tujuan Proyek

1. Membangun sistem CRUD (Create, Read, Update, Delete) untuk entitas Event, Peserta, dan Registrasi.
2. Menerapkan arsitektur Model-View-Controller (MVC) Laravel secara penuh.
3. Menggunakan Eloquent ORM untuk seluruh interaksi dengan database.
4. Mengimplementasikan validasi server-side melalui Form Request Validation.
5. Merancang antarmuka pengguna modern dan responsif menggunakan Tailwind CSS.

### 1.4 Batasan Masalah

1. Aplikasi berbasis web — tidak mencakup versi mobile native.
2. Digunakan oleh admin/panitia — tidak ada halaman publik untuk pendaftaran mandiri.
3. Terdapat 3 entitas utama: Event, Participant, Registration.
4. Database menggunakan SQLite (file-based database) untuk kemudahan deployment.
5. Tidak termasuk sistem autentikasi pengguna.

---

## BAB 2 FRAMEWORK YANG DIGUNAKAN

### 2.1 Pengertian Laravel

Laravel adalah framework PHP open-source yang dikembangkan oleh Taylor Otwell pada tahun 2011. Laravel mengikuti pola arsitektur Model-View-Controller (MVC) dan menyediakan berbagai fitur bawaan seperti Eloquent ORM, Blade templating engine, Artisan CLI, sistem migration database, dan Form Request validation.

Versi Laravel yang digunakan dalam proyek ini adalah **Laravel 13.x** yang berjalan di atas **PHP 8.5**. Laravel 13 merupakan versi rilis terbaru framework ini.

### 2.2 Alasan Memilih Laravel

Beberapa alasan pemilihan Laravel sebagai framework untuk proyek ini adalah:

| No | Alasan | Penjelasan |
|----|--------|------------|
| 1 | Arsitektur MVC | Memisahkan logika bisnis (Model), tampilan (View), dan pengendali (Controller) |
| 2 | Eloquent ORM | Object-Relational Mapping yang ekspresif — tidak perlu menulis SQL mentah |
| 3 | Blade Template | Template engine ringan dengan sintaks bersih |
| 4 | Migration System | Version control untuk skema database |
| 5 | Form Request Validation | Validasi server-side yang rapi dan terstruktur |
| 6 | Artisan CLI | Command-line tool untuk berbagai tugas otomatisasi |
| 7 | Vite Integration | Build tool frontend modern untuk CSS dan JavaScript |
| 8 | Komunitas Besar | Banyak tutorial, package, dan dokumentasi |

### 2.3 Kelebihan Laravel

1. **Ekosistem Lengkap** — Laravel menyediakan package official seperti Breeze (autentikasi), Jetstream, Cashier, dan Forge.
2. **Keamanan Bawaan** — CSRF protection, SQL injection prevention melalui parameter binding, XSS protection pada Blade.
3. **Eloquent ORM Ekspresif** — Memungkinkan query database menggunakan PHP syntax yang mudah dibaca.
4. **Route Caching** — Optimasi performa untuk aplikasi production.
5. **Blade Components** — Template engine dengan fitur komponen yang reusable.
6. **Built-in Pagination** — Fitur pagination yang otomatis terintegrasi dengan Tailwind CSS.

### 2.4 Kekurangan Laravel

1. **Learning Curve Curam** — Bagi pemula, konsep seperti Service Container, Facades, dan Dependency Injection cukup kompleks.
2. **Framework Berat** — Laravel memiliki banyak dependensi yang membuat ukuran project relatif besar.
3. **Prasyarat Multi-Tools** — Membutuhkan Composer (PHP) dan Node.js/npm (JavaScript) untuk development.
4. **Perubahan Versi** — Upgrade antar versi mayor sering memerlukan penyesuaian kode yang signifikan.

---

## BAB 3 ANALISIS SISTEM

### 3.1 Deskripsi Proyek

Campus Event Management System (EMS) adalah aplikasi web yang dirancang untuk membantu admin atau panitia kampus dalam:

1. **Mengelola Data Event** — Membuat, melihat, mengedit, dan menghapus event kampus.
2. **Mengelola Data Peserta** — Mendata peserta yang terdaftar dalam sistem.
3. **Mengelola Registrasi** — Mendaftarkan peserta ke event tertentu dengan validasi anti-duplikasi.
4. **Dashboard Statistik** — Menampilkan ringkasan jumlah event, peserta, registrasi, dan event aktif.

### 3.2 Fitur Sistem

| ID | Fitur | Keterangan |
|----|-------|------------|
| F01 | Dashboard | 4 kartu statistik + registrasi terbaru + event mendatang |
| F02 | CRUD Event | Create, Read, Update, Delete data event |
| F03 | CRUD Peserta | Create, Read, Update, Delete data peserta |
| F04 | CRUD Registrasi | Daftarkan peserta ke event, edit, hapus registrasi |
| F05 | Validasi Server-Side | Form Request Validation untuk semua input |
| F06 | Pencarian | Search bar di setiap halaman data |
| F07 | Pagination | 10 data per halaman |
| F08 | Responsive Design | Tampilan adaptif di desktop dan mobile |
| F09 | Unique Constraint | Mencegah registrasi ganda (event + participant) |

### 3.3 Use Case Diagram

```
┌──────────────────────────────────────────────────┐
│                  ADMIN (PANITIA)                  │
└──────────────────────┬───────────────────────────┘
                       │
     ┌─────────────────┼─────────────────┐
     │                 │                 │
     ▼                 ▼                 ▼
┌──────────┐    ┌────────────┐    ┌──────────────┐
│  Kelola  │    │  Kelola    │    │   Kelola     │
│  Event   │    │  Peserta   │    │  Registrasi  │
└──────────┘    └────────────┘    └──────────────┘
     │                 │                 │
     │    ┌────────────┼────────────┐    │
     └───►│        Dashboard        │◄───┘
          │   (Lihat Statistik)     │
          └─────────────────────────┘
```

### 3.4 Alur MVC (Model-View-Controller)

```
┌──────────────────────────────────────────────────────────┐
│                       BROWSER                            │
└─────────────────────┬────────────────────────────────────┘
                      │ HTTP Request (GET/POST/DELETE)
                      ▼
┌──────────────────────────────────────────────────────────┐
│                      ROUTE (web.php)                      │
│  Route::resource('events', EventController::class)       │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│                   CONTROLLER                              │
│  EventController.php                                      │
│  public function index(): View                            │
│  {                                                        │
│      $events = Event::withCount('registrations')         │
│          ->paginate(10);                                  │
│      return view('events.index', compact('events'));     │
│  }                                                        │
└─────────────────────┬────────────────────────────────────┘
                      │ Eloquent Query
                      ▼
┌──────────────────────────────────────────────────────────┐
│                   MODEL (Eloquent)                        │
│  Event.php: hasMany → Registration                       │
│  SELECT * FROM events + COUNT registrations              │
└─────────────────────┬────────────────────────────────────┘
                      │ SQL Query
                      ▼
┌──────────────────────────────────────────────────────────┐
│                   DATABASE (SQLite)                       │
│  events table, participants table, registrations table   │
└─────────────────────┬────────────────────────────────────┘
                      │ Data
                      ▼
┌──────────────────────────────────────────────────────────┐
│                   VIEW (Blade + Tailwind)                  │
│  events/index.blade.php                                   │
│  @foreach($events as $event)                             │
│  {{ $event->title }} — {{ $event->registrations_count }} │
│  @endforeach                                              │
│  {{ $events->links() }}                                  │
└─────────────────────┬────────────────────────────────────┘
                      │ HTML Response
                      ▼
┌──────────────────────────────────────────────────────────┐
│                       BROWSER                            │
│  (Tampilan Table + Search + Pagination)                  │
└──────────────────────────────────────────────────────────┘
```

---

## BAB 4 DATABASE

### 4.1 Entity Relationship Diagram (ERD)

```
┌──────────────────────────┐
│         events           │
├──────────────────────────┤
│ PK  id          (bigInt) │ ───┐
│     title       (string) │    │
│     description (text)   │    │  1 : N
│     event_date  (datetime)│   │
│     location    (string) │    │
│     quota       (integer)│    │
│     status      (enum)   │    │
│     created_at  (time)   │    │
│     updated_at  (time)   │    │
└──────────────────────────┘    │
                                │
                    ┌───────────┘
                    │
                    ▼
┌──────────────────────────┐
│      registrations       │
├──────────────────────────┤
│ PK  id               (bigInt)  │
│ FK  event_id         (bigInt)  │ ── REFERENCES events(id) ON DELETE CASCADE
│ FK  participant_id   (bigInt)  │ ── REFERENCES participants(id) ON DELETE CASCADE
│     registration_date(datetime)│
│     created_at       (time)    │
│     updated_at       (time)    │
│                               │
│ UNIQUE (event_id, participant_id)  ← mencegah duplikasi
└──────────────────────────┘
                    ▲
                    │
                    │  N : 1
                    │
┌──────────────────────────┐
│      participants        │
├──────────────────────────┤
│ PK  id          (bigInt) │
│     name        (string) │
│     email       (string) │ ── UNIQUE
│     phone       (string) │
│     created_at  (time)   │
│     updated_at  (time)   │
└──────────────────────────┘
```

### 4.2 Struktur Tabel

**Tabel 4.1: Struktur Tabel `events`**

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigInteger, PK | AI, primary key |
| title | string(255) | Judul event, NOT NULL |
| description | text | Deskripsi event, nullable |
| event_date | datetime | Tanggal pelaksanaan, NOT NULL |
| location | string(255) | Lokasi event, NOT NULL |
| quota | integer | Kuota maksimal peserta, NOT NULL |
| status | enum('upcoming','ongoing','completed','cancelled') | Status event |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu perubahan |

**Tabel 4.2: Struktur Tabel `participants`**

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigInteger, PK | AI, primary key |
| name | string(255) | Nama peserta, NOT NULL |
| email | string(255) | Email unik, NOT NULL, UNIQUE |
| phone | string(20) | Nomor telepon, nullable |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu perubahan |

**Tabel 4.3: Struktur Tabel `registrations`**

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | bigInteger, PK | AI, primary key |
| event_id | bigInteger, FK | Referensi ke events.id, ON DELETE CASCADE |
| participant_id | bigInteger, FK | Referensi ke participants.id, ON DELETE CASCADE |
| registration_date | datetime | Tanggal pendaftaran, default: now() |
| created_at | timestamp | Waktu pembuatan |
| updated_at | timestamp | Waktu perubahan |

**Constraint Khusus:** `UNIQUE(event_id, participant_id)` — memastikan satu peserta hanya dapat mendaftar satu kali di setiap event.

### 4.3 Relasi Antar Tabel

| Relasi | Tipe | Penjelasan |
|--------|------|------------|
| Event → Registration | 1 : N (hasMany) | Satu event bisa memiliki banyak registrasi |
| Participant → Registration | 1 : N (hasMany) | Satu peserta bisa memiliki banyak registrasi di berbagai event |
| Registration → Event | N : 1 (belongsTo) | Setiap registrasi terhubung ke satu event |
| Registration → Participant | N : 1 (belongsTo) | Setiap registrasi terhubung ke satu peserta |
| Event → Participant | M : N (belongsToMany) | Melalui tabel pivot registrations |

### 4.4 Migration Database

Laravel menggunakan sistem **Migration** untuk mengelola perubahan skema database. Migration adalah file PHP yang berisi instruksi untuk membuat (up) atau menghapus (down) tabel.

Contoh migration tabel registrations:

```php
Schema::create('registrations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->cascadeOnDelete();
    $table->foreignId('participant_id')->constrained()->cascadeOnDelete();
    $table->dateTime('registration_date')->useCurrent();
    $table->timestamps();
    $table->unique(['event_id', 'participant_id']);
});
```

Migration dijalankan dengan perintah:
```bash
php artisan migrate
```

### 4.5 Database Seeder

DatabaseSeeder bertugas mengisi data dummy untuk keperluan pengembangan dan demonstrasi. Data yang di-seed:

| Entitas | Jumlah |
|---------|--------|
| Events | 7 event (5 upcoming, 2 completed) |
| Participants | 15 peserta |
| Registrations | 30 registrasi |

Contoh data event yang di-seed:
- Workshop Web Development (quota: 30)
- Seminar Cyber Security (quota: 100)
- Lomba Debat Bahasa Inggris (completed)
- Pameran Proyek Mahasiswa (quota: 50)
- Pelatihan Public Speaking (quota: 25)
- Hackathon 2026 (completed)
- Career Fair Kampus (quota: 200)

Seeder dijalankan dengan perintah:
```bash
php artisan db:seed
```

---

## BAB 5 IMPLEMENTASI

### 5.1 Langkah Instalasi

1. **Clone repository** — `git clone https://github.com/Faiz-abdurrachman/ems.git`
2. **Install dependensi PHP** — `composer install`
3. **Install dependensi JavaScript** — `npm install`
4. **Setup database** — `touch database/database.sqlite`
5. **Jalankan migration** — `php artisan migrate`
6. **Isi data** — `php artisan db:seed`
7. **Build CSS** — `npm run build`
8. **Jalankan server** — `php artisan serve --port=8080`
9. **Buka browser** — `http://localhost:8080`

### 5.2 Struktur Folder Laravel

```
ems/
├── app/
│   ├── Http/
│   │   ├── Controllers/              ← Controller (logika bisnis)
│   │   │   ├── DashboardController.php
│   │   │   ├── EventController.php
│   │   │   ├── ParticipantController.php
│   │   │   └── RegistrationController.php
│   │   └── Requests/                 ← Form Request Validation
│   │       ├── StoreEventRequest.php
│   │       ├── UpdateEventRequest.php
│   │       ├── StoreParticipantRequest.php
│   │       ├── UpdateParticipantRequest.php
│   │       ├── StoreRegistrationRequest.php
│   │       └── UpdateRegistrationRequest.php
│   └── Models/                       ← Model (Eloquent ORM)
│       ├── Event.php
│       ├── Participant.php
│       └── Registration.php
├── database/
│   ├── migrations/                   ← Skema database
│   │   ├── ...create_events_table.php
│   │   ├── ...create_participants_table.php
│   │   └── ...create_registrations_table.php
│   ├── seeders/
│   │   └── DatabaseSeeder.php        ← Data dummy
│   └── database.sqlite               ← File database SQLite
├── resources/
│   ├── css/app.css                   ← Entry point Tailwind CSS
│   └── views/                        ← Blade Templates
│       ├── layouts/app.blade.php     ← Layout utama
│       ├── components/sidebar.blade.php
│       ├── dashboard.blade.php
│       ├── events/                   ← 4 view untuk event
│       ├── participants/             ← 4 view untuk peserta
│       └── registrations/            ← 4 view untuk registrasi
├── routes/
│   └── web.php                       ← Definisi route
├── Dockerfile                        ← Deploy Render
├── render.yaml                       ← Konfigurasi Render
└── composer.json                     ← Dependensi PHP
```

### 5.3 Penjelasan MVC

#### 5.3.1 Model

Model merepresentasikan data dan logika bisnis. Dalam Laravel, setiap tabel di database memiliki satu Model Eloquent.

**Event.php:**
```php
class Event extends Model
{
    protected $fillable = ['title', 'description', 'event_date', 'location', 'quota', 'status'];
    protected $casts = ['event_date' => 'datetime', 'quota' => 'integer'];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
```

- `$fillable` — mendefinisikan kolom yang boleh diisi massal (mass assignment protection)
- `$casts` — mengkonversi tipe data kolom (datetime, integer)
- `registrations()` — mendefinisikan relasi one-to-many ke tabel registrations

**Registration.php:**
```php
class Registration extends Model
{
    protected $fillable = ['event_id', 'participant_id', 'registration_date'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }
}
```

- `belongsTo(Event::class)` — setiap registrasi memiliki satu event (belongsTo = many-to-one)
- `belongsTo(Participant::class)` — setiap registrasi memiliki satu peserta

#### 5.3.2 View (Blade)

Blade adalah template engine Laravel. File disimpan di `resources/views/` dengan ekstensi `.blade.php`.

Proyek ini memiliki 15 file Blade yang saling terkait:

| Direktif Blade | Fungsi |
|----------------|--------|
| `@extends('layouts.app')` | Mewarisi layout utama |
| `@section('content')` | Mendefinisikan konten untuk layout |
| `@foreach($events as $event)` | Loop data |
| `@csrf` | Token CSRF protection |
| `@method('PUT')` | Method spoofing untuk form PUT/DELETE |
| `@error('title')` | Menampilkan pesan error validasi |
| `{{ $variable }}` | Output data ke HTML |
| `{!! $html !!}` | Output HTML tanpa escaping |

#### 5.3.3 Controller

Controller menangani request HTTP dan menghubungkan Model dengan View.

**EventController@index — Menampilkan daftar event:**
```php
public function index(): View
{
    $events = Event::withCount('registrations')
        ->when(request('search'), fn($q) =>
            $q->where('title','like','%'.request('search').'%'))
        ->latest()
        ->paginate(10)
        ->withQueryString();
    return view('events.index', compact('events'));
}
```

- `withCount('registrations')` — eager load jumlah registrasi per event
- `when(search)` — pencarian kondisional
- `paginate(10)` — 10 data per halaman
- `withQueryString()` — menyertakan query string di pagination links

**RegistrationController@store — Mendaftarkan peserta:**
```php
public function store(StoreRegistrationRequest $request): RedirectResponse
{
    Registration::create([
        'event_id' => $request->event_id,
        'participant_id' => $request->participant_id,
        'registration_date' => now(),
    ]);
    return redirect()->route('registrations.index')
        ->with('success', 'Peserta berhasil didaftarkan.');
}
```

- Menerima `StoreRegistrationRequest` yang sudah tervalidasi
- `Registration::create()` — mass assignment dengan data tervalidasi
- `redirect()->route()` — redirect ke halaman index
- `with('success', ...)` — flash message

#### 5.3.4 Route

Route mendefinisikan mapping antara URL, HTTP method, dan Controller.

```php
Route::get('/', DashboardController::class)->name('dashboard');
Route::resource('events', EventController::class);
Route::resource('participants', ParticipantController::class);
Route::resource('registrations', RegistrationController::class);
```

| Fitur Route | Penjelasan |
|-------------|------------|
| `Route::get('/', DashboardController::class)` | Route single action ke DashboardController |
| `Route::resource('events', ...)` | Otomatis generate 7 route CRUD (index, create, store, show, edit, update, destroy) |
| `->name('dashboard')` | Memberi nama route untuk digunakan di Blade (`{{ route('dashboard') }}`) |

Total route yang dihasilkan: **25 route** (1 dashboard + 7×3 resource = 22 + 2 storage).

### 5.4 Eloquent ORM

Eloquent ORM adalah implementasi Active Record pattern di Laravel yang memungkinkan developer berinteraksi dengan database menggunakan objek PHP tanpa menulis SQL mentah.

**Contoh query yang digunakan dalam proyek:**

| Query | SQL Equivalent |
|-------|---------------|
| `Event::count()` | `SELECT COUNT(*) FROM events` |
| `Event::find(1)` | `SELECT * FROM events WHERE id=1` |
| `Event::create([...])` | `INSERT INTO events (...) VALUES (...)` |
| `Event::where('status','upcoming')->get()` | `SELECT * FROM events WHERE status='upcoming'` |
| `Event::withCount('registrations')` | `SELECT *, (SELECT COUNT(*) FROM registrations WHERE event_id=events.id) as registrations_count FROM events` |
| `Registration::with(['event','participant'])` | `SELECT * FROM registrations; SELECT * FROM events WHERE id IN (...); SELECT * FROM participants WHERE id IN (...)` |

**Eager Loading:**

Eager loading dengan `with()` mencegah N+1 query problem. Contoh:

```php
// Tanpa eager loading = N+1 query (slow)
$registrations = Registration::all();
foreach ($registrations as $reg) {
    echo $reg->event->title; // Query baru setiap iterasi!
}

// Dengan eager loading = 3 query (fast)
$registrations = Registration::with(['event', 'participant'])->get();
```

### 5.5 Form Request Validation

Form Request adalah kelas khusus yang memisahkan logika validasi dari controller.

**StoreEventRequest.php:**
```php
class StoreEventRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after:now'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
        ];
    }
}
```

**StoreRegistrationRequest.php — Mencegah registrasi ganda:**
```php
'event_id' => [
    'required', 'exists:events,id',
    Rule::unique('registrations')
        ->where('participant_id', $this->participant_id),
],
```

- `exists:events,id` — memastikan event_id benar-benar ada di database
- `Rule::unique(...)` — mencegah input duplikat untuk kombinasi (event_id, participant_id)

**Custom Message (Bahasa Indonesia):**
```php
public function messages(): array
{
    return [
        'title.required' => 'Judul event wajib diisi.',
        'quota.min' => 'Kuota minimal 1 peserta.',
    ];
}
```

### 5.6 Tailwind CSS dan Responsive Design

Tailwind CSS v4 digunakan untuk seluruh styling dalam proyek ini. Tailwind CSS adalah utility-first CSS framework yang menyediakan class-class kecil seperti `flex`, `text-sm`, `bg-indigo-600` yang dikombinasikan langsung di elemen HTML.

**Keunggulan Tailwind:**
- Utility-first — tidak perlu menulis CSS kustom
- JIT (Just-In-Time) compiler — hanya generate class yang digunakan
- Responsive prefix — `sm:`, `md:`, `lg:`, `xl:` untuk breakpoints
- Dark mode support
- Integrasi seamless dengan Vite

**Contoh responsive grid:**
```html
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <!-- 1 kolom di mobile, 2 di tablet, 4 di desktop -->
</div>
```

### 5.7 Search dan Pagination

**Search** diimplementasikan menggunakan Eloquent query scope dengan `when()`:

```php
$events = Event::withCount('registrations')
    ->when(request('search'), fn($q) =>
        $q->where('title', 'like', '%'.request('search').'%')
          ->orWhere('location', 'like', '%'.request('search').'%'))
    ->latest()
    ->paginate(10)
    ->withQueryString();
```

**Pagination** menggunakan method bawaan Laravel:

```php
paginate(10) // 10 data per halaman
$events->links() // Menampilkan navigasi halaman di Blade
```

---

## BAB 6 IMPLEMENTASI CRUD

### 6.1 Create (Event)

**Route:** `POST /events` → `EventController@store`

**Controller:**
```php
public function store(StoreEventRequest $request): RedirectResponse
{
    Event::create($request->validated());
    return redirect()->route('events.index')
        ->with('success', 'Event berhasil dibuat.');
}
```

**View (Form):**
```html
<form action="{{ route('events.store') }}" method="POST">
    @csrf
    <input type="text" name="title" value="{{ old('title') }}">
    @error('title') <p class="text-red-600">{{ $message }}</p> @enderror
    <button type="submit">Create Event</button>
</form>
```

### 6.2 Read (Event)

**Index (list):**
```php
$events = Event::withCount('registrations')->paginate(10);
return view('events.index', compact('events'));
```

**Show (detail):**
```php
$event->load(['registrations.participant']);
$event->loadCount('registrations');
return view('events.show', compact('event'));
```

### 6.3 Update (Event)

**Route:** `PUT /events/{event}` → `EventController@update`

```php
public function update(UpdateEventRequest $request, Event $event): RedirectResponse
{
    $event->update($request->validated());
    return redirect()->route('events.index')
        ->with('success', 'Event berhasil diperbarui.');
}
```

### 6.4 Delete (Event)

**Route:** `DELETE /events/{event}` → `EventController@destroy`

```php
public function destroy(Event $event): RedirectResponse
{
    $event->delete();
    return redirect()->route('events.index')
        ->with('success', 'Event berhasil dihapus.');
}
```

Karena foreign key menggunakan `cascadeOnDelete()`, saat event dihapus, semua registrasi terkait juga otomatis terhapus dari database.

### 6.5 CRUD Peserta

Pola yang sama diterapkan untuk Participant, dengan validasi khusus email unik:
- `email` = `required|email|unique:participants,email`
- Pada update: `Rule::unique('participants','email')->ignore($this->route('participant'))`

### 6.6 CRUD Registrasi

Pola yang sama dengan validasi khusus:
- `event_id` = `required|exists:events,id`
- `participant_id` = `required|exists:participants,id`
- Anti-duplikasi: `Rule::unique('registrations')->where('participant_id', $this->participant_id)`

---

## BAB 7 TAMPILAN SISTEM

### 7.1 Dashboard

Dashboard menampilkan empat kartu statistik dengan warna berbeda:
- **Total Events** — ikon kalender, warna indigo
- **Total Participants** — ikon user, warna emerald
- **Total Registrations** — ikon checklist, warna amber
- **Active Events** — ikon petir, warna rose

Setiap kartu menampilkan angka besar dan label kecil. Di bawahnya terdapat dua panel:
- **Recent Registrations** — tabel 5 registrasi terbaru
- **Upcoming Events** — daftar 5 event mendatang dengan progress bar

### 7.2 Halaman Data

Setiap halaman list (events, participants, registrations) memiliki:
- Judul halaman + tombol "Add New"
- Search bar dengan ikon kaca pembesar
- Tabel responsif dengan header tebal dan row hover
- Kolom aksi (View, Edit, Delete) di sisi kanan
- Status badge berwarna untuk status event
- Pagination navigasi di bagian bawah

### 7.3 Form Tambah

Form menggunakan layout card putih dengan border dan shadow. Setiap field:
- Label di atas input
- Input full-width dengan rounded corner
- Border merah + pesan error di bawah field jika validasi gagal
- Tombol Cancel + Submit di bagian bawah

### 7.4 Form Edit

Mirip dengan form tambah, tetapi semua field sudah terisi dengan data yang ada menggunakan `old('field', $model->field)`.

### 7.5 Halaman Detail

Menampilkan semua informasi entitas dalam format grid 2 kolom. Untuk detail event, terdapat:
- Progress bar registrasi
- Tabel peserta yang sudah mendaftar
- Tombol Edit dan Delete

---

## BAB 8 PENGUJIAN

### 8.1 Skenario Pengujian

| No | Skenario | Input | Hasil Diharapkan | Hasil | Status |
|----|----------|-------|-----------------|-------|--------|
| 1 | Tambah event valid | Data lengkap | Redirect ke index, event muncul | Sesuai | ✅ |
| 2 | Tambah event tanpa judul | title kosong | Validasi error "Judul event wajib diisi" | Sesuai | ✅ |
| 3 | Tambah event kuota 0 | quota=0 | Validasi error "Kuota minimal 1" | Sesuai | ✅ |
| 4 | Tambah event tanggal lampau | event_date < now | Validasi error "Tanggal setelah hari ini" | Sesuai | ✅ |
| 5 | Tambah peserta email duplikat | email sudah ada | Validasi error "Email sudah terdaftar" | Sesuai | ✅ |
| 6 | Format email invalid | email="abc" | Validasi error "Format email tidak valid" | Sesuai | ✅ |
| 7 | Registrasi normal | event + peserta valid | Sukses, redirect ke index | Sesuai | ✅ |
| 8 | Registrasi duplikat | same event + same participant | Validasi error "Peserta sudah terdaftar" | Sesuai | ✅ |
| 9 | Edit event | Ubah status | Sukses, status berubah | Sesuai | ✅ |
| 10 | Hapus event | Delete | Sukses, event hilang dari tabel | Sesuai | ✅ |
| 11 | Hapus event dgn registrasi | Delete | Cascade: event + registrasi terhapus | Sesuai | ✅ |
| 12 | Search event | search="workshop" | Tabel terfilter | Sesuai | ✅ |
| 13 | Pagination | Data > 10 | Muncul navigasi halaman | Sesuai | ✅ |
| 14 | Dashboard statistik | Buka / | Semua angka sesuai | Sesuai | ✅ |

### 8.2 Hasil Pengujian

Seluruh 14 skenario pengujian lulus 100% tanpa error. Validasi server-side berfungsi dengan baik, constraint unik mencegah registrasi ganda, dan cascade delete bekerja sesuai yang diharapkan. Semua tombol dan navigasi berfungsi dengan benar.

---

## BAB 9 KESIMPULAN

### 9.1 Hasil Proyek

Proyek Sistem Manajemen Event Kampus (EMS) telah berhasil dibangun menggunakan Laravel 13, Eloquent ORM, Blade template engine, dan Tailwind CSS v4. Sistem ini menyediakan:

1. Full CRUD untuk 3 entitas yang saling berelasi (Event, Participant, Registration)
2. Dashboard statistik real-time dengan 4 kartu informasi
3. Validasi data lengkap melalui 6 Form Request
4. Pencarian dan pagination di setiap halaman data
5. Pencegahan registrasi ganda melalui constraint unik
6. Antarmuka pengguna modern dan responsif
7. Deployment siap melalui Docker di Render

### 9.2 Kelebihan Sistem

1. Arsitektur MVC yang bersih dan terstruktur
2. 100% Eloquent ORM — tidak ada SQL mentah
3. Validasi server-side yang ketat
4. Cascade delete untuk menjaga integritas data
5. Desain responsif yang adaptif di berbagai ukuran layar
6. Dashboard informatif untuk monitoring cepat
7. Siap demo presentasi dalam 10-15 menit

### 9.3 Saran Pengembangan Selanjutnya

1. **Autentikasi Pengguna** — Menambahkan sistem login dengan Laravel Breeze atau Jetstream
2. **Role-Based Access Control** — Membedakan hak akses admin dan peserta biasa
3. **Halaman Publik** — Peserta dapat mendaftar mandiri ke event yang tersedia
4. **Notifikasi Email** — Konfirmasi pendaftaran via email otomatis
5. **Export Data** — Fitur export ke PDF atau Excel untuk laporan
6. **REST API** — Menyediakan endpoint JSON untuk integrasi dengan frontend lain
7. **Upload Poster** — Fitur upload gambar poster untuk setiap event
8. **QR Code** — Generate QR code untuk check-in peserta di hari event

---

## LAMPIRAN A — DAFTAR ROUTE

| Method | URI | Controller Method | Nama Route |
|--------|-----|-------------------|------------|
| GET | / | DashboardController@__invoke | dashboard |
| GET | /events | EventController@index | events.index |
| GET | /events/create | EventController@create | events.create |
| POST | /events | EventController@store | events.store |
| GET | /events/{event} | EventController@show | events.show |
| GET | /events/{event}/edit | EventController@edit | events.edit |
| PUT/PATCH | /events/{event} | EventController@update | events.update |
| DELETE | /events/{event} | EventController@destroy | events.destroy |
| GET | /participants | ParticipantController@index | participants.index |
| GET | /participants/create | ParticipantController@create | participants.create |
| POST | /participants | ParticipantController@store | participants.store |
| GET | /participants/{participant} | ParticipantController@show | participants.show |
| GET | /participants/{participant}/edit | ParticipantController@edit | participants.edit |
| PUT/PATCH | /participants/{participant} | ParticipantController@update | participants.update |
| DELETE | /participants/{participant} | ParticipantController@destroy | participants.destroy |
| GET | /registrations | RegistrationController@index | registrations.index |
| GET | /registrations/create | RegistrationController@create | registrations.create |
| POST | /registrations | RegistrationController@store | registrations.store |
| GET | /registrations/{registration} | RegistrationController@show | registrations.show |
| GET | /registrations/{registration}/edit | RegistrationController@edit | registrations.edit |
| PUT/PATCH | /registrations/{registration} | RegistrationController@update | registrations.update |
| DELETE | /registrations/{registration} | RegistrationController@destroy | registrations.destroy |

## LAMPIRAN B — DAFTAR MODEL

| Model | File | $fillable | Relasi |
|-------|------|-----------|--------|
| Event | app/Models/Event.php | title, description, event_date, location, quota, status | hasMany(Registration), belongsToMany(Participant) |
| Participant | app/Models/Participant.php | name, email, phone | hasMany(Registration), belongsToMany(Event) |
| Registration | app/Models/Registration.php | event_id, participant_id, registration_date | belongsTo(Event), belongsTo(Participant) |

## LAMPIRAN C — DAFTAR CONTROLLER

| Controller | File | Method | Fungsi |
|------------|------|--------|--------|
| DashboardController | app/Http/Controllers/DashboardController.php | __invoke() | Menampilkan dashboard statistik |
| EventController | app/Http/Controllers/EventController.php | index, create, store, show, edit, update, destroy | CRUD Event |
| ParticipantController | app/Http/Controllers/ParticipantController.php | index, create, store, show, edit, update, destroy | CRUD Peserta |
| RegistrationController | app/Http/Controllers/RegistrationController.php | index, create, store, show, edit, update, destroy | CRUD Registrasi |

## LAMPIRAN D — DAFTAR VIEW BLADE

| View | Path | Fungsi |
|------|------|--------|
| app.blade.php | layouts/ | Layout utama dengan header dan sidebar |
| sidebar.blade.php | components/ | Navigasi sidebar |
| dashboard.blade.php | — | Dashboard statistik |
| index.blade.php | events/ | Tabel daftar event |
| create.blade.php | events/ | Form tambah event |
| edit.blade.php | events/ | Form edit event |
| show.blade.php | events/ | Detail event |
| index.blade.php | participants/ | Tabel daftar peserta |
| create.blade.php | participants/ | Form tambah peserta |
| edit.blade.php | participants/ | Form edit peserta |
| show.blade.php | participants/ | Detail peserta |
| index.blade.php | registrations/ | Tabel daftar registrasi |
| create.blade.php | registrations/ | Form tambah registrasi |
| edit.blade.php | registrations/ | Form edit registrasi |
| show.blade.php | registrations/ | Detail registrasi |

## LAMPIRAN E — DAFTAR FORM REQUEST

| Form Request | File | Field Utama | Aturan Kunci |
|-------------|------|-------------|-------------|
| StoreEventRequest | Http/Requests/StoreEventRequest.php | title, event_date, location, quota, status | required, date|after:now, integer|min:1 |
| UpdateEventRequest | Http/Requests/UpdateEventRequest.php | (sama, tanpa after:now) | (sama) |
| StoreParticipantRequest | Http/Requests/StoreParticipantRequest.php | name, email, phone | required, email, unique:participants |
| UpdateParticipantRequest | Http/Requests/UpdateParticipantRequest.php | (sama, ignore current ID) | (sama + ignore) |
| StoreRegistrationRequest | Http/Requests/StoreRegistrationRequest.php | event_id, participant_id | required, exists, unique(combo) |
| UpdateRegistrationRequest | Http/Requests/UpdateRegistrationRequest.php | (sama, ignore current ID) | (sama + ignore) |
