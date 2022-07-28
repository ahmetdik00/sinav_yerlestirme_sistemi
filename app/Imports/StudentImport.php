<?php

namespace App\Imports;

use App\Models\StudentInfo;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('slug');

class StudentImport implements ToModel, WithHeadingRow, SkipsOnError, SkipsEmptyRows
{
    use Importable, SkipsErrors;

    private $rows = 0;
    /**
    * @param array $row
    *
    * @return Model|null
    */

    public function model(array $row)
    {
        $this->rows++;

        return new StudentInfo([
            'aday_no' => ltrim($row['aday_no']),
            'aday_resim' => ltrim($row['aday_id']),
            'basvuru_tarihi' => ltrim($row['basvuru_tarihi']),
            'onay_tarihi' => ltrim($row['onay_tarihi']),
            'kimlik_no' => ltrim($row['tc_kimlik_numarasi']),
            'ad_soyad' => ltrim($row['adi_soyadi']),
            'baba_adi' => ltrim($row['baba_adi']),
            'dogum_yeri' => ltrim($row['dogum_yeri']),
            'dogum_tarihi' => ltrim($row['dogum_tarihi']),
            'uyruk' => ltrim($row['uyruk']),
            'cinsiyet' => ltrim($row['cinsiyet']),
            'tel_no' => ltrim($row['cep_telefonu']),
            'email' => ltrim($row['e_posta']),
            'mezuniyet_tarihi' => ltrim($row['mezuniyet_tarihi'])
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
