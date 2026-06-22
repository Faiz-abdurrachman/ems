# 🧭 WORKFLOW GUIDE — Event Management System (EMS)

## Panduan Lengkap Penggunaan Aplikasi

> URL: https://ems-production-8c0e.up.railway.app/  
> Admin: admin@ems.test / password

---

## 🌐 1. PUBLIC AREA (Peserta Event)

Ini halaman yang bisa diakses siapa aja tanpa login. Peserta bisa liat event dan daftar.

### 1.1 Landing Page — Melihat Daftar Event
```
Buka: https://ems-production-8c0e.up.railway.app/
```

**Yang muncul:**
- Header "Event Kampus" + deskripsi
- Search bar buat cari event by judul
- Chip kategori: Workshop, Seminar, Lomba, Pameran, dll (klik buat filter)
- Grid card event (masing-masing card ada: gambar/poster, judul, tanggal, lokasi, progress kuota)

**Contoh filter:**
- Klik "Workshop" → cuma nampilin event kategori Workshop
- Search "web" → cuma nampilin event yang judulnya ada kata "web"

### 1.2 Detail Event — Melihat Detail + Mendaftar
```
Klik salah satu card event → /events/{id}
```

**Yang muncul:**
- Poster/gambar event (kalau ada)
- Judul, tanggal, lokasi, deskripsi lengkap
- Info kuota: "X / Y Terdaftar"
- Form pendaftaran di sidebar kanan

### 1.3 Mendaftar ke Event
```
Di halaman detail event, isi form:
  Nama Lengkap: (wajib)
  Email: (wajib, format email)
  Telepon: (opsional)
Klik "Daftar Sekarang"
```

**Hasil:**
- ✅ Sukses → redirect ke landing page + notifikasi hijau "Pendaftaran berhasil!"
- ❌ Gagal (email sudah terdaftar) → error "Anda sudah terdaftar di event ini"
- ❌ Gagal (kuota penuh) → form tidak muncul, ganti badge "Kuota sudah penuh"
- ❌ Gagal (event berakhir) → form tidak muncul, ganti "Event telah berakhir"

---

## 🔐 2. LOGIN ADMIN
```
Buka: https://ems-production-8c0e.up.railway.app/login
```

Isi:
- Email: `admin@ems.test`
- Password: `password`

Login sukses → redirect ke dashboard admin.

---

## 📊 3. ADMIN AREA (Login Required)

Setelah login, semua halaman admin bisa diakses.

### 3.1 Dashboard
```
/admin
```

**Menampilkan:**
- 4 kartu statistik: Total Events, Total Participants, Total Registrations, Active Events
- Tabel "Recent Registrations" (5 registrasi terbaru)
- List "Upcoming Events" (5 event mendatang dengan progress bar)

### 3.2 Kelola Events
```
/admin/events
```

**Fitur:**
| Aksi | Cara | Hasil |
|---|---|---|
| Lihat semua | Buka halaman | Tabel dengan #, Title, Date, Location, Quota, Status, Registrations, Actions |
| Search | Ketik di search bar → otomatis filter | Cuma event yang match |
| Filter kategori | Klik chip kategori (Workshop, Seminar, dll) | Cuma event kategori tsb |
| Lihat detail | Klik judul event (warna indigo) | Halaman detail event |
| Tambah event | Klik "Tambah Event" → isi form | Event baru tersimpan |
| Edit event | Klik icon pensil → ubah data → simpan | Data terupdate |
| Hapus event | Klik icon tong sampah → konfirmasi → hapus | Event terhapus |

### 3.3 Detail Event — Fitur Admin
```
/admin/events/{id}
```

Selain info event, admin punya 3 tombol tambahan:
| Tombol | Fungsi |
|---|---|
| **Presensi** | Buka halaman check-in → tandai siapa yang hadir |
| **Export CSV** | Download daftar peserta sebagai file CSV (bisa dibuka Excel) |
| **Edit** | Ubah data event |
| **Hapus** | Hapus event (dengan konfirmasi) |

### 3.4 Kelola Peserta
```
/admin/participants
```

**Fitur:**
- Tabel: #, Name, Email, Phone, Events Joined, Actions
- Search by nama/email
- Tambah peserta baru
- Edit data peserta
- Hapus peserta

### 3.5 Kelola Registrasi
```
/admin/registrations
```

**Fitur:**
- Tabel: #, Participant, Event, Registration Date, Actions
- Daftarkan peserta ke event manual
- Edit registrasi (ubah event/peserta)
- Hapus registrasi

---

## ☑️ 4. CHECK-IN / PRESENSI
```
/admin/events/{id}/check-in
```

**Yang muncul:**
- Progress bar: "X / Y peserta telah hadir"
- Tabel semua peserta terdaftar dengan status

**Cara pakai:**
1. Cari nama peserta di tabel
2. Klik **"Tandai Hadir"** → badge berubah jadi hijau "Hadir" ✅
3. Kalau salah → klik **"Batalkan"** → balik ke "Belum Hadir"

Progress bar update otomatis setiap kali ada perubahan.

---

## 📥 5. EXPORT DATA
```
/admin/events/{id}/export
```

Langsung download file CSV berisi:
- No, Nama, Email, Telepon, Tanggal Daftar, Kehadiran

Bisa dibuka di Excel / Google Sheets buat cetak daftar hadir.

---

## 🏷️ 6. KATEGORI EVENT

Setiap event bisa dikasih kategori. Kategori yang tersedia:
- Workshop
- Seminar
- Lomba
- Pameran
- Career Fair
- Pelatihan
- Hackathon

**Filter by kategori:**
- Public: chip di atas grid event
- Admin: chip di header tabel event

---

## 🖼️ 7. UPLOAD POSTER/GAMBAR

Saat tambah/edit event, ada field "Poster Event".
- Format: JPEG, PNG, WebP
- Maksimal: 5 MB
- Gambar muncul di landing page card + halaman detail

---

## 🛡️ 8. VALIDASI & ERROR HANDLING

| Skenario | Error yang muncul |
|---|---|
| Form kosong (judul/sebagian) | "Nama wajib diisi", "Judul event wajib diisi" |
| Email tidak valid | "Format email tidak valid" |
| Email sudah terdaftar (peserta) | "Email sudah terdaftar. Gunakan email lain" |
| Registrasi ganda ke event sama | "Anda sudah terdaftar di event ini" |
| Kuota penuh | "Kuota event sudah penuh" |
| Event sudah berakhir | "Event sudah berakhir" |
| Login gagal | "Email atau password salah" |
| Akses admin tanpa login | Redirect ke /login |

---

## 📊 9. TEST REPORT (25+ Tests)

### 9.1 Public Routes
| # | Test | Result |
|---|---|---|
| 1 | GET / (Landing Page) | ✅ 200 |
| 2 | GET /events/1 (Detail) | ✅ 200 |
| 3 | GET /events/3 (Detail) | ✅ 200 |
| 4 | GET /events/7 (Detail) | ✅ 200 |
| 5 | GET /login | ✅ 200 |
| 6 | Landing shows "Event Kampus" | ✅ |
| 7 | Category filter chips appear | ✅ |

### 9.2 Authentication
| # | Test | Result |
|---|---|---|
| 8 | GET /admin (no login) | ✅ 302 → /login |
| 9 | GET /admin/events (no login) | ✅ 302 → /login |
| 10 | GET /admin/participants (no login) | ✅ 302 → /login |
| 11 | GET /admin/registrations (no login) | ✅ 302 → /login |
| 12 | POST /login (correct) | ✅ 302 (redirect) |
| 13 | Login page shows "Admin Login" | ✅ |

### 9.3 Admin Dashboard (after login)
| # | Test | Result |
|---|---|---|
| 14 | GET /admin | ✅ 200 |
| 15 | GET /admin/events | ✅ 200 |
| 16 | GET /admin/events/create | ✅ 200 |
| 17 | GET /admin/participants | ✅ 200 |
| 18 | GET /admin/participants/create | ✅ 200 |
| 19 | GET /admin/registrations | ✅ 200 |
| 20 | GET /admin/registrations/create | ✅ 200 |
| 21 | GET /admin/events/1 | ✅ 200 |
| 22 | GET /admin/events/1/edit | ✅ 200 |
| 23 | GET /admin/participants/1 | ✅ 200 |

### 9.4 Check-in & Export
| # | Test | Result |
|---|---|---|
| 24 | GET /admin/events/1/check-in | ✅ 200 |
| 25 | Check-in shows "Tandai Hadir" buttons | ✅ 5 buttons |
| 26 | POST toggle-attendance | ✅ 302 (redirect) |
| 27 | GET /admin/events/1/export (CSV) | ✅ 200 text/csv |

### 9.5 Search & Filter
| # | Test | Result |
|---|---|---|
| 28 | ?search=Workshop | ✅ 200 |
| 29 | ?category=1 | ✅ 200 |
| 30 | Public ?search=Workshop | ✅ 200 |
| 31 | Public ?category=2 | ✅ 200 |

### 9.6 Data Integrity
| # | Test | Result |
|---|---|---|
| 32 | 7 categories seeded | ✅ |
| 33 | 7 events seeded | ✅ |
| 34 | 15 participants seeded | ✅ |
| 35 | 30 registrations seeded | ✅ |
| 36 | 1 admin user (admin@ems.test) | ✅ |
| 37 | Categories auto-assigned to events | ✅ |

### 9.7 UI/UX
| # | Test | Result |
|---|---|---|
| 38 | Delete modal (custom, not native confirm) | ✅ |
| 39 | Clear search button (X) | ✅ |
| 40 | Loading spinner on form submit | ✅ |
| 41 | aria-label on icon buttons | ✅ |
| 42 | Dismissable flash messages | ✅ |
| 43 | Sticky table headers | ✅ |
| 44 | Mobile sidebar backdrop | ✅ |
| 45 | Tooltip on truncated text | ✅ |

---

## 🏗️ 10. ARSITEKTUR SISTEM

```
┌──────────────────────────────────────────────────────────────┐
│                       PUBLIC LAYER                            │
│  /                     → PublicEventController@index          │
│  /events/{event}       → PublicEventController@show           │
│  /events/{event}/register → PublicEventController@register   │
├──────────────────────────────────────────────────────────────┤
│                       AUTH LAYER                              │
│  /login                → LoginController                      │
│  /logout               → LoginController (auth required)      │
├──────────────────────────────────────────────────────────────┤
│                       ADMIN LAYER (with auth middleware)      │
│  /admin                → DashboardController                  │
│  /admin/events         → EventController (CRUD)               │
│  /admin/participants   → ParticipantController (CRUD)         │
│  /admin/registrations  → RegistrationController (CRUD)        │
│  /admin/events/{id}/check-in → RegistrationController         │
│  /admin/events/{id}/export   → RegistrationController         │
└──────────────────────────────────────────────────────────────┘

MODEL LAYER:
  Event ──── hasMany ───→ Registration ←─── hasMany ── Participant
     │                        │                        │
     │ belongsTo              │ belongsTo              │
     ▼                        ▼                        ▼
  Category              (event_id FK)           (participant_id FK)
                        (attended_at)
```

---

## 📁 11. FLOWCHART: Daftar Event (Peserta)

```
Peserta buka /
    │
    ├─ Search / filter kategori
    │
    └─ Klik card event → /events/{id}
           │
           ├─ Lihat detail event (judul, tanggal, lokasi, kuota)
           │
           ├─ Event sudah berakhir?
           │   └─ YA → "Event telah berakhir" (form hidden)
           │
           ├─ Kuota penuh?
           │   └─ YA → "Kuota sudah penuh" (form hidden)
           │
           └─ Isi form: Nama, Email, Telepon → Klik "Daftar Sekarang"
                  │
                  ├─ Email sudah terdaftar di event ini?
                  │   └─ YA → Error "Anda sudah terdaftar di event ini"
                  │
                  └─ TIDAK → Simpan peserta + registrasi → Redirect ke /
                                └─ Notifikasi hijau "Pendaftaran berhasil!"
```

---

## 📁 12. FLOWCHART: Presensi Check-in (Admin)

```
Admin login → /admin/events → klik event → klik "Presensi"
    │
    └─ /admin/events/{id}/check-in
           │
           ├─ Tampilkan progress bar + semua peserta
           │
           ├─ Cari nama peserta
           │
           └─ Klik "Tandai Hadir"
                  │
                  ├─ attended_at = now()
                  ├─ Badge berubah hijau "Hadir" ✅
                  ├─ Progress bar update
                  └─ Tombol berubah jadi "Batalkan"
                         │
                         └─ Klik "Batalkan"
                                ├─ attended_at = null
                                ├─ Badge kembali abu "Belum Hadir"
                                └─ Progress bar update
```

---

## 🚀 13. CARA MENJALANKAN (LOKAL)

```bash
cd "/home/faiz/Semester 4/Rekayasa Web/slide22/ems"

# Fresh start (reset DB)
rm -f database/database.sqlite
touch database/database.sqlite
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan migrate --force
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan db:seed --force
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan tinker --execute="App\Models\Event::all()->each(fn(\$e,\$i) => \$e->update(['category_id' => (\$i % 7) + 1]));"

# Build & run
npm run build
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan serve --host=0.0.0.0 --port=8080
```

Buka: http://localhost:8080

---

## 🔗 14. ROUTE REFERENCE CARD

```
PUBLIC:
  GET    /                                    Landing page + list event
  GET    /events/{event}                      Detail event + form daftar
  POST   /events/{event}/register             Submit pendaftaran

AUTH:
  GET    /login                               Form login
  POST   /login                               Submit login
  POST   /logout                              Logout (must be logged in)

ADMIN (must be logged in):
  GET    /admin                               Dashboard
  GET    /admin/events                        List events
  GET    /admin/events/create                 Form tambah event
  POST   /admin/events                        Simpan event baru
  GET    /admin/events/{event}                Detail event
  GET    /admin/events/{event}/edit           Form edit event
  PUT    /admin/events/{event}                Update event
  DELETE /admin/events/{event}                Hapus event
  GET    /admin/participants                  List peserta
  GET    /admin/participants/create           Form tambah peserta
  POST   /admin/participants                  Simpan peserta baru
  GET    /admin/participants/{participant}    Detail peserta
  GET    /admin/participants/{participant}/edit  Form edit peserta
  PUT    /admin/participants/{participant}    Update peserta
  DELETE /admin/participants/{participant}    Hapus peserta
  GET    /admin/registrations                 List registrasi
  GET    /admin/registrations/create          Form registrasi baru
  POST   /admin/registrations                 Simpan registrasi
  GET    /admin/registrations/{registration}  Detail registrasi
  GET    /admin/registrations/{registration}/edit  Form edit registrasi
  PUT    /admin/registrations/{registration}  Update registrasi
  DELETE /admin/registrations/{registration}  Hapus registrasi
  POST   /admin/registrations/{id}/toggle-attendance  Toggle hadir/batal
  GET    /admin/events/{event}/check-in       Halaman presensi
  GET    /admin/events/{event}/export         Download CSV
```

---

## 🎯 15. TIPS DEMO

1. **Buka 3 tab di browser:** Tab 1 = public landing `/`, Tab 2 = login page `/login`, Tab 3 = admin dashboard `/admin`
2. **Tab 1 (Public):** Tunjukkan filter kategori, search, klik event, daftar
3. **Tab 2 → Tab 3:** Login → tunjukkin dashboard statistik
4. **Tab 3 (Admin):** CRUD event, cek presensi, download CSV
5. **Closing:** Balik ke tab 1 → tunjukkin data ke-update setelah admin nambah event
