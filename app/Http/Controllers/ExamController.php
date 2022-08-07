<?php

namespace App\Http\Controllers;

use App\Imports\ResultsExamImport;
use App\Models\Sinif;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ExamController extends Controller
{
    /* SINAV */

    public function exam()
    {
        $documents = DB::table('sinav_giris_belge')->get();
        $student = StudentInfo::all();
        $classes = Sinif::all();
        $capacity = Sinif::sum('kapasite');
        $sayi = DB::table('kullanilan_sinif_sayisi')->sum('sayi');
        return view('admin.pages.exam', compact('classes', 'capacity', 'documents', 'student', 'sayi'));
    }

    public function examPlace()
    {
        $capacities = Sinif::select('kapasite')->get();
        $sumCapacities = Sinif::sum('kapasite');
        $class = Sinif::all();
        $student = StudentInfo::inRandomOrder()->get();
        $countStudent = StudentInfo::count('id');
        $countClass =  Sinif::count('id');

        $j = 0;
        $a = 0;
        $b = 0;

        if (!empty($class)) {
            if ($j < $countClass && $countStudent > 0) {

                for ($i = $a; $i < $sumCapacities; $i++)
                {
                    if ($i == ($sumCapacities - 1) )
                    {
                        Sinif::where(['universite' => $class[$j]->universite, 'sinif' => $class[$j]->sinif])->update([
                            'yerlesen_ogrenci' => ($b + 1)
                        ]);
                    }

                    if ($b == $capacities[$j]->kapasite)
                    {
                        Sinif::where(['universite' => $class[$j]->universite, 'sinif' => $class[$j]->sinif])->update([
                            'yerlesen_ogrenci' => $b
                        ]);

                        $j = $j + 1;
                        $b = 0;
                    }

                    if ($i == $countStudent)
                    {
                        Sinif::where(['universite' => $class[$j]->universite, 'sinif' => $class[$j]->sinif])->update([
                            'yerlesen_ogrenci' => $b
                        ]);

                        //TODO session_start();
                        //TODO session()->put('class', intVal($j+1));
                        DB::table('kullanilan_sinif_sayisi')->insert([
                            'sayi' => intVal($j+1)
                        ]);
                        return back()
                            ->with('message_success', 'Öğrenciler başarıyla yerleştirildi.');
                    }

                    $unique = DB::table('sinav_giris_belge')->where(['aday_no' => $student[$i]->aday_no, 'kimlik_no' => $student[$i]->kimlik_no])->get();
                    if (count($unique) == 0) {
                        DB::table('sinav_giris_belge')->insert([
                            'aday_no' => $student[$i]->aday_no,
                            'kimlik_no' => $student[$i]->kimlik_no,
                            'ad_soyad' => $student[$i]->ad_soyad,
                            'baba_adi' => $student[$i]->baba_adi,
                            'dogum_yeri' => $student[$i]->dogum_yeri,
                            'dogum_tarihi' => $student[$i]->dogum_tarihi,
                            'uyruk' => $student[$i]->uyruk,
                            'sinav_ili' => $class[$j]->sinav_ili,
                            'universite' => $class[$j]->universite,
                            'fakulte' => $class[$j]->fakulte,
                            'kat' => $class[$j]->kat,
                            'sinif' => $class[$j]->sinif,
                            'sira' => ($b+1)

                        ]);

                        $b++;
                    }

                }

                if ($countStudent > $sumCapacities) {

                    DB::table('kullanilan_sinif_sayisi')->insert([
                        'sayi' => intVal($j + 1)
                    ]);

                    return back()
                        ->with('message_uyari', 'Öğrenci sayısı toplam kontenjanı geçti yenı sınıflar ekleyiniz!');
                }
            }
            else if ($j == $countClass)
            {
                return back()
                    ->with('message_error', 'Var olmayan sınıflara öğrenci ataması yaptınız!');
            } else {
                return back()
                    ->with('message_error2', 'Var olmayan sınıflara öğrenci ataması yaptınız!');
            }
        } else {
            return back()
                ->with('message_error', 'Sınıflar doldu daha fazla yerleştirme işlemi yapamazsınız!');
        }
    }

    public function deleteAllPlaces()
    {
        DB::table('sinav_giris_belge')->delete();
        DB::table('kullanilan_sinif_sayisi')->delete();
        Sinif::updateOrCreate([
            'yerlesen_ogrenci' => 0
        ]);

        return back()
            ->with('delete_message', 'Tüm sınıflar boşaltılı.');
    }

    public  function listExamClass()
    {
        $documents = DB::table('sinav_giris_belge')->get();
        $classes = Sinif::all();
        return view('admin.pages.list-exam-class', compact('documents', 'classes'));
    }

    public function showClass($universite, $sinif)
    {
        $student_info = DB::table('sinav_giris_belge')->where(['universite' => $universite, 'sinif' => $sinif])->get();
        return view('admin.pages.show-class-data', compact('student_info'));
    }

    /* SINAV SONUÇLARI */

    public function resultOfExam()
    {
        $results = DB::table('sinav_sonuc_belge')->get();
        return view('admin.pages.results-of-exam', compact('results'));
    }

    public function uploadResultOfExam(Request $request)
    {
        $file = $request->file('file')->store('results');
        if (empty($file))
        {
            return back()
                ->with('message_warning', 'Lütfen herhangi bir dosya seçin...');
        }
        else
        {
            try {
                $import = new ResultsExamImport();
                $import->import($file);
                return back()
                    ->with('message_success', 'Excel dosyası başarıyla aktarıldı.');
            } catch (Throwable $e) {
                return back()
                    ->with('message_danger', $e->getMessage()/*'Yüklemeye çalıştığınız veriler, veritabanında kayıtlı verilerle aynı veya verilerde bir hata var!'*/);
            }
        }
    }

    public function deleteAllResultOfExam()
    {
        DB::table('sinav_sonuc_belge')->delete();

        return back()
            ->with('delete_message', 'Tüm sınıv sonuçları silindi.');
    }
}
