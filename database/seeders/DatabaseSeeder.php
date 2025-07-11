<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Data;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'role' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123'),
        ]);


        $dataKaryawan = [
            ['nama' => 'Ahmad Budi', 'jabatan' => 'Kantor', 'nim' => '20230001', 'alamat' => 'Jl. Sudirman No.15, Palembang'],
            ['nama' => 'Siti Aminah', 'jabatan' => 'Kantor', 'nim' => '20230002', 'alamat' => 'Jl. Jendral Sudirman No.32, Palembang'],
            ['nama' => 'Joko Santoso', 'jabatan' => 'Lapangan', 'nim' => '20230003', 'alamat' => 'Jl. Alang-Alang Lebar No.55, Palembang'],
            ['nama' => 'Rina Saraswati', 'jabatan' => 'Kantor', 'nim' => '20230004', 'alamat' => 'Jl. Suka Maju No.20, Palembang'],
            ['nama' => 'Dedi Ruslan', 'jabatan' => 'Lapangan', 'nim' => '20230005', 'alamat' => 'Jl. Agung No.7, Palembang'],
            ['nama' => 'Nani Oktaviani', 'jabatan' => 'Kantor', 'nim' => '20230006', 'alamat' => 'Jl. Mahakam No.8, Palembang'],
            ['nama' => 'Rizal Anwar', 'jabatan' => 'Lapangan', 'nim' => '20230007', 'alamat' => 'Jl. Kolonel Atmo No.14, Palembang'],
            ['nama' => 'Tia Sari', 'jabatan' => 'Kantor', 'nim' => '20230008', 'alamat' => 'Jl. Raden Fatah No.2, Palembang'],
            ['nama' => 'Budi Santosa', 'jabatan' => 'Lapangan', 'nim' => '20230009', 'alamat' => 'Jl. Komjen Pol. M. Kasman No.15, Palembang'],
            ['nama' => 'Wati Fitria', 'jabatan' => 'Kantor', 'nim' => '20230010', 'alamat' => 'Jl. Pahlawan No.6, Palembang'],
            ['nama' => 'Eko Prasetyo', 'jabatan' => 'Lapangan', 'nim' => '20230011', 'alamat' => 'Jl. Basuki Rahmat No.11, Palembang'],
            ['nama' => 'Lina Maulina', 'jabatan' => 'Kantor', 'nim' => '20230012', 'alamat' => 'Jl. Palembang No.31, Palembang'],
            ['nama' => 'Taufik Hidayat', 'jabatan' => 'Lapangan', 'nim' => '20230013', 'alamat' => 'Jl. M. Noor No.23, Palembang'],
            ['nama' => 'Mira Septiani', 'jabatan' => 'Kantor', 'nim' => '20230014', 'alamat' => 'Jl. Veteran No.18, Palembang'],
            ['nama' => 'Andi Wibawa', 'jabatan' => 'Lapangan', 'nim' => '20230015', 'alamat' => 'Jl. Diponegoro No.40, Palembang'],
            ['nama' => 'Citra Herawati', 'jabatan' => 'Kantor', 'nim' => '20230016', 'alamat' => 'Jl. Taman No.9, Palembang'],
            ['nama' => 'Rudi Hartono', 'jabatan' => 'Lapangan', 'nim' => '20230017', 'alamat' => 'Jl. Raya No.5, Palembang'],
            ['nama' => 'Nia Anjani', 'jabatan' => 'Kantor', 'nim' => '20230018', 'alamat' => 'Jl. Budi Utomo No.17, Palembang'],
            ['nama' => 'Hendra Setiawan', 'jabatan' => 'Lapangan', 'nim' => '20230019', 'alamat' => 'Jl. H. M. Rasjidi No.28, Palembang'],
            ['nama' => 'Tita Nurul', 'jabatan' => 'Kantor', 'nim' => '20230020', 'alamat' => 'Jl. Citra No.12, Palembang'],
            ['nama' => 'Arif Rahman', 'jabatan' => 'Lapangan', 'nim' => '20230021', 'alamat' => 'Jl. Hang Tuah No.36, Palembang'],
            ['nama' => 'Fitriani Maesaroh', 'jabatan' => 'Kantor', 'nim' => '20230022', 'alamat' => 'Jl. Kertanegara No.9, Palembang'],
        ];

        DB::table('karyawans')->insert($dataKaryawan);


        $kriteria = [
            [
                'nama' => 'Absen',
                'bobot' => '25',
                'keterangan' => 'Benefit'
            ],
            [
                'nama' => 'Tanggung Jawab',
                'bobot' => '20',
                'keterangan' => 'Benefit'
            ],
            [
                'nama' => 'Kepemimpinan',
                'bobot' => '15',
                'keterangan' => 'Benefit'
            ],
            [
                'nama' => 'Produktivitas',
                'bobot' => '15',
                'keterangan' => 'Benefit'
            ],
            [
                'nama' => 'Laporan Kegiatan',
                'bobot' => '10',
                'keterangan' => 'Benefit'
            ],
            [
                'nama' => 'Sikap',
                'bobot' => '10',
                'keterangan' => 'Benefit'
            ],
            [
                'nama' => 'Gotong Royong',
                'bobot' => '5',
                'keterangan' => 'Benefit'
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create([
                'nama' => $k['nama'],
                'bobot' => $k['bobot'],
                'keterangan' => $k['keterangan'],
            ]);
        }


        $subKriteria = [
            [
                'kriteria_id' => 1,
                'nama' => 'Kehadiran',
                'bobot' => 50,
                'penilaian' => json_encode([
                    ["rentang" => "Hadir > 90%", "skor" => 3],
                    ["rentang" => "Hadir 75% - 90%", "skor" => 2],
                    ["rentang" => "Hadir < 75%", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Keterlambatan',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "<2X", "skor" => 3],
                    ["rentang" => "2-4X", "skor" => 2],
                    ["rentang" => ">4X", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 1,
                'nama' => 'Izin',
                'bobot' => 20,
                'penilaian' => json_encode([
                    ["rentang" => "Tidak Pernah", "skor" => 3],
                    ["rentang" => "1-5x izin dengan keterangan", "skor" => 2],
                    ["rentang" => ">4x izin/tanpa keterangan", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Penyelesaian Tugas',
                'bobot' => 50,
                'penilaian' => json_encode([
                    ["rentang" => "Menyelesaikan semua tugas tepat waktu dan sesuai instruksi", "skor" => 3],
                    ["rentang" => "Menyelesaikan sebagian besar tugas tepat waktu", "skor" => 2],
                    ["rentang" => "Tidak menyelesaikan tugas atau sering terlambat", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Kualitas Kerja',
                'bobot' => 25,
                'penilaian' => json_encode([
                    ["rentang" => "Kualitas kerja baik, sangat sedikit atau tidak ada kesalahan", "skor" => 3],
                    ["rentang" => "Kualitas kerja cukup, beberapa kesalahan", "skor" => 2],
                    ["rentang" => "Kualitas kerja buruk, banyak kesalahan", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 2,
                'nama' => 'Inisiatif',
                'bobot' => 25,
                'penilaian' => json_encode([
                    ["rentang" => "Sering menunjukkan inisiatif", "skor" => 3],
                    ["rentang" => "Kadang-kadang menunjukkan inisiatif", "skor" => 2],
                    ["rentang" => "Tidak pernah menunjukkan inisiatif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Pengambilan Keputusan',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu mampu mengambil keputusan yang efektif", "skor" => 3],
                    ["rentang" => "Kadang-kadang mampu mengambil keputusan yang efektif", "skor" => 2],
                    ["rentang" => "Tidak mampu mengambil keputusan yang efektif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Komunikasi',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu mampu berkomunikasi dengan jelas dan efektif", "skor" => 3],
                    ["rentang" => "Kadang-kadang mampu berkomunikasi dengan jelas dan efektif", "skor" => 2],
                    ["rentang" => "Kurang mampu berkomunikasi dengan jelas dan efektif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 3,
                'nama' => 'Pemecahan Masalah',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu mampu memecahkan masalah dengan baik", "skor" => 3],
                    ["rentang" => "Kadang-kadang mampu memecahkan masalah dengan baik", "skor" => 2],
                    ["rentang" => "Tidak mampu memecahkan masalah dengan baik", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Efisiensi Waktu',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu efisien dan tidak terganggu", "skor" => 3],
                    ["rentang" => "Kadang-kadang efisien, tetapi sering mengalami gangguan", "skor" => 2],
                    ["rentang" => "Sering membuang waktu atau tidak efisien", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Ketepatan Waktu',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu tepat waktu dan memenuhi tenggat waktu", "skor" => 3],
                    ["rentang" => "Kadang-kadang tepat waktu, tetapi ada kasus telat", "skor" => 2],
                    ["rentang" => "Sering telat atau tidak menepati tenggat waktu", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 4,
                'nama' => 'Kreativitas',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu memberikan ide kreatif dan inovatif", "skor" => 3],
                    ["rentang" => "Kadang-kadang memberikan ide kreatif", "skor" => 2],
                    ["rentang" => "Tidak pernah memberikan ide kreatif atau inovatif", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Kelengkapan Laporan',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Lengkap, semua informasi yang diperlukan ada", "skor" => 3],
                    ["rentang" => "Cukup lengkap, namun masih kurang beberapa informasi penting", "skor" => 2],
                    ["rentang" => "Tidak lengkap, banyak informasi yang hilang", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Pengumpulan Laporan Tepat Waktu',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu tepat waktu dalam pengumpulan laporan", "skor" => 3],
                    ["rentang" => "Kadang-kadang tepat waktu, namun sering terlambat", "skor" => 2],
                    ["rentang" => "Sering terlambat mengumpulkan laporan", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 5,
                'nama' => 'Kejelasan Laporan',
                'bobot' => 30,
                'penilaian' => json_encode([
                    ["rentang" => "Sangat jelas, mudah dipahami", "skor" => 3],
                    ["rentang" => "Cukup jelas, tetapi masih memerlukan penjelasan lebih lanjut", "skor" => 2],
                    ["rentang" => "Tidak jelas, sulit dipahami", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 6,
                'nama' => 'Respon terhadap Kritik',
                'bobot' => 60,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu menerima kritik dengan baik", "skor" => 3],
                    ["rentang" => "Kadang-kadang menerima kritik dengan baik", "skor" => 2],
                    ["rentang" => "Tidak menerima kritik dengan baik", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 6,
                'nama' => 'Etika',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Etika sangat baik", "skor" => 3],
                    ["rentang" => "Etika cukup baik", "skor" => 2],
                    ["rentang" => "Etika kurang baik", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 7,
                'nama' => 'Tanggung Jawab',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu bertanggung jawab bersama", "skor" => 3],
                    ["rentang" => "Kadang-kadang bertanggung jawab bersama", "skor" => 2],
                    ["rentang" => "Kurang bertanggung jawab bersama", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 7,
                'nama' => 'Partisipasi Aktif',
                'bobot' => 40,
                'penilaian' => json_encode([
                    ["rentang" => "Selalu aktif dalam kegiatan kantor", "skor" => 3],
                    ["rentang" => "Kadang-kadang aktif dalam kegiatan kantor", "skor" => 2],
                    ["rentang" => "Tidak aktif dalam kegiatan kantor", "skor" => 1],
                ]),
            ],
            [
                'kriteria_id' => 7,
                'nama' => 'Kepedulian terhadap Rekan',
                'bobot' => 20,
                'penilaian' => json_encode([
                    ["rentang" => "Sangat peduli terhadap rekan kerja", "skor" => 3],
                    ["rentang" => "Cukup peduli terhadap rekan kerja", "skor" => 2],
                    ["rentang" => "Kurang peduli terhadap rekan kerja", "skor" => 1],
                ]),
            ]
        ];

        // Menyimpan data ke tabel sub_kriteria dan penilaian
        foreach ($subKriteria as $sk) {
            $subKriteria = SubKriteria::create([
                'kriteria_id' => $sk['kriteria_id'],
                'nama' => $sk['nama'],
                'bobot' => $sk['bobot'],
                'penilaian' => $sk['penilaian'],
            ]);
        }
    }
}
