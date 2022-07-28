<?php

namespace App\Imports;

use App\Models\Results;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');

class ResultsExamImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable, SkipsErrors;

    private $rows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rows++;

        return new Results([
            'email' => ltrim($row['email']),
            'puan' => (empty(ltrim($row['puan']))) ? 'GİRMEDİ' : ltrim($row['puan'])
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}
