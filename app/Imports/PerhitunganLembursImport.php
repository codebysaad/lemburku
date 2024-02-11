<?php

namespace App\Imports;

use App\Models\HariLibur;
use App\Models\Lembur;
use App\Models\LemburFix;
use App\Models\PangkatGol;
use App\Models\Pegawai;
use App\Models\TarifLembur;
use App\Models\TarifLemburFix;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PerhitunganLembursImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $tglLembur = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_lembur'])->format('Y-m-d');
        // $idPegawai = $this->getPegawaiId($row['nama']);
        $statusHari = $this->getStatusHari($tglLembur);
        // $idGol = $this->getPangkatId($idPegawai);
        // $uangMakanLembur = $this->getUangMakanLembur($idGol);
        $uangMakanLembur = $this->getUangMakanLembur($row['gol']);
        $tarifPerJam = ($statusHari == 'L') ? $this->getTarifLembur($row['gol']) * 2 : $this->getTarifLembur($row['gol']);
        // $harga = ($this->hitungDurasi($row['mulai'], $row['akhir'], $row['pengajuan_awal'], $row['pengajuan_akhir'], $row['durasi_pengajuan']) * $tarifPerJam) + $uangMakanLembur;
        $harga = (8 * $tarifPerJam) + $uangMakanLembur;

        return new LemburFix([
            'nama' => $row[0],
            'gol' => $row[1],
            'tgl_lembur' => '2024-01-20',
            'mulai' => '07:30',
            'akhir' => '16:00',
            'pengajuan_awal' => '07:00',
            'pengajuan_akhir' => '17:00',
            'durasi_pengajuan' => 8,
            'harga' => 380000,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // return new LemburFix([
        //     'nama' => $row['nama'],
        //     'gol' => $row['gol'],
        //     'tgl_lembur' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_lembur'])->format('Y-m-d'),
        //     'mulai' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mulai'])->format('H:i'),
        //     'akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['akhir'])->format('H:i'),
        //     'pengajuan_awal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['pengajuan_awal'])->format('H:i'),
        //     'pengajuan_akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['pengajuan_akhir'])->format('H:i'),
        //     'durasi_pengajuan' => $row['durasi_pengajuan'],
        //     'harga' => $harga,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // return new Lembur([
        //     'pegawai_id' => $idPegawai,
        //     'tgl_lembur' => $tglLembur,
        //     'mulai' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mulai'])->format('H:i'),
        //     'akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['akhir'])->format('H:i'),
        //     'pengajuan_awal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['pengajuan_awal'])->format('H:i'),
        //     'pengajuan_akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['pengajuan_akhir'])->format('H:i'),
        //     'durasi_pengajuan' => $row['durasi_pengajuan'],
        //     'harga' => $harga,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);
    }

    private function getPegawaiId($name)
    {
        return Pegawai::where('nama', 'like', '%' . $name . '%')->value('id');

        // return Pegawai::where('nama', '=', $name)->value('id');
    }

    private function getPangkatId($pegawai_id)
    {
        return Pegawai::where('id', '=', $pegawai_id)->value('pangkat_id');
    }

    private function getStatusHari($tglLembur)
    {
        return (HariLibur::where('tgl', '=', $tglLembur)->value('status') == 'L') ? 'L' : 'HK';
    }

    private function getUangMakanLembur($golId)
    {
        // return TarifLembur::where('gol_id', '=', $golId)->value('uang_makan');
        return TarifLemburFix::where('gol', '=', $golId)->value('uang_makan');
    }

    private function getTarifLembur($golId)
    {
        // return TarifLembur::where('gol_id', '=', $golId)->value('tarif');
        return TarifLemburFix::where('gol', '=', $golId)->value('tarif');
    }

    private function hitungDurasi($awal, $akhir, $pAwal, $pAkhir, $pDurasi)
    {
        $jamAwal = (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($awal)->format('H:i') < \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($pAwal)->format('H:i')) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($pAwal)->format('H:i') : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($awal)->format('H:i');
        $jamAkhir = (\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($akhir)->format('H:i') < \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($pAkhir)->format('H:i')) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($pAkhir)->format('H:i') : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($akhir)->format('H:i');

        $time = new DateTime($jamAkhir);
        $menit = $time->format('i');

        $durasi = ($menit > 50) ? ($jamAkhir - $jamAwal) + 1 : $jamAkhir - $jamAwal;

        return ($durasi > $pDurasi) ? $pDurasi : $durasi;
    }
}
