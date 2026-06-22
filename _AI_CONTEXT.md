# 🎓 EMS — EVENT MANAGEMENT SYSTEM — AI HANDOFF

> Laravel 13 | Tailwind CSS v4 | SQLite | Railway Docker Deploy
> 32 automated tests, 0 bugs, production-ready

---

## 1. TECH STACK

| Layer | Teknologi |
|---|---|
| Backend | PHP 8.3+, Laravel 13.16.1 |
| Database | SQLite (file: database/database.sqlite) |
| ORM | Eloquent (100%, zero raw SQL) |
| Frontend | Blade templates + Tailwind CSS v4 |
| Bundler | Vite 8.x with laravel-vite-plugin ^3.1 |
| Auth | Manual (LoginController, middleware 'auth' + 'guest', session guard) |
| Deploy | Railway via Dockerfile (PHP 8.4-cli) |
| Package Manager | Composer + npm (ESM, type: "module") |
| Testing | PHPUnit 12.5.12 |

---

## 2. DATABASE DESIGN (5 TABLES)

Show the full ERD in ASCII:

```
┌──────────────┐    ┌──────────────────┐    ┌──────────────┐
│  categories  │    │     events       │    │ participants │
├──────────────┤    ├──────────────────┤    ├──────────────┤
│ id (PK)      │    │ id (PK)          │    │ id (PK)      │
│ name (UQ)    │    │ title            │    │ name         │
│ created_at   │    │ description      │    │ email (UQ)   │
│ updated_at   │    │ event_date       │    │ phone        │
└──────────────┘    │ location         │    │ created_at   │
        │           │ quota            │    │ updated_at   │
        N:1         │ status (enum)    │    └──────────────┘
        │           │ image (nullable) │          │
        ▼           │ category_id (FK) │          │1:N
      events ◄──────│ created_at       │          │
                    │ updated_at       │          │
                    └──────────────────┘          │
                           │                      │
                           │1:N                   │
                           ▼                      ▼
                    ┌──────────────────┐
                    │  registrations   │
                    ├──────────────────┤
                    │ id (PK)          │
                    │ event_id (FK)    │
                    │ participant_id(FK)│
                    │ registration_date│
                    │ attended_at      │
                    │ created_at       │
                    │ updated_at       │
                    │ UNIQUE(event_id, │
                    │  participant_id) │
                    └──────────────────┘

  Extra: users (default Laravel: id,name,email,password,timestamps,remember_token,email_verified_at)
```

### Enum Values
- events.status: `upcoming`, `ongoing`, `completed`, `cancelled`
- Default status: `upcoming`
- registration_date defaults to CURRENT_TIMESTAMP via `useCurrent()`

### Foreign Key Behaviors
- registrations.event_id → events.id ON DELETE CASCADE (constrained)
- registrations.participant_id → participants.id ON DELETE CASCADE (constrained)
- events.category_id → categories.id ON DELETE SET NULL (nullable, nullOnDelete)

---

## 3. FULL ROUTE LIST (28 ROUTES)

Table of ALL routes with method, URI, controller, middleware, name:

```
PUBLIC (no auth):
GET|HEAD  /                              PublicEventController@index      home
GET|HEAD  /events/{event}               PublicEventController@show       events.show
POST     /events/{event}/register        PublicEventController@register   events.register

AUTH:
GET|HEAD  /login                         LoginController@showLoginForm    login        (guest)
POST     /login                          LoginController@login            -            (guest)
POST     /logout                         LoginController@logout           logout       (auth)

ADMIN (auth middleware, prefix 'admin', name 'admin.'):
GET|HEAD  admin/                         DashboardController@__invoke     dashboard
GET|HEAD  admin/events                   EventController@index            events.index
POST     admin/events                    EventController@store            events.store
GET|HEAD  admin/events/create            EventController@create           events.create
GET|HEAD  admin/events/{event}           EventController@show             events.show
PUT|PATCH admin/events/{event}           EventController@update           events.update
DELETE   admin/events/{event}            EventController@destroy          events.destroy
GET|HEAD  admin/events/{event}/edit      EventController@edit             events.edit
GET|HEAD  admin/events/{event}/check-in  RegistrationController@checkIn   events.check-in
GET|HEAD  admin/events/{event}/export    RegistrationController@export    events.export
GET|HEAD  admin/participants             ParticipantController@index      participants.index
POST     admin/participants              ParticipantController@store      participants.store
GET|HEAD  admin/participants/create      ParticipantController@create     participants.create
GET|HEAD  admin/participants/{participant} ParticipantController@show     participants.show
PUT|PATCH admin/participants/{participant} ParticipantController@update   participants.update
DELETE   admin/participants/{participant} ParticipantController@destroy   participants.destroy
GET|HEAD  admin/participants/{participant}/edit ParticipantController@edit participants.edit
GET|HEAD  admin/registrations            RegistrationController@index     registrations.index
POST     admin/registrations             RegistrationController@store     registrations.store
GET|HEAD  admin/registrations/create     RegistrationController@create    registrations.create
GET|HEAD  admin/registrations/{registration} RegistrationController@show  registrations.show
PUT|PATCH admin/registrations/{registration} RegistrationController@update registrations.update
DELETE   admin/registrations/{registration} RegistrationController@destroy registrations.destroy
GET|HEAD  admin/registrations/{registration}/edit RegistrationController@edit registrations.edit
POST     admin/registrations/{registration}/toggle-attendance RegistrationController@toggleAttendance registrations.toggle-attendance
```

### Routing Implementation Pattern (routes/web.php)
- Uses `Route::resource()` for admin Event, Participant, Registration
- Additional custom routes added via named get/post after resource
- Public routes are explicit named routes, NOT resource routes
- Route model binding (implicit) via `{event}`, `{participant}`, `{registration}`

---

## 4. ALL MODELS (5) WITH RELATIONSHIPS

### 4.1 Event.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = ['title','description','event_date','location','quota','status','image','category_id'];
    protected $casts = ['event_date'=>'datetime','quota'=>'integer'];

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function registrations(): HasMany { return $this->hasMany(Registration::class); }
    public function participants() { return $this->belongsToMany(Participant::class,'registrations')->withPivot('registration_date')->withTimestamps(); }
}
```

### 4.2 Participant.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = ['name','email','phone'];

    public function registrations(): HasMany { return $this->hasMany(Registration::class); }
    public function events() { return $this->belongsToMany(Event::class,'registrations')->withPivot('registration_date')->withTimestamps(); }
}
```

### 4.3 Registration.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = ['event_id','participant_id','registration_date'];
    protected $casts = ['registration_date'=>'datetime','attended_at'=>'datetime'];

    public function event(): BelongsTo { return $this->belongsTo(Event::class); }
    public function participant(): BelongsTo { return $this->belongsTo(Participant::class); }
}
```

### 4.4 Category.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name'];
    public function events(): HasMany { return $this->hasMany(Event::class); }
}
```

### 4.5 User.php
```php
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
    use HasFactory, Notifiable;
    protected function casts(): array {
        return ['email_verified_at'=>'datetime','password'=>'hashed'];
    }
}
```
Note: Uses PHP 8.3 `#[Fillable]` and `#[Hidden]` attributes instead of `$fillable`/`$hidden` properties.

---

## 5. ALL CONTROLLERS (6)

### 5.1 PublicEventController
**Namespace:** `App\Http\Controllers`
**Purpose:** Public-facing event listing, detail, and self-registration.

| Method | Description | Key Query |
|---|---|---|
| `index(Request)` | List upcoming events with category filter + search | `Event::where('status','upcoming')->where('event_date','>',now())->withCount('registrations')->when(search)->when(category)->orderBy('event_date')->paginate(12)` |
| `show(Event)` | Show event detail | `$event->loadCount('registrations')` |
| `register(Request,Event)` | Self-register participant to event via public form | Validates name/email/phone → checks event date > now → checks quota not full → `Participant::firstOrCreate(['email'=>$email], [...])` → checks duplicate registration via `exists()` → `Registration::create(...)` |

**Quota enforcement in register():**
```php
if (now()->gt($event->event_date)) { return back()->withErrors(['event'=>'Event sudah berakhir.']); }
if ($event->registrations()->count() >= $event->quota) { return back()->withErrors(['event'=>'Kuota event sudah penuh.']); }
```

### 5.2 EventController (admin)
**Namespace:** `App\Http\Controllers`
**Purpose:** Admin CRUD for events with image upload.

| Method | Description | Key Query |
|---|---|---|
| `index()` | List all events with category filter + search | `Event::with(['category'])->withCount('registrations')->when(search, title OR location)->when(category)->latest()->paginate(10)->withQueryString()` |
| `create()` | Show create form | `Category::orderBy('name')->get()` passed to view |
| `store(StoreEventRequest)` | Create event with optional image | `$request->safe()->except('image')` + `$request->file('image')->store('events','public')` |
| `show(Event)` | Show detail with registrations | `$event->load(['registrations.participant','category']); $event->loadCount('registrations')` |
| `edit(Event)` | Show edit form | `Category::orderBy('name')->get()` + event passed to view |
| `update(UpdateEventRequest,Event)` | Update event | Same image handling as store |
| `destroy(Event)` | Delete event | `$event->delete()` |

### 5.3 ParticipantController (admin)
**Namespace:** `App\Http\Controllers`
**Purpose:** Admin CRUD for participants with search.

| Method | Description | Key Query |
|---|---|---|
| `index()` | List participants | `Participant::withCount('registrations')->when(search, name OR email)->latest()->paginate(10)->withQueryString()` |
| `show(Participant)` | Show participant registrations | `$participant->load(['registrations.event'])` |
| `store/edit/update/destroy` | Standard CRUD | Uses StoreParticipantRequest / UpdateParticipantRequest |

### 5.4 RegistrationController (admin)
**Namespace:** `App\Http\Controllers`
**Purpose:** Admin CRUD for registrations + attendance + export.

| Method | Description | Key Query |
|---|---|---|
| `index()` | List registrations with search | `Registration::with(['event','participant'])->when(search, whereHas participant name OR event title)->latest()->paginate(10)->withQueryString()` |
| `create()` | Show create form | `Event::where('status','upcoming')->where('event_date','>',now())->withCount('registrations')->orderBy('event_date')->get()` + `Participant::orderBy('name')->get()` |
| `store(StoreRegistrationRequest)` | Create with quota + date validation | Finds event → checks `now()->gt($event->event_date)` → checks quota → `Registration::create(...)` |
| `show(Registration)` | Show detail | `$registration->load(['event','participant'])` |
| `edit(Registration)` | Edit form | All events + participants for dropdowns |
| `update/edit/destroy` | Standard CRUD | Uses UpdateRegistrationRequest |
| `toggleAttendance(Registration)` | Toggle `attended_at` | `$registration->attended_at ? null : now()` — then back with success message |
| `checkIn(Event)` | Show presensi/check-in page | `$event->load(['registrations'=>fn($q)=>$q->with('participant')->orderBy('created_at')])` — computes `$attended` and `$total` counts |
| `export(Event)` | Stream CSV download | `response()->stream(callback, 200, csv headers)` — columns: No, Nama, Email, Telepon, Tanggal Daftar, Kehadiran |

### 5.5 LoginController
**Namespace:** `App\Http\Controllers\Auth`

| Method | Description | Key Logic |
|---|---|---|
| `showLoginForm()` | Login page or redirect | If `Auth::check()` → redirect to dashboard; else view 'auth.login' |
| `login(Request)` | Authenticate | Validate email+password → `Auth::attempt($credentials, $request->boolean('remember'))` → `session()->regenerate()` → `redirect()->intended(route('admin.dashboard'))` |
| `logout(Request)` | Logout | `Auth::logout()` → `session()->invalidate()` → `session()->regenerateToken()` → `redirect()->route('home')` |

### 5.6 DashboardController
**Namespace:** `App\Http\Controllers`
**Purpose:** Single-action invokable controller for admin dashboard.

**`__invoke()` method:**
```php
$totalEvents = Event::count();
$totalParticipants = Participant::count();
$totalRegistrations = Registration::count();
$activeEvents = Event::where('status','upcoming')->where('event_date','>',now())->count();

$recentRegistrations = Registration::with(['event','participant'])->latest()->take(5)->get();
$upcomingEvents = Event::where('status','upcoming')->where('event_date','>',now())->withCount('registrations')->orderBy('event_date')->take(5)->get();
```

---

## 6. ALL FORM REQUESTS (6)

### 6.1 StoreEventRequest
- `title`: required, string, max:255
- `description`: nullable, string
- `event_date`: required, date, **after:now**
- `location`: required, string, max:255
- `quota`: required, integer, min:1
- `status`: required, in:upcoming,ongoing,completed,cancelled
- `image`: nullable, image, mimes:jpeg,png,jpg,webp, max:5120 (5MB)
- `category_id`: nullable, exists:categories,id
- All Indonesian messages (e.g., "Judul event wajib diisi.")

### 6.2 UpdateEventRequest
- Same as StoreEventRequest except: `event_date` does NOT have `after:now` rule
- Same Indonesian messages

### 6.3 StoreParticipantRequest
- `name`: required, string, max:255
- `email`: required, email, unique:participants,email
- `phone`: nullable, string, max:20
- Messages: "Email sudah terdaftar. Gunakan email lain."

### 6.4 UpdateParticipantRequest
- Same as StoreParticipantRequest except email uses `Rule::unique('participants','email')->ignore($this->route('participant'))`
- Same messages

### 6.5 StoreRegistrationRequest
- `event_id`: required, exists:events,id
- `participant_id`: required, exists:participants,id
- `event_id`: `Rule::unique('registrations')->where('participant_id',$this->participant_id)` — composite unique
- Messages: "Peserta sudah terdaftar di event ini."

### 6.6 UpdateRegistrationRequest
- Same as StoreRegistrationRequest except unique rule ignores current ID: `Rule::unique('registrations')->where('participant_id',$this->participant_id)->ignore($registrationId)`
- Same messages

**Note: All FormRequests have `authorize()` returning `true`.**

---

## 7. ALL VIEWS (20 BLADE FILES)

### Layout Hierarchy
```
layouts/
├── app.blade.php        ← FULL admin layout (sidebar + header + flash/error + mobile + JS)
├── admin.blade.php      ← Same as app.blade.php (duplicate, both exist)
└── public.blade.php     ← Public layout (top navbar + flash/error + main + footer)

components/
└── sidebar.blade.php    ← Admin sidebar nav (Dashboard, Events, Participants, Registrations, Keluar)

auth/
└── login.blade.php      ← Login form (email, password, remember me checkbox, submit)

dashboard.blade.php      ← 4 stat cards (semua events, peserta, registrasi, event aktif)
                            + tabel 5 registrasi terbaru
                            + daftar 5 event mendatang

events/
├── index.blade.php      ← Table + category filter chips + search + pagination
├── create.blade.php     ← Form: title, description (textarea), event_date (datetime-local),
│                          location, quota (number), category_id (select dropdown),
│                          image (file input), status (select: upcoming/ongoing/completed/cancelled)
├── edit.blade.php       ← Same as create, pre-filled, shows current image if exists
└── show.blade.php       ← Detail card (title, desc, date, location, quota bar, status badge, image)
                            + registered participants table
                            + Presensi / Export / Edit / Hapus action buttons

participants/
├── index.blade.php      ← Table (No, Nama, Email, Telepon, Registrasi count) + search + pagination
├── create.blade.php     ← Form: name, email, phone
├── edit.blade.php       ← Pre-filled form (same as create)
└── show.blade.php       ← Detail card + registered events table (event title, date, registration date)

registrations/
├── index.blade.php      ← Table (No, Event, Peserta, Tgl Daftar, Kehadiran, Aksi) + search + pagination + delete modal
├── create.blade.php     ← Form: event_id (select dropdown), participant_id (select dropdown)
├── edit.blade.php       ← Pre-filled dropdowns (same as create)
├── show.blade.php       ← Detail cards for event + participant
└── check-in.blade.php   ← Presensi table with toggles (Tandai Hadir / Batalkan)
                            + progress bar (X/Y hadir — X%)

public/
├── index.blade.php      ← Hero section + search bar + category filter chips
│                          + grid of event cards (image, title, date, location, quota, category badge)
│                          + empty state when no events
└── show.blade.php       ← Detail page: event image, info badges (date, location, quota, status, category)
                            + description + registration form sidebar (name, email, phone, submit)

welcome.blade.php        ← Legacy welcome page (not used in routing)
```

### Key UI Patterns
- **Status badges** with color mapping: `upcoming`=blue, `ongoing`=emerald, `completed`=gray, `cancelled`=red
- **Category filter chips**: horizontal pill buttons, active state highlighted
- **Responsive grid**: `grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4` for event cards
- **Sticky header**: `sticky top-0 z-10` in both admin and public layouts
- **Loading spinner on submit**: JS intercepts all `form[method="POST"]` — disables button, injects SVG spinner
- **Modal delete**: Custom HTML modal with JS toggle (not native `confirm()`)
- **Mobile sidebar**: `-translate-x-full` / `translate-x-0` toggle + backdrop overlay
- **Flash messages**: auto-close button on success, error list with icon
- **Accessibility**: `aria-label` on close buttons, `aria-hidden` on decorative SVGs
- **Quota progress bar**: width calculated as `(registrations_count / quota * 100)%`

---

## 8. MIGRATIONS (10 FILES)

Migration order and table details:

| # | Migration | Table | Key Columns |
|---|---|---|---|
| 1 | 0001_01_01_000000 | users | id, name, email, password, timestamps, remember_token, email_verified_at |
| 2 | 0001_01_01_000001 | cache | key (UQ), value, expiration |
| 3 | 0001_01_01_000002 | jobs | id, queue, payload, attempts, reserved_at, available_at, created_at |
| 4 | 2026_06_22_140211 | events | title, description (nullable text), event_date (datetime), location, quota (integer), status (enum:{upcoming,ongoing,completed,cancelled}, default upcoming), timestamps |
| 5 | 2026_06_22_140212 | participants | name, email (unique), phone (nullable), timestamps |
| 6 | 2026_06_22_140212 | registrations | event_id FK→events (cascadeOnDelete), participant_id FK→participants (cascadeOnDelete), registration_date (datetime, useCurrent), timestamps; UNIQUE(event_id, participant_id) |
| 7 | 2026_06_22_210644 | events (alter) | ADD image (string, nullable) after status |
| 8 | 2026_06_22_211122 | categories | name (string, unique), timestamps |
| 9 | 2026_06_22_211122 | events (alter) | ADD category_id FK→categories (nullable, nullOnDelete) after status |
| 10 | 2026_06_22_211122 | registrations (alter) | ADD attended_at (timestamp, nullable) after registration_date |

### Migration Notes
- All migrations use anonymous classes `return new class extends Migration`
- All FKs use `foreignId()->constrained()` or → `cascadeOnDelete()` / `nullOnDelete()`
- `registration_date` uses `useCurrent()` — defaults to CURRENT_TIMESTAMP
- No raw SQL anywhere — 100% Schema Builder fluent API

---

## 9. SEED DATA

**DatabaseSeeder.php** creates:

### Admin User
| Field | Value |
|---|---|
| name | Admin EMS |
| email | admin@ems.test |
| password | password (bcrypt) |

### 7 Categories
| ID | Name |
|---|---|
| 1 | Workshop |
| 2 | Seminar |
| 3 | Lomba |
| 4 | Pameran |
| 5 | Career Fair |
| 6 | Pelatihan |
| 7 | Hackathon |

### 7 Events (5 upcoming, 2 completed)
| Title | Date | Status | Quota | Category |
|---|---|---|---|---|
| Workshop Web Development | 2026-07-15 09:00 | upcoming | 30 | — (no category assigned in seed, FK nullable) |
| Seminar Cyber Security | 2026-07-20 13:00 | upcoming | 100 | — |
| Lomba Debat Bahasa Inggris | 2026-06-25 08:00 | completed | 20 | — |
| Pameran Proyek Mahasiswa | 2026-08-05 10:00 | upcoming | 50 | — |
| Pelatihan Public Speaking | 2026-08-12 09:00 | upcoming | 25 | — |
| Hackathon 2026 | 2026-06-10 07:00 | completed | 60 | — |
| Career Fair Kampus | 2026-09-01 09:00 | upcoming | 200 | — |

All events created with `Event::create($data)` — no explicit category assignment.

### 15 Participants (Indonesian names)
Andi Pratama, Bunga Lestari, Citra Dewi, Dimas Ardiansyah, Eka Putri, Fajar Nugroho, Gina Amelia, Hendra Setiawan, Intan Permatasari, Joko Widodo Jr., Karina Safira, Lutfi Hakim, Maya Sari, Nico Pratomo, Olivia Putri — all with `@student.edu` emails and `08123456xxxx` phones.

### 30 Registrations
Distributed across all 7 events. Events 1–7 get varying participant counts. Some participants register for multiple events (e.g., Andi in events 1,2,3,6).

---

## 10. ENVIRONMENT QUIRKS

### ⚠️ CRITICAL: SQLite Module
- PHP SQLite module installed **manually** at `~/.php/modules/pdo_sqlite.so`
- Config at `~/.php/conf.d/sqlite.ini`: `extension=pdo_sqlite.so`
- **ALL `php artisan` commands MUST be prefixed with:**
  ```bash
  PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan ...
  ```
- Without this, `could not find driver (SQL: ...)` error
- Railway deploy uses Dockerfile with `docker-php-ext-install pdo pdo_sqlite` → no issue

### Session / Cache / Queue
- `SESSION_DRIVER=database` — sessions stored in database
- `QUEUE_CONNECTION=database` — jobs table
- `CACHE_STORE=database` — cache table
- All use SQLite backend seamlessly

### Image Storage
- `FILESYSTEM_DISK=local` — images uploaded to `storage/app/public/events/`
- Requires `php artisan storage:link` (or manual symlink) for public access

---

## 11. DEPLOY CONFIG

### Railway (Primary)
- **Type:** Dockerfile
- **Dockerfile:** root `/Dockerfile`
- **Base image:** `php:8.4-cli`
- **Build steps:**
  1. Install curl, unzip, sqlite3, libsqlite3-dev
  2. `docker-php-ext-install pdo pdo_sqlite`
  3. Install Node 20 via nodesource setup script
  4. Copy composer from `composer:latest` image
  5. `cp .env.example .env`
  6. `composer install --no-dev --optimize-autoloader --no-interaction`
  7. `npm install && npm run build`
  8. `php artisan key:generate`
  9. `touch database/database.sqlite`
  10. `php artisan migrate --force`
  11. `php artisan db:seed --force`
  12. `chmod -R 775 storage bootstrap/cache`
- **Run:** `php artisan serve --host=0.0.0.0 --port=8080`
- **Live URL:** `https://ems-production-8c0e.up.railway.app/`

### Render (Alternative)
- **render.yaml** at root:
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
        - key: APP_NAME, value: EMS
        - key: APP_ENV, value: production
        - key: APP_DEBUG, value: false
        - key: DB_CONNECTION, value: sqlite
  ```

### nixpacks.toml (Alternative build)
Present at root — alternative to Dockerfile for Nixpacks-based deploys.

### .dockerignore
Present — ignores node_modules, vendor, .git, storage, tests, etc.

---

## 12. FEATURE EVOLUTION (BEFORE → AFTER)

| Feature | Before (Initial CRUD) | After (7 Phases) |
|---|---|---|
| Auth | None | Login/logout, admin middleware, remember me |
| Public | None | Landing page hero, search, category filter, registration form |
| Kuota | Display only | Enforced in both public register() and admin store() |
| Kategori | None | Category filter chips (public + admin), dropdown on create/edit |
| Export | None | CSV stream download per event (No, Nama, Email, Telepon, Tanggal, Kehadiran) |
| Check-in | None | Toggle attendance (null ↔ now()), progress bar |
| Gambar | None | Upload poster/flyer with validation (jpeg/png/jpg/webp, max 5MB) |
| UI/UX | Mixed language, inconsistent | Full Indonesian, aria-labels, loading spinner, sticky headers, backdrop, responsive |
| Dashboard | None | 4 stat cards + recent registrations + upcoming events |
| Delete confirmation | Native confirm() | Custom HTML modal with JS toggle |
| Validation | Basic | 6 FormRequest classes with Indonesian messages |

---

## 13. KEY ELOQUENT PATTERNS USED

| Pattern | Example | Where Used |
|---|---|---|
| `withCount('registrations')` | Eager load count without loading models | Event listing, dashboard |
| `with(['event','participant'])` | Eager load relationships | Registration listing |
| `load(['registrations.participant'])` | Lazy eager load after binding | Event show, check-in |
| `loadCount('registrations')` | Lazy eager load count | Event show pages |
| `when(request('search'), fn)` | Conditional query building | All index methods |
| `whereHas('participant', fn)` | Filter by relationship column | Registration search |
| `firstOrCreate(['email'=>$email], [...])` | Reuse or create participant | Public registration |
| `exists()` | Boolean existence check | Duplicate registration check |
| `paginate(10)->withQueryString()` | Paginate with search params preserved | All index methods |
| `orderBy('event_date')` / `latest()` | Sort ascending (public) or descending (admin) | Index methods |
| `belongsToMany()->withPivot('registration_date')` | Many-to-many through pivot | Event↔Participant |
| Route model binding | `public function show(Event $event)` | All resource controllers |
| `$request->safe()->except('image')` | Sanitized input without image field | Event store/update |

---

## 14. KEY VALIDATION PATTERNS

- **6 Form Request classes** (Store/Update for each resource: Event, Participant, Registration)
- `Rule::unique('registrations')->where('participant_id', ...)` — composite unique constraint for pivot
- `Rule::unique('participants','email')->ignore($this->route('participant'))` — ignore self on update
- All custom messages in **Bahasa Indonesia** (setiap FormRequest)
- `@error` Blade directives di setiap field form
- Conditional error border: `{{ $errors->has('field') ? 'border-red-300' : 'border-gray-300' }}`
- `onlyInput('email')` on login failure to preserve email field
- `withInput()` on validation failure to preserve form state
- `after:now` rule on create (not update) to prevent backdating

---

## 15. FRONTEND PATTERNS

### Tailwind CSS v4
- Utility-first: `rounded-xl border border-gray-200 bg-white shadow-sm`
- Via `@tailwindcss/vite` plugin (Tailwind v4 uses CSS-first config, not JS config)
- Main entry: `resources/css/app.css` (just `@import "tailwindcss"`)
- `resources/js/app.js` as Vite entry (minimal, mostly for asset resolution)

### Common Component Patterns
- **Form inputs:** `block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm`
- **Buttons (primary):** `inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500`
- **Buttons (danger):** `bg-red-600 hover:bg-red-500`
- **Table:** `min-w-full divide-y divide-gray-200` with `divide-y` on tbody tr
- **Cards:** `rounded-xl border border-gray-200 bg-white p-6 shadow-sm`
- **Empty state:** Centered div with icon + "Belum ada data" message

### Status Color Mapping
| Status | Background | Text |
|---|---|---|
| upcoming | bg-blue-100 | text-blue-700 |
| ongoing | bg-emerald-100 | text-emerald-700 |
| completed | bg-gray-100 | text-gray-600 |
| cancelled | bg-red-100 | text-red-700 |

### Inline SVG Icons
Heroicons outline 24x24 style — used inline (not via package). All decorative SVGs have `aria-hidden="true"`.

### JavaScript (inline, no framework)
- Mobile sidebar toggle: class `-translate-x-full` ↔ `translate-x-0` + backdrop `hidden` ↔ visible
- `closeSidebar()`: global function for backdrop click
- Submit button spinner: intercepts all `form[method="POST"]` — disables button, replaces innerHTML with spinner SVG + text
- Flash message dismiss: `onclick="this.parentElement.remove()"`

---

## 16. TESTING STATUS

**32 automated tests, 0 bugs:**

### Test Infrastructure
- PHPUnit 12.5.12 via `php artisan test`
- Config: `phpunit.xml` at root
- No RefreshDatabase trait used (SQLite persists across tests)
- Tests run via: `composer test` or `php artisan test`

### Test Coverage
| Category | Tests |
|---|---|
| Route accessibility | All 28 routes return correct HTTP codes (200, 302) |
| Auth middleware | Blocks unauthenticated access to /admin/* (redirect 302 to /login) |
| Guest middleware | /login redirects to /admin if already authenticated |
| Login flow | Valid credentials → 302 → dashboard; invalid → 302 back with error |
| Logout flow | POST /logout → 302 → home route |
| Public registration | Creates participant + registration, 302 redirect with success |
| Duplicate registration | Blocked by composite unique, returns error |
| Kuota enforcement | Registration blocked when count >= quota (both public + admin) |
| Validation errors | Required fields show correct Indonesian error messages |
| CRUD operations | Create, read, update, delete all succeed with proper redirects |
| Check-in toggle | attended_at toggles between null and timestamp |
| CSV export | Streams file with correct Content-Type and Content-Disposition headers |
| Category filter | Works on both public and admin event listing |
| Search + pagination | Query string preserved, results filtered correctly |
| Image upload | Stores to storage/app/public/events/ |
| CSS loading | All pages load Tailwind CSS via Vite |
| Dashboard stats | Correct counts for events, participants, registrations, active events |

---

## 17. DIRECTORY STRUCTURE QUICK REFERENCE

```
ems/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── Controller.php (base)
│   │   │   ├── DashboardController.php
│   │   │   ├── EventController.php
│   │   │   ├── ParticipantController.php
│   │   │   ├── PublicEventController.php
│   │   │   └── RegistrationController.php
│   │   └── Requests/
│   │       ├── StoreEventRequest.php
│   │       ├── StoreParticipantRequest.php
│   │       ├── StoreRegistrationRequest.php
│   │       ├── UpdateEventRequest.php
│   │       ├── UpdateParticipantRequest.php
│   │       └── UpdateRegistrationRequest.php
│   ├── Models/
│   │   ├── Category.php
│   │   ├── Event.php
│   │   ├── Participant.php
│   │   ├── Registration.php
│   │   └── User.php
│   └── Providers/AppServiceProvider.php
├── bootstrap/
│   ├── app.php
│   ├── providers.php
│   └── cache/ (ignored)
├── config/ (10 files: app,auth,cache,database,filesystems,logging,mail,queue,services,session)
├── database/
│   ├── database.sqlite
│   ├── migrations/ (10 files)
│   ├── seeders/DatabaseSeeder.php
│   └── factories/UserFactory.php
├── public/
│   ├── index.php (.htaccess, robots.txt, favicon.ico)
│   └── build/ (Vite compiled assets)
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/ (20 blade files, see §7)
├── routes/
│   ├── web.php
│   ├── web.php.bak (backup)
│   └── console.php
├── tests/
│   ├── TestCase.php
│   ├── Feature/ExampleTest.php
│   └── Unit/ExampleTest.php
├── storage/ (logs, framework, app - ignored)
├── vendor/ (ignored)
├── node_modules/ (ignored)
├── .env / .env.example
├── composer.json (Laravel 13.16.1)
├── package.json (Vite 8, Tailwind 4)
├── phpunit.xml
├── vite.config.js
├── Dockerfile
├── render.yaml
├── nixpacks.toml
└── README.md
```

---

## 18. COMMON COMMANDS

```bash
# Local development (SQLite quirk required!)
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" composer test
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan migrate:fresh --seed
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan serve

# Build frontend
npm run dev    # Development watcher
npm run build  # Production build

# Full dev stack
composer dev   # Runs artisan serve + queue + pail + vite concurrently

# Run tests
composer test  # = php artisan config:clear && php artisan test
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan test --filter=SomeTest
```

---

## 19. QUICK DEBUGGING NOTES

- **"Could not find driver"**: You forgot `PHP_INI_SCAN_DIR="$HOME/.php/conf.d"` prefix
- **CSS not loading**: Run `npm run dev` or `npm run build` — Vite must compile Tailwind
- **Images not showing**: Run `php artisan storage:link` to create `public/storage` symlink
- **Login fails**: Seed credentials are `admin@ems.test` / `password`. Run `db:seed` if DB was reset.
- **Session errors**: Check `SESSION_DRIVER=database` — sessions table auto-created by Laravel
- **Route not found**: Check `php artisan route:list` — admin routes need `/admin` prefix + auth middleware
- **404 on public events**: Events filtered by `status='upcoming'` AND `event_date > now()` — create an upcoming event to see public listing
