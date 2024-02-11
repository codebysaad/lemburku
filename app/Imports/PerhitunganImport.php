<?php

namespace App\Imports;

use App\Models\HariLibur;
use App\Models\LemburFix;
use App\Models\Pegawai;
use App\Models\TarifLemburFix;
use DateTime;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PerhitunganImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $tglLembur = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_lembur'])->format('Y-m-d');
        // $idPegawai = $this->getPegawaiId($row['nama']);
        // $statusHari = $this->getStatusHari($tglLembur);
        // $idGol = $this->getPangkatId($idPegawai);
        // $uangMakanLembur = $this->getUangMakanLembur($idGol);
        // $uangMakanLembur = $this->getUangMakanLembur($row['gol']);
        // $tarifPerJam = ($statusHari == 'L') ? $this->getTarifLembur($row['gol']) * 2 : $this->getTarifLembur($row['gol']);
        // $harga = ($this->hitungDurasi($row['mulai'], $row['akhir'], $row['pengajuan_awal'], $row['pengajuan_akhir'], $row['durasi_pengajuan']) * $tarifPerJam) + $uangMakanLembur;
        // $harga = (8 * $tarifPerJam) + $uangMakanLembur;
        $harga = (8 * 40000) + 31000;

        // return new LemburFix([
        //     'nama' => $row[0],
        //     'gol' => $row[1],
        //     'tgl_lembur' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2])->format('Y-m-d'),
        //     'mulai' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])->format('H:i'),
        //     'akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])->format('H:i'),
        //     'pengajuan_awal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format('H:i'),
        //     'pengajuan_akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('H:i'),
        //     'durasi_pengajuan' => $row[7],
        //     'harga' => 380000,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        return new LemburFix([
            'nama' => $row[0],
            'gol' => $row[1],
            'tgl_lembur' => Date::excelToDateTimeObject($row[2])->format('Y-m-d'),
            'mulai' => Date::excelToDateTimeObject($row[3])->format('H:i'),
            'akhir' => Date::excelToDateTimeObject($row[4])->format('H:i'),
            'pengajuan_awal' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])->format('H:i'),
            'pengajuan_akhir' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('H:i'),
            'durasi_pengajuan' => $row[7],
            'harga' => 380000,
            'created_at' => now(),
            'updated_at' => now()
        ]);
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
