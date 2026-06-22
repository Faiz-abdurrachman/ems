# SCRIPT PRESENTASI — EVENT MANAGEMENT SYSTEM (EMS)

## 1. SCRIPT PRESENTASI 10 MENIT (VERSI TERBARU)

### Menit 0-1: Pembukaan

"Assalamu'alaikum wr wb. Selamat pagi/siang, Bapak/Ibu Dosen dan teman-teman sekalian. Perkenalkan nama saya Faiz Abdurrachman, NIM 241111021. Saya akan mempresentasikan proyek tugas mata kuliah Framework PHP dan CRUD, yaitu Sistem Manajemen Event Kampus — Event Management System — dibangun menggunakan Laravel 13 dan Tailwind CSS v4. Jadi ini adalah aplikasi web lengkap dengan dua area: halaman publik buat peserta lihat dan daftar event, dan panel admin buat panitia kelola semuanya."

### Menit 1-2: Latar Belakang & Demo Landing Page

"Latar belakangnya sederhana. Kampus sering bikin event — workshop, seminar, lomba, career fair. Tapi pendaftarannya masih manual: Google Form beda-beda, rekap Excel satu-satu. Saya bangun sistem terpadu di mana semua event terpusat, peserta bisa daftar sendiri, dan panitia bisa monitor real-time. Buka halaman publik — landing page dengan grid card event upcoming. Ada search, ada filter chip kategori — Workshop, Seminar, Lomba, Hackathon — tinggal klik langsung terfilter. Setiap card ada gambar/poster, progress bar kuota, dan badge 'Kuota Penuh' kalo udah penuh."

### Menit 2-3: Demo Detail Event + Daftar Publik

"Klik salah satu event — masuk ke detail. Layout dua kolom: kiri info lengkap event, kanan form pendaftaran. Ini yang keren: sistem cek 3 hal sebelum daftar. Pertama, cek tanggal — kalo event udah lewat, form diganti 'Event telah berakhir'. Kedua, cek kuota — kalo penuh, form diganti 'Kuota sudah penuh'. Ketiga, cek duplikasi — kalo email udah daftar, error 'Anda sudah terdaftar'. Semua ini dicek di controller dengan Eloquent query. Saya daftarin dulu satu peserta baru... berhasil! Alert hijau muncul. Sekarang daftar lagi pake email sama... error! Ini pencegahan registrasi ganda."

### Menit 3-4: Login Admin & Dashboard

"Sekarang masuk ke panel admin. Buka `/login` — ini halaman terpisah dari publik. Saya login dengan email admin. Ini ada 4 kartu statistik di dashboard: Total Events, Total Peserta, Total Registrasi, Event Aktif. Semua angka real-time dari query COUNT. Di bawahnya tabel registrasi terbaru dan upcoming events dengan progress bar. Semua data di dashboard ini bisa diklik langsung ke detailnya."

### Menit 4-5: CRUD Event — Kategori + Gambar + Validasi

"Sidebar → Events. Tabel event dengan filter chip kategori di atas. Setiap event punya status badge: Akan Datang (biru), Berlangsung (hijau), Selesai (abu), Dibatalkan (merah). Klik 'Tambah Event'. Form lengkap: judul, deskripsi, tanggal, lokasi, kuota, dropdown kategori, dropdown status, dan upload poster! Saya coba submit kosong... error validasi merah. Isi benar, upload gambar, submit... berhasil! Event baru muncul dengan progress bar 0/kuota."

### Menit 5-6: CRUD Registrasi + Kuota Enforcement

"Sidebar → Registrations. Tabel semua registrasi. Klik 'Registrasi Baru'. Dua dropdown: event (cuma upcoming yang muncul) dan peserta. Pilih event + peserta → submit. Saya coba daftarkan ke event yang sama... error karena validasi duplikat di Form Request. Dan yang lebih penting: kuota enforcement! Di controller, sebelum create registration, sistem cek: count registrations >= quota? Kalo iya, error 'Kuota penuh'. Jadi gak mungkin overbook."

### Menit 6-7: Presensi + Export

"Sekarang fitur yang paling kepake pas hari-H: Presensi. Buka detail event → klik tombol hijau 'Presensi'. Muncul tabel semua peserta terdaftar dengan status 'Belum Hadir' (abu-abu) dan tombol 'Tandai Hadir'. Klik → status berubah jadi 'Hadir' (hijau) + centang. Bisa dibatalkan juga. Progress bar di atas: 'X/Y peserta telah hadir'. Bagus banget buat panitia hari-H. Terus tombol Export CSV — download daftar peserta lengkap buat dicetak. Kolom: No, Nama, Email, Telepon, Tanggal Daftar, Kehadiran."

### Menit 7-8: Penjelasan Teknis — Arsitektur

"Secara teknis, aplikasi ini strict MVC. Struktur foldernya: 6 Controller — PublicEventController (publik), LoginController (auth), dan 4 admin controller. 4 Model: Event, Participant, Registration, Category. 18 Blade view dengan 2 layout terpisah: admin.blade.php (sidebar + header) dan public.blade.php (navbar + footer). 28 route: public, auth, dan admin (prefix /admin, middleware auth). Semua interaksi database 100% Eloquent — hasMany, belongsTo, belongsToMany di 4 model."

### Menit 8-9: Database & Relasi

"Database pakai SQLite, 4 tabel. Events: judul, deskripsi, tanggal, lokasi, kuota, status, gambar, category_id. Participants: nama, email unik, telepon. Registrations: event_id FK, participant_id FK, registration_date, attended_at. Categories: nama. Relasi: Event hasMany Registration, Participant hasMany Registration, Registration belongsTo keduanya. Unique constraint (event_id, participant_id) mencegah duplikasi. Category hasMany Event — makanya bisa filter per kategori. attended_at nullable — makanya bisa presensi."

### Menit 9-10: Penutup

"Kesimpulannya, proyek ini berhasil membangun Event Management System dengan fitur: landing page publik, pendaftaran mandiri, panel admin dengan autentikasi, CRUD lengkap 3 entitas, filter kategori, upload gambar, kuota enforcement, export CSV, dan check-in presensi. Semua dibangun dengan Laravel 13, Tailwind CSS v4, Eloquent ORM 100%, 6 Form Request validasi, 28 route, dan 32 automated test dengan 0 bug. Untuk pengembangan selanjutnya: multi-role, notifikasi email, REST API, dan QR code check-in. Saya rasa cukup. Terima kasih, Bapak/Ibu. Saya buka sesi tanya jawab."

Sekian presentasi saya. Terima kasih atas perhatian Bapak/Ibu dan teman-teman. Saya buka sesi tanya jawab."

---

## 2. DAFTAR PERTANYAAN + JAWABAN (DIPERBARUI)

### 1. Kenapa memilih Laravel dibanding framework lain?

"Laravel punya ekosistem lengkap: Eloquent ORM yang ekspresif, Blade template engine, Artisan CLI untuk scaffolding, Migration untuk version control database, Form Request untuk validasi terstruktur, middleware untuk auth, dan integrasi Vite + Tailwind CSS. Laravel juga sangat cocok untuk proyek MVC karena pemisahan Model-View-Controller sangat jelas. Di proyek ini saya membuktikannya: 4 model, 18 view, 6 controller, semuanya terpisah rapi."

### 2. Kenapa pakai SQLite, bukan MySQL?

"Untuk project tugas kuliah dan demo, SQLite jauh lebih praktis. Tidak perlu install database server, cukup satu file. Konfigurasi di .env cuma satu baris: DB_CONNECTION=sqlite. Backup tinggal copy file. Untuk production dengan banyak user, tinggal ganti ke MySQL — cukup ubah .env dan config/database.php. Tidak ada perubahan kode sama sekali karena Eloquent abstraksi database engine."

### 3. Apa perbedaan hasMany dan belongsTo?

"hasMany dipakai di sisi 'satu' — Event hasMany Registration. belongsTo dipakai di sisi 'banyak' — Registration belongsTo Event. Kuncinya: foreign key selalu di tabel sisi 'banyak'. Di proyek ini: tabel registrations punya event_id (FK ke events) dan participant_id (FK ke participants). Jadi Registration belongsTo Event dan belongsTo Participant."

### 4. Apa itu Eloquent ORM dan bagaimana penggunaannya di proyek ini?

"Eloquent ORM adalah Active Record implementation Laravel. Setiap tabel database punya satu Model. Di proyek ini saya pakai 100% Eloquent — gak ada satu pun raw SQL. Contoh: Event::withCount('registrations')->where('status','upcoming')->paginate(10). Eager loading: Registration::with(['event','participant'])->get() mencegah N+1 query. BelongsToMany lewat pivot: $event->participants via tabel registrations."

### 5. Bagaimana cara mencegah registrasi ganda di proyek ini?

"Tiga lapis: pertama, di level database — UNIQUE constraint (event_id, participant_id). Kedua, di Form Request — StoreRegistrationRequest pakai Rule::unique('registrations')->where(...). Ketiga, di controller — PublicEventController@register cek manual dengan Registration::where()->exists(). Jadi triple protection."

### 6. Bagaimana cara deploy aplikasi ini?

"Deploy ke Railway menggunakan Docker. Dockerfile di root project: FROM php:8.3-cli, install SQLite + Node + Composer, composer install, npm build, migrate, seed. Railway auto-build dari GitHub — setiap push ke main langsung auto-deploy. URL publik: ems-production-8c0e.up.railway.app."

### 7. Apa kelebihan utama sistem ini dibanding CRUD tutorial biasa?

"Banyak. Pertama, autentikasi — admin panel diproteksi. Kedua, dua layout terpisah — publik dan admin, bukan satu template. Ketiga, kuota enforcement — gak bisa overbook. Keempat, presensi — track kehadiran real di hari-H. Kelima, export CSV. Keenam, upload gambar. Ketujuh, filter kategori. Ini bukan sekadar CRUD tabel biasa — ini sistem yang siap dipakai beneran."

### 8. Apa itu Form Request dan bagaimana penggunaannya?

"Form Request adalah kelas validasi terpisah dari controller. Di proyek ini ada 6 Form Request — store/update untuk Event, Participant, Registration. Contoh StoreEventRequest: validasi title required, event_date after:now, quota min:1, status in:upcoming/ongoing/completed/cancelled, image max:5MB, category_id exists. Setiap Form Request juga punya custom messages Bahasa Indonesia. Controller tinggal type-hint — validasi otomatis jalan sebelum method controller."

### 9. Bagaimana mekanisme check-in/presensi bekerja?

"Tabel registrations punya kolom attended_at (datetime, nullable). Di controller, method toggleAttendance: kalo attended_at null → set now() (hadir). Kalo udah terisi → set null (batal). View check-in menampilkan semua peserta + tombol toggle per baris + progress bar persentase kehadiran. Export CSV juga mencatat status kehadiran."

### 10. Apa yang terjadi kalau kuota event sudah penuh?

"Tiga hal: pertama, di landing page, card event tampil badge 'Kuota Penuh' warna merah. Kedua, di detail event, form pendaftaran diganti pesan 'Kuota sudah penuh'. Ketiga, di admin panel, saat admin coba daftarin peserta lewat form, sistem return error 'Kuota event sudah penuh' dengan withInput() biar data gak hilang. Jadi tiga tempat dicek."

### 11. Bagaimana autentikasi diimplementasikan?

"Manual tanpa package tambahan. LoginController handle login/logout dengan Auth::attempt(), session regenerate, dan redirect intended. Middleware 'auth' melindungi semua route /admin/*. Route 'guest' memastikan halaman login hanya bisa diakses user yang belum login. User model pakai Authenticatable bawaan Laravel dengan password auto-hash."

### 12. Apa kelebihan Tailwind CSS dibanding Bootstrap?

"Tailwind utility-first — kita rakit desain dari class-class kecil seperti flex, p-4, text-sm. Hasilnya lebih unik, gak kelihatan 'template Bootstrap'. Tailwind v4 juga lebih ringan karena JIT compiler — cuma generate class yang dipakai. Di proyek ini, saya pakai Tailwind untuk semua styling: dashboard cards, tabel responsif, status badges, filter chips, form layout, mobile sidebar."

### 13. Bagaimana cara filter event per kategori?

"Kategori disimpan di tabel categories (id, name). Tabel events punya category_id FK. Di controller: ->when(request('category'), fn($q) => $q->where('category_id', request('category'))). Di view: chip filter berbentuk rounded pill — klik 'Workshop' kirim ?category=1, klik 'Semua' reset. Active chip jadi warna indigo, inactive abu-abu."

### 14. Bagaimana cara export CSV?

"Manual dengan StreamedResponse — gak pake package external. Controller RegistrationController@export: load registrations dengan participant, stream response dengan header Content-Type: text/csv. Callback function iterasi data, tulis ke php://output pakai fputcsv. Kolom: No, Nama, Email, Telepon, Tanggal Daftar, Kehadiran. Nama file: daftar-peserta-{slug-event}.csv."

### 15. Bagaimana struktur route di aplikasi ini?

"28 route dalam 3 grup. Public: GET / (landing), GET /events/{event} (detail), POST /events/{event}/register (daftar). Auth: GET/POST /login, POST /logout. Admin: prefix /admin, middleware auth, 3 resource controller + check-in + export. Contoh: GET /admin/events → EventController@index. Route naming: admin.events.index, admin.participants.show, dll."

---

## 3. FLOW PRESENTASI (CHEATSHEET)

| Waktu | Aktivitas | Halaman |
|---|---|---|
| 0-1 | Pembukaan, salam, perkenalan | — |
| 1-2 | Latar belakang + Demo Landing Page | `/` |
| 2-3 | Detail Event + Daftar + Kuota + Duplikasi | `/events/1`, form daftar |
| 3-4 | Login Admin + Dashboard | `/login` → `/admin` |
| 4-5 | CRUD Event + Kategori + Upload Gambar | `/admin/events`, form create |
| 5-6 | CRUD Registrasi + Kuota Enforcement | `/admin/registrations`, form create |
| 6-7 | Presensi + Export CSV | `/admin/events/1/check-in`, export |
| 7-8 | Arsitektur MVC — 6 controller, 4 model, 18 view, 28 route | VSCode / struktur folder |
| 8-9 | Database 4 tabel + Relasi Eloquent | ERD / phpMyAdmin |
| 9-10 | Penutup, kesimpulan, Q&A | — |

---

## 4. TIPS PRESENTASI

1. **Pre-load browser tabs** — landing page, detail event, login, admin dashboard. Biar gak nunggu loading.
2. **Siapkan data dummy** — catat nama & email yang belum dipakai buat demo daftar.
3. **Login dulu sebelum presentasi** — langsung ke dashboard pas waktunya.
4. **Latihan 3x** — perhatikan timing, jangan terlalu cepat.
5. **Bicara jelas & percaya diri** — dosen lebih suka mahasiswa yang paham projectnya.
6. **Kalau ada error, tetap tenang** — jelaskan apa yang terjadi, bisa jadi bahan diskusi.
7. **Backup screenshot** — kalau-kalau internet/server bermasalah.

## 5. CREDENTIALS

| Role | Email | Password |
|---|---|---|
| Admin | `admin@ems.test` | `password` |

## 6. URL LIVE

**https://ems-production-8c0e.up.railway.app/**
