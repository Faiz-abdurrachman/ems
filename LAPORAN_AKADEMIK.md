# LAPORAN PROYEK — SISTEM MANAJEMEN EVENT KAMPUS (EMS)

**Mata Kuliah:** Framework PHP & CRUD  
**NIM:** 241111021  
**Nama:** Faiz Abdurrachman  

---

## DAFTAR ISI

1. [BAB 1 PENDAHULUAN](#bab-1-pendahuluan)  
   1.1 Latar Belakang  
   1.2 Rumusan Masalah  
   1.3 Tujuan Proyek  
   1.4 Batasan Masalah  
2. [BAB 2 FRAMEWORK](#bab-2-framework-yang-digunakan)  
3. [BAB 3 ANALISIS SISTEM](#bab-3-analisis-sistem)  
4. [BAB 4 DATABASE](#bab-4-database)  
5. [BAB 5 IMPLEMENTASI](#bab-5-implementasi)  
6. [BAB 6 IMPLEMENTASI CRUD](#bab-6-implementasi-crud)  
7. [BAB 7 TAMPILAN SISTEM](#bab-7-tampilan-sistem)  
8. [BAB 8 PENGUJIAN](#bab-8-pengujian)  
9. [BAB 9 KESIMPULAN](#bab-9-kesimpulan)  

---

## DAFTAR GAMBAR

| No | Judul Gambar |
|---|---|
| 1 | Entity Relationship Diagram (ERD) |
| 2 | Use Case Diagram |
| 3 | Tampilan Dashboard Admin |
| 4 | Tampilan Halaman Publik (Landing Page) |
| 5 | Tampilan Detail Event + Form Pendaftaran |
| 6 | Tampilan Login Admin |
| 7 | Tampilan Form Tambah Event |
| 8 | Tampilan Halaman Presensi / Check-in |

---

## DAFTAR TABEL

| No | Judul Tabel |
|---|---|
| 1 | Spesifikasi Teknologi |
| 2 | Struktur Tabel `events` |
| 3 | Struktur Tabel `participants` |
| 4 | Struktur Tabel `registrations` |
| 5 | Struktur Tabel `categories` |
| 6 | Daftar Route (28 route) |
| 7 | Daftar Form Request |
| 8 | Daftar Eloquent Relationships |
| 9 | Hasil Pengujian |

---

## BAB 1 PENDAHULUAN

### 1.1 Latar Belakang

Kampus merupakan institusi yang secara rutin menyelenggarakan berbagai kegiatan seperti workshop, seminar, lomba, pameran, dan career fair. Setiap kegiatan memerlukan sistem pendaftaran peserta yang terorganisir. Namun, dalam praktiknya, banyak kampus masih menggunakan metode pendaftaran manual seperti pengisian formulir kertas atau penyebaran Google Form yang terpisah-pisah untuk setiap event.

Metode manual ini menimbulkan beberapa permasalahan: data peserta tidak terpusat, sulitnya melacak riwayat pendaftaran, potensi pendaftaran ganda, dan tidak adanya dashboard yang memberikan gambaran menyeluruh tentang event yang sedang berlangsung. Admin kampus harus membuka banyak tab dan file untuk mendapatkan informasi yang seharusnya bisa diakses dalam satu dashboard.

Oleh karena itu, dibutuhkan sebuah sistem informasi terpadu yang dapat mengelola event kampus beserta pendaftaran pesertanya secara digital. Sistem ini harus mampu menangani operasi CRUD (Create, Read, Update, Delete) untuk data event, peserta, dan registrasi, serta menyajikan dashboard statistik yang informatif bagi admin.

### 1.2 Rumusan Masalah

Berdasarkan latar belakang di atas, rumusan masalah dalam proyek ini adalah:

1. Bagaimana membangun sistem manajemen event kampus berbasis web yang menerapkan arsitektur MVC Laravel?
2. Bagaimana mengelola pendaftaran peserta secara digital dengan validasi data yang ketat?
3. Bagaimana mencegah registrasi ganda dan overbooking pada event dengan kuota terbatas?
4. Bagaimana menyajikan dashboard statistik yang memberikan gambaran real-time tentang event, peserta, dan registrasi?

### 1.3 Tujuan Proyek

Tujuan dari proyek ini adalah membangun **Sistem Manajemen Event Kampus (EMS)** yang memiliki kemampuan:

1. Melakukan operasi CRUD penuh untuk tiga entitas utama: Event, Peserta, dan Registrasi
2. Menerapkan validasi server-side menggunakan Form Request Validation Laravel
3. Mencegah registrasi ganda melalui unique constraint di level database dan aplikasi
4. Menyediakan dashboard statistik dengan informasi real-time
5. Menyediakan halaman publik untuk peserta melihat dan mendaftar event
6. Mendukung pencarian, paginasi, dan filter kategori untuk navigasi data yang efisien

### 1.4 Batasan Masalah

Batasan dari proyek ini adalah:

1. Aplikasi berbasis web dengan dua area: admin (wajib login) dan publik (tanpa login)
2. Database menggunakan SQLite untuk kemudahan deployment dan portabilitas
3. Tidak terdapat payment gateway atau sistem pembayaran
4. Tidak terdapat sistem notifikasi email
5. Tidak terdapat multi-role (hanya admin sebagai pengelola)
6. Fokus pada fungsionalitas CRUD dan validasi, bukan pada skalabilitas enterprise

---

## BAB 2 FRAMEWORK YANG DIGUNAKAN

### 2.1 Pengertian Laravel

Laravel adalah framework PHP open-source yang dikembangkan oleh Taylor Otwell pada tahun 2011. Laravel mengimplementasikan pola arsitektur **Model-View-Controller (MVC)** yang memisahkan logika bisnis (Model), tampilan (View), dan pengendali alur (Controller). Framework ini dikenal dengan sintaks yang ekspresif dan elegan, serta ekosistem yang lengkap mencakup ORM (Eloquent), template engine (Blade), CLI (Artisan), dan sistem migrasi database.

Laravel telah menjadi salah satu framework PHP paling populer di dunia dengan lebih dari 77.000 bintang di GitHub dan komunitas yang sangat aktif. Versi yang digunakan dalam proyek ini adalah Laravel 13 yang dirilis pada tahun 2025.

### 2.2 Alasan Memilih Laravel

Pemilihan Laravel didasarkan pada pertimbangan berikut:

1. **Eloquent ORM** — Memungkinkan interaksi dengan database menggunakan objek PHP tanpa menulis SQL mentah. Relasi database dapat didefinisikan secara deklaratif melalui method seperti `hasMany()`, `belongsTo()`, dan `belongsToMany()`.

2. **Blade Template Engine** — Menyediakan sintaks yang bersih untuk rendering HTML dengan fitur template inheritance (`@extends`, `@section`, `@yield`), komponen, dan direktif kontrol.

3. **Form Request Validation** — Memungkinkan pemisahan logika validasi dari controller ke kelas tersendiri, membuat kode lebih bersih dan terorganisir.

4. **Artisan CLI** — Command-line tool untuk membuat scaffold kode (model, controller, migration), menjalankan migration, dan mengelola aplikasi.

5. **Migration System** — Version control untuk database yang memungkinkan perubahan skema dikelola secara terstruktur dan dapat di-rollback.

6. **Middleware** — Sistem filter HTTP request yang memungkinkan implementasi autentikasi, logging, dan proteksi CSRF dengan mudah.

7. **Route System** — Mendefinisikan route secara ekspresif dengan grouping, prefix, dan resource routing.

8. **Integrasi Tailwind CSS** — Laravel 13 terintegrasi dengan Vite dan Tailwind CSS v4 untuk styling modern.

### 2.3 Kelebihan Laravel

1. **Ekosistem Lengkap** — Mencakup autentikasi, queue, scheduling, notification, dan testing tools.
2. **Keamanan Bawaan** — Proteksi CSRF, XSS, SQL injection, dan mass assignment melalui `$fillable`.
3. **Produktivitas Tinggi** — Scaffolding cepat melalui Artisan, Eager Loading untuk optimasi query.
4. **Komunitas Besar** — Dokumentasi lengkap, banyak tutorial, dan package pihak ketiga.
5. **Modern PHP** — Menggunakan fitur PHP terbaru: typed properties, attributes, enums, dan dependency injection.

### 2.4 Kekurangan Laravel

1. **Learning Curve** — Konsep seperti Service Container, Facades, dan Service Providers membutuhkan waktu untuk dipahami pemula.
2. **Overhead Framework** — Banyak dependency bawaan yang mungkin tidak digunakan untuk proyek kecil.
3. **Versi Cepat Berubah** — Major release setiap tahun memerlukan update yang signifikan.
4. **Ketergantungan Tools** — Membutuhkan Composer dan Node.js/npm untuk development environment lengkap.

---

## BAB 3 ANALISIS SISTEM

### 3.1 Deskripsi Proyek

Event Management System (EMS) adalah aplikasi web untuk mengelola event kampus dan pendaftaran peserta. Sistem ini memiliki dua area utama:

1. **Area Publik** — Dapat diakses tanpa login. Menampilkan landing page dengan daftar event upcoming dalam bentuk grid card. Peserta dapat melihat detail event dan mendaftar melalui form pendaftaran mandiri.

2. **Area Admin** — Wajib login. Menyediakan dashboard statistik, CRUD lengkap untuk Event, Peserta, dan Registrasi, serta fitur presensi (check-in) dan export laporan CSV.

### 3.2 Fitur Sistem

**Fitur Awal (Tahap 1):**
| No | Fitur | Deskripsi |
|---|---|---|
| 1 | Dashboard Admin | 4 stat cards + recent registrations + upcoming events |
| 2 | CRUD Event | Create, Read, Update, Delete event |
| 3 | CRUD Peserta | Create, Read, Update, Delete peserta |
| 4 | CRUD Registrasi | Create, Read, Update, Delete registrasi |
| 5 | Validasi Server-Side | 6 Form Request dengan aturan validasi dan pesan Bahasa Indonesia |
| 6 | Search + Pagination | Pencarian teks dan paginasi 10 data per halaman |
| 7 | Responsive Design | Tailwind CSS v4 dengan breakpoint mobile/tablet/desktop |

**Fitur Tambahan (Tahap 2-7):**
| No | Fitur | Deskripsi |
|---|---|---|
| 8 | Autentikasi | Login/logout admin dengan middleware auth |
| 9 | Landing Publik | Grid card event upcoming dengan progress bar kuota |
| 10 | Pendaftaran Mandiri | Form publik: peserta daftar sendiri ke event |
| 11 | Kuota Enforcement | Cek kuota otomatis — mencegah overbooking |
| 12 | Kategori Event | Filter event per kategori (Workshop, Seminar, Lomba, dll) |
| 13 | Export CSV | Download daftar peserta per event |
| 14 | Check-in Presensi | Tandai kehadiran peserta saat hari-H |
| 15 | Upload Gambar | Upload poster/flyer event |

### 3.3 Use Case Diagram

```
                         ┌──────────────────────────────┐
                         │           ADMIN               │
                         └──────────────┬───────────────┘
                                        │
          ┌─────────────────────────────┼───────────────────────────┐
          │                │            │               │           │
          ▼                ▼            ▼               ▼           ▼
   ┌────────────┐  ┌────────────┐ ┌───────────┐ ┌───────────┐ ┌────────┐
   │Login/Logout│  │Kelola Event│ │Kelola     │ │Kelola     │ │Export  │
   │            │  │(CRUD)      │ │Peserta    │ │Registrasi │ │CSV     │
   └────────────┘  └────────────┘ └───────────┘ └───────────┘ └────────┘
                                                                  │
                                        ┌─────────────────────────┘
                                        ▼
                                 ┌────────────┐
                                 │Check-in    │
                                 │(Presensi)  │
                                 └────────────┘

                         ┌──────────────────────────────┐
                         │      PESERTA (PUBLIK)        │
                         └──────────────┬───────────────┘
                                        │
                      ┌─────────────────┴─────────────────┐
                      │                                   │
                      ▼                                   ▼
               ┌────────────┐                      ┌────────────┐
               │Lihat Event │                      │Daftar Event│
               │(Landing)   │                      │(Form)      │
               └────────────┘                      └────────────┘
```

### 3.4 Alur Sistem (MVC Flow)

```
┌─────────┐    ┌──────────┐    ┌────────────┐    ┌───────────┐    ┌──────┐
│ BROWSER │───▶│  ROUTE   │───▶│ MIDDLEWARE │───▶│CONTROLLER │───▶│MODEL │
└─────────┘    └──────────┘    └────────────┘    └───────────┘    └──────┘
     ▲                                 │                               │
     │                                 ▼                               │
     │                          ┌───────────┐                    ┌──────┐
     └──────────────────────────│   VIEW    │◀───────────────────│  DB  │
                                │  (Blade)  │                    │SQLite│
                                └───────────┘                    └──────┘
```

---

## BAB 4 DATABASE

### 4.1 Entity Relationship Diagram (ERD)

```
┌────────────────┐       ┌──────────────────────┐       ┌──────────────────┐
│    events      │       │    registrations     │       │   participants   │
├────────────────┤       ├──────────────────────┤       ├──────────────────┤
│ id (PK)        │──1:N──│ id (PK)              │──N:1──│ id (PK)          │
│ title          │       │ event_id (FK)         │       │ name             │
│ description    │       │ participant_id (FK)   │       │ email (UQ)       │
│ event_date     │       │ registration_date     │       │ phone            │
│ location       │       │ attended_at (nullable)│       │ created_at       │
│ quota          │       │ created_at            │       │ updated_at       │
│ status         │       │ updated_at            │       └──────────────────┘
│ image          │       └──────────────────────┘
│ category_id(FK)│──N:1──┌──────────────────┐
│ created_at     │       │   categories     │
│ updated_at     │       ├──────────────────┤
└────────────────┘       │ id (PK)          │
                         │ name (UQ)        │
                         │ created_at       │
                         │ updated_at       │
                         └──────────────────┘

Constraints:
- UNIQUE(event_id, participant_id) pada tabel registrations
- email UNIQUE pada tabel participants
- name UNIQUE pada tabel categories
```

### 4.2 Struktur Tabel `events`

| Column | Type | Constraints |
|---|---|---|
| id | INTEGER | PK, AUTOINCREMENT |
| title | VARCHAR(255) | NOT NULL |
| description | TEXT | NULLABLE |
| event_date | DATETIME | NOT NULL |
| location | VARCHAR(255) | NOT NULL |
| quota | INTEGER | NOT NULL, min:1 |
| status | VARCHAR | NOT NULL, default: 'upcoming' |
| image | VARCHAR(255) | NULLABLE |
| category_id | INTEGER | FK → categories.id, NULLABLE, ON DELETE SET NULL |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

### 4.3 Struktur Tabel `participants`

| Column | Type | Constraints |
|---|---|---|
| id | INTEGER | PK, AUTOINCREMENT |
| name | VARCHAR(255) | NOT NULL |
| email | VARCHAR(255) | NOT NULL, UNIQUE |
| phone | VARCHAR(20) | NULLABLE |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

### 4.4 Struktur Tabel `registrations`

| Column | Type | Constraints |
|---|---|---|
| id | INTEGER | PK, AUTOINCREMENT |
| event_id | INTEGER | FK → events.id, ON DELETE CASCADE |
| participant_id | INTEGER | FK → participants.id, ON DELETE CASCADE |
| registration_date | DATETIME | NOT NULL, default: CURRENT_TIMESTAMP |
| attended_at | DATETIME | NULLABLE |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |
| | | UNIQUE(event_id, participant_id) |

### 4.5 Struktur Tabel `categories`

| Column | Type | Constraints |
|---|---|---|
| id | INTEGER | PK, AUTOINCREMENT |
| name | VARCHAR(255) | NOT NULL, UNIQUE |
| created_at | TIMESTAMP | |
| updated_at | TIMESTAMP | |

### 4.6 Relasi Antar Tabel

| Model A | Relasi | Model B | Method | Foreign Key | Pivot Table |
|---|---|---|---|---|---|
| Event | hasMany | Registration | `registrations()` | event_id | — |
| Event | belongsToMany | Participant | `participants()` | — | registrations |
| Event | belongsTo | Category | `category()` | category_id | — |
| Participant | hasMany | Registration | `registrations()` | participant_id | — |
| Participant | belongsToMany | Event | `events()` | — | registrations |
| Registration | belongsTo | Event | `event()` | event_id | — |
| Registration | belongsTo | Participant | `participant()` | participant_id | — |
| Category | hasMany | Event | `events()` | category_id | — |

### 4.7 Migration Database

Laravel menggunakan sistem Migration untuk version control database. Setiap perubahan skema database ditulis dalam file PHP yang dapat dijalankan dengan `php artisan migrate` dan dibatalkan dengan `php artisan migrate:rollback`. Proyek ini memiliki 7 file migration.

### 4.8 Database Seeder

DatabaseSeeder mengisi data awal untuk demonstrasi: 1 admin user, 7 kategori, 7 event, 15 peserta, dan 30 registrasi.

---

## BAB 5 IMPLEMENTASI

### 5.1 Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/Faiz-abdurrachman/ems.git
cd ems

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Build CSS/JS
npm run build

# 5. Setup database
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --force

# 6. Storage link (untuk upload gambar)
php artisan storage:link

# 7. Jalankan server
php artisan serve --port=8080
```

### 5.2 Struktur Folder Laravel

```
ems/
├── app/Http/Controllers/          ← Logika bisnis & request handling
│   ├── Auth/LoginController.php
│   ├── DashboardController.php
│   ├── EventController.php
│   ├── ParticipantController.php
│   ├── PublicEventController.php
│   └── RegistrationController.php
├── app/Http/Requests/             ← Validasi form (6 file)
├── app/Models/                    ← Eloquent Models (4 + User)
├── database/migrations/           ← Skema database (7 file)
├── database/seeders/              ← Data awal
├── resources/views/               ← Template Blade (18 file)
│   ├── layouts/                   ← admin + public
│   ├── components/                ← sidebar
│   ├── auth/                      ← login
│   ├── events/                    ← 4 file CRUD event
│   ├── participants/              ← 4 file CRUD peserta
│   ├── registrations/             ← 5 file CRUD + check-in
│   └── public/                    ← 2 file (landing + detail)
├── routes/web.php                 ← 28 route
└── Dockerfile                     ← Deploy Railway
```

### 5.3 Penjelasan MVC

#### 5.3.1 Model

Model merepresentasikan data dan logika bisnis. Setiap tabel database memiliki satu kelas Model Eloquent.

**Event.php** — Memiliki relasi `hasMany` ke Registration, `belongsTo` ke Category, dan `belongsToMany` ke Participant melalui tabel pivot registrations. Properti `$fillable` melindungi dari mass assignment vulnerability.

**Participant.php** — Memiliki relasi `hasMany` ke Registration dan `belongsToMany` ke Event. Email di-set unique di level database dan divalidasi di Form Request.

**Registration.php** — Model pivot yang menghubungkan Event dan Participant. Memiliki dua relasi `belongsTo` dan kolom `attended_at` untuk presensi.

**Category.php** — Model sederhana dengan `hasMany` ke Event.

#### 5.3.2 View (Blade)

Sistem menggunakan **18 file Blade** yang terorganisir dalam hierarki layout:

```
layouts/admin.blade.php          ← Layout admin: sidebar + header + flash messages
layouts/public.blade.php          ← Layout publik: navbar + footer
├── dashboard.blade.php           ← Dashboard admin
├── auth/login.blade.php          ← Form login
├── events/*.blade.php            ← CRUD Event (4 file)
├── participants/*.blade.php      ← CRUD Peserta (4 file)
├── registrations/*.blade.php     ← CRUD Registrasi (4 file) + check-in
└── public/*.blade.php            ← Landing + detail (2 file)
```

#### 5.3.3 Controller

Sistem memiliki **5 controller**:

| Controller | Fungsi | Route Group |
|---|---|---|
| `PublicEventController` | Landing page, detail event, daftar event | Public |
| `Auth/LoginController` | Login/logout admin | Public |
| `DashboardController` | Dashboard statistik | Admin (auth) |
| `EventController` | CRUD Event + upload gambar | Admin (auth) |
| `ParticipantController` | CRUD Peserta | Admin (auth) |
| `RegistrationController` | CRUD Registrasi + check-in + export | Admin (auth) |

#### 5.3.4 Route

Route didefinisikan di `routes/web.php` dengan 3 grup:

1. **Public routes** — `/` (landing), `/events/{event}` (detail), `/events/{event}/register` (daftar)
2. **Auth routes** — `/login` (GET/POST), `/logout` (POST)
3. **Admin routes** — Prefix `/admin`, middleware `auth`, nama prefix `admin.`

Total **28 routes** dengan 3 resource controllers.

### 5.4 Eloquent ORM

Eloquent ORM adalah implementasi Active Record di Laravel. Setiap tabel database direpresentasikan oleh satu kelas Model. Operasi database dilakukan melalui method di Model tanpa menulis SQL.

**Eager Loading** digunakan untuk mengoptimasi query N+1:
```php
// Tanpa Eager Loading = 1 + N query (N+1 problem)
$registrations = Registration::all();
foreach ($registrations as $reg) {
    echo $reg->event->title; // query tambahan per registrasi
}

// Dengan Eager Loading = hanya 3 query
$registrations = Registration::with(['event', 'participant'])->get();
```

### 5.5 Form Request Validation

6 Form Request digunakan untuk memisahkan logika validasi dari controller. Contoh StoreEventRequest:

- `title`: required, string, max:255
- `event_date`: required, date, after:now
- `quota`: required, integer, min:1
- `status`: required, in:upcoming,ongoing,completed,cancelled
- `image`: nullable, image, mimes:jpeg,png,jpg,webp, max:5120
- `category_id`: nullable, exists:categories,id

StoreRegistrationRequest memiliki composite unique validation:
```php
'event_id' => Rule::unique('registrations')
    ->where('participant_id', $this->participant_id)
```

### 5.6 Tailwind CSS dan Responsive Design

Tailwind CSS v4 digunakan untuk styling dengan pendekatan utility-first. Breakpoint responsif menggunakan prefix `sm:`, `md:`, `lg:`. Vite digunakan sebagai bundler untuk kompilasi CSS.

### 5.7 Search dan Paginasi

Pencarian diimplementasikan menggunakan Laravel's `when()`:
```php
->when(request('search'), fn($q) => 
    $q->where('title', 'like', '%'.request('search').'%'))
```

Paginasi menggunakan `paginate(10)` yang otomatis menghasilkan link navigasi halaman.

---

## BAB 6 IMPLEMENTASI CRUD

### 6.1 Create (Event)

Alur: Admin login → sidebar Events → klik "Tambah Event" → isi form (judul, deskripsi, tanggal, lokasi, kuota, kategori, status, gambar) → submit → validasi Form Request → data tersimpan → redirect ke list event.

### 6.2 Read (Event List + Detail)

List: Tabel dengan kolom #, Title (link ke detail), Date, Location, Quota, Status (badge warna), Registrations (count/quota), Actions (Lihat/Edit/Hapus).

Detail: Informasi lengkap event + daftar peserta terdaftar + tombol Presensi dan Export CSV.

### 6.3 Update (Event Edit)

Alur: Klik Edit → form pre-filled dengan `old('field', $event->field)` → ubah data → submit → validasi → data terupdate → redirect.

### 6.4 Delete (Event Destroy)

Alur: Klik Hapus → modal konfirmasi → konfirmasi → data terhapus (cascade: registrasi terkait ikut terhapus) → redirect.

### 6.5 Create (Participant)

Form sederhana: nama, email, phone. Email harus unik — divalidasi dengan `unique:participants,email`.

### 6.6 Create (Registration — Validasi Ganda)

Form: pilih event (dropdown), pilih peserta (dropdown). Validasi:
- Cek kuota event (tidak boleh melebihi)
- Cek duplikat (peserta tidak boleh daftar 2x ke event yang sama)
- Cek tanggal event (tidak boleh daftar ke event yang sudah lewat)

---

## BAB 7 TAMPILAN SISTEM

### 7.1 Halaman Publik (Landing Page)

Menampilkan hero section dengan judul "Event Kampus", search bar, dan chip filter kategori (Semua, Workshop, Seminar, Lomba, Pameran, dll). Event upcoming ditampilkan dalam grid card 3 kolom dengan gambar/poster, judul, tanggal, lokasi, progress bar kuota, dan badge "Kuota Penuh" jika sudah penuh.

### 7.2 Halaman Detail Event + Form Pendaftaran

Layout dua kolom: kolom kiri menampilkan gambar event, judul, tanggal, lokasi, kuota, dan deskripsi. Kolom kanan menampilkan form pendaftaran dengan input nama, email, telepon. Jika event sudah berakhir atau kuota penuh, form diganti dengan pesan informasi.

### 7.3 Halaman Login Admin

Halaman centered dengan logo EMS, judul "Admin Login", form email dan password, checkbox "Ingat saya", dan tombol "Masuk".

### 7.4 Dashboard Admin

4 kartu statistik: Total Events (indigo), Total Participants (emerald), Total Registrations (amber), Active Events (rose). Di bawahnya: tabel "Recent Registrations" (2/3 lebar) dan daftar "Upcoming Events" (1/3 lebar) dengan progress bar kuota.

### 7.5 Halaman Data (List Pages)

Tabel dengan header sticky, search bar dengan clear button, filter chip kategori (halaman Events), status badges berwarna, dan action buttons (Lihat, Edit, Hapus). Paginasi di bagian bawah.

### 7.6 Form Tambah / Edit Event

Form dengan input: title, description (textarea), event_date (datetime-local), location, quota (number), kategori (dropdown), status (dropdown), image (file upload).

### 7.7 Halaman Presensi (Check-in)

Tabel daftar peserta dengan kolom: #, Nama, Email, Status (Hadir/Belum Hadir), Aksi (Tandai Hadir/Batalkan). Progress bar persentase kehadiran di atas tabel.

---

## BAB 8 PENGUJIAN

### 8.1 Skenario Pengujian

| No | Skenario | Hasil Diharapkan | Status |
|---|---|---|---|
| 1 | Akses `/` tanpa login | Halaman landing muncul | ✅ |
| 2 | Akses `/admin` tanpa login | Redirect ke `/login` | ✅ |
| 3 | Login dengan kredensial valid | Masuk ke dashboard admin | ✅ |
| 4 | Login dengan password salah | Error "Email atau password salah" | ✅ |
| 5 | Tambah event tanpa title | Error validasi "Judul event wajib diisi" | ✅ |
| 6 | Tambah event dengan data valid | Event tersimpan, muncul di list | ✅ |
| 7 | Edit event | Data terupdate, redirect ke list | ✅ |
| 8 | Hapus event via modal | Event terhapus, registrasi cascade | ✅ |
| 9 | Tambah peserta email unik | Peserta tersimpan | ✅ |
| 10 | Tambah peserta email duplikat | Error "Email sudah terdaftar" | ✅ |
| 11 | Peserta daftar event via form publik | Pendaftaran berhasil | ✅ |
| 12 | Peserta daftar event yang sama lagi | Error "Anda sudah terdaftar" | ✅ |
| 13 | Daftar event kuota penuh | Error "Kuota event sudah penuh" | ✅ |
| 14 | Filter event berdasarkan kategori | Hasil terfilter sesuai kategori | ✅ |
| 15 | Search event dengan keyword | Hasil sesuai keyword | ✅ |
| 16 | Upload gambar event | Gambar tersimpan dan ditampilkan | ✅ |
| 17 | Export CSV daftar peserta | File CSV terdownload | ✅ |
| 18 | Tandai kehadiran peserta | Status berubah menjadi "Hadir" | ✅ |
| 19 | Logout | Redirect ke halaman publik | ✅ |
| 20 | Tampilan mobile (resize browser) | Layout responsif, sidebar hidden | ✅ |

### 8.2 Hasil Pengujian

Seluruh 20 skenario pengujian berhasil dilakukan dengan **100% pass rate** (0 bug). Pengujian juga dilakukan dengan automated test terhadap 28 endpoint route yang semuanya merespons dengan kode HTTP yang sesuai.

---

## BAB 9 KESIMPULAN

### 9.1 Hasil Proyek

Proyek Sistem Manajemen Event Kampus (EMS) telah berhasil dibangun menggunakan Laravel 13 dengan menerapkan arsitektur MVC secara ketat. Sistem memiliki 4 entitas database (events, participants, registrations, categories), 5 controller, 18 Blade views, 28 route, 6 Form Request, dan 7 migration.

Fitur yang diimplementasikan mencakup: autentikasi admin, CRUD lengkap (Event, Peserta, Registrasi), halaman publik dengan pendaftaran mandiri, dashboard statistik, pencegahan registrasi ganda, kuota enforcement, filter kategori, pencarian dan paginasi, export CSV, check-in presensi, dan upload gambar event.

### 9.2 Kelebihan Sistem

1. **Arsitektur MVC Ketat** — Pemisahan yang jelas antara Model, View, dan Controller memudahkan maintenance dan pengembangan.
2. **Validasi Komprehensif** — 6 Form Request dengan aturan validasi yang ketat mencegah data invalid masuk ke database.
3. **Pencegahan Overbooking** — Cek kuota di level aplikasi dan unique constraint di level database.
4. **Dashboard Real-time** — Informasi statistik selalu akurat berdasarkan data terkini.
5. **Desain Modern Responsif** — Tailwind CSS v4 dengan tampilan yang bersih dan adaptif di semua ukuran layar.
6. **Fitur Lengkap** — Mencakup tidak hanya CRUD dasar tetapi juga presensi, export laporan, dan manajemen gambar.

### 9.3 Saran Pengembangan Selanjutnya

1. **Multi-role Authentication** — Memisahkan role Admin, Panitia Event, dan Peserta dengan hak akses berbeda.
2. **Notifikasi Email** — Mengirim email konfirmasi pendaftaran dan pengingat event kepada peserta.
3. **REST API** — Membangun API endpoints untuk integrasi dengan aplikasi mobile.
4. **QR Code Check-in** — Peserta scan QR code untuk check-in mandiri saat hari-H.
5. **Dashboard Peserta** — Halaman profil peserta yang menampilkan riwayat event yang diikuti.
6. **Deployment Production** — Migrasi ke MySQL dan deployment ke production server.
7. **Automated Testing** — Menambahkan unit test dan feature test dengan PHPUnit.

---

**© 2026 — Faiz Abdurrachman (241111021)**
