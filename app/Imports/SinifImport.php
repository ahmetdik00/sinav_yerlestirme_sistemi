<?php

namespace App\Imports;

use App\Models\Sinif;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');

class SinifImport implements ToModel, SkipsOnError, SkipsEmptyRows
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

        return new Sinif([
            'sinav_ili' => ltrim($row[0]),
            'universite' => ltrim($row[1]),
            'fakulte' => ltrim($row[2]),
            'kat' => ltrim($row[3]),
            'sinif' => ltrim($row[4]),
            'kapasite' => ltrim($row[5])
        ]);

    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
