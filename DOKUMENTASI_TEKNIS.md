# DOKUMENTASI TEKNIS — EVENT MANAGEMENT SYSTEM (EMS)

---

## 1. INSTALASI PROJECT

### 1.1 Prasyarat
- PHP 8.3+
- Composer
- Node.js 18+ + npm
- Ekstensi SQLite (php-sqlite3)

### 1.2 Clone Repository
```bash
git clone https://github.com/Faiz-abdurrachman/ems.git
cd ems
```

### 1.3 Install Dependencies
```bash
composer install
npm install
```

### 1.4 Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

File `.env.example` berisi konfigurasi default seperti berikut:
```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
DB_CONNECTION=sqlite
SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

### 1.5 Setup Database
```bash
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force
```

### 1.6 Build Frontend
```bash
npm run build
```

### 1.7 Run Development Server
```bash
php artisan serve --port=8080
```
Buka http://localhost:8080

### 1.8 Warning: Environment Khusus
Di environment ini, modul SQLite diinstall secara manual. Semua command artisan wajib menggunakan prefix:
```bash
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan ...
```

### 1.9 Deploy ke Railway
Menggunakan Dockerfile:
```dockerfile
FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    curl unzip sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN cp .env.example .env

RUN composer install --no-dev --optimize-autoloader --no-interaction && \
    npm install && npm run build && \
    php artisan key:generate && \
    touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080
```

Konfigurasi Render (render.yaml):
```yaml
services:
  - type: web
    name: ems
    runtime: docker
    plan: free
    repo: https://github.com/Faiz-abdurrachman/ems
    branch: main
    dockerfilePath: ./Dockerfile
    envVars:
      - key: APP_NAME
        value: EMS
      - key: APP_ENV
        value: production
      - key: APP_DEBUG
        value: false
      - key: DB_CONNECTION
        value: sqlite
```

---

## 2. STRUKTUR FOLDER

```
ems/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php         ← Autentikasi login/logout
│   │   │   ├── Controller.php                   ← Base controller abstract
│   │   │   ├── DashboardController.php          ← Statistik dashboard admin
│   │   │   ├── EventController.php              ← CRUD Event (admin)
│   │   │   ├── ParticipantController.php        ← CRUD Peserta (admin)
│   │   │   ├── PublicEventController.php        ← Landing page + daftar publik
│   │   │   └── RegistrationController.php       ← CRUD Registrasi + check-in + export CSV
│   │   └── Requests/
│   │       ├── StoreEventRequest.php            ← Validasi tambah event
│   │       ├── UpdateEventRequest.php           ← Validasi edit event
│   │       ├── StoreParticipantRequest.php      ← Validasi tambah peserta
│   │       ├── UpdateParticipantRequest.php      ← Validasi edit peserta
│   │       ├── StoreRegistrationRequest.php     ← Validasi tambah registrasi
│   │       └── UpdateRegistrationRequest.php    ← Validasi edit registrasi
│   ├── Models/
│   │   ├── Category.php                         ← Model Kategori (hasMany events)
│   │   ├── Event.php                            ← Model Event (hasMany registrations, belongsTo category)
│   │   ├── Participant.php                      ← Model Peserta (hasMany registrations)
│   │   ├── Registration.php                     ← Model Registrasi (belongsTo event + participant)
│   │   └── User.php                             ← Model User (Authenticatable)
│   └── Providers/
│       └── AppServiceProvider.php               ← Force HTTPS di production + trust proxies
├── bootstrap/
│   ├── app.php                                  ← Konfigurasi aplikasi Laravel
│   └── providers.php                            ← Service provider list
├── config/
│   ├── auth.php                                 ← Konfigurasi guard & provider auth (session + Eloquent)
│   ├── database.php                             ← Konfigurasi database (default SQLite)
│   ├── cache.php                                ← Cache config (database driver)
│   ├── session.php                              ← Session config (database driver)
│   ├── queue.php                                ← Queue config (database driver)
│   ├── mail.php, logging.php, filesystems.php   ← Konfigurasi pendukung
│   └── services.php                             ← Third-party service config
├── database/
│   ├── database.sqlite                          ← File database SQLite
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_06_22_140211_create_events_table.php
│   │   ├── 2026_06_22_140212_create_participants_table.php
│   │   ├── 2026_06_22_140212_create_registrations_table.php
│   │   ├── 2026_06_22_210644_add_image_to_events_table.php
│   │   ├── 2026_06_22_211122_add_attended_at_to_registrations_table.php
│   │   ├── 2026_06_22_211122_add_category_id_to_events_table.php
│   │   └── 2026_06_22_211122_create_categories_table.php
│   └── seeders/
│       └── DatabaseSeeder.php                   ← Admin user + 7 kategori + 7 event + 15 peserta + 30 registrasi
├── resources/
│   ├── css/app.css                              ← Tailwind v4 entry point
│   ├── js/app.js                                ← JavaScript entry point
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php                  ← Layout admin (sidebar + header + main + flash messages + JS)
│       │   ├── app.blade.php                    ← Layout base (digunakan welcome)
│       │   └── public.blade.php                 ← Layout publik (navbar + footer + flash messages)
│       ├── components/
│       │   └── sidebar.blade.php                ← Sidebar navigasi admin (Dashboard, Events, Participants, Registrations, Logout)
│       ├── auth/
│       │   └── login.blade.php                  ← Form login admin
│       ├── dashboard.blade.php                  ← Dashboard admin (4 stat cards + recent registrations + upcoming events)
│       ├── events/
│       │   ├── index.blade.php                  ← Tabel daftar event + search + category filter
│       │   ├── create.blade.php                 ← Form tambah event (image, title, desc, date, location, quota, category, status)
│       │   ├── edit.blade.php                   ← Form edit event
│       │   └── show.blade.php                   ← Detail event + daftar registrasi
│       ├── participants/
│       │   ├── index.blade.php                  ← Tabel daftar peserta + search
│       │   ├── create.blade.php                 ← Form tambah peserta
│       │   ├── edit.blade.php                   ← Form edit peserta
│       │   └── show.blade.php                   ← Detail peserta + riwayat registrasi
│       ├── registrations/
│       │   ├── index.blade.php                  ← Tabel daftar registrasi + search
│       │   ├── create.blade.php                 ← Form tambah registrasi (pilih event + pilih peserta)
│       │   ├── edit.blade.php                   ← Form edit registrasi
│       │   ├── show.blade.php                   ← Detail registrasi
│       │   └── check-in.blade.php               ← Tabel presensi + toggle kehadiran
│       ├── public/
│       │   ├── index.blade.php                  ← Landing page + search + category filter + event card grid
│       │   └── show.blade.php                   ← Detail event publik + form pendaftaran
│       └── welcome.blade.php                    ← Welcome page default Laravel
├── routes/
│   └── web.php                                  ← Semua 28 route (public + auth + admin resource)
├── storage/                                     ← Logs, cache, compiled views, uploaded images
├── public/                                      ← Index.php entry point + compiled assets
├── Dockerfile                                   ← Deploy Railway / Render
├── render.yaml                                  ← Konfigurasi Render
├── package.json                                 ← NPM dependencies (Tailwind v4, Vite)
├── vite.config.js                               ← Konfigurasi Vite bundler
├── composer.json                                ← PHP dependencies (Laravel 13)
└── .env.example                                 ← Template environment
```

**Penjelasan:**
- `app/Http/Controllers/` — Semua controller: publik (PublicEventController) dan admin (EventController, ParticipantController, RegistrationController, DashboardController, LoginController).
- `app/Http/Requests/` — Form Request untuk validasi input, memisahkan logika validasi dari controller.
- `app/Models/` — Eloquent models yang merepresentasikan tabel database.
- `resources/views/` — Blade templates, dibagi menjadi layouts (admin, public), komponen (sidebar), dan view per modul (events, participants, registrations, public, auth).
- `database/migrations/` — Skema database versi-terkontrol.
- `routes/web.php` — Semua definisi route aplikasi (28 route).

---

## 3. SOURCE CODE — MODEL

### 3.1 Event.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'quota',
        'status',
        'image',
        'category_id',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'quota' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'registrations')
            ->withPivot('registration_date')
            ->withTimestamps();
    }
}
```

**Penjelasan relasi:**
- `category()` — **belongsTo** Category. Setiap Event memiliki satu Kategori. Foreign key: `category_id` pada tabel `events`.
- `registrations()` — **hasMany** Registration. Satu Event memiliki banyak Registration. Foreign key: `event_id` pada tabel `registrations`.
- `participants()` — **belongsToMany** Participant melalui pivot table `registrations`. Menggunakan `withPivot('registration_date')` untuk mengakses kolom `registration_date` dari tabel pivot.

### 3.2 Participant.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'registrations')
            ->withPivot('registration_date')
            ->withTimestamps();
    }
}
```

**Penjelasan relasi:**
- `registrations()` — **hasMany** Registration. Satu Peserta dapat mendaftar di banyak event.
- `events()` — **belongsToMany** Event melalui tabel pivot `registrations`. Memungkinkan query `$participant->events` untuk mendapatkan semua event yang diikuti peserta.

### 3.3 Registration.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'participant_id',
        'registration_date',
    ];

    protected $casts = [
        'registration_date' => 'datetime',
        'attended_at' => 'datetime',
    ];

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

**Penjelasan relasi:**
- `event()` — **belongsTo** Event. Setiap registrasi terkait dengan satu event. Foreign key: `event_id`.
- `participant()` — **belongsTo** Participant. Setiap registrasi terkait dengan satu peserta. Foreign key: `participant_id`.
- **Casts:** `registration_date` dan `attended_at` di-cast ke `datetime` sehingga otomatis menjadi instance Carbon.

### 3.4 Category.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name'];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
```

**Penjelasan:** `events()` — **hasMany** Event. Satu Kategori memiliki banyak Event. Foreign key: `category_id` pada tabel `events`.

### 3.5 User.php

```php
<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
```

**Penjelasan:** Model autentikasi standar Laravel menggunakan `Authenticatable`. Atribut PHP 8 (`#[Fillable]`, `#[Hidden]`) digunakan sebagai alternatif properti `$fillable` dan `$hidden`. Password otomatis di-hash melalui cast `'password' => 'hashed'`.

### 3.6 Relasi Eloquent Lengkap

| Model A | Relasi | Model B | Method | Foreign Key | Pivot Table |
|---|---|---|---|---|---|
| Event | hasMany | Registration | registrations() | event_id | — |
| Event | belongsToMany | Participant | participants() | — | registrations |
| Event | belongsTo | Category | category() | category_id | — |
| Participant | hasMany | Registration | registrations() | participant_id | — |
| Participant | belongsToMany | Event | events() | — | registrations |
| Registration | belongsTo | Event | event() | event_id | — |
| Registration | belongsTo | Participant | participant() | participant_id | — |
| Category | hasMany | Event | events() | category_id | — |

---

## 4. SOURCE CODE — CONTROLLER

### 4.1 PublicEventController.php

```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicEventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->withCount('registrations')
            ->when($request->search, fn($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->orderBy('event_date')
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('public.index', compact('events', 'categories'));
    }

    public function show(Event $event): View
    {
        $event->loadCount('registrations');

        return view('public.show', compact('event'));
    }

    public function register(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        if (now()->gt($event->event_date)) {
            return back()->withErrors(['event' => 'Event sudah berakhir.']);
        }

        if ($event->registrations()->count() >= $event->quota) {
            return back()->withErrors(['event' => 'Kuota event sudah penuh.']);
        }

        $participant = Participant::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
            ]
        );

        $existing = Registration::where('event_id', $event->id)
            ->where('participant_id', $participant->id)
            ->exists();

        if ($existing) {
            return back()->withErrors(['email' => 'Anda sudah terdaftar di event ini.']);
        }

        Registration::create([
            'event_id' => $event->id,
            'participant_id' => $participant->id,
            'registration_date' => now(),
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Pendaftaran berhasil! Anda telah terdaftar di event "'.$event->title.'".');
    }
}
```

**Penjelasan setiap method:**
- **index()** — Menampilkan halaman landing dengan daftar event `upcoming` yang `event_date > now()`. Mendukung pencarian (`search`) dan filter kategori (`category`). Menggunakan `withCount('registrations')` untuk menghitung jumlah peserta. Paginasi 12 item per halaman.
- **show()** — Menampilkan detail event publik. Menggunakan Route Model Binding (`Event $event`) untuk otomatis resolve event dari URL. `loadCount('registrations')` untuk menampilkan jumlah pendaftar.
- **register()** — Memproses pendaftaran publik:
  1. Validasi input (nama wajib, email wajib & valid, telepon opsional).
  2. Cek apakah event sudah berakhir (`now() > event_date`).
  3. Cek apakah kuota penuh (`registrations count >= quota`).
  4. `firstOrCreate` participant berdasarkan email — jika email sudah ada, gunakan data lama; jika belum, buat baru.
  5. Cek duplikasi — peserta tidak boleh daftar dua kali di event yang sama.
  6. Buat registrasi baru dengan `registration_date = now()`.

### 4.2 EventController.php (Admin)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with(['category'])
            ->withCount('registrations')
            ->when(request('search'), fn($q) => $q->where('title', 'like', '%'.request('search').'%')
                ->orWhere('location', 'like', '%'.request('search').'%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('events.index', compact('events', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('events.create', compact('categories'));
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event): View
    {
        $event->load(['registrations.participant', 'category']);
        $event->loadCount('registrations');

        return view('events.show', compact('event'));
    }

    public function edit(Event $event): View
    {
        $categories = Category::orderBy('name')->get();

        return view('events.edit', compact('event', 'categories'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
```

**Penjelasan setiap method:**
- **index()** — Menampilkan tabel semua event (tanpa filter status). Eager load `category`, `withCount('registrations')`. Search mencakup `title` dan `location`. Filter kategori. Paginasi 10 item. `withQueryString()` mempertahankan query string saat paginasi.
- **create()** — Menampilkan form tambah event. Mengirim data `categories` untuk dropdown.
- **store()** — Menerima `StoreEventRequest` (Form Request). Upload gambar via `->store('events', 'public')` ke `storage/app/public/events/`. Data gambar hanya dimasukkan jika ada file upload.
- **show()** — Detail event admin. Eager load `registrations.participant` (nested) dan `category`.
- **update()** — Sama seperti store, menggunakan `UpdateEventRequest` dan `$event->update()`.
- **destroy()** — Menghapus event. Registrasi terkait akan otomatis terhapus karena foreign key `cascadeOnDelete`.

### 4.3 RegistrationController.php (Admin)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RegistrationController extends Controller
{
    public function index(): View
    {
        $registrations = Registration::with(['event', 'participant'])
            ->when(request('search'), function ($q) {
                $q->whereHas('participant', fn($sub) => $sub->where('name', 'like', '%'.request('search').'%'))
                  ->orWhereHas('event', fn($sub) => $sub->where('title', 'like', '%'.request('search').'%'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('registrations.index', compact('registrations'));
    }

    public function create(): View
    {
        $events = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->withCount('registrations')
            ->orderBy('event_date')->get();
        $participants = Participant::orderBy('name')->get();

        return view('registrations.create', compact('events', 'participants'));
    }

    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $event = Event::findOrFail($request->event_id);

        if (now()->gt($event->event_date)) {
            return back()->withErrors(['event_id' => 'Event sudah berakhir.'])->withInput();
        }

        if ($event->registrations()->count() >= $event->quota) {
            return back()->withErrors(['event_id' => 'Kuota event sudah penuh.'])->withInput();
        }

        Registration::create([
            'event_id' => $request->event_id,
            'participant_id' => $request->participant_id,
            'registration_date' => now(),
        ]);

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Peserta berhasil didaftarkan ke event.');
    }

    public function show(Registration $registration): View
    {
        $registration->load(['event', 'participant']);

        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration): View
    {
        $events = Event::orderBy('event_date')->get();
        $participants = Participant::orderBy('name')->get();

        return view('registrations.edit', compact('registration', 'events', 'participants'));
    }

    public function update(UpdateRegistrationRequest $request, Registration $registration): RedirectResponse
    {
        $registration->update([
            'event_id' => $request->event_id,
            'participant_id' => $request->participant_id,
        ]);

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function destroy(Registration $registration): RedirectResponse
    {
        $registration->delete();

        return redirect()
            ->route('admin.registrations.index')
            ->with('success', 'Registrasi berhasil dihapus.');
    }

    public function toggleAttendance(Registration $registration): RedirectResponse
    {
        $registration->update([
            'attended_at' => $registration->attended_at ? null : now(),
        ]);

        $status = $registration->attended_at ? 'Hadir' : 'Batal hadir';

        return back()->with('success', 'Status kehadiran diperbarui: '.$status.'.');
    }

    public function checkIn(Event $event): View
    {
        $event->load(['registrations' => fn($q) => $q->with('participant')->orderBy('created_at')]);

        $attended = $event->registrations->whereNotNull('attended_at')->count();
        $total = $event->registrations->count();

        return view('registrations.check-in', compact('event', 'attended', 'total'));
    }

    public function export(Event $event): StreamedResponse
    {
        $event->load(['registrations.participant']);

        $fileName = 'daftar-peserta-'.str($event->title)->slug().'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ];

        $callback = function () use ($event) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama', 'Email', 'Telepon', 'Tanggal Daftar', 'Kehadiran']);

            foreach ($event->registrations as $i => $reg) {
                fputcsv($file, [
                    $i + 1,
                    $reg->participant->name ?? '—',
                    $reg->participant->email ?? '—',
                    $reg->participant->phone ?? '—',
                    $reg->registration_date->format('d M Y, H:i'),
                    $reg->attended_at ? 'Hadir ('.$reg->attended_at->format('d M Y, H:i').')' : 'Belum hadir',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
```

**Penjelasan method kunci:**
- **index()** — Eager load `event` dan `participant`. Search menggunakan `whereHas` untuk mencari berdasarkan nama peserta atau judul event.
- **store()** — Validasi kuota dan tanggal event sebelum menyimpan registrasi (validasi duplikasi sudah ditangani oleh `StoreRegistrationRequest`).
- **toggleAttendance()** — Toggle kehadiran: jika `attended_at` sudah terisi, set ke `null` (batal hadir); jika null, set ke `now()` (tandai hadir).
- **checkIn()** — Halaman presensi per event. Memuat semua registrasi dengan peserta. Menghitung `$attended` (yang `attended_at` tidak null) dan `$total`.
- **export()** — Export CSV menggunakan `StreamedResponse`. Membuat response streaming dengan callback yang menulis CSV via `fputcsv`. Kolom: No, Nama, Email, Telepon, Tanggal Daftar, Kehadiran. Nama file: `daftar-peserta-{slug-event}.csv`.

### 4.4 DashboardController.php

```php
<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalEvents = Event::count();
        $totalParticipants = Participant::count();
        $totalRegistrations = Registration::count();
        $activeEvents = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->count();

        $recentRegistrations = Registration::with(['event', 'participant'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingEvents = Event::where('status', 'upcoming')
            ->where('event_date', '>', now())
            ->withCount('registrations')
            ->orderBy('event_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalEvents',
            'totalParticipants',
            'totalRegistrations',
            'activeEvents',
            'recentRegistrations',
            'upcomingEvents'
        ));
    }
}
```

**Penjelasan:** Single Action Controller (`__invoke`). Menyediakan 6 data untuk dashboard:
1. **totalEvents** — Jumlah seluruh event.
2. **totalParticipants** — Jumlah seluruh peserta.
3. **totalRegistrations** — Jumlah seluruh registrasi.
4. **activeEvents** — Jumlah event `upcoming` dengan tanggal > sekarang.
5. **recentRegistrations** — 5 registrasi terbaru dengan eager load event & participant.
6. **upcomingEvents** — 5 event mendatang dengan `withCount('registrations')` untuk progress bar.

### 4.5 ParticipantController.php

```php
<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(): View
    {
        $participants = Participant::withCount('registrations')
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%'.request('search').'%')
                ->orWhere('email', 'like', '%'.request('search').'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('participants.index', compact('participants'));
    }

    public function create(): View
    {
        return view('participants.create');
    }

    public function store(StoreParticipantRequest $request): RedirectResponse
    {
        Participant::create($request->validated());

        return redirect()
            ->route('admin.participants.index')
            ->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function show(Participant $participant): View
    {
        $participant->load(['registrations.event']);

        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant): View
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(UpdateParticipantRequest $request, Participant $participant): RedirectResponse
    {
        $participant->update($request->validated());

        return redirect()
            ->route('admin.participants.index')
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Participant $participant): RedirectResponse
    {
        $participant->delete();

        return redirect()
            ->route('admin.participants.index')
            ->with('success', 'Peserta berhasil dihapus.');
    }
}
```

**Penjelasan:** Resource controller standar. `show()` melakukan eager load `registrations.event` untuk menampilkan riwayat registrasi peserta beserta nama event.

### 4.6 Auth/LoginController.php

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    protected string $redirectTo = '/admin';
    protected string $home = '/admin';

    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
```

**Penjelasan flow:**
- **showLoginForm()** — Jika user sudah login (`Auth::check()`), redirect langsung ke dashboard. Jika belum, tampilkan form login.
- **login()** — Validasi email dan password. `Auth::attempt()` dengan dukungan fitur "remember me". Session diregenerate untuk mencegah session fixation. Redirect ke `intended` URL atau dashboard.
- **logout()** — `Auth::logout()`, invalidate session, regenerate CSRF token, redirect ke home.

---

## 5. SOURCE CODE — VIEW (BLADE)

### 5.1 Layout Hierarchy

```
layouts/public.blade.php          layouts/admin.blade.php
        |                                   |
        +--- @yield('content')              +--- @yield('content')
             |                                    |
    public/index.blade.php                  dashboard.blade.php
    public/show.blade.php                   events/index.blade.php
    auth/login.blade.php                    events/create.blade.php
    welcome.blade.php                       events/edit.blade.php
                                            events/show.blade.php
                                            participants/*
                                            registrations/*
                                      +--- includes: <x-sidebar />
```

### 5.2 Layout Admin (layouts/admin.blade.php)

```html
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS — Event Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div id="mobile-backdrop" class="fixed inset-0 z-10 bg-black/50 hidden lg:hidden" onclick="closeSidebar()"></div>
    <div class="flex h-full">
        <x-sidebar />

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <button id="mobile-menu-btn" class="lg:hidden ...">...</button>
                        <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500">Campus Event Management</span>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <!-- Flash message success dengan tombol close -->
                @endif

                @if ($errors->any())
                    <!-- Daftar error validasi -->
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript: mobile sidebar toggle, loading spinner on form submit -->
</body>
</html>
```

**Fitur layout admin:**
- **Sidebar** — Komponen `<x-sidebar />` yang fixed di kiri, bisa di-toggle di mobile.
- **Header sticky** — Judul halaman dari `@yield('title')`, tombol hamburger untuk mobile.
- **Flash message** — Notifikasi sukses (hijau) dengan tombol close. Error validasi (merah) dengan daftar `$errors->all()`.
- **JavaScript** — Mobile backdrop + sidebar toggle. Loading spinner otomatis pada semua `<form method="POST">` saat disubmit.

### 5.3 Layout Publik (layouts/public.blade.php)

```html
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS — Event Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <!-- Logo EMS -->
                <span class="text-lg font-semibold text-gray-900">EMS</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 ...">Admin</a>
            </div>
        </div>
    </header>

    <main class="py-8">
        <!-- Flash messages success & error -->
        @yield('content')
    </main>

    <footer class="border-t border-gray-200 py-8 text-center text-xs text-gray-400">
        EMS v1.0 — Laravel {{ app()->version() }}
    </footer>
</body>
</html>
```

**Fitur layout publik:**
- **Navbar sticky** — Logo EMS + link Admin.
- **Flash messages** — Sama seperti layout admin: success (hijau) dan error (merah).
- **Footer** — Versi aplikasi dan versi Laravel.

### 5.4 Sidebar Component (components/sidebar.blade.php)

```html
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-20 flex w-64 flex-col bg-gray-900 text-gray-300
    transition-transform lg:translate-x-0 -translate-x-full">
    <div class="flex h-16 items-center gap-2 px-6 border-b border-gray-800">
        <!-- Logo EMS -->
    </div>

    <nav class="flex-1 space-y-1 px-3 py-4">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium
           {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.events.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium
           {{ request()->routeIs('admin.events.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
            Events
        </a>

        <a href="{{ route('admin.participants.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium
           {{ request()->routeIs('admin.participants.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
            Participants
        </a>

        <a href="{{ route('admin.registrations.index') }}"
           class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium
           {{ request()->routeIs('admin.registrations.*') ? 'bg-gray-800 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
            Registrations
        </a>
    </nav>

    <div class="border-t border-gray-800 px-3 py-4 space-y-3">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 ...">
                Keluar
            </button>
        </form>
        <p class="text-xs text-gray-500 px-3">{{ auth()->user()->name ?? 'Admin' }}</p>
    </div>
</aside>
```

**Fitur sidebar:**
- 4 link navigasi: Dashboard, Events, Participants, Registrations.
- **Active state** menggunakan `request()->routeIs('admin.xxx.*')` — pola wildcard untuk mencocokkan semua sub-route.
- Tombol Logout dalam form POST dengan `@csrf`.
- Nama user yang sedang login ditampilkan di bagian bawah.

### 5.5 Dashboard (dashboard.blade.php)

```html
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- 4 Stat Cards: Total Events, Total Participants, Total Registrations, Active Events -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Card Total Events (indigo) -->
        <!-- Card Total Participants (emerald) -->
        <!-- Card Total Registrations (amber) -->
        <!-- Card Active Events (rose) -->
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Recent Registrations Table (col-span-2) -->
        <div class="lg:col-span-2 ...">
            <table class="w-full">
                <thead>Event | Participant | Date</thead>
                <tbody>
                    @foreach ($recentRegistrations as $registration)
                        <tr>
                            <td>{{ $registration->event->title ?? '—' }}</td>
                            <td>{{ $registration->participant->name ?? '—' }}</td>
                            <td>{{ $registration->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Upcoming Events (col-span-1) -->
        <div class="...">
            @foreach ($upcomingEvents as $event)
                <div>
                    <p>{{ $event->title }}</p>
                    <div>{{ date }} | {{ registrations_count }}</div>
                    <!-- Progress bar: registrations_count / quota -->
                    <div class="h-1.5 rounded-full bg-gray-100">
                        <div style="width: {{ ($event->registrations_count / $event->quota * 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
```

**Fitur dashboard:**
- 4 **stat cards** dengan ikon SVG dan gradien latar belakang dekoratif.
- **Recent Registrations** — tabel 5 registrasi terbaru dengan kolom Event, Participant, Date.
- **Upcoming Events** — list 5 event mendatang dengan progress bar `registrations_count/quota`.
- Kondisi **empty state** — jika tidak ada data, tampilkan pesan "Belum ada data".

### 5.6 Public Landing (public/index.blade.php)

```html
@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-7xl px-6">
    <!-- Hero Section -->
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold ...">Event Kampus</h1>
        <p class="mt-3 text-lg text-gray-500">Daftar event mendatang yang bisa kamu ikuti</p>
        <!-- Search Form -->
        <form method="GET" action="{{ route('home') }}" class="mt-6 mx-auto max-w-md relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event...">
            @if(request('search'))
                <a href="{{ route('home') }}">Clear</a>
            @endif
        </form>
    </div>

    <!-- Category Filter Chips -->
    <div class="flex flex-wrap justify-center gap-2">
        <a href="{{ route('home') }}" class="rounded-full px-4 py-1.5 text-xs font-medium
           {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-100 ...' }}">Semua</a>
        @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->id]) }}" class="...">{{ $cat->name }}</a>
        @endforeach
    </div>

    <!-- Event Card Grid (3 columns) -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($events as $event)
            <a href="{{ route('events.show', $event) }}" class="group block ...">
                @if($event->image)
                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}">
                @else
                    <div class="flex h-48 ... bg-gradient-to-br from-indigo-50 to-indigo-100">
                        <!-- Placeholder -->
                    </div>
                @endif
                <div class="p-5">
                    <h3>{{ $event->title }}</h3>
                    <div>{{ date }} | {{ location }}</div>
                    <!-- Progress bar -->
                    <div>...</div>
                    @if($event->registrations_count >= $event->quota)
                        <span>Kuota Penuh</span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    {{ $events->links() }}
</div>
@endsection
```

**Fitur landing page:**
- **Hero** — Judul, deskripsi, dan search input.
- **Category chips** — Filter berdasarkan kategori, berbentuk pill/rounded button. "Semua" untuk reset filter.
- **Event cards** — Grid 3 kolom. Setiap card menampilkan gambar (atau placeholder gradient), judul, tanggal, lokasi, progress bar kuota, dan badge "Kuota Penuh" jika penuh.
- **Paginasi** — `{{ $events->links() }}` untuk navigasi halaman.

### 5.7 Public Event Detail (public/show.blade.php)

```html
@extends('layouts.public')

@section('content')
<div class="mx-auto max-w-4xl px-6">
    <a href="{{ route('home') }}">Kembali ke daftar event</a>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Kolom Kiri (col-span-2): Detail Event -->
        <div class="lg:col-span-2 space-y-6">
            @if($event->image)
                <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}">
            @else
                <!-- Placeholder gradient -->
            @endif

            <h1>{{ $event->title }}</h1>

            <!-- Info badges: Date, Location, Registrations count -->
            <div class="flex flex-wrap gap-3">
                <span>{{ date }}</span>
                <span>{{ $event->location }}</span>
                <span>{{ $event->registrations_count }} / {{ $event->quota }} Terdaftar</span>
            </div>

            @if($event->description)
                <div class="prose">{{ $event->description }}</div>
            @endif
        </div>

        <!-- Kolom Kanan: Form Pendaftaran (sticky) -->
        <div>
            <div class="sticky top-24 ...">
                <h2>Daftar Event Ini</h2>

                @if(now()->gt($event->event_date))
                    <div>Event telah berakhir</div>
                @elseif($event->registrations_count >= $event->quota)
                    <div>Kuota sudah penuh</div>
                @else
                    <form method="POST" action="{{ route('events.register', $event) }}">
                        @csrf
                        <input name="name" placeholder="Nama Lengkap" required>
                        <input name="email" type="email" placeholder="Email" required>
                        <input name="phone" placeholder="Telepon (opsional)">
                        <button type="submit">Daftar Sekarang</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
```

**Fitur detail event publik:**
- **Two-column layout**: kiri (2/3) untuk detail event, kanan (1/3) untuk form pendaftaran (sticky).
- **3 state handling** untuk form pendaftaran:
  1. Event berakhir → pesan "Event telah berakhir".
  2. Kuota penuh → pesan "Kuota sudah penuh".
  3. Tersedia → tampilkan form dengan field Nama, Email, Telepon.

### 5.8 Admin Event Create (events/create.blade.php)

```html
@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="mx-auto max-w-2xl">
    <a href="{{ route('admin.events.index') }}">Back to Events</a>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b px-6 py-5">
            <h2>Create New Event</h2>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Image Upload -->
            <div>
                <label>Poster Event (opsional)</label>
                <input type="file" name="image" accept="image/*">
                @error('image') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Title -->
            <div>
                <label>Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required>
                @error('title') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div>
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
                @error('description') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Event Date -->
            <div>
                <label>Event Date</label>
                <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required>
                @error('event_date') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Location -->
            <div>
                <label>Location</label>
                <input type="text" name="location" value="{{ old('location') }}" required>
                @error('location') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Quota -->
            <div>
                <label>Quota</label>
                <input type="number" name="quota" value="{{ old('quota') }}" min="1" required>
                @error('quota') <p>{{ $message }}</p> @enderror
            </div>

            <!-- Category Dropdown -->
            <div>
                <label>Kategori</label>
                <select name="category_id">
                    <option value="">Tanpa Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label>Status</label>
                <select name="status">
                    <option value="upcoming">Akan Datang</option>
                    <option value="ongoing">Berlangsung</option>
                    <option value="completed">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
                @error('status') <p>{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 border-t pt-5">
                <a href="{{ route('admin.events.index') }}">Cancel</a>
                <button type="submit">Create Event</button>
            </div>
        </form>
    </div>
</div>
@endsection
```

**Fitur form create event:**
- `enctype="multipart/form-data"` untuk upload gambar.
- Semua field menggunakan `old('field')` untuk mempertahankan input saat validasi gagal.
- Error validasi per-field menggunakan `@error('field')`.
- Dropdown kategori dari database.
- Dropdown status dengan 4 opsi (upcoming, ongoing, completed, cancelled).

### 5.9 Admin Check-in (registrations/check-in.blade.php)

```html
@extends('layouts.admin')

@section('title', 'Presensi: '.$event->title)

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.events.show', $event) }}">Kembali ke detail event</a>
            <h2>Presensi: {{ $event->title }}</h2>
            <p>{{ $attended }} / {{ $total }} peserta telah hadir</p>
        </div>
        <!-- Progress bar attendance -->
        <div class="flex items-center gap-2">
            <div class="h-3 w-40 rounded-full bg-gray-100">
                <div class="h-full rounded-full bg-emerald-500"
                     style="width: {{ $total > 0 ? round($attended / $total * 100) : 0 }}%"></div>
            </div>
            <span>{{ $total > 0 ? round($attended / $total * 100) : 0 }}%</span>
        </div>
    </div>

    <div class="rounded-xl border bg-white shadow-sm">
        <table class="w-full">
            <thead>
                <tr>
                    <th>#</th><th>Nama</th><th>Email</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->registrations as $reg)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $reg->participant->name ?? '—' }}</td>
                        <td>{{ $reg->participant->email ?? '—' }}</td>
                        <td>
                            @if($reg->attended_at)
                                <span class="bg-emerald-50 text-emerald-700">Hadir</span>
                            @else
                                <span class="bg-gray-100 text-gray-500">Belum Hadir</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.registrations.toggle-attendance', $reg) }}">
                                @csrf
                                <button type="submit" class="{{ $reg->attended_at ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }}">
                                    {{ $reg->attended_at ? 'Batalkan' : 'Tandai Hadir' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
```

**Fitur check-in page:**
- Progress bar kehadiran dengan persentase.
- Tabel berisi daftar semua peserta terdaftar di event.
- Kolom status: badge hijau "Hadir" (jika `attended_at` terisi) atau abu-abu "Belum Hadir".
- Toggle button: "Tandai Hadir" (hijau) atau "Batalkan" (merah) untuk toggle status kehadiran.

### 5.10 Key Blade Directives Used

| Directive | Kegunaan |
|---|---|
| `@extends('layout')` | Pewarisan template dari layout parent |
| `@section('name')` / `@endsection` | Mendefinisikan konten section |
| `@yield('name', 'default')` | Menampilkan konten section dari child view |
| `@csrf` | Menyisipkan CSRF token hidden input |
| `@method('DELETE')` | Method spoofing untuk PUT/PATCH/DELETE |
| `@foreach / @endforeach` | Iterasi array/collection |
| `@if / @elseif / @else / @endif` | Kondisional |
| `@error('field') / @enderror` | Menampilkan pesan error validasi per field |
| `@php / @endphp` | Menulis kode PHP inline (digunakan untuk `$statusColors` mapping di events index) |
| `{{ $var }}` | Output escaped (XSS-safe) |
| `{!! $html !!}` | Output unescaped |
| `route('name')` | Generate URL dari nama route |
| `request()->routeIs('pattern')` | Cek apakah current route cocok dengan pattern |
| `old('field')` | Menampilkan nilai input sebelumnya (setelah validasi gagal) |
| `$loop->iteration` | Nomor iterasi (1-based) dalam `@foreach` |

---

## 6. SOURCE CODE — ROUTE

### 6.1 routes/web.php

```php
<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

# Public Routes
Route::get('/', [PublicEventController::class, 'index'])->name('home');
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('events.show');
Route::post('/events/{event}/register', [PublicEventController::class, 'register'])->name('events.register');

# Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

# Admin Routes (auth required)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::resource('events', EventController::class);
    Route::resource('participants', ParticipantController::class);
    Route::resource('registrations', RegistrationController::class);
    Route::post('registrations/{registration}/toggle-attendance', [RegistrationController::class, 'toggleAttendance'])
        ->name('registrations.toggle-attendance');
    Route::get('events/{event}/check-in', [RegistrationController::class, 'checkIn'])
        ->name('events.check-in');
    Route::get('events/{event}/export', [RegistrationController::class, 'export'])
        ->name('events.export');
});
```

### 6.2 Daftar Lengkap Route (28 Route)

| No | Method | URI | Controller | Middleware | Route Name | Deskripsi |
|---|---|---|---|---|---|---|
| 1 | GET | `/` | PublicEventController@index | — | home | Landing page event publik |
| 2 | GET | `/events/{event}` | PublicEventController@show | — | events.show | Detail event publik |
| 3 | POST | `/events/{event}/register` | PublicEventController@register | — | events.register | Pendaftaran event publik |
| 4 | GET | `/login` | LoginController@showLoginForm | guest | login | Form login admin |
| 5 | POST | `/login` | LoginController@login | guest | — | Proses login |
| 6 | POST | `/logout` | LoginController@logout | auth | logout | Proses logout |
| 7 | GET | `/admin` | DashboardController | auth | admin.dashboard | Dashboard admin |
| 8 | GET | `/admin/events` | EventController@index | auth | admin.events.index | List event admin |
| 9 | GET | `/admin/events/create` | EventController@create | auth | admin.events.create | Form tambah event |
| 10 | POST | `/admin/events` | EventController@store | auth | admin.events.store | Simpan event baru |
| 11 | GET | `/admin/events/{event}` | EventController@show | auth | admin.events.show | Detail event admin |
| 12 | GET | `/admin/events/{event}/edit` | EventController@edit | auth | admin.events.edit | Form edit event |
| 13 | PUT/PATCH | `/admin/events/{event}` | EventController@update | auth | admin.events.update | Update event |
| 14 | DELETE | `/admin/events/{event}` | EventController@destroy | auth | admin.events.destroy | Hapus event |
| 15 | GET | `/admin/participants` | ParticipantController@index | auth | admin.participants.index | List peserta |
| 16 | GET | `/admin/participants/create` | ParticipantController@create | auth | admin.participants.create | Form tambah peserta |
| 17 | POST | `/admin/participants` | ParticipantController@store | auth | admin.participants.store | Simpan peserta baru |
| 18 | GET | `/admin/participants/{participant}` | ParticipantController@show | auth | admin.participants.show | Detail peserta |
| 19 | GET | `/admin/participants/{participant}/edit` | ParticipantController@edit | auth | admin.participants.edit | Form edit peserta |
| 20 | PUT/PATCH | `/admin/participants/{participant}` | ParticipantController@update | auth | admin.participants.update | Update peserta |
| 21 | DELETE | `/admin/participants/{participant}` | ParticipantController@destroy | auth | admin.participants.destroy | Hapus peserta |
| 22 | GET | `/admin/registrations` | RegistrationController@index | auth | admin.registrations.index | List registrasi |
| 23 | GET | `/admin/registrations/create` | RegistrationController@create | auth | admin.registrations.create | Form tambah registrasi |
| 24 | POST | `/admin/registrations` | RegistrationController@store | auth | admin.registrations.store | Simpan registrasi baru |
| 25 | GET | `/admin/registrations/{registration}` | RegistrationController@show | auth | admin.registrations.show | Detail registrasi |
| 26 | GET | `/admin/registrations/{registration}/edit` | RegistrationController@edit | auth | admin.registrations.edit | Form edit registrasi |
| 27 | PUT/PATCH | `/admin/registrations/{registration}` | RegistrationController@update | auth | admin.registrations.update | Update registrasi |
| 28 | DELETE | `/admin/registrations/{registration}` | RegistrationController@destroy | auth | admin.registrations.destroy | Hapus registrasi |
| 29 | POST | `/admin/registrations/{registration}/toggle-attendance` | RegistrationController@toggleAttendance | auth | admin.registrations.toggle-attendance | Toggle kehadiran |
| 30 | GET | `/admin/events/{event}/check-in` | RegistrationController@checkIn | auth | admin.events.check-in | Halaman presensi event |
| 31 | GET | `/admin/events/{event}/export` | RegistrationController@export | auth | admin.events.export | Export CSV peserta |

### 6.3 Route Grouping

- **Public group (No middleware)** — Route 1-3: Dapat diakses tanpa login, untuk publik melihat dan mendaftar event.
- **Guest group (middleware: 'guest')** — Route 4-5: Hanya bisa diakses jika BELUM login. Jika sudah login, redirect ke dashboard.
- **Auth individual** — Route 6: Route `/logout` dengan middleware `auth`, di luar group.
- **Admin group (middleware: 'auth', prefix: 'admin', name: 'admin.')** — Route 7-31: Semua route admin.
  - `Route::resource()` otomatis menghasilkan 7 route (index, create, store, show, edit, update, destroy) per resource.
  - 3 resource: `events`, `participants`, `registrations` = 21 route.
  - 3 route tambahan: `toggle-attendance`, `check-in`, `export`.
  - Total admin route: 1 (dashboard) + 21 (resources) + 3 (custom) = 25 route.

---

## 7. SOURCE CODE — FORM REQUEST

### 7.1 StoreEventRequest

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date', 'after:now'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul event wajib diisi.',
            'event_date.required' => 'Tanggal event wajib diisi.',
            'event_date.after' => 'Tanggal event harus setelah hari ini.',
            'location.required' => 'Lokasi event wajib diisi.',
            'quota.required' => 'Kuota peserta wajib diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota minimal 1 peserta.',
            'status.required' => 'Status event wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar maksimal 5 MB.',
        ];
    }
}
```

### 7.2 StoreRegistrationRequest (Composite Unique)

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'participant_id' => ['required', 'exists:participants,id'],
            'event_id' => [
                Rule::unique('registrations')
                    ->where('participant_id', $this->participant_id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'Event wajib dipilih.',
            'event_id.exists' => 'Event tidak ditemukan.',
            'event_id.unique' => 'Peserta sudah terdaftar di event ini.',
            'participant_id.required' => 'Peserta wajib dipilih.',
            'participant_id.exists' => 'Peserta tidak ditemukan.',
        ];
    }
}
```

**Catatan penting:** Validasi composite unique menggunakan `Rule::unique('registrations')->where('participant_id', $this->participant_id)`. Ini memastikan kombinasi `event_id` + `participant_id` bersifat unik — seorang peserta tidak bisa mendaftar dua kali di event yang sama.

### 7.3 Semua 6 Form Request — Ringkasan

| Form Request | Fields | Key Rules | Digunakan Di |
|---|---|---|---|
| StoreEventRequest | title, description, event_date, location, quota, status, image, category_id | event_date: after:now, quota: min:1, image: mimes + max:5120 | EventController@store |
| UpdateEventRequest | (sama dengan Store) | event_date tanpa after:now (bisa edit event masa lalu) | EventController@update |
| StoreParticipantRequest | name, email, phone | email: unique:participants | ParticipantController@store |
| UpdateParticipantRequest | name, email, phone | email: unique, ignore current participant ID | ParticipantController@update |
| StoreRegistrationRequest | event_id, participant_id | Composite unique: event_id + participant_id | RegistrationController@store |
| UpdateRegistrationRequest | event_id, participant_id | Composite unique, ignore current registration ID | RegistrationController@update |

---

## 8. SOURCE CODE — MIGRATION

### 8.1 create_events_table

```php
Schema::create('events', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->dateTime('event_date');
    $table->string('location');
    $table->integer('quota');
    $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
    $table->timestamps();
});
```

### 8.2 create_participants_table

```php
Schema::create('participants', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->timestamps();
});
```

### 8.3 create_registrations_table

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

**Catatan penting:**
- `constrained()->cascadeOnDelete()` — Jika event atau participant dihapus, semua registrasi terkait otomatis terhapus.
- `unique(['event_id', 'participant_id'])` — Composite unique index: mencegah peserta mendaftar dua kali di event yang sama.

### 8.4 Migration Summary

| No | Migration File | Tabel | Kolom Baru / Tindakan |
|---|---|---|---|
| 1 | 0001_01_01_000000_create_users_table | users, password_reset_tokens, sessions | Membuat tabel auth bawaan Laravel |
| 2 | 0001_01_01_000001_create_cache_table | cache | Membuat tabel cache |
| 3 | 0001_01_01_000002_create_jobs_table | jobs, job_batches, failed_jobs | Membuat tabel queue jobs |
| 4 | 2026_06_22_140211_create_events_table | events | title, description, event_date, location, quota, status |
| 5 | 2026_06_22_140212_create_participants_table | participants | name, email (unique), phone |
| 6 | 2026_06_22_140212_create_registrations_table | registrations | event_id (FK), participant_id (FK), registration_date, unique composite |
| 7 | 2026_06_22_210644_add_image_to_events_table | events | Menambah kolom image (nullable string) |
| 8 | 2026_06_22_211122_add_attended_at_to_registrations_table | registrations | Menambah kolom attended_at (nullable timestamp) |
| 9 | 2026_06_22_211122_add_category_id_to_events_table | events | Menambah foreign key category_id ke tabel categories (nullable, nullOnDelete) |
| 10 | 2026_06_22_211122_create_categories_table | categories | id, name (unique), timestamps |

---

## 9. SOURCE CODE — SEEDER

### 9.1 DatabaseSeeder.php

```php
<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Participant;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin User
        User::create([
            'name' => 'Admin EMS',
            'email' => 'admin@ems.test',
            'password' => bcrypt('password'),
        ]);

        // 7 Categories
        $categories = ['Workshop', 'Seminar', 'Lomba', 'Pameran', 'Career Fair', 'Pelatihan', 'Hackathon'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }

        // 7 Events (5 upcoming, 2 completed)
        $events = [
            [
                'title' => 'Workshop Web Development',
                'description' => 'Belajar membuat aplikasi web modern menggunakan Laravel dan Tailwind CSS.',
                'event_date' => '2026-07-15 09:00:00',
                'location' => 'Lab Komputer A, Gedung Teknik',
                'quota' => 30,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Seminar Cyber Security',
                'description' => 'Membahas tren terbaru keamanan siber dan etika hacking.',
                'event_date' => '2026-07-20 13:00:00',
                'location' => 'Auditorium Utama',
                'quota' => 100,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Lomba Debat Bahasa Inggris',
                'event_date' => '2026-06-25 08:00:00',
                'location' => 'Ruang Seminar Lantai 3',
                'quota' => 20,
                'status' => 'completed',
            ],
            [
                'title' => 'Pameran Proyek Mahasiswa',
                'event_date' => '2026-08-05 10:00:00',
                'location' => 'Lobby Utama Kampus',
                'quota' => 50,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Pelatihan Public Speaking',
                'event_date' => '2026-08-12 09:00:00',
                'location' => 'Ruang 401, Gedung Serbaguna',
                'quota' => 25,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Hackathon 2026',
                'description' => 'Kompetisi coding 24 jam.',
                'event_date' => '2026-06-10 07:00:00',
                'location' => 'Lab Komputer B & C',
                'quota' => 60,
                'status' => 'completed',
            ],
            [
                'title' => 'Career Fair Kampus',
                'description' => 'Temuilah recruiter dari 20+ perusahaan teknologi.',
                'event_date' => '2026-09-01 09:00:00',
                'location' => 'Lapangan Parkir Utama',
                'quota' => 200,
                'status' => 'upcoming',
            ],
        ];

        foreach ($events as $data) {
            Event::create($data);
        }

        // 15 Participants
        $participants = [
            ['name' => 'Andi Pratama', 'email' => 'andi@student.edu', 'phone' => '081234567890'],
            ['name' => 'Bunga Lestari', 'email' => 'bunga@student.edu', 'phone' => '081234567891'],
            // ... 13 lainnya
        ];

        foreach ($participants as $data) {
            Participant::create($data);
        }

        // 30 Registrations (mapping event_id + participant_id)
        $registrations = [
            ['event_id' => 1, 'participant_id' => 1],
            ['event_id' => 1, 'participant_id' => 2],
            ['event_id' => 1, 'participant_id' => 3],
            // ... 27 lainnya
        ];

        foreach ($registrations as $data) {
            Registration::create($data);
        }
    }
}
```

**Data yang di-seed:**
- **1 admin user** — email: admin@ems.test, password: password.
- **7 kategori** — Workshop, Seminar, Lomba, Pameran, Career Fair, Pelatihan, Hackathon.
- **7 event** — 5 upcoming dan 2 completed dengan berbagai kuota (20–200).
- **15 peserta** — dengan email domain `@student.edu`.
- **30 registrasi** — mapping event-participant untuk mengisi data demo.

---

## 10. CREDENTIALS & ACCESS

| Role | Email | Password | Akses |
|---|---|---|---|
| Admin | admin@ems.test | password | `/admin/*` (wajib login) |
| Public | — | — | `/` dan `/events/*` (terbuka untuk umum) |

---

## 11. FITUR LENGKAP

| No | Fitur | Deskripsi | Tipe Akses |
|---|---|---|---|
| 1 | Landing Page Publik | Menampilkan semua event upcoming dengan search, filter kategori, dan paginasi | Publik |
| 2 | Detail Event Publik | Halaman detail event dengan form pendaftaran + validasi kuota & tanggal | Publik |
| 3 | Pendaftaran Event | Form pendaftaran publik dengan validasi duplikasi (firstOrCreate participant) | Publik |
| 4 | Login Admin | Autentikasi admin dengan fitur "remember me" | Guest |
| 5 | Logout | Menghapus session dan redirect ke home | Auth |
| 6 | Dashboard Admin | 4 stat cards (Events, Participants, Registrations, Active) + recent + upcoming | Admin |
| 7 | CRUD Events | Kelola event: create, read, update, delete dengan upload poster | Admin |
| 8 | CRUD Participants | Kelola data peserta | Admin |
| 9 | CRUD Registrations | Kelola pendaftaran (admin dapat mendaftarkan peserta ke event) | Admin |
| 10 | Validasi Form Request | 6 Form Request dengan custom error messages bahasa Indonesia | Admin |
| 11 | Filter Kategori | Chip/pill filter kategori di halaman publik dan admin events | Publik & Admin |
| 12 | Search | Pencarian event berdasarkan judul (publik) dan judul/lokasi (admin) | Publik & Admin |
| 13 | Upload Gambar Event | Upload poster event dengan validasi tipe file dan ukuran (max 5 MB) | Admin |
| 14 | Manajemen Kuota | Progress bar kuota pendaftaran + pengecekan kuota penuh saat registrasi | Publik & Admin |
| 15 | Presensi / Check-in | Halaman presensi per event dengan toggle kehadiran (hadir/batal) | Admin |
| 16 | Progress Bar Kehadiran | Visualisasi persentase kehadiran di halaman check-in | Admin |
| 17 | Export CSV | Export daftar peserta + status kehadiran ke file CSV per event | Admin |
| 18 | Composite Unique Validation | Validasi unik event_id + participant_id mencegah registrasi ganda | Sistem |
| 19 | Soft State Handling | Form pendaftaran menangani 3 state: available, kuota penuh, event berakhir | Publik |
| 20 | Flash Messages | Notifikasi sukses dan error di layout admin dan publik | Global |
| 21 | Loading Spinner | Semua tombol submit form otomatis menampilkan spinner saat loading | Admin |
| 22 | Mobile Responsive | Sidebar collapsible di mobile dengan backdrop overlay | Admin |
| 23 | Delete Confirmation Modal | Modal konfirmasi sebelum menghapus event | Admin |
| 24 | Pagination | Paginasi dengan preserved query string di semua list halaman | Global |
| 25 | Kategorisasi Event | Event dapat dikategorikan (belongsTo Category) | Admin |
| 26 | Route Model Binding | Implicit binding untuk Event, Participant, dan Registration | Sistem |
| 27 | CSRF Protection | Semua form POST/PUT/DELETE dilindungi @csrf | Sistem |
| 28 | Force HTTPS | AppServiceProvider memaksa HTTPS di environment production | Sistem |
| 29 | Trust Proxies | Middleware trust proxies untuk deployment di belakang reverse proxy | Sistem |
| 30 | Docker Deployment | Dockerfile multi-stage siap deploy ke Railway/Render | DevOps |

---

## 12. ARSITEKTUR SINGKAT

```
                         ┌──────────────────────────────┐
                         │     Browser (Public)          │
                         │  /  +  /events/{id}          │
                         └──────────┬───────────────────┘
                                    │ HTTP
                         ┌──────────▼───────────────────┐
                         │  PublicEventController        │
                         │  index / show / register      │
                         └──────────┬───────────────────┘
                                    │
              ┌─────────────────────┼─────────────────────┐
              │                     │                     │
    ┌─────────▼────────┐  ┌────────▼────────┐  ┌─────────▼────────┐
    │   Event Model     │  │ Participant     │  │ Registration     │
    │   + Category      │  │ Model           │  │ Model (pivot)    │
    └──────────────────┘  └─────────────────┘  └──────────────────┘
              │                     │                     │
              └─────────────────────┼─────────────────────┘
                                    │
                         ┌──────────▼───────────────────┐
                         │  SQLite Database              │
                         │  events, participants,        │
                         │  registrations, categories,   │
                         │  users, sessions, cache       │
                         └──────────────────────────────┘

                         ┌──────────────────────────────┐
                         │     Browser (Admin)           │
                         │  /admin/*                     │
                         └──────────┬───────────────────┘
                                    │ HTTP + Session Auth
                         ┌──────────▼───────────────────┐
                         │  LoginController              │
                         │  + Middleware auth             │
                         └──────────┬───────────────────┘
                                    │
              ┌─────────────────────┼─────────────────────┐
              │                     │                     │
    ┌─────────▼────────┐  ┌────────▼────────┐  ┌─────────▼────────┐
    │  EventController  │  │ Participant     │  │ Registration     │
    │  + Form Requests  │  │ Controller      │  │ Controller       │
    │  + Image Upload   │  │ + Form Requests │  │ + Check-in       │
    └──────────────────┘  └─────────────────┘  │ + CSV Export     │
                                                └──────────────────┘
```

---

## 13. TEKNOLOGI / STACK

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 13 (PHP 8.4) |
| Database | SQLite (via file database/database.sqlite) |
| ORM | Eloquent (Active Record pattern) |
| Frontend Styling | Tailwind CSS v4 (via Vite) |
| JavaScript Bundler | Vite |
| Autentikasi | Session-based Auth (Eloquent driver) |
| Session Driver | Database |
| Queue Driver | Database |
| Cache Driver | Database |
| Validasi | Laravel Form Request + custom messages |
| Deployment | Docker (PHP 8.4 CLI + Node.js + SQLite) |
| Image Storage | Laravel Storage (local disk, `storage/app/public/`) |

---

*Dokumentasi ini dibuat berdasarkan kode sumber aktual project EMS per 23 Juni 2026.*
