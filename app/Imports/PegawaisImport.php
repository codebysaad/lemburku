<?php

namespace App\Imports;

use App\Models\PangkatGol;
use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaisImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pegawai([
            'nama' => $row['nama'],
            'nip' => $row['nip'],
            'pangkat_id' => $this->getPangkatId($row['pangkat_gol']),
            'jabatan' => $row['jabatan'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function getPangkatId($pangkat)
    {
        return PangkatGol::where('name', '=', $pangkat)->value('id');
    }
}
