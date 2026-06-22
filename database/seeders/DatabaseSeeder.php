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
        User::create([
            'name' => 'Admin EMS',
            'email' => 'admin@ems.test',
            'password' => bcrypt('password'),
        ]);

        $categories = ['Workshop', 'Seminar', 'Lomba', 'Pameran', 'Career Fair', 'Pelatihan', 'Hackathon'];
        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }


        $events = [
            [
                'title' => 'Workshop Web Development',
                'description' => 'Belajar membuat aplikasi web modern menggunakan Laravel dan Tailwind CSS. Cocok untuk pemula hingga intermediate.',
                'event_date' => '2026-07-15 09:00:00',
                'location' => 'Lab Komputer A, Gedung Teknik',
                'quota' => 30,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Seminar Cyber Security',
                'description' => 'Membahas tren terbaru keamanan siber, etika hacking, dan praktik terbaik melindungi data.',
                'event_date' => '2026-07-20 13:00:00',
                'location' => 'Auditorium Utama',
                'quota' => 100,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Lomba Debat Bahasa Inggris',
                'description' => 'Kompetisi debat antar fakultas menggunakan bahasa Inggris dengan tema teknologi dan pendidikan.',
                'event_date' => '2026-06-25 08:00:00',
                'location' => 'Ruang Seminar Lantai 3',
                'quota' => 20,
                'status' => 'completed',
            ],
            [
                'title' => 'Pameran Proyek Mahasiswa',
                'description' => 'Pamerkan proyek akhir semester kalian. Terbuka untuk seluruh jurusan.',
                'event_date' => '2026-08-05 10:00:00',
                'location' => 'Lobby Utama Kampus',
                'quota' => 50,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Pelatihan Public Speaking',
                'description' => 'Tingkatkan kemampuan berbicara di depan umum dengan coach profesional.',
                'event_date' => '2026-08-12 09:00:00',
                'location' => 'Ruang 401, Gedung Serbaguna',
                'quota' => 25,
                'status' => 'upcoming',
            ],
            [
                'title' => 'Hackathon 2026',
                'description' => 'Kompetisi coding 24 jam. Bangun solusi inovatif untuk masalah nyata.',
                'event_date' => '2026-06-10 07:00:00',
                'location' => 'Lab Komputer B & C',
                'quota' => 60,
                'status' => 'completed',
            ],
            [
                'title' => 'Career Fair Kampus',
                'description' => 'Temuilah recruiter dari 20+ perusahaan teknologi ternama. Bawa CV terbaikmu!',
                'event_date' => '2026-09-01 09:00:00',
                'location' => 'Lapangan Parkir Utama',
                'quota' => 200,
                'status' => 'upcoming',
            ],
        ];

        foreach ($events as $data) {
            Event::create($data);
        }

        $participants = [
            ['name' => 'Andi Pratama', 'email' => 'andi@student.edu', 'phone' => '081234567890'],
            ['name' => 'Bunga Lestari', 'email' => 'bunga@student.edu', 'phone' => '081234567891'],
            ['name' => 'Citra Dewi', 'email' => 'citra@student.edu', 'phone' => '081234567892'],
            ['name' => 'Dimas Ardiansyah', 'email' => 'dimas@student.edu', 'phone' => '081234567893'],
            ['name' => 'Eka Putri', 'email' => 'eka@student.edu', 'phone' => '081234567894'],
            ['name' => 'Fajar Nugroho', 'email' => 'fajar@student.edu', 'phone' => '081234567895'],
            ['name' => 'Gina Amelia', 'email' => 'gina@student.edu', 'phone' => '081234567896'],
            ['name' => 'Hendra Setiawan', 'email' => 'hendra@student.edu', 'phone' => '081234567897'],
            ['name' => 'Intan Permatasari', 'email' => 'intan@student.edu', 'phone' => '081234567898'],
            ['name' => 'Joko Widodo Jr.', 'email' => 'joko@student.edu', 'phone' => '081234567899'],
            ['name' => 'Karina Safira', 'email' => 'karina@student.edu', 'phone' => '081234567800'],
            ['name' => 'Lutfi Hakim', 'email' => 'lutfi@student.edu', 'phone' => '081234567801'],
            ['name' => 'Maya Sari', 'email' => 'maya@student.edu', 'phone' => '081234567802'],
            ['name' => 'Nico Pratomo', 'email' => 'nico@student.edu', 'phone' => '081234567803'],
            ['name' => 'Olivia Putri', 'email' => 'olivia@student.edu', 'phone' => '081234567804'],
        ];

        foreach ($participants as $data) {
            Participant::create($data);
        }

        $registrations = [
            ['event_id' => 1, 'participant_id' => 1],
            ['event_id' => 1, 'participant_id' => 2],
            ['event_id' => 1, 'participant_id' => 3],
            ['event_id' => 1, 'participant_id' => 4],
            ['event_id' => 2, 'participant_id' => 1],
            ['event_id' => 2, 'participant_id' => 5],
            ['event_id' => 2, 'participant_id' => 6],
            ['event_id' => 2, 'participant_id' => 7],
            ['event_id' => 2, 'participant_id' => 8],
            ['event_id' => 3, 'participant_id' => 1],
            ['event_id' => 3, 'participant_id' => 2],
            ['event_id' => 3, 'participant_id' => 9],
            ['event_id' => 3, 'participant_id' => 10],
            ['event_id' => 4, 'participant_id' => 3],
            ['event_id' => 4, 'participant_id' => 5],
            ['event_id' => 4, 'participant_id' => 11],
            ['event_id' => 5, 'participant_id' => 2],
            ['event_id' => 5, 'participant_id' => 6],
            ['event_id' => 5, 'participant_id' => 12],
            ['event_id' => 6, 'participant_id' => 1],
            ['event_id' => 6, 'participant_id' => 3],
            ['event_id' => 6, 'participant_id' => 5],
            ['event_id' => 6, 'participant_id' => 7],
            ['event_id' => 6, 'participant_id' => 9],
            ['event_id' => 6, 'participant_id' => 13],
            ['event_id' => 6, 'participant_id' => 14],
            ['event_id' => 6, 'participant_id' => 15],
            ['event_id' => 7, 'participant_id' => 4],
            ['event_id' => 7, 'participant_id' => 8],
            ['event_id' => 7, 'participant_id' => 10],
        ];

        foreach ($registrations as $data) {
            Registration::create($data);
        }
    }
}
