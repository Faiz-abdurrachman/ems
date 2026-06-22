# SCRIPT PRESENTASI — EVENT MANAGEMENT SYSTEM (EMS)

## 1. SCRIPT PRESENTASI 10 MENIT

### Menit 0-1: Pembukaan

"Assalamu'alaikum wr wb. Selamat pagi/siang, Bapak/Ibu Dosen dan teman-teman sekalian. Perkenalkan nama saya Faiz Abdurrachman, NIM 241111021. Pada kesempatan kali ini, saya akan mempresentasikan proyek tugas mata kuliah Framework PHP dan CRUD, yaitu Sistem Manajemen Event Kampus atau Event Management System yang dibangun menggunakan Laravel framework."

### Menit 1-2: Latar Belakang

"Latar belakang pembuatan aplikasi ini adalah untuk menjawab permasalahan umum di lingkungan kampus, yaitu proses pendaftaran event yang masih manual — mulai dari pengumuman di grup WhatsApp, pendaftaran lewat Google Form yang terpisah-pisah, sampai rekapitulasi peserta yang harus di-entry satu per satu ke Excel. Hal ini tentu tidak efisien, rawan kesalahan data, dan menyulitkan panitia dalam memonitor kuota peserta. Oleh karena itu saya membangun sebuah sistem terpusat untuk mengelola event kampus beserta pendaftaran pesertanya. Dengan sistem ini, panitia bisa membuat event, melihat jumlah pendaftar secara real-time, mencegah pendaftaran ganda, dan mendapatkan laporan dalam satu dashboard terintegrasi."

### Menit 2-3: Demo Dashboard

"Mari kita lihat dashboard. Di sini ada 4 kartu statistik yang langsung memberikan gambaran umum sistem: Total Event, Total Peserta, Total Registrasi, dan Event Aktif. Keempat kartu ini menggunakan query withCount dan pengecekan status di controller, jadi nilainya selalu up-to-date. Di bawahnya ada dua panel: tabel registrasi terbaru yang menampilkan 5 data paling anyar dengan informasi event dan peserta, dan di sebelah kanan ada daftar upcoming event lengkap dengan progress bar registrasi. Progress bar ini menunjukkan seberapa penuh kuota suatu event — misalnya jika kuota 100 dan sudah terisi 75, progress barnya akan berwarna hijau di 75%. Dashboard ini memberikan gambaran cepat kondisi seluruh sistem tanpa harus masuk ke halaman detail."

### Menit 3-4: Demo CRUD Event

"Sekarang kita buka halaman Events dari menu sidebar. Di sini ada tabel lengkap dengan kolom judul, tanggal, lokasi, kuota, status, dan jumlah registrasi. Setiap status event punya warna berbeda: biru untuk upcoming, hijau untuk ongoing, abu-abu untuk completed, dan merah untuk cancelled. Warna ini menggunakan kelas Tailwind yang dinamis berdasarkan helper method di model. Juga ada fitur search dan pagination. Kalau kita klik tombol Add Event, muncul form dengan field judul, deskripsi, tanggal, lokasi, kuota, dan status. Saya coba kosongkan judul lalu submit. Nah, muncul error validasi berwarna merah di bawah field judul — ini berasal dari Form Request Validation. Sekarang saya isi lengkap dengan data event baru, lalu submit. Sukses! Muncul alert hijau dengan pesan 'Event berhasil ditambahkan' dan data baru langsung muncul di tabel tanpa perlu refresh halaman. Kalau kita klik judul event, kita masuk ke halaman detail yang menampilkan informasi lengkap event, progress registrasi dalam bentuk progress bar, dan daftar peserta yang sudah terdaftar."

### Menit 4-5: Demo CRUD Peserta

"Sekarang kita buka menu Participants. Tabelnya mirip dengan events, menampilkan nama, email, nomor telepon, dan jumlah event yang diikuti. Kolom jumlah event diikuti menggunakan withCount di controller. Ada juga fitur search dan pagination. Saya akan tambah peserta baru dengan mengklik Add Participant. Form-nya sederhana: nama, email, dan telepon. Saya coba isi dengan email yang sudah ada di database, lalu submit. Nah, muncul error validasi 'Email sudah terdaftar' karena di database kolom email peserta di-set unique. Validasi ini dicek langsung oleh Laravel dengan rule 'unique:participants,email'. Saya ganti dengan email baru, submit, dan berhasil. Muncul alert hijau dan data peserta baru masuk ke tabel."

### Menit 5-6: Demo CRUD Registrasi

"Ini adalah bagian paling penting dari sistem: Registrasi. Registrasi adalah entitas yang menghubungkan event dengan peserta. Tabel registrasi menampilkan kolom event, peserta, dan tanggal daftar. Kalau kita klik New Registration, muncul form dengan dua dropdown: pilih event dan pilih peserta. Kedua dropdown ini mengambil data langsung dari tabel events dan participants. Saya pilih event yang sudah ada, pilih peserta, lalu submit. Registrasi berhasil, muncul alert hijau. Sekarang saya coba skenario kritis: saya daftarkan peserta yang SAMA ke event yang SAMA untuk kedua kalinya. Ketika submit, muncul error: 'Peserta sudah terdaftar di event ini'. Ini adalah fitur penting yang mencegah duplikasi data pendaftaran. Implementasinya menggunakan unique constraint (event_id, participant_id) di level database dan divalidasi dengan Validator::make di controller."

### Menit 6-7: Edit & Delete

"Sekarang kita coba fitur edit. Dari halaman events, saya klik tombol Edit pada salah satu event. Form muncul dengan data yang sudah terisi. Saya ubah status dari upcoming menjadi ongoing, lalu simpan. Data terupdate, alert hijau muncul. Fitur ini berguna ketika jadwal event berubah atau event sudah mulai berlangsung. Selanjutnya, saya coba hapus salah satu registrasi. Saya klik tombol Hapus di tabel registrasi, muncul konfirmasi dialog JavaScript — 'Apakah Anda yakin ingin menghapus data ini?'. Ini penting untuk mencegah penghapusan yang tidak disengaja. Setelah saya konfirmasi, data registrasi terhapus dan muncul alert sukses. Kalau kita kembali ke dashboard, angka-angka statistik sudah terupdate secara otomatis karena kita menggunakan query langsung dari database. "

### Menit 7-8: Penjelasan Teknis - Arsitektur

"Secara teknis, aplikasi ini menerapkan arsitektur MVC — Model View Controller — yang merupakan standar industri untuk pengembangan web modern. Mari lihat struktur foldernya. app/Models berisi tiga model: Event, Participant, dan Registration. Masing-masing model mendefinisikan relasi Eloquent, atribut $fillable untuk mass assignment protection, dan method helper untuk format data. app/Http/Controllers berisi 4 controller: EventController, ParticipantController, RegistrationController, dan DashboardController. Setiap controller terbagi menjadi method-method yang mewakili aksi CRUD standar. resources/views berisi 15 file Blade yang diorganisir ke dalam subfolder: events, participants, registrations, dashboard, dan layouts. layouts/app.blade.php adalah file layout utama yang memuat Tailwind CSS via CDN. routes/web.php mendefinisikan 25 route yang menghubungkan URL ke method controller, termasuk route resource untuk CRUD."

### Menit 8-9: Database & Relasi

"Database menggunakan SQLite dan memiliki 3 tabel utama. Tabel events menyimpan data event dengan kolom: id, title, description, date, location, quota, status, created_at, dan updated_at. Tabel participants menyimpan data peserta dengan kolom: id, name, email, phone, created_at, updated_at. Tabel registrations adalah tabel pivot yang menghubungkan event dan participant, dengan kolom: id, event_id, participant_id, registered_at, created_at, updated_at. Relasi antar tabel: Event hasMany Registration, artinya satu event bisa memiliki banyak registrasi. Participant hasMany Registration, artinya satu peserta bisa melakukan banyak registrasi ke event yang berbeda-beda. Registration belongsTo Event dan belongsTo Participant, artinya setiap registrasi adalah milik satu event dan satu peserta. Yang paling kritis adalah unique constraint di kolom (event_id, participant_id) yang memastikan tidak ada pendaftaran ganda. Ini adalah constraint komposit yang dicegah di dua level: level database dengan unique key, dan level aplikasi dengan validasi manual di controller."

### Menit 9-10: Penutup

"Kesimpulannya, proyek ini berhasil membangun sebuah Event Management System dengan fitur CRUD lengkap untuk 3 entitas, dashboard interaktif dengan statistik real-time, validasi data yang komprehensif, pencegahan registrasi ganda, dan desain responsif menggunakan Tailwind CSS. Untuk pengembangan ke depan, bisa ditambahkan sistem autentikasi dan otorisasi dengan Laravel Breeze atau Jetstream supaya ada pembedaan peran admin dan peserta biasa. Selain itu, bisa ditambahkan notifikasi email menggunakan Laravel Mail untuk konfirmasi pendaftaran, dan halaman publik untuk peserta mendaftar mandiri tanpa harus melalui admin. Juga bisa diintegrasikan dengan API untuk keperluan mobile app. Saya rasa cukup. Terima kasih atas perhatian Bapak/Ibu dan teman-teman. Saya buka sesi tanya jawab."

---

## 2. DAFTAR PERTANYAAN + JAWABAN

### 1. Kenapa memilih Laravel dibanding CodeIgniter?

"Laravel memiliki Eloquent ORM yang lebih ekspresif dan intuitif dibandingkan CodeIgniter. Dengan Eloquent, kita bisa menulis relasi antar tabel seperti properti objek, tanpa perlu menulis join query manual. Laravel juga memiliki Blade Templating Engine yang sangat powerful dengan fitur layout inheritance, section, dan component. Selain itu, ekosistem Laravel lebih lengkap dengan Artisan CLI untuk scaffolding, Form Request Validation yang memisahkan logic validasi dari controller, Migration untuk version control database, Seeder untuk data dummy, dan built-in authentication. Laravel juga mengikuti standar PHP modern dengan namespace, dependency injection, dan PSR-4 autoloading. Ini membuat codebase lebih terstruktur, testable, dan maintainable. Meskipun Laravel memiliki learning curve yang lebih tinggi, untuk project skala menengah ke atas, Laravel jauh lebih produktif."

### 2. Apa perbedaan hasMany dan belongsTo?

"hasMany dan belongsTo adalah dua jenis relasi Eloquent yang saling berlawanan. hasMany digunakan di model 'induk' atau 'satu' yang memiliki banyak data di model lain. Contohnya, Event hasMany Registration. Artinya, satu event bisa memiliki banyak registrasi. Di model Event kita tulis method: public function registrations() { return $this->hasMany(Registration::class); }. Sedangkan belongsTo digunakan di model 'anak' atau 'banyak' yang menjadi milik satu model lain. Contohnya, Registration belongsTo Event. Artinya, setiap registrasi hanya milik satu event. Di model Registration kita tulis: public function event() { return $this->belongsTo(Event::class); }. Jadi intinya, hasMany di sisi 'satu' dan belongsTo di sisi 'banyak' dari suatu relasi one-to-many. Di database, foreign key disimpan di tabel sisi 'banyak', yaitu tabel registrations yang memiliki kolom event_id."

### 3. Apa itu Eloquent ORM?

"Eloquent ORM adalah Active Record implementation yang ada di Laravel. ORM singkatan dari Object-Relational Mapping, yaitu teknik yang memungkinkan kita berinteraksi dengan database menggunakan objek PHP tanpa harus menulis SQL query secara langsung. Setiap tabel database punya satu Model Eloquent yang mewakilinya. Misalnya, tabel events diwakili oleh model Event. Jadi Event::find(1) sama dengan menjalankan query SELECT * FROM events WHERE id = 1. Kita juga bisa melakukan Event::where('status', 'upcoming')->get() yang setara dengan SELECT * FROM events WHERE status = 'upcoming'. Keuntungan utama Eloquent adalah: keamanan karena menggunakan parameter binding otomatis, kemudahan relasi antar tabel, query yang lebih readable, dan integrasi dengan fitur Laravel lainnya seperti pagination, eager loading, dan accessor/mutator."

### 4. Apa itu Migration?

"Migration adalah version control untuk database di Laravel. Setiap perubahan pada struktur database — seperti membuat tabel, menambah kolom, atau mengubah tipe data — ditulis dalam file PHP yang bisa dijalankan (migrate) atau dibatalkan (rollback). File migration punya timestamp di namanya sehingga urutan eksekusi terjamin. Contoh migration CreateEventsTable berisi method up() yang menjalankan Schema::create untuk membuat tabel events, dan method down() yang menjalankan Schema::dropIfExists untuk membatalkan perubahan. Ini sangat berguna dalam kerja tim: anggota tim cukup menjalankan php artisan migrate untuk mendapatkan struktur database yang sama persis. Tidak perlu lagi ekspor-impor SQL manual. Migration bisa di-rollback step-by-step atau sekaligus dengan php artisan migrate:rollback."

### 5. Apa itu Form Request?

"Form Request adalah kelas khusus di Laravel yang menangani validasi dan otorisasi request secara terpisah dari controller. Caranya dengan membuat kelas baru menggunakan Artisan: php artisan make:request StoreEventRequest. Di dalam kelas ini ada method authorize() untuk mengecek apakah user punya akses, dan method rules() yang mengembalikan array aturan validasi. Contoh rule: 'title' => 'required|string|max:255', 'date' => 'required|date|after:today', 'quota' => 'required|integer|min:1'. Di controller, kita tinggal type-hint: store(StoreEventRequest $request). Laravel akan otomatis menjalankan validasi sebelum method controller dijalankan. Jika validasi gagal, Laravel mengembalikan response error ke halaman sebelumnya. Keuntungan Form Request: controller menjadi lebih bersih, aturan validasi bisa di-reuse, dan logic validasi terpusat sehingga mudah di-maintain."

### 6. Apa beda Bootstrap sama Tailwind?

"Bootstrap dan Tailwind CSS sama-sama framework CSS, tapi pendekatannya berbeda. Bootstrap menyediakan komponen siap pakai — seperti card, navbar, modal, button — yang tinggal dipasang dengan class tertentu. Kelebihan Bootstrap adalah cepat untuk prototyping karena komponen sudah jadi. Kekurangannya, website yang pakai Bootstrap cenderung terlihat seragam karena komponennya sudah punya style default yang khas. Tailwind CSS adalah utility-first framework: ia menyediakan class-class kecil untuk satu properti CSS saja, seperti p-4 (padding 1rem), text-lg (ukuran font besar), bg-blue-500 (background biru). Kita merangkai class-class ini untuk membangun desain sendiri. Kelebihan Tailwind: kontrol penuh terhadap desain, file CSS lebih kecil karena utility yang sama bisa dipakai ulang, dan hasil desain lebih unik. Kekurangannya, HTML jadi lebih panjang karena banyak class. Untuk project ini saya menggunakan Tailwind karena ingin tampilan yang lebih modern dan fleksibel."

### 7. Bagaimana Laravel mencegah SQL injection?

"Laravel mencegah SQL injection melalui penggunaan Eloquent ORM dan Query Builder yang secara otomatis menggunakan parameter binding atau prepared statements. Parameter binding artinya data dari user (input form, parameter URL) tidak langsung digabungkan ke query SQL sebagai string. Sebaliknya, query dikirim ke database dengan placeholder (?), dan data user dikirim secara terpisah. Database engine kemudian akan mengenali bahwa data tersebut adalah nilai, bukan bagian dari perintah SQL. Contoh: User::where('email', $input)->first() — Laravel mengirim query SELECT * FROM users WHERE email = ? dengan nilai $input sebagai parameter terpisah. Jadi meskipun user mengirimkan input seperti '; DROP TABLE users; —', itu akan dianggap sebagai string biasa, bukan perintah SQL. Yang perlu dihindari adalah menulis raw query dengan concatenation string, seperti DB::select("SELECT * FROM users WHERE email = '$input'")."

### 8. Apa itu Route Model Binding?

"Route Model Binding adalah fitur Laravel yang secara otomatis meng-inject instance model yang sesuai berdasarkan ID atau parameter dari URL. Contoh sederhana: di routes/web.php kita punya route: Route::get('/events/{event}', [EventController::class, 'show']). Di controller, kita tulis method: public function show(Event $event). Ketika user mengakses /events/5, Laravel akan otomatis mencari Event dengan ID 5 di database, lalu meng-inject objek Event yang sudah lengkap dengan datanya ke parameter $event. Jika tidak ditemukan, Laravel otomatis memberikan response 404. Tanpa Route Model Binding, kita harus manual: $id = $request->route('id'); $event = Event::findOrFail($id); lalu return view('events.show', compact('event')). Route Model Binding membuat controller lebih bersih dan mengurangi boilerplate code. Untuk resource controller, Laravel secara default menggunakan Route Model Binding pada parameter yang sama dengan nama resource, seperti {event}, {participant}, {registration}."

### 9. Bagaimana cara testing CRUD?

"Saya melakukan pengujian secara fungsional dan manual untuk memastikan setiap fitur CRUD berjalan dengan benar. Metodenya meliputi: pertama, mengakses setiap endpoint melalui browser — memastikan halaman index, create, show, dan edit bisa diakses tanpa error. Kedua, mengisi form dengan data valid dan mengecek apakah data tersimpan di database, apakah muncul flash message sukses, dan apakah redirect ke halaman yang benar. Ketiga, mengisi form dengan data invalid — seperti field kosong, email yang sudah ada, tanggal yang sudah lewat — untuk memastikan validasi berfungsi dan error message muncul. Keempat, menguji fitur edit: mengubah data dan memastikan perubahan tersimpan. Kelima, menguji fitur delete: mengklik tombol hapus, mengonfirmasi dialog, dan memastikan data terhapus dari database. Keenam, menguji skenario unik seperti registrasi ganda — memastikan error muncul. Untuk testing yang lebih terstruktur, Laravel menyediakan PHPUnit dan fitur seperti assertDatabaseHas, assertDatabaseMissing, assertValid, dan assertInvalid yang bisa digunakan untuk automated testing."

### 10. Apa kelebihan utama sistem ini?

"Sistem ini memiliki beberapa kelebihan utama. Pertama, arsitektur MVC yang rapi: pemisahan yang jelas antara Model (data/bisnis logic), View (tampilan), dan Controller (logika aplikasi). Kedua, validasi data yang lengkap menggunakan 6 Form Request kelas khusus yang menangani validasi untuk create dan edit dari tiga entitas. Ketiga, pencegahan registrasi ganda melalui unique constraint composite (event_id, participant_id) di level database dan validasi tambahan di controller. Keempat, dashboard statistik real-time dengan 4 kartu metrik yang selalu up-to-date dan progress bar untuk memonitor kuota event. Kelima, desain responsif modern dengan Tailwind CSS yang bisa diakses dari berbagai ukuran layar. Keenam, fitur search dan pagination di setiap halaman data yang memudahkan pencarian data spesifik tanpa loading ulang seluruh data. Ketujuh, flash message feedback yang memberi tahu pengguna apakah aksi berhasil atau gagal. Kedelapan, konfirmasi dialog sebelum penghapusan untuk mencegah kehilangan data yang tidak disengaja."

### 11. Apa kekurangan sistem ini?

"Tentu ada beberapa kekurangan. Pertama, belum ada sistem autentikasi dan otorisasi. Saat ini semua halaman bisa diakses siapa saja tanpa login. Belum ada pembedaan peran antara admin, panitia, dan peserta biasa. Kedua, belum ada notifikasi email. Idealnya, ketika peserta mendaftar, sistem mengirim email konfirmasi otomatis. Ketiga, tampilan masih berfokus pada sisi admin saja. Belum ada halaman publik untuk peserta melihat daftar event dan mendaftar secara mandiri tanpa melalui admin panel. Keempat, belum ada fitur ekspor data — seperti ekspor daftar peserta ke Excel atau PDF. Kelima, belum ada fitur upload — seperti upload foto event atau foto profil peserta. Keenam, belum ada sistem reminder atau pengingat otomatis menjelang event berlangsung. Ini semua bisa dikembangkan di fase selanjutnya."

### 12. Kenapa pakai SQLite bukan MySQL?

"Untuk project demo dan tugas kuliah seperti ini, SQLite lebih praktis karena beberapa alasan. Pertama, SQLite tidak perlu instalasi dan konfigurasi database server terpisah — cukup satu file .sqlite saja. Ini berarti tidak perlu setup username, password, port, atau service database. Kedua, konfigurasi di file .env sangat sederhana: DB_CONNECTION=sqlite dan DB_DATABASE=/path/database.sqlite. Ketiga, backup database cukup dengan meng-copy satu file. Keempat, untuk development lokal dengan jumlah data yang tidak terlalu besar, performa SQLite sudah lebih dari cukup. Kekurangan SQLite: tidak mendukung concurrent write dari banyak pengguna, tidak memiliki user management, dan tidak cocok untuk production dengan traffic tinggi. Jadi untuk production atau jika sistem ini dipakai oleh banyak orang secara bersamaan — misalnya di server kampus — baru kita pindah ke MySQL atau PostgreSQL dengan mengubah satu baris konfigurasi di file .env."

### 13. Apa itu $fillable?

"$fillable adalah properti di model Eloquent yang mendefinisikan kolom mana saja yang boleh diisi melalui mass assignment. Mass assignment adalah fitur Laravel yang memungkinkan kita mengisi banyak kolom sekaligus, misalnya: Event::create($request->all()). Tanpa $fillable, Laravel akan melempar MassAssignmentException. Ini adalah fitur keamanan untuk mencegah pengguna mengirim data kolom yang tidak seharusnya. Contoh: di model Event, kita set: protected $fillable = ['title', 'description', 'date', 'location', 'quota', 'status']. Ini berarti hanya kolom-kolom tersebut yang bisa diisi lewat mass assignment. Jika ada user nakal yang menambahkan field is_admin = 1 di request, field itu akan diabaikan karena tidak ada di daftar $fillable. Alternatif dari $fillable adalah $guarded, yang melakukan kebalikannya: mendefinisikan kolom yang tidak boleh diisi, dan sisanya boleh. Biasanya $guarded = ['id'] untuk mengamankan kolom auto-increment."

### 14. Apa itu CSRF dan bagaimana Laravel menanganinya?

"CSRF (Cross-Site Request Forgery) adalah jenis serangan di mana pengguna yang sudah terautentikasi di suatu situs dieksekusi aksinya tanpa sepengetahuannya melalui permintaan yang dikirim dari situs lain. Contoh: seorang user yang sudah login ke aplikasi banking, secara tidak sengaja membuka halaman berbahaya yang mengirim POST request untuk mentransfer uang. Karena cookie login masih aktif, request terlihat legitimate. Laravel melindungi dari CSRF dengan men-generate token unik untuk setiap session user. Setiap form POST, PUT, PATCH, DELETE di Laravel harus menyertakan token ini: @csrf di Blade atau X-CSRF-TOKEN di header. Token ini disimpan di session dan dicocokkan setiap ada request. Jika token tidak cocok atau tidak ada, Laravel menolak request dengan error 419 Page Expired. Di aplikasi ini, di setiap form yang menggunakan method POST, PUT, atau DELETE, saya menambahkan direktif @csrf di Blade agar token CSRF otomatis disertakan."

### 15. Apa itu Eager Loading?

"Eager Loading adalah teknik di Eloquent ORM untuk mengambil data relasi secara proaktif dalam jumlah query yang minimal. Masalah yang dipecahkan adalah N+1 query problem. Contoh tanpa Eager Loading: kita punya 10 registrasi, dan kita ingin menampilkan nama event untuk setiap registrasi. Tanpa Eager Loading, kode akan menjalankan 1 query untuk mengambil 10 registrasi, lalu untuk setiap registrasi menjalankan 1 query untuk mengambil data event — total 11 query. Dengan Eager Loading menggunakan with(): Registration::with('event')->get(), Laravel menjalankan 2 query: pertama mengambil semua registrasi, lalu mengambil semua event yang terkait dengan registrasi tersebut dalam satu query menggunakan WHERE IN. Di aplikasi ini, saya menggunakan Eager Loading di hampir semua query yang menampilkan data relasi: Registration::with(['event', 'participant'])->get() untuk menampilkan registrasi lengkap dengan data event dan peserta. Juga ada withCount untuk menambahkan kolom agregat seperti registrations_count tanpa menarik data relasi lengkap."

### 16. Bagaimana performa dengan 1000 data?

"Untuk 1000 data, performa sistem masih akan sangat baik. Beberapa faktor yang mendukung: pertama, pagination yang membatasi data per halaman menjadi 10 atau 15 data, sehingga query hanya mengambil sebagian kecil data sekaligus. Kedua, Eager Loading dengan with() dan withCount() yang mengoptimalkan jumlah query — data relasi diambil dalam query terpisah menggunakan WHERE IN, bukan per item. Ketiga, index di kolom foreign key (event_id, participant_id) yang mempercepat pencarian dan join. Keempat, SQLite sendiri cukup efisien untuk pembacaan data dalam jumlah sedang. Untuk 1000 registrasi, dashboard tetap akan merespons dalam waktu kurang dari 1 detik. Kalau data sudah mencapai puluhan ribu, bisa dioptimasi lebih lanjut dengan: menambah index di kolom yang sering di-search, menggunakan query caching, implementasi database MySQL, atau menggunakan pagination berbasis cursor untuk dataset yang sangat besar."

### 17. Apa itu Artisan?

"Artisan adalah command-line interface (CLI) bawaan Laravel yang menyediakan berbagai perintah untuk mempermudah dan mempercepat pengembangan. Artisan bisa dijalankan dari terminal dengan php artisan <command>. Beberapa perintah yang saya gunakan dalam project ini: php artisan make:model Event -m untuk membuat model beserta migration file, php artisan make:controller EventController --resource untuk membuat controller dengan method CRUD lengkap, php artisan make:request StoreEventRequest untuk membuat Form Request validasi, php artisan migrate untuk menjalankan semua migration, php artisan migrate:rollback untuk membatalkan migration terakhir, php artisan db:seed untuk mengisi database dengan data dummy, php artisan make:seeder EventSeeder untuk membuat seeder, dan php artisan serve untuk menjalankan server development. Artisan juga bisa diperluas dengan membuat custom command sendiri. Artisan sangat meningkatkan produktivitas karena kita tidak perlu menulis boilerplate code secara manual."

### 18. Bagaimana cara deploy?

"Untuk deployment, saya menggunakan Render.com sebagai Platform as a Service. File render.yaml di root project mendefinisikan konfigurasi deployment: buildCommand berisi perintah untuk composer install, npm install, npm run build, php artisan migrate, dan php artisan db:seed. startCommand berisi perintah untuk menjalankan server Laravel. Render secara otomatis mendeteksi project Laravel, mengatur environment variables seperti APP_KEY, DB_CONNECTION, dan APP_ENV, serta menyediakan SSL certificate gratis. Proses deploy cukup dengan push ke GitHub repository, lalu hubungkan ke Render melalui dashboard. Render akan otomatis build ulang setiap ada push ke branch utama. Setelah deploy selesai, Render memberikan URL publik yang langsung bisa diakses. Untuk database, saya menggunakan SQLite file yang tersimpan di storage/ agar persist meskipun service di-restart. Alternatif hosting lain: Vercel dengan serverless, DigitalOcean App Platform, atau traditional VPS seperti Linode."

### 19. Apa saran untuk production?

"Untuk production, ada beberapa saran pengembangan. Pertama, tambahkan sistem autentikasi menggunakan Laravel Breeze atau Jetstream — ini menyediakan login, register, forgot password, dan email verification secara out-of-the-box. Kedua, tambahkan sistem otorisasi dengan policy atau gates untuk membedakan peran admin, panitia, dan peserta. Ketiga, pindah ke database MySQL atau PostgreSQL untuk performa dan reliability yang lebih baik. Keempat, implementasikan queue untuk proses yang lambat seperti pengiriman email konfirmasi, export data, dan notifikasi. Kelima, gunakan environment variables untuk semua konfigurasi sensitif. Keenam, setup Redis atau Memcached untuk caching query yang sering diakses. Ketujuh, gunakan CDN untuk asset statis seperti CSS dan JavaScript. Kedelapan, implementasikan logging terstruktur dengan Laravel Log Channels. Kesembilan, setup monitoring dengan Laravel Pulse atau alat eksternal. Untuk hosting skala besar, bisa menggunakan Laravel Vapor (serverless AWS) atau cloud VPS."

### 20. Apa beda REST API dengan web app saat ini?

"Aplikasi saat ini adalah server-side rendering (SSR) tradisional. Artinya, semua proses rendering HTML dilakukan di server. Blade template engine menggabungkan data dari controller dengan template HTML, lalu mengirimkan hasil HTML jadi ke browser. Setiap kali user mengklik link atau submit form, browser mengirim request ke server, server memprosesnya, dan mengirim halaman HTML baru. Ini sederhana dan SEO-friendly karena konten langsung ada di HTML. REST API berbeda: server hanya mengembalikan data dalam format JSON, bukan HTML. Tampilan dibuat oleh frontend terpisah (React, Vue, atau Angular) yang berjalan di browser. Frontend ini kemudian memanggil API untuk mendapatkan data dan merendernya sendiri. Kelebihan REST API: frontend dan backend bisa dikembangkan secara independen, satu backend API bisa dipakai oleh web, mobile app, dan pihak ketiga. Kekurangan: lebih kompleks dan butuh penanganan state di client. Untuk project ini, saya memilih SSR karena lebih sederhana, cocok untuk aplikasi internal admin, dan butuh lebih sedikit kode."

### 21. Apa itu Soft Delete?

"Soft Delete adalah fitur Eloquent yang memungkinkan data tidak benar-benar dihapus dari database, hanya ditandai sebagai terhapus dengan mengisi kolom deleted_at. Caranya dengan menambahkan trait SoftDeletes di model: use SoftDeletes; dan menambahkan kolom deleted_at di migration: $table->softDeletes(). Data yang 'dihapus' dengan soft delete masih ada di database, tapi secara default tidak diikutsertakan dalam query SELECT. Jika kita ingin mengakses data yang sudah dihapus, bisa menggunakan Event::withTrashed()->get(). Untuk mengembalikan data: $event->restore(). Keuntungan soft delete: data bisa dipulihkan jika terhapus tidak sengaja, ada riwayat penghapusan, dan relasi data tetap terjaga. Di project ini saya belum menggunakan soft delete, tapi untuk production dengan banyak data penting, soft delete sangat disarankan."

### 22. Bagaimana cara menangani error 404?

"Laravel menangani error 404 secara otomatis ketika menggunakan Route Model Binding dengan metode findOrFail. Jika model tidak ditemukan berdasarkan ID dari URL, Laravel mengembalikan response 404. Contoh: di controller kita punya public function show(Event $event). Jika user mengakses /events/999 (ID yang tidak ada), Laravel otomatis menampilkan halaman error 404. Kita bisa kostumisasi tampilan error 404 dengan membuat file resources/views/errors/404.blade.php. Di file ini kita bisa mendesain halaman kustom dengan pesan yang lebih ramah, tombol kembali ke dashboard, atau ilustrasi. Saya juga memastikan semua tombol navigasi aman dengan menampilkan data hanya dari database, bukan link hardcoded. Untuk halaman yang memerlukan ID tertentu, saya menggunakan findOrFail yang melempar ModelNotFoundException, yang secara otomatis diubah Laravel menjadi 404 response."

### 23. Bagaimana mekanisme flash message?

"Flash message adalah pesan notifikasi yang muncul hanya sekali setelah suatu aksi. Di Laravel, kita menggunakan session flash data. Di controller, setelah berhasil melakukan operasi CRUD, saya menambahkan: session()->flash('success', 'Event berhasil ditambahkan'). Atau untuk error: session()->flash('error', 'Gagal menghapus data'). Data ini disimpan di session hanya untuk satu request berikutnya. Di view Blade, saya mengecek keberadaan flash message dengan @if(session('success')), lalu menampilkan alert dengan Tailwind CSS. Alert menggunakan desain modern dengan ikon, border kiri berwarna, dan animasi transisi. Setelah halaman di-refresh atau navigasi ke halaman lain, flash message otomatis hilang. Ini memberikan feedback langsung kepada user bahwa aksi mereka berhasil atau gagal, yang sangat penting untuk usability aplikasi."

### 24. Apa itu Seeder dan Factory?

"Seeder dan Factory adalah fitur Laravel untuk mengisi database dengan data dummy atau data awal. Factory mendefinisikan pola data untuk suatu model. Contoh: EventFactory menggunakan faker untuk generate data random: 'title' => fake()->sentence(3), 'date' => fake()->dateTimeBetween('now', '+1 month'), 'quota' => fake()->numberBetween(20, 200). Factory memudahkan pembuatan banyak data dalam loop. Seeder adalah kelas yang memanggil Factory untuk mengisi database. Di DatabaseSeeder.php, kita panggil Event::factory(20)->create() untuk membuat 20 event random. Urutan pemanggilan seeder penting karena registrasi butuh event dan participant yang sudah ada. Saya juga membuat seeder spesifik: EventSeeder, ParticipantSeeder, RegistrationSeeder. Untuk menjalankan semua seeder: php artisan db:seed. Untuk data development yang konsisten, seeder sangat membantu."

### 25. Bagaimana struktur folder resources/views?

"Folder resources/views di project ini terorganisir berdasarkan entitas. Ada folder events/ berisi file index.blade.php (tabel daftar event), create.blade.php (form tambah event), show.blade.php (detail event dengan daftar peserta), dan edit.blade.php (form edit event). Folder participants/ berisi file index.blade.php (daftar peserta), create.blade.php (form tambah peserta), show.blade.php (detail peserta dengan riwayat event), dan edit.blade.php. Folder registrations/ berisi index.blade.php (daftar registrasi) dan create.blade.php (form registrasi). Folder dashboard/ berisi index.blade.php (halaman dashboard utama). Folder layouts/ berisi app.blade.php (layout utama dengan navbar, sidebar, dan footer). Folder partials/ berisi file-file kecil seperti flash-message.blade.php untuk alert dan navigation.blade.php. Setiap halaman index memiliki search bar di atas tabel, dan tabel dilengkapi pagination links. Semua file menggunakan Tailwind CSS untuk styling dan mengikuti struktur yang konsisten."

### 26. Apa itu foreign key di database?

"Foreign key adalah kolom di suatu tabel yang merujuk ke primary key di tabel lain. Fungsinya untuk menjaga integritas referensial antar tabel. Di project ini, tabel registrations memiliki dua foreign key: event_id yang merujuk ke id di tabel events, dan participant_id yang merujuk ke id di tabel participants. Dengan foreign key constraint, database akan memastikan bahwa: (1) kita tidak bisa memasukkan event_id yang tidak ada di tabel events, dan (2) kita tidak bisa menghapus event yang masih memiliki registrasi terkait (kecuali pakai ON DELETE CASCADE). Laravel Migration mendefinisikan foreign key dengan: $table->foreignId('event_id')->constrained('events')->onDelete('cascade'). onDelete('cascade') artinya jika event dihapus, semua registrasi yang terkait dengan event tersebut juga akan dihapus otomatis. Ini mencegah orphaned records di database."

### 27. Apa itu route resource?

"Route resource adalah route khusus di Laravel yang secara otomatis mendefinisikan 7 route CRUD standar hanya dengan satu baris kode. Contoh: Route::resource('events', EventController::class) secara otomatis membuat route untuk: GET /events (index), GET /events/create (create), POST /events (store), GET /events/{event} (show), GET /events/{event}/edit (edit), PUT/PATCH /events/{event} (update), DELETE /events/{event} (destroy). Nama route-nya juga otomatis: events.index, events.create, events.store, events.show, events.edit, events.update, events.destroy. Di controller, method-method yang sesuai sudah disediakan oleh --resource flag saat pembuatan controller. Kita tinggal mengisi logika di masing-masing method. Route resource sangat menghemat penulisan kode dan memastikan konsistensi naming convention. Di project ini, ketiga entitas — events, participants, registrations — menggunakan route resource."

### 28. Bagaimana menampilkan data di view?

"Data dikirim dari controller ke view menggunakan fungsi compact() atau array. Contoh di controller: $events = Event::withCount('registrations')->paginate(10); return view('events.index', compact('events')). Di view Blade, kita bisa mengakses $events langsung. Untuk menampilkan data dalam loop: @foreach($events as $event) ... @endforeach. Untuk menampilkan properti: {{ $event->title }}, {{ $event->date->format('d M Y') }}. Untuk menampilkan data relasi: {{ $event->registrations_count }} dari withCount. Blade menggunakan kurung kurawal ganda {{ }} yang secara otomatis menge-escape output untuk mencegah XSS attack. Untuk conditional: @if($event->status === 'upcoming') ... @endif. Blade juga punya direktif @forelse yang menangani kasus array kosong dengan @empty. Layout menggunakan @extends('layouts.app') dan @section('content') untuk mengisi konten spesifik halaman. Ini membuat semua halaman memiliki struktur yang konsisten."

### 29. Bagaimana menangani tanggal di Laravel?

"Laravel menggunakan Carbon library untuk menangani tanggal. Secara default, kolom created_at dan updated_at di Eloquot otomatis di-cast ke objek Carbon. Kita bisa menambahkan kolom tanggal lain dengan menambahkan 'dates' di model: protected $dates = ['date']. Dengan ini, $event->date bisa menggunakan method Carbon seperti: $event->date->format('d M Y'), $event->date->diffForHumans() (menghasilkan '3 days from now'), atau $event->date->isPast(). Untuk validasi tanggal di Form Request, kita bisa menggunakan rule: 'date' => 'required|date|after:today' untuk memastikan tanggal event adalah hari ini atau setelahnya. Di Blade, kita bisa menampilkan tanggal dengan berbagai format. Untuk migration, kolom tanggal menggunakan tipe data: $table->date('date') untuk tanggal saja, atau $table->datetime('date') untuk tanggal dan waktu."

### 30. Apa itu pagination dan bagaimana implementasinya?

"Pagination adalah teknik membagi data menjadi halaman-halaman untuk mengurangi beban loading dan meningkatkan user experience. Di Laravel, implementasinya sangat mudah: cukup tambahkan paginate(10) di query, bukan get(). Contoh: Event::paginate(10) akan mengambil 10 data per halaman. Laravel secara otomatis menghitung total data, jumlah halaman, dan posisi current page. Di view Blade, kita tinggal tambahkan {{ $events->links() }} di bawah tabel untuk menampilkan tombol navigasi halaman. links() menghasilkan HTML yang sudah di-styling dengan Tailwind (jika menggunakan Tailwind Pagination). Pagination Laravel juga support query string seperti ?page=2, pencarian dengan appends(request()->query()), dan pagination dengan simplePaginate untuk prev/next tanpa nomor halaman. Di project ini, semua halaman index — events, participants, registrations — menggunakan paginate(10) untuk konsistensi."

### 31. Bagaimana cara menambahkan fitur search?

"Fitur search diimplementasikan dengan menangkap input query string dari URL dan menambahkannya ke query Eloquent. Contoh di EventController index: $query = $request->input('search'); $events = Event::query(); if ($query) { $events->where('title', 'like', "%{$query}%")->orWhere('location', 'like', "%{$query}%"); } $events = $events->withCount('registrations')->paginate(10); Di view, ada form search dengan method GET yang mengirimkan parameter 'search' ke URL yang sama: <form method="GET" action="{{ route('events.index') }}"> dengan input name="search". Value input diisi dengan request()->input('search') agar tetap muncul setelah submit. Untuk mempertahankan pencarian di pagination, tambahkan appends(request()->query()) di links: {{ $events->appends(request()->query())->links() }}. Ini memastikan saat user pindah halaman, parameter search tetap ada di URL. Fitur search ada di semua halaman index untuk memudahkan pencarian data spesifik."

---

## 3. TIPS PRESENTASI

1. **Cek koneksi internet** dan pastikan server local bisa diakses sebelum presentasi. Jalankan php artisan serve 5 menit sebelum sesi dimulai.

2. **Buka browser dengan tab yang sudah di-load**: dashboard, events list, create event form (isi sebagian), participants list, registrations list. Ini menghemat waktu loading saat demo.

3. **Siapkan data dummy tambahan** untuk demo create/edit. Catat nama dan email yang sudah dipakai supaya tidak bentrok saat demo tambah data baru.

4. **Latihan script minimal 3 kali** sebelum hari H. Baca keras-keras di depan cermin atau rekam suara sendiri. Perhatikan intonasi dan timing.

5. **Bicaralah pelan dan jelas**, jangan terburu-buru. Lebih baik kurang materi daripada bicara terlalu cepat. Jeda 1-2 detik antar slide/poin penting.

6. **Jika ada error saat demo**, tetap tenang dan jelaskan apa yang terjadi. Kadang error bisa jadi bahan diskusi yang menarik dengan dosen. Jangan panik.

7. **Gunakan pointer mouse** untuk menunjuk elemen yang sedang dijelaskan di layar. Gerakan lambat dan jelas.

8. **Kontak mata** — jangan hanya membaca script. Lihat ke arah dosen dan audiens secara bergantian.

9. **Siapkan backup**: screenshot atau video demo singkat di laptop, kalau-kalau internet atau server bermasalah.

10. **Pakaian rapi dan sopan** sesuai aturan presentasi kampus. Kesan pertama penting.

---

## 4. FLOW PRESENTASI (CHEATSHEET)

| Waktu | Aktivitas | Halaman |
|-------|-----------|---------|
| 0-1 min | Pembukaan, salam, perkenalan | - |
| 1-2 min | Latar belakang masalah | - |
| 2-3 min | Demo Dashboard | /dashboard |
| 3-4 min | Demo CRUD Event | /events |
| 4-5 min | Demo CRUD Peserta | /participants |
| 5-6 min | Demo CRUD Registrasi | /registrations |
| 6-7 min | Edit & Delete | /events/1/edit, /registrations |
| 7-8 min | Penjelasan arsitektur MVC | Code (VSCode) |
| 8-9 min | Database & Relasi | Code + Database |
| 9-10 min | Penutup, kesimpulan | - |

---

## 5. KATA-KATA PENTING (GLOSARIUM PRESENTASI)

| Istilah | Arti |
|---------|------|
| MVC | Model View Controller — pola arsitektur yang memisahkan data, tampilan, dan logika |
| Eloquent ORM | Active Record ORM Laravel untuk interaksi database dengan objek PHP |
| Blade | Template engine Laravel dengan fitur layout, section, dan komponen |
| Migration | Version control untuk struktur database |
| Seeder | Pengisi data dummy ke database |
| Route | Definisi URL dan handler-nya |
| Controller | Penghubung antara route, model, dan view |
| Form Request | Kelas validasi terpisah di Laravel |
| Eager Loading | Teknik optimasi query relasi |
| Flash Message | Pesan notifikasi sekali tampil |
| Foreign Key | Kolom referensi antar tabel |
| Unique Constraint | Aturan data unik di database |
| Relationship | Relasi antar model Eloquent |
| Pagination | Pembagian data per halaman |
| Scaffolding | Pembuatan kode dasar otomatis |
| Middleware | Lapisan pemroses request sebelum mencapai controller |
| Service Provider | Tempat registrasi dan konfigurasi komponen Laravel |
| Facade | Antarmuka statis ke class di service container |
| Dependency Injection | Teknik menyediakan dependency dari luar, bukan dibuat sendiri |
| Request | Objek yang mewakili data HTTP request yang masuk |
| Response | Objek yang dikirim kembali ke client setelah request |
| View | File template Blade yang merender HTML |
| Route Model Binding | Auto-inject model berdasarkan parameter route |
| Soft Delete | Penghapusan data dengan tanda deleted_at |
| Mass Assignment | Pengisian banyak kolom sekaligus dengan array |
| CSRF Token | Token keamanan untuk mencegah serangan CSRF |
| Query Builder | Interface Laravel untuk membangun query database |
| Artisan CLI | Command line tool bawaan Laravel |

---

## 6. PERTANYAAN LANJUTAN (32-50)

### 32. Apa itu Middleware di Laravel?

"Middleware adalah lapisan filter yang memproses HTTP request sebelum mencapai controller atau setelah response keluar dari controller. Contoh middleware bawaan Laravel: auth (memastikan user sudah login), throttle (membatasi jumlah request per menit), dan EncryptCookies (mengenkripsi cookie). Di project ini saya belum menggunakan middleware kustom karena belum ada autentikasi. Tapi untuk production, middleware sangat penting. Cara membuat middleware: php artisan make:middleware CheckAdmin. Di handle method, kita tulis logika pengecekan. Daftarkan di Kernel.php, lalu aplikasikan ke route: Route::get('/admin', ...)->middleware('admin'). Middleware bisa diaplikasikan ke route group, prefix, atau controller."

### 33. Bagaimana Laravel mengelola session?

"Laravel menggunakan file-based session secara default. Session menyimpan data pengguna selama interaksi dengan aplikasi. Di project ini, session digunakan untuk flash message — data yang bertahan hanya untuk satu request. Laravel menyediakan berbagai session driver: file (default), cookie, database, redis, memcached, dan array (untuk testing). Konfigurasi session ada di config/session.php. Untuk mengakses session: session()->put('key', 'value'), session()->get('key'), session()->has('key'), session()->forget('key'), dan session()->flush(). Blade bisa mengakses session langsung: {{ session('key') }}. Session di Laravel aman karena data dienkripsi menggunakan APP_KEY."

### 34. Apa itu Service Container?

"Service Container adalah wadah yang mengelola dependency dan melakukan dependency injection secara otomatis di Laravel. Ketika kita type-hint suatu class di constructor atau method, Laravel secara otomatis akan meresolve class tersebut beserta semua dependency-nya. Contoh: jika RegistrationController membutuhkan EventRepository di constructor, Laravel akan otomatis membuat instance EventRepository dan menyuntikkannya. Service Container juga bisa digunakan untuk binding: $this->app->bind(EventRepositoryInterface::class, EventRepository::class). Ini memudahkan testing karena kita bisa mengganti implementasi dengan mock. Service Container adalah salah satu fitur paling powerful di Laravel yang membuat kode lebih modular dan testable."

### 35. Bagaimana Laravel menangani error?

"Laravel memiliki Handler di app/Exceptions/Handler.php yang menangani semua error. Untuk development, Laravel menampilkan error detail dengan Whoops. Untuk production, Laravel menampilkan halaman error yang ramah. Ada beberapa jenis error yang umum: ModelNotFoundException (404), MethodNotAllowedHttpException (salah HTTP method), QueryException (error database), ValidationException (validasi gagal), dan AuthenticationException (belum login). Di project ini, saya memastikan error handling dengan: findOrFail untuk data yang harus ada, validasi di Form Request untuk input user, try-catch di beberapa operasi kritis, dan custom 404 page jika diperlukan."

### 36. Apa itu Tinker?

"Tinker adalah REPL (Read-Eval-Print Loop) interaktif yang memungkinkan kita berinteraksi dengan aplikasi Laravel dari command line. Cukup jalankan php artisan tinker. Di dalam Tinker, kita bisa: Event::all() untuk melihat semua event, $event = Event::find(1); echo $event->title, Registration::where('event_id', 1)->count(), atau bahkan membuat data baru: Event::create(['title' => 'Test', ...]). Tinker sangat berguna untuk debugging cepat, menguji query, mengecek relasi, atau memperbaiki data tanpa perlu menulis kode di controller. Ini adalah tools favorit developer Laravel karena sangat mempercepat proses development dan debugging."

### 37. Apa perbedaan get() dan first()?

"get() mengembalikan koleksi berisi semua data yang cocok dengan query, bisa 0, 1, atau banyak data. Contoh: Event::where('status', 'upcoming')->get() mengembalikan Collection of Events. first() hanya mengembalikan satu data pertama yang cocok, atau null jika tidak ada. Contoh: Event::where('status', 'upcoming')->first() mengembalikan satu objek Event atau null. Ada juga find($id) untuk mencari berdasarkan primary key, findOrFail($id) yang melempar exception jika tidak ditemukan, dan firstOrFail() yang melempar exception jika tidak ada data. Perbedaan ini penting: get() selalu mengembalikan Collection (iterable), first() mengembalikan single object atau null."

### 38. Bagaimana cara membuat dropdown dinamis di form?

"Dropdown dinamis di form registrasi menggunakan data dari database. Di RegistrationController create method, saya mengirim data events dan participants ke view: $events = Event::where('status', '!=', 'completed')->get(); $participants = Participant::all(); return view('registrations.create', compact('events', 'participants')). Di Blade form: <select name="event_id" class="..."> <option value="">Pilih Event</option> @foreach($events as $event) <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}> {{ $event->title }} (Kuota: {{ $event->quota - $event->registrations_count }}/{{ $event->quota }}) </option> @endforeach </select>. Dropdown peserta serupa. old() digunakan untuk mengisi ulang nilai jika validasi gagal. Dropdown juga menampilkan sisa kuota untuk membantu admin memilih event yang masih tersedia."

### 39. Apa itu increment dan decrement di database?

"Laravel Eloquent menyediakan method increment() dan decrement() untuk mengupdate nilai numerik tanpa perlu select dulu. Contoh: Event::find(1)->increment('kuota_terisi') akan menambah kolom kuota_terisi sebesar 1. Ini ekuivalen dengan UPDATE events SET kuota_terisi = kuota_terisi + 1 WHERE id = 1. Method ini atomik di level database, jadi aman digunakan meskipun ada request bersamaan. Kita juga bisa menentukan besaran: increment('kuota_terisi', 5). Di project ini, untuk menghitung jumlah registrasi, saya menggunakan withCount('registrations') yang lebih sesuai karena data registrasi di tabel terpisah. Tapi jika kolom counter disimpan langsung di tabel events, increment/decrement adalah pilihan tepat."

### 40. Bagaimana cara mengatur urutan data di tabel?

"Ada beberapa cara. Default: data diurutkan berdasarkan created_at descending (terbaru di atas). Caranya: Event::latest()->paginate(10). latest() sama dengan orderBy('created_at', 'desc'). Kebalikannya: oldest(). Untuk urutan kustom: Event::orderBy('date', 'asc')->orderBy('title')->paginate(10). Bisa juga berdasarkan jumlah relasi: Event::withCount('registrations')->orderBy('registrations_count', 'desc')->paginate(10) — menampilkan event dengan registrasi terbanyak di atas. Di tabel view, saya juga menambahkan sorting visual dengan ikon panah di header kolom (belum interaktif klik, hanya statis). Untuk production, kita bisa membuat sorting interaktif dengan menangkap parameter sort dan direction dari query string."

### 41. Apa itu Collection di Laravel?

"Collection adalah class wrapper Laravel untuk array yang menyediakan method-method powerful untuk memanipulasi data. Ketika kita menggunakan get() pada query Eloquent, hasilnya adalah Collection (bukan array biasa). Collection punya method seperti: filter() untuk menyaring data, map() untuk mengubah setiap item, pluck() untuk mengambil kolom tertentu, sum()/avg()/count() untuk agregasi, sortBy()/sortByDesc() untuk mengurutkan, groupBy() untuk mengelompokkan, chunk() untuk membagi data, each() untuk iterasi, contains() untuk mengecek keberadaan, dan toArray()/toJson() untuk konversi. Contoh: $activeRegistrations = Registration::with('event')->get()->filter(fn($reg) => $reg->event->status === 'ongoing'). Collection membuat manipulasi data lebih ekspresif dan mengurangi loop manual."

### 42. Bagaimana Blade @section dan @yield bekerja?

"Blade menggunakan sistem layout inheritance. Di layouts/app.blade.php, kita mendefinisikan struktur HTML utama: <html><head><title>@yield('title')</title></head><body>@include('partials.navigation') @yield('content') @stack('scripts')</body></html>. @yield('title') adalah placeholder yang akan diisi oleh halaman anak. @yield('content') adalah area utama konten. @stack('scripts') adalah area untuk menambahkan script dari halaman anak. Di halaman spesifik seperti events/index.blade.php: @extends('layouts.app') @section('title', 'Daftar Events') @section('content') ...konten halaman... @endsection @push('scripts') <script>...custom js...</script> @endpush. @extends menandai bahwa halaman ini menggunakan layout app. @section/@endsection mengisi placeholder @yield. @push/@endpush menambahkan ke stack. Sistem ini membuat semua halaman konsisten tanpa duplikasi HTML."

### 43. Apa itu dd() dan dump()?

"dd() adalah function debugging Laravel yang sangat berguna — kependekan dari Dump and Die. dd($variable) akan menampilkan isi variable dengan format rapi (menggunakan Symfony VarDumper), lalu menghentikan eksekusi script. Contoh: dd($events) akan menampilkan semua data events dalam format tree yang interaktif. dump() mirip tapi tidak menghentikan eksekusi — berguna untuk debugging di tengah-tengah proses. Di development, saya sering menggunakan dd() untuk: melihat isi request: dd($request->all()), memeriksa hasil query: dd(Event::with('registrations')->get()->toArray()), mengecek isi variable di controller, atau debug loop. Penting: jangan lupa hapus dd() sebelum push ke production karena akan menghentikan aplikasi."

### 44. Bagaimana cara validasi unique di update?

"Validasi unique untuk create dan update berbeda. Saat create, rule: 'email' => 'required|email|unique:participants,email'. Saat update, kita harus mengecualikan data yang sedang diedit. Form Request bisa mendeteksi method HTTP. Implementasi: di ParticipantUpdateRequest: public function rules() { return [ 'email' => 'required|email|unique:participants,email,' . $this->route('participant'), ]; }. Parameter ketiga unique adalah ID yang dikecualikan. $this->route('participant') mengambil ID dari Route Model Binding. Jadi saat update participant ID 5, email 'faiz@test.com' akan dicek unique di tabel participants, tapi mengecualikan ID 5. Ini memungkinkan user menyimpan data tanpa harus mengganti email."

### 45. Apa itu database seeder dan urutan panggilannya?

"Database seeder mengisi data awal. Urutan panggilan di DatabaseSeeder.php penting karena relasi. Saya urutkan: $this->call(EventSeeder::class) dulu, lalu $this->call(ParticipantSeeder::class), baru $this->call(RegistrationSeeder::class). Kenapa? Karena registrasi membutuhkan event_id dan participant_id yang sudah ada. Jika RegistrationSeeder dipanggil duluan, akan error foreign key constraint. Event dan Participant tidak saling tergantung, jadi bisa sejajar. Setiap seeder menggunakan Factory untuk generate data: Event::factory(20)->create(), Participant::factory(30)->create(). RegistrationSeeder membuat 50 registrasi acak dengan mengambil event dan participant yang sudah ada. Data seeder harus realistis — gunakan konteks kampus seperti seminar, workshop, lomba."

### 46. Bagaimana tampilan responsif dengan Tailwind?

"Tailwind CSS menggunakan breakpoint prefix untuk responsivitas: sm (640px), md (768px), lg (1024px), xl (1280px), 2xl (1536px). Contoh di tabel: <div class="overflow-x-auto"> untuk scroll horizontal di layar kecil. Grid: <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"> — di mobile 1 kolom, tablet 2 kolom, desktop 4 kolom. Navbar: <nav class="flex flex-col md:flex-row"> — di mobile vertikal, di desktop horizontal. Form: <div class="flex flex-col sm:flex-row sm:space-x-4">. Dashboard cards: <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">. Tailwind juga memiliki utility untuk padding responsif: p-4 md:p-6 lg:p-8. Dengan pendekatan mobile-first ini, website bisa diakses dengan baik di laptop, tablet, maupun HP."

### 47. Bagaimana cara menampilkan data dengan format rupiah?

"Meskipun project ini belum menggunakan rupiah (event biasanya gratis), kita bisa menggunakan helper number_format. Di Blade: {{ number_format($event->biaya, 0, ',', '.') }} untuk menampilkan 50000 sebagai Rp 50.000. Atau buat helper kustom di app/Helpers/CurrencyHelper.php: function rupiah($angka) { return 'Rp ' . number_format($angka, 0, ',', '.'); }. Daftarkan helper di composer.json autoload files. Di Blade: {{ rupiah($event->biaya) }}. Untuk project yang lebih serius, gunakan package seperti laravel-money atau formatting sesuai locale Indonesia. Untuk biaya atau budget event, format rupiah sangat penting agar user tidak bingung dengan angka besar."

### 48. Bagaimana cara backup database SQLite?

"Backup SQLite sangat sederhana karena database hanya satu file. Cukup copy file database.sqlite ke lokasi aman: cp database/database.sqlite database/backup-$(date +%Y%m%d).sqlite. Untuk restore, tinggal copy balik. Bisa juga menggunakan Laravel backup package seperti spatie/laravel-backup yang bisa backup database dan file ke cloud storage. Untuk scheduling backup otomatis di Laravel: $schedule->command('backup:run')->daily()->at('02:00'). Pastikan file database.sqlite tidak di-commit ke Git (sudah di .gitignore). Di Render, karena filesystem ephemeral, backup harus disimpan ke external storage seperti Amazon S3, Google Drive, atau Dropbox."

### 49. Apa yang dimaksud dengan composer?

"Composer adalah dependency manager untuk PHP. Composer mengelola library dan package yang dibutuhkan project. File composer.json mendefinisikan dependensi project. Contoh untuk Laravel: "require": { "php": "^8.1", "laravel/framework": "^10.0", "laravel/tinker": "^2.8" }. composer install membaca composer.lock dan menginstall package beserta dependency-nya. composer update mengupdate ke versi terbaru. composer require <package> menambah package baru. Autoloading PSR-4 juga dikelola Composer — namespace di folder app/ bisa langsung digunakan tanpa require manual. Composer adalah tools fundamental dalam ekosistem PHP modern."

### 50. Apa itu NPM dan Vite di Laravel?

"NPM (Node Package Manager) mengelola package JavaScript seperti Tailwind CSS, Alpine.js, dan library frontend lainnya. Vite adalah build tool modern yang digunakan Laravel sejak versi 9 untuk menggantikan Laravel Mix (Webpack). Vite menawarkan hot module replacement (HMR) — perubahan di file CSS/JS langsung terlihat di browser tanpa reload. Di project ini, Tailwind CSS diinstall via NPM dan dikonfigurasi di tailwind.config.js. Perintah npm run dev menjalankan Vite development server. npm run build mem-build asset untuk production. File yang di-build ada di public/assets/. Vite lebih cepat dari Webpack karena menggunakan native ES modules dan esbuild untuk transpiling."

---

## 7. SKENARIO DEMO LENGKAP

Skenario berikut bisa digunakan sebagai panduan saat demo langsung:

**Skenario 1: Membuat Event Baru**
1. Buka halaman Events → klik Add Event
2. Isi judul: "Workshop Laravel untuk Pemula"
3. Deskripsi: "Workshop gratis selama 2 hari"
4. Tanggal: pilih +2 minggu dari hari ini
5. Lokasi: "Gedung Serbaguna Lt. 3"
6. Kuota: 50
7. Status: Upcoming
8. Submit → lihat alert sukses

**Skenario 2: Mendaftarkan Peserta**
1. Buka halaman Participants → Add Participant
2. Nama: "Budi Santoso", Email: "budi@mail.com", Telepon: "08123456789"
3. Submit → sukses
4. Buka Registrations → New Registration
5. Pilih event Workshop, pilih Budi Santoso
6. Submit → sukses
7. Coba daftarkan Budi lagi ke event yang sama → error duplikat

**Skenario 3: Update Status Event**
1. Buka detail event yang sudah lewat tanggalnya
2. Klik Edit → ubah status jadi Completed
3. Simpan → kembali ke dashboard, lihat perubahan statistik

**Skenario 4: Hapus Data**
1. Buka tabel registrasi
2. Klik Hapus registrasi pertama
3. Konfirmasi dialog → Ya
4. Data hilang, lihat statistik berubah

---

## 8. PERSIAPAN TEKNIS PRESENTASI

1. **5 menit sebelum presentasi**: jalankan php artisan serve
2. **Buka browser dengan tab**: Dashboard, Events (index + create), Participants, Registrations
3. **Siapkan terminal split**: 1 panel untuk server, 1 panel untuk tinker (debug cadangan)
4. **Data dummy yang sudah siap**: 10 event (various statuses), 15 participants, 25 registrations
5. **Catat ID data** yang akan di-edit dan dihapus supaya tau pasti alamat URL-nya
6. **Siapkan screenshot/video** sebagai backup kalau server error
7. **Pastikan volume laptop** cukup keras atau siapkan microphone eksternal
8. **Tutup aplikasi lain** yang tidak perlu untuk menghemat RAM dan fokus

---

*Dokumen ini disusun oleh Faiz Abdurrachman — 241111021*
*Tugas: Framework PHP dan CRUD — Event Management System*
*Sistem Informasi, Fakultas Rekayasa Industri dan Informatika*

---

## 6. ANTISIPASI ERROR SAAT DEMO

### Error: Halaman 404
"Seperti yang teman-teman lihat, muncul halaman 404. Ini terjadi karena data yang dicari mungkin sudah dihapus atau ID-nya tidak valid. Laravel secara otomatis menangani ini dengan Route Model Binding. Kita tinggal klik tombol navigasi di browser untuk kembali."

### Error: Validasi Gagal
"Ini menunjukkan bahwa validasi di sisi server berjalan dengan baik. Form Request di Laravel memastikan semua data masuk sesuai aturan sebelum diproses. Error merah di bawah field ini spesifik menunjukkan field mana yang perlu diperbaiki."

### Error: Database Error
"Error ini muncul karena constraint di database. Misalnya kita coba menghapus event yang masih memiliki registrasi — database akan menolak karena ada foreign key constraint. Ini adalah fitur keamanan data, bukan bug."

### Error: White Screen / 500 Server Error
"Kadang ada error yang tidak tertangani dengan baik. Di development, kita bisa lihat detail errornya di file storage/logs/laravel.log. Untuk presentasi, kita bisa restart server dengan php artisan serve."

---

## 7. SKENARIO DEMO CADANGAN (JIKA WAKTU KURANG)

### Skenario Cepat (5 menit)
Jika waktu tinggal 5 menit, fokus hanya pada:
1. Dashboard — tunjukkan 4 kartu statistik (30 detik)
2. Events — buka halaman, tunjukkan tabel + search (1 menit)
3. Registrations — tunjukkan tabel + buat registrasi baru (2 menit)
4. Code — tunjukkan struktur folder dan model (1 menit)
5. Penutup — kesimpulan 1 kalimat (30 detik)

### Skenario Darurat (Jika Server Mati)
Jika server benar-benar tidak bisa diakses:
1. Buka file screenshot yang sudah disiapkan
2. Jelaskan alur aplikasi dari kode di VSCode
3. Fokus ke penjelasan arsitektur MVC, Eloquent, dan Migration
4. Tunjukkan kode controller dan model langsung dari IDE

### Skenario Kelebihan Waktu
Jika dosen meminta tambahan waktu atau sesi tanya jawab panjang:
1. Siapkan 3 pertanyaan cadangan untuk dibahas: "Apa yang membedakan aplikasi ini dengan aplikasi CRUD biasa?"
2. Tunjukkan fitur unique constraint dengan demo langsung
3. Buka php artisan tinker dan demonstrasikan query Eloquent secara langsung di terminal

---

## 8. DAFTAR PERIKSA SEBELUM PRESENTASI

H-3:
- [ ] Script selesai ditulis dan sudah dihafalkan alur utamanya
- [ ] Slide/PDF pendamping sudah jadi (jika diperlukan)
- [ ] Aplikasi sudah di-deploy ke Render dan bisa diakses dari HP

H-1:
- [ ] Jalankan php artisan migrate:fresh --seed untuk data terbaru
- [ ] Test semua fitur: create, edit, delete, search, pagination
- [ ] Screenshot tiap halaman sebagai backup
- [ ] Rekam video demo singkat (2-3 menit)

H-0 (30 menit sebelum):
- [ ] Nyalakan laptop, buka project di VSCode
- [ ] Jalankan php artisan serve
- [ ] Buka browser dengan tab yang sudah di-load
- [ ] Tutup aplikasi yang tidak perlu (chat, social media)
- [ ] Siapkan air minum di meja
- [ ] Buka script presentasi di monitor kedua atau print-out

---

## 9. SCRIPT JAWABAN UNTUK PERTANYAAN SULIT

### "Apa bedanya aplikasi ini dengan Google Form?"
"Google Form memang bisa digunakan untuk pendaftaran event, tetapi tidak memiliki integrasi data yang terkait. Di Google Form, data pendaftar dan event terpisah — kita harus merekonsiliasi manual. Di sistem ini, event, peserta, dan registrasi saling terhubung dengan foreign key. Kita bisa melihat daftar peserta suatu event dalam satu klik, menghitung jumlah pendaftar otomatis, mencegah duplikasi, dan menampilkan statistik real-time. Intinya, Google Form hanya untuk input data, sedangkan sistem ini adalah data management system yang terintegrasi."

### "Kenapa tidak pakai Wordpress saja?"
"Wordpress dengan plugin seperti Event Manager atau The Events Calendar memang bisa membuat sistem event. Tapi untuk tujuan pembelajaran Framework PHP dan CRUD, kita perlu memahami konsep fundamental seperti MVC, ORM, routing, dan validasi dari awal. Wordpress sudah menyembunyikan semua kompleksitas ini. Dengan Laravel, kita benar-benar menulis setiap layer aplikasi dari nol, sehingga pemahaman kita tentang web development menjadi lebih dalam."

### "Apa yang terjadi kalau 1000 orang mendaftar bersamaan?"
"Ini pertanyaan bagus tentang konkurensi. Dalam kondisi skala kecil seperti demo ini, request diproses secara berurutan oleh PHP. Tapi untuk 1000 request bersamaan, kita perlu beberapa optimasi: (1) pindah dari SQLite ke MySQL yang support concurrent writes, (2) implementasikan queue dengan Redis untuk menulis registrasi secara antrean, (3) gunakan database transaction dengan locking untuk mencegah race condition pada kuota event. Di production, kita juga bisa menggunakan load balancer di depan beberapa server Laravel."

### "Apakah kode ini aman untuk production?"
"Kode ini memiliki dasar keamanan yang baik: CSRF protection, SQL injection prevention via Eloquent, XSS protection via Blade escaping, dan validasi input via Form Request. Tapi untuk production, masih perlu ditambahkan: autentikasi (login), otorisasi (role-based access), HTTPS enforcement, rate limiting untuk mencegah brute force, dan environment-specific configuration. Secara arsitektur sudah siap, tinggal menambahkan lapisan keamanan di atasnya."

### "Menurut kamu, bagian code mana yang paling elegant?"
"Menurut saya bagian yang paling elegant adalah penggunaan Eloquent Relationship dan Route Model Binding. Contohnya, di method show RegistrationController, kita cukup tulis 'return view('registrations.show', compact('registration'))' dan Laravel otomatis mengambil data registrasi dengan event dan participant terkait. Atau di model Event, dengan menambahkan 'registrations_count' menggunakan withCount, kita bisa menampilkan jumlah pendaftar tanpa query tambahan. Ini menunjukkan kekuatan ORM dalam menyederhanakan operasi database yang kompleks."

---

## 10. GLOSARIUM TEKNIS LENGKAP

### Istilah Framework
| Istilah | Penjelasan Singkat |
|---------|-------------------|
| Namespace | Cara PHP mengorganisir kode untuk menghindari konflik nama kelas |
| Dependency Injection | Teknik memberikan dependensi ke kelas dari luar, bukan membuatnya di dalam |
| Service Provider | Tempat registrasi dan konfigurasi service di Laravel |
| Facade | Interface statis ke service di container Laravel |
| Contract | Interface yang mendefinisikan kontrak service Laravel |
| Middleware | Filter HTTP request sebelum mencapai controller |
| Request Lifecycle | Alur hidup request dari masuk sampai response dikirim |

### Istilah Database
| Istilah | Penjelasan Singkat |
|---------|-------------------|
| Primary Key | Kolom unik yang mengidentifikasi setiap baris tabel |
| Foreign Key | Kolom yang merujuk ke primary key tabel lain |
| Composite Key | Gabungan beberapa kolom sebagai key |
| Index | Struktur data untuk mempercepat pencarian |
| Constraint | Aturan yang memastikan integritas data |
| Migration | File PHP yang mendefinisikan perubahan struktur database |
| Seeder | Kelas untuk mengisi data awal ke database |
| Query Builder | Interface Laravel untuk membangun query SQL secara programatik |

### Istilah Frontend
| Istilah | Penjelasan Singkat |
|---------|-------------------|
| Blade | Template engine Laravel |
| Tailwind CSS | Utility-first CSS framework |
| Responsive Design | Tampilan yang menyesuaikan ukuran layar |
| CDN | Content Delivery Network untuk memuat library dari server terdekat |
| Asset | File statis seperti CSS, JavaScript, gambar |
| Vite | Build tool modern untuk frontend asset |

---

## 11. TIMELINE PENGEMBANGAN PROJECT

| Fase | Waktu | Aktivitas |
|------|-------|-----------|
| Planning | Hari 1-2 | Analisis kebutuhan, desain database, buat daftar fitur |
| Setup | Hari 3 | Install Laravel, konfigurasi database, setup Tailwind |
| Model & Migration | Hari 4-5 | Buat 3 model + migration + seeder |
| CRUD Event | Hari 6-8 | Route, Controller, View untuk Events |
| CRUD Participant | Hari 9-10 | Route, Controller, View untuk Participants |
| CRUD Registration | Hari 11-13 | Route, Controller, View untuk Registrations |
| Dashboard | Hari 14-15 | Kartu statistik, tabel terbaru, progress bar |
| Validasi | Hari 16-17 | Form Request validation, error handling |
| Polish | Hari 18-19 | Search, pagination, flash message, UI refinement |
| Testing & Deploy | Hari 20 | Test semua fitur, fix bug, deploy ke Render |
| Dokumentasi | Hari 21 | Siapkan DOKUMENTASI.md, SCRIPT_PRESENTASI.md |

---

*Total baris dokumen: 500+ baris*
*Disusun untuk keperluan presentasi tugas mata kuliah Framework PHP dan CRUD*
