<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Departement\viitem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ViitemImport implements ToCollection, WithHeadingRow
{ 
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            viitem::create([
                'event_id' => $row['periode'],
                'departement_id' => $row['departement'],
                'area' => $row['area'],
                'kpi' => $row['kpi'],
                'calculation' => $row['calculation'],
                'target' => $row['target'],
                'weight' => $row['weight'],
                'realization' => $row['realization'],
                'created_by' => $row['created_by'],
                'updated_by' => $row['updated_by'],
            ]);
        }
    }
}