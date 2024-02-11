<?php

namespace App\Imports;

use App\Models\PangkatGol;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PangkatGolsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new PangkatGol([
            'gol' => $row['gol'],
            'name' => $row['pangkat_gol'],
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
