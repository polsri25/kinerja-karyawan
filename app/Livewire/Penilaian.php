<?php

namespace App\Livewire;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Penilaiandb;
use Livewire\Component;

class Penilaian extends Component
{
    public $karyawans;
    public $id_karyawan = [];
    public $nama_karyawan = [];
    public $jabatan_karyawan = [];
    public $pendidikan_karyawan = [];
    public $pengalaman_karyawan = [];
    public $kriteria = [];
    public $nilai = [];

    public $jabatans;
    public $selectedJabatan;
    public $selectedKaryawan;
    public $karyawanByJabatan = [];
    public $selectedKaryawanList = [];

    public $periode_dari;
    public $periode_sampai;

    public function mount()
    {
        $this->jabatans = Karyawan::select('jabatan')->distinct()->pluck('jabatan');
        $this->kriteria = Kriteria::all();
        $this->selectedKaryawanList = [];
        $this->selectedJabatan = null; // Initialize selectedJabatan
        $this->selectedKaryawan = null; // Initialize selectedKaryawan
        $this->karyawanByJabatan = []; // Initialize karyawanByJabatan
    }

    // Metode custom untuk menangani perubahan jabatan
    public function jabatanChanged($value)
    {
        $this->selectedJabatan = $value;
        $this->updatedSelectedJabatan($value);
    }

    // Metode lifecycle yang akan dipanggil oleh metode custom
    public function updatedSelectedJabatan($value)
    {
        $this->karyawanByJabatan = Karyawan::where('jabatan', $value)->get();
        $this->selectedKaryawan = null; // Reset nilai selectedKaryawan
    }

    public function tambahKaryawan()
    {
        if ($this->selectedKaryawan) {
            // Check if the employee is already selected
            $isAlreadySelected = collect($this->selectedKaryawanList)->contains('id', $this->selectedKaryawan);

            if (!$isAlreadySelected) {
                $karyawan = Karyawan::find($this->selectedKaryawan);
                if ($karyawan) {
                    // Add the new employee to the selectedKaryawanList
                    $this->selectedKaryawanList[] = [
                        'id' => $karyawan->id,
                        'nama' => $karyawan->nama,
                        'jabatan' => $karyawan->jabatan,
                        'nim' => $karyawan->nim,
                        'alamat' => $karyawan->alamat,
                    ];

                    // Initialize nilai for the new employee
                    $this->nilai[$karyawan->id] = [];
                    foreach ($this->kriteria as $item) {
                        $this->nilai[$karyawan->id][$item->id][$item->nama] = 0;
                    }

                    $this->selectedKaryawan = null;
                    $this->karyawans = $this->selectedKaryawanList; // Update $karyawans with selectedKaryawanList
                }
            } else {
                // Handle case where karyawan is already selected
                session()->flash('message', 'Karyawan sudah dipilih sebelumnya.');
            }
        }
    }



    public function checkSelectedKaryawan()
    {
        foreach ($this->selectedKaryawanList as $karyawan) {
            $this->id_karyawan[$karyawan['id']] = $karyawan['id'];
            $this->nama_karyawan[$karyawan['id']] = $karyawan['nama'];
            $this->jabatan_karyawan[$karyawan['id']] = $karyawan['jabatan'];
        }
    }


    public function render()
    {
        return view('livewire.penilaian');
    }

    public function validateForm()
    {
        $isValid = true;

        foreach ($this->selectedKaryawanList as $karyawan) {
            foreach ($this->kriteria as $item) {
                $karyawanId = $karyawan['id'];
                $kriteriaId = $item->id;
                $namaKriteria = $item->nama;

                // Reset error bag for this nilai
                $this->resetErrorBag('nilai.' . $karyawanId . '.' . $kriteriaId);

                // Check if the nilai array for this karyawan and kriteria exists
                if (!isset($this->nilai[$karyawanId][$kriteriaId][$namaKriteria])) {
                    $this->resetErrorBag('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria);
                    $this->addError('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria, 'Nilai untuk ' . $namaKriteria . ' harus diisi.');
                    $isValid = false;
                } else {
                    $bobot = $this->nilai[$karyawanId][$kriteriaId][$namaKriteria];

                    // Convert to integer (optional, depending on your needs)
                    $bobot = (int) $bobot;

                    // Check if the value is numeric and within range
                    if (!is_numeric($bobot) || $bobot == 0) {
                        $this->resetErrorBag('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria);
                        $this->addError('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria, 'Nilai untuk ' . $namaKriteria . ' harus berupa angka lebih dari 0.');
                        $isValid = false;
                    } elseif ($bobot < 1 || $bobot > 100) {
                        $this->resetErrorBag('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria);
                        $this->addError('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria, 'Nilai untuk ' . $namaKriteria . ' harus antara 1 dan 100.');
                        $isValid = false;
                    } else {
                        // Clear error if validation passes
                        $this->resetErrorBag('nilai.' . $karyawanId . '.' . $kriteriaId . '.' . $namaKriteria);
                    }
                }
            }
        }

        return $isValid;
    }




    public function hasilAkhir()
    {
        $isValid = $this->validateForm();

        if (!$isValid) {
            // If validation fails, redirect back with an error message
            session()->flash('error', 'Ada kesalahan validasi. Silakan lengkapi semua input yang diperlukan.');
            return redirect()->back();
        }
        $this->checkSelectedKaryawan();
        $utilityValues = $this->getUtilityValues();
        // dd($utilityValues);

        $hasilAkhir = [];

        foreach ($utilityValues as $setKey => $set) {
            $totalNilai = 0;
            $perKriteria = [];

            $idKaryawan = $this->id_karyawan[$setKey];
            $namaKaryawan = $this->nama_karyawan[$setKey];

            foreach ($set as $namaKriteria => $utility) {
                $kriteria = $this->kriteria->firstWhere('nama', $namaKriteria);

                if ($kriteria) {
                    $bobot = (float) $kriteria->bobot;
                    $nilaiPerKriteria = $utility / ($bobot * 0.01);

                    $perKriteria[$namaKriteria] = $nilaiPerKriteria;
                    $totalNilai += $nilaiPerKriteria;
                }
            }

            $hasilAkhir[$setKey] = [
                'id_karyawan' => $idKaryawan,
                'tgl_penilaian' => now()->toDateString(),
                'data' => [
                    'nama_karyawan' => $namaKaryawan,
                    'nilai_per_kriteria' => $perKriteria,
                    'total_nilai' => $totalNilai,
                ],
            ];
        }

        // Buat array sementara untuk menyimpan total_nilai
        $totalNilaiArr = [];

        foreach ($hasilAkhir as $key => $value) {
            $totalNilaiArr[$key] = $value['data']['total_nilai'];
        }

        // Urutkan $hasilAkhir berdasarkan total_nilai descending
        arsort($totalNilaiArr);

        // Beri peringkat berdasarkan urutan yang telah diurutkan
        $ranking = 1;
        foreach ($totalNilaiArr as $key => $totalNilai) {
            $hasilAkhir[$key]['data']['ranking'] = $ranking;
            $ranking++;
        }

        // Simpan ke dalam tabel penilaian menggunakan model Penilaian
        foreach ($hasilAkhir as $key => $value) {
            Penilaiandb::create([
                'karyawan_id' => $value['id_karyawan'],
                'tgl_penilaian' => $this->periode_dari . ' s/d ' . $this->periode_sampai,
                'data' => json_encode($value['data']),
                'tanggal_dari' => $this->periode_dari,
                'tanggal_sampai' => $this->periode_sampai,
            ]);
        }
        // dd($hasilAkhir);
        // Redirect setelah selesai
        return redirect()->route('penilaian.index');
    }







    public function normalizeData()
    {

        $normalizedData = [];

        foreach ($this->nilai as $setKey => $set) {
            foreach ($set as $kriteriaKey => $kriteria) {
                foreach ($kriteria as $namaKriteria => $nilai) {
                    // Normalisasi nilai dengan mengalikan dengan 0.01
                    $normalizedData[$setKey][$kriteriaKey][$namaKriteria] = $nilai * 0.01;
                }
            }
        }
        // dd($normalizedData);
        return $normalizedData;
    }

    public function getMaxMinValues()
    {
        $normalizedData = $this->normalizeData();

        $maxValues = [];
        foreach ($normalizedData as $set) {
            foreach ($set as $kriteria) {
                foreach ($kriteria as $namaKriteria => $nilai) {
                    if (!isset($maxValues[$namaKriteria])) {
                        $maxValues[$namaKriteria] = $nilai;
                    } else {
                        if ($nilai > $maxValues[$namaKriteria]) {
                            $maxValues[$namaKriteria] = $nilai;
                        }
                    }
                }
            }
        }
        $minValues = [];
        foreach ($normalizedData as $set) {
            foreach ($set as $kriteria) {
                foreach ($kriteria as $namaKriteria => $nilai) {
                    if (!isset($minValues[$namaKriteria])) {
                        $minValues[$namaKriteria] = $nilai;
                    } else {
                        if ($nilai < $minValues[$namaKriteria]) {
                            $minValues[$namaKriteria] = $nilai;
                        }
                    }
                }
            }
        }
        // dd($maxValues, $minValues);
        return [$maxValues, $minValues];
    }

    private function isBenefitKriteria($namaKriteria)
    {
        // Dapatkan kriteria berdasarkan nama
        $kriteria = $this->kriteria->firstWhere('nama', $namaKriteria);

        // Periksa apakah kriteria memiliki keterangan "Benefit"
        return $kriteria && $kriteria->keterangan == 'Benefit';
    }
    public function getUtilityValues()
    {
        list($maxValues, $minValues) = $this->getMaxMinValues();
        $normalizedData = $this->normalizeData();
        $utilityValues = [];

        foreach ($normalizedData as $setKey => $set) {
            foreach ($set as $kriteriaKey => $kriteria) {
                foreach ($kriteria as $namaKriteria => $nilai) {
                    if ($this->isBenefitKriteria($namaKriteria)) {
                        $nilaiMin = $minValues[$namaKriteria];
                        $nilaiMax = $maxValues[$namaKriteria];

                        if ($nilaiMax == $nilaiMin) {
                            $utilityValues[$setKey][$namaKriteria] = 0; // Handle division by zero
                        } else {
                            $utilityValues[$setKey][$namaKriteria] = ($nilai - $nilaiMin) / ($nilaiMax - $nilaiMin);
                        }
                    } else {
                        $utilityValues[$setKey][$namaKriteria] = $nilai; // For non-benefit criteria, simply use normalized value
                    }
                }
            }
        }
        // dd($utilityValues);
        return $utilityValues;
    }
}
