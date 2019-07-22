<?php

namespace App\Imports;

use App\DataTraining;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class DataTrainingImport implements ToModel
{

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        return new DataTraining([
            'kesukaran' => $row[0],
            'pembeda' => $row[1],
            'keputusan' => $row[2],
        ]);
    }
}
