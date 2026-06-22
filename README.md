# 🎓 Event Management System (EMS)

> **Campus Event & Registration Manager**  
> Laravel 13 | Tailwind CSS v4 | SQLite | Railway Deploy

---

## 🚀 Quick Start

```bash
cd ems
npm install && npm run build
touch database/database.sqlite
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan migrate --force
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan db:seed --force
PHP_INI_SCAN_DIR="$HOME/.php/conf.d" php artisan serve --port=8080
```

Buka **http://127.0.0.1:8080**

> ⚠️ **PENTING:** Prefix `PHP_INI_SCAN_DIR="$HOME/.php/conf.d"` wajib karena SQLite module diinstall manual di `~/.php/modules/`.

---

## 🔑 Credentials

| Role | Email | Password |
|---|---|---|
| Admin | `admin@ems.test` | `password` |

---

## 🌐 Live Demo

**https://ems-production-8c0e.up.railway.app/**

---

## 📖 Fitur

| Fitur | Deskripsi |
|---|---|
| 🔐 **Auth** | Login/logout admin dengan middleware protection |
| 🌐 **Public Landing** | Halaman publik dengan grid event upcoming |
| 📝 **Pendaftaran** | Peserta bisa daftar mandiri via form publik |
| 🛑 **Kuota** | Cek kuota otomatis — mencegah overbooking |
| 📂 **Kategori** | Filter event per kategori (Workshop, Seminar, Lomba, dll) |
| 📊 **Export CSV** | Download daftar peserta per event |
| ✅ **Check-in** | Presensi — tandai hadir/batal per peserta |
| 🖼️ **Gambar** | Upload poster/flyer event |
| 🔍 **Search** | Cari event/peserta di semua halaman |
| 📄 **Pagination** | 10 data per halaman |
| 📱 **Responsive** | Tailwind CSS v4 — mobile-friendly |

---

## 📁 Dokumentasi

| File | Isi |
|---|---|
| `_AI_CONTEXT.md` | Full project context (PRD, SRS, ERD, semua route, semua file) |
| `LAPORAN_AKADEMIK.md` | Laporan BAB 1-9 untuk submisi kampus |
| `DOKUMENTASI_TEKNIS.md` | Instalasi, struktur folder, source code detail |
| `WORKFLOW.md` | Panduan alur aplikasi + testing + script demo |
| `SCRIPT_PRESENTASI.md` | Script presentasi 10 menit + 20 Q&A dosen |

---

## 🏗️ Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | PHP 8.3, Laravel 13 |
| Database | SQLite |
| ORM | Eloquent (100%, zero raw SQL) |
| Frontend | Blade + Tailwind CSS v4 |
| Bundler | Vite |
| Deploy | Railway (Docker) |

---

## 📊 Database

```
events ──1:N── registrations ──N:1── participants
  │                                      │
  └──N:1── categories
```

---

## 🧪 Testing

**32 tests, 0 bugs** — semua route dan fitur terverifikasi.
