<?php

namespace App\Http\Controllers;

use App\Imports\ResultsExamImport;
use App\Imports\SinifImport;
use App\Imports\StudentImport;
use App\Models\Sinif;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AdminController extends Controller
{
    /* ÖĞRENCİLER */

    public function index()
    {
        $class = DB::table('class')->count('id');
        $capacity = DB::table('class')->sum('kapasite');
        $student = DB::table('student_info')->count('aday_no');
        $documents = DB::table('sinav_giris_belge')->count('aday_no');
        $datetime =Carbon::now('EUROPE/ISTANBUL');
        $mytime = $datetime->locale('tr')->isoFormat('LLLL');
        return view('admin.index', compact('capacity', 'student', 'documents', 'class', 'mytime'));
    }

    public function students()
    {
        $students = DB::table('student_info')->get();
        return view('admin.pages.add-student', compact('students'));
    }

    public function addStudent(Request $request)
    {
        $file = $request->file('file')->store('student');
        if (empty($file))
        {
            return back()
                ->with('message_warning', 'Lütfen herhangi bir dosya seçin...');
        }
        else
        {
            try {
                $import = new StudentImport();
                $import->import($file);
                $newStudents = DB::table('student_info')->latest()->take($import->getRowCount())->get();
                foreach ($newStudents as $student)
                {
                    DB::table('student')->insertOrIgnore([
                        'aday_no' => $student->aday_no,
                        'kimlik_no' => $student->kimlik_no,
                        'name' => $student->ad_soyad,
                        'email' => $student->email,
                        'password' => Hash::make(substr($student->kimlik_no, -5))
                    ]);
                }

                return back()->with('message_success', 'Excel dosyası başarıyla aktarıldı.');
            } catch (Exception $e) {
                    return back()
                        ->with('message_error', $e->getMessage()/*'Yüklemeye çalıştığınız veriler, veritabanında kayıtlı verilerle aynı veya verilerde bir hata var!'*/);

            }
        }
    }

    public function listStudentData()
    {

        $students = DB::table('student_info')->get();

        $countEntry = DB::table('sinav_giris_belge')->count('id');

        $countResult = DB::table('sinav_sonuc_belge')->count('id');
        return view('admin.pages.list-student-data', compact('students', 'countResult', 'countEntry'));
    }

    public function entryDocument($aday_no)
    {
        $entryDocuments = DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.aday_no',  $aday_no)
            ->get();
        $entryDocument = $entryDocuments[0];
        return view('admin.pages.panel.entry-document', compact('entryDocument'));
    }

    public function entryDocumentPrint($aday_no)
    {
        $students =  DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.aday_no', $aday_no)
            ->get();
        $student = $students[0];

        $path = public_path('img/image001.png');
        $path2 = public_path('img/Foto/'. $student->aday_resim .'.jpg');
        $image = base64_encode(file_get_contents($path));
        $image2 = base64_encode(file_get_contents($path2));

        $dompdf = new Dompdf();
        $html = '<!DOCTYPE html>
                <html lang="tr">
                <head>
                    <style>
                        * {
                        font-family: DejaVu Sans, sans-serif;
                        }

                        tr {
                            line-height: 15px;
                        }

                        tr{
                            font-size: 10px;
                        }

                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }

                        td {
                            padding-left: 4px;
                            height: 20px;
                        }

                    </style>
                </head>
                <body style="display: flex; justify-content: center">
                <table style="width:700px; margin-bottom: 2px">
                    <tr>
                        <td style="text-align: center;">
                            <img src="data:image/png;base64,' . $image . '" alt="">
                        </td>
                        <td style="text-align: center; padding: 0; font-size: 10px">
                            <b>
                                T.C. <br>
                                HATAY MUSTAFA KEMAL ÜNİVERSİTESİ ULUSLARARASI ÖĞRENCİ<br>
                                SEÇME VE YERLEŞTİRME SINAVI SINAV GİRİŞ BELGESİ <br>
                                (HMKÜYÖS-2022) <br>
                                HATAY MUSTAFA KEMAL UNIVERSTY INTERNATIONAL STUDENT <br>
                                SELECTION AND PLACEMENT EXAM RESULTS DOCUMENT <br>
                                (HMKÜYÖS-2022)
                            </b>
                        </td>
                        <td style="width: 100px">
                            <img style="width: 97px; height: 120px" src="data:image/png;base64,' . $image2 . '" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Aday Numarası</b> / Application <br> Number</td>
                        <td colspan="2">' . $student->aday_no .'</td>
                    </tr>
                    <tr>
                        <td><b>T.C. Kimlik / Y.U. Numarası</b> / FR Number</td>
                        <td colspan="2">' . $student->kimlik_no .'</td>
                    </tr>
                    <tr>
                        <td><b>ADI  ve SOYADI</b> / Name and Surname</td>
                        <td colspan="2">' .  $student->ad_soyad .'</td>
                    </tr>
                    <tr>
                        <td><b>Baba Adı</b> / Father name</td>
                        <td colspan="2">' . $student->baba_adi .'</td>
                    </tr>
                    <tr>
                        <td><b>Doğum Yeri</b> / Place of Birth</td>
                        <td colspan="2">' . $student->dogum_yeri .'</td>
                    </tr>
                    <tr>
                        <td><b>Doğum Tarihi</b> / Date of Brith</td>
                        <td colspan="2">' . $student->dogum_tarihi .'</td>
                    </tr>
                    <tr>
                        <td><b>Uyruğu</b> / Nationalty</td>
                        <td colspan="2">' . $student->uyruk .'</td>
                    </tr>
                    <tr>
                        <td><b>SINAV İLİ</b>  / Exam Province</td>
                        <td colspan="2">' . $student->sinav_ili .'</td>
                    </tr>
                    <tr>
                        <td><b>SINAV YERİ</b> / Exam Place</td>
                        <td colspan="2">' . $student->universite .'</td>
                    </tr>
                    <tr>
                        <td><b>FAKÜLTE</b> / Faculty</td>
                        <td colspan="2">' . $student->fakulte .'</td>
                    </tr>
                    <tr>
                        <td><b>SINIF NO</b> / Class Number</td>
                        <td colspan="2">' . $student->sinif .'</td>
                    </tr>
                    <tr>
                        <td><b>SIRA NUMARASI</b> / Seat Number</td>
                        <td colspan="2">' . $student->sira .'</td>
                    </tr>
                    <tr>
                        <td><b>SINAV TARİHİ</b> / SAATİ Exam <br> Date / Time</td>
                        <td colspan="2">' . $student->created_at .'</td>
                </table>
                            <div style="width: 700px; font-size: 10px; margin-right: 20px; margin-left: 20px">
                                <b style="margin-left: 250px">ADAYLARIN DİKKATİNE</b> <br> <br>

                                1.	Sınav süresi 120 dakikadır.<br>
                                2.	Sınavda; Temel Öğrenme Becerileri (40 soru) ve Matematik (40 soru) testi olmak üzere toplam 80 soru sorulacaktır.<br>
                                3.	Sınavın ilk 15 dakikasından gelen adaylar sınav binasına alınmayacaktır. <br>
                                4.	4 Yanlış 1 Doğru cevabı götürmektedir. <br>
                                5.	Adaylar sınava; T.C Kimlik Kartı, Nüfus Cüzdanı, Geçici Kimlik Belgesi, Süresi Geçmemiş Pasaport, İkamet İzin Belgesi Evlilik Cüzdanı,
                                <br> K.K.T.C Kimlik Belgesi, Pembe-Mavi Kart, İçişleri Bakanlığı Göç İdaresi tarafından verilen süresi geçerli “Uluslararası Koruma Statü Sahibi
                                <br> Kimlik Belgesi” ile “Geçici Koruma Kimlik Belgesi (Suriye Uyruklular için)”  belgelerinden herhangi bir kimlik belgesine ek olarak sınava giriş
                                <br> Kimlik Belgesi” ile belgelerinden herhangi bir kimlik belgesine ek olarak sınava giriş belgesiyle girebileceklerdir. Sayılan kimlik belgesi eksik olan ve sınava giriş belgesi olmayan adaylar sınava alınmayacaktır.
                                <br>
                                6.	Adayların sınava girebilmeleri için gerekli belgeler dışında, yanlarında çanta, güneş gözlüğü, kağıt, kitap, defter, not vb. dokümanlar,
                                <br> pergel, açıölçer, cetvel vb. araçlar; cep telefonu, bilgisayar, hesap makinesi, tablet telsiz, kamera, kulaklık vb. iletişim, depolama, kayıt ve
                                <br> veri aktarma cihazları; ruhsatlı veya resmi amaçlı olsa bile silah ve silah yerine geçebilecek nesneler bulundurmaları yasaktır.
                                <br>
                                7.	Sınava gelirken yanınızda kurşun kalem, silgi ve kalemtıraş bulundurmalısınız. <br>
                                8.	Başvuru sırasında biyometrik fotoğraf yüklemeyen veya kimliğinde fotoğrafı net olmayanların yanlarında biyometrik fotoğraf getirmeleri gerekmektedir.
                                <br><br>

                                <b style="margin-left: 250px">ATTENTION TO CANDIDATES</b> <br><br>

                                1.	Duration for the exam is 120 minutes. <br>
                                2.	A total of 80 questions will be asked,  including The Basic Learning Skills (40 questions) and Mathematics (40 questions) test.
                                <br>
                                3.	Candidates who arrive after the first 15 minutes of the exam will not be admitted to the exam building.
                                <br>
                                4.	4 Wrong lead to 1 correct answer. <br>
                                5.	You can enter the exam with the official cards written below and the exam entrance document. T.C. Identity Card, T.C. Temporary Identity
                                <br> Document, Unaxpired passport, Recidence Permit Certificate, Marriage certificate, K.K.T.C Identity Card, Pink-Blue Card. “International
                                <br> Protection Status Owner Idenntity Document”  valid for the period given by the ID card or the entrance document will not be allowed to take the exam.
                                <br>
                                6.	Canditates are not allowed to take the exam with the following items: Bags, sunglasses, paper, boks, notebooks, notes, documents,
                                <br> compasses, protractors, rulers, cell phones, computers, calculators, tablets, radios, cameras, headsets, communications, storage,
                                <br> recording and data transfer devices and weapons. <br>
                                7.	You should have a pencil, eraser and sharperner with you when you come to the exam.
                                <br>
                                8.	Who don’t upload a biometric photo during the application process or who dont have a clear photo on their identity card, They have to
                                <br> bring a biometric photo with them.

                            </div>
                </body>
                </html>
                '

        ;
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('a4');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        return back()->with($dompdf->stream('HMKÜYÖS - 2022 SINAV GİRİŞ BELGESİ'));
    }

    public function resultDocument($aday_no, $email)
    {
        $resultDocuments = DB::table('sinav_sonuc_belge')->where('email', $email)->get();
        $students = DB::table('student_info')->where('aday_no', $aday_no)->get();

        $student = $students[0];
        $resultDocument = $resultDocuments[0];
        return view('admin.pages.panel.result-document', compact('resultDocument', 'student'));
    }

    public function resultDocumentPrint($aday_no, $email)
    {
        $students =  DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.aday_no', $aday_no)
            ->get();
        $results =  DB::table('sinav_sonuc_belge')->where('email', $email)->get();
        $student = $students[0];
        $result = $results[0];

        $path = public_path('img/image001.png');
        $path2 = public_path('img/Foto/'. $student->aday_resim .'.jpg');
        $image = base64_encode(file_get_contents($path));
        $image2 = base64_encode(file_get_contents($path2));

        $dompdf = new Dompdf();
        $html = '
                <!DOCTYPE html>
                <html lang="tr">
                <head>
                    <meta charset="UTF-8">
                    <title>Title</title>
                    <!-- Google Font: Source Sans Pro -->
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
                    <!-- Theme style -->
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css" integrity="sha512-IuO+tczf4J43RzbCMEFggCWW5JuX78IrCJRFFBoQEXNvGI6gkUw4OjuwMidiS4Lm9Q2lILzpJwZuMWuSEeT9UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
                    <style>

                        * {
                            font-family: DejaVu Sans, sans-serif;
                            padding-top: 0;
                            padding-bottom: 0;
                            font-size: 12px;
                        }

                        p {
                            margin: 0.4rem;
                        }

                        td {
                            padding: 5px;
                        }

                        a {
                            color: red;
                            background: #6cdbff;
                        }
                    </style>
                </head>
                <body style="display: flex; flex-direction: column; align-items: center;">
                    <table style="width: 700px" border="1" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td style="text-align: center">
                                <img src="data:image/png;base64,' . $image . '" alt="http://yosbelgedogrulama.mku.edu.tr/"/>
                            </td>
                            <td style="line-height: 15px; text-align: center;">
                                <b>
                                    T.C. <br>
                                    HATAY MUSTAFA KEMAL ÜNİVERSİTESİ ULUSLARARASI ÖĞRENCİ <br>
                                    SEÇME VE YERLEŞTİRME SINAV SONUÇ BELGESİ<br>
                                    (HMKÜYÖS-2022) <br>
                                    HATAY MUSTAFA KEMAL UNIVERSTY INTERNATIONAL STUDENT <br>
                                    SELECTION AND PLACEMENT EXAM RESULTS DOCUMENT <br>
                                    (HMKÜYÖS-2022)
                                </b>
                            </td>
                            <td>
                                <img style="height: 220px; width: 180px" src="data:image/png;base64,' . $image2 . '" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 5px">
                                <strong>Sınav Tarihi: 21 HAZİRAN 2022, 10:30</strong> / Examination Date: 21 June 2021, 10:30
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Aday Numarası </strong>/ Application Number
                            </td>
                            <td colspan="2">
                                ' . $student->aday_no . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>T.C. Kimlik/Y.U. Numarası </strong>/ FR Number
                            </td>
                            <td colspan="2">
                                ' . $student->kimlik_no . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Adı ve Soyadı </strong>/ Name and Surname
                            </td>
                            <td colspan="2">
                                ' . $student->ad_soyad . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Baba Adı</strong> / Middle name
                            </td>
                            <td colspan="2">
                                ' . $student->baba_adi . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Doğum Yeri</strong> / Birth Place
                            </td>
                            <td colspan="2">
                                ' . $student->dogum_yeri . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Doğum Tarihi </strong>/ Date of Brith
                            </td>
                            <td colspan="2">
                                ' . $student->dogum_tarihi . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Uyruğu </strong>/ Nationalty
                            </td>
                            <td colspan="2">
                                ' . $student->uyruk . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Puanı / Score</strong>
                            </td>
                            <td colspan="2">
                                ' . $result->puan . '
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <ol style="padding-top: 1rem; padding-left: 60px">
                        <li>
                            Sınav sonuçları Aday numarasına göre
                            <a href="http://yosbelgedogrulama.mku.edu.tr/">
                                <strong>http://yosbelgedogrulama.mku.edu.tr/</strong>
                            </a><br>
                            adresi üzerinden sorgulanabilmektedir.
                        </li>
                        <li>
                            HMKÜYÖS-2022 sınavında adaylara 80 soru sorulmuş, sınav yüz yüze
                            yapılmıştır.
                        </li>
                        <li>
                            Adayların puanları, HMKÜYÖS-2022 deki sorulara verdikleri doğru ve
                            yanlış cevapları ayrı ayrı <br> sayılarak 4 yanlış cevap sayısının 1 doğru
                            cevabı eksiltmesi sonucu oluşmuştur.
                        </li>
                    </ol>
                </body>
                </html>

                '

        ;
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        return back()->with($dompdf->stream('HMKÜYÖS - 2022 SINAV SONUÇ BELGESİ'));
    }

    public function deleteAllstudent()
    {
        DB::table('student_info')->delete();
        DB::table('student')->delete();
        DB::table('sinav_giris_belge')->delete();
        DB::table('class')->update([
            'yerlesen_ogrenci' => 0
        ]);
        DB::table('kullanilan_sinif_sayisi')->delete();
        return back()
            ->with('message_deleteAllsuccess', 'Tüm öğrenci bilgileri başarıyla silindi.');
    }

    /* SINIFLAR */

    public function classes()
    {
        $classes = DB::table('class')->get();
        return view('admin.pages.add-classes', compact('classes'));
    }

    public function addClasses(Request $request)
    {
        $file = $request->file('file')->store('class');

        $request->validate([
            'file' => 'required',
        ]);

        if (empty($file))
        {
            return back()
                ->with('message_warning', 'Lütfen herhangi bir dosya seçin...');
        }
        else
        {
            try {
                $import = new SinifImport();
                $import->import($file);

                return back()
                    ->with('message_success', 'Excel dosyası başarıyla aktarıldı.');
            } catch (Throwable $e) {
                return back()
                    ->with('message_danger', $e->getMessage()/*'Yüklemeye çalıştığınız veriler, veritabanında kayıtlı verilerle aynı veya verilerde bir hata var!'*/);
            }
        }
    }

    public function addClass()
    {
        return view('admin.pages.add-class');
    }

    public function addClassData(Request $request)
    {
        try {
             $request->validate( [
                'sinav_ili' =>'required',
                'universite' => 'required',
                'fakulte' => 'required',
                'kat' => 'required',
                'sinif' => 'required',
                'kapasite' => 'required|numeric'
            ]);

            $credentials = [
                'sinav_ili' => $request->input('sinav_ili'),
                'universite' => $request->input('universite'),
                'fakulte' => $request->input('fakulte'),
                'kat' => $request->input('kat'),
                'sinif' => $request->input('sinif'),
                'kapasite' => $request->input('kapasite')
            ];

            Sinif::create($credentials);

            return back()
                ->with('message_success', 'Ekleme işlemi başarıyla tamamlandı.');
        } catch (Exception $e) {
            return back()
                ->with('message_danger', 'Ekleme işlemi yapılamadı');
        }
    }

    public function listClassData()
    {
        $classes = DB::table('class')->get();
        $capacity = DB::table('class')->sum('kapasite');
        $documents = DB::table('sinav_giris_belge')->count('id');
        return view('admin.pages.list-class-data', compact('classes', 'capacity', 'documents'));
    }

    public function deleteClass($id)
    {
        DB::table('class')->delete($id);
        return back()
            ->with('message_delete', 'Sınıf başarıyla silindi.');
    }

    public function deleteAllClass()
    {
        DB::table('class')->delete();
        DB::table('sinav_giris_belge')->delete();
        DB::table('kullanilan_sinif_sayisi')->delete();
        return back()
            ->with('delete_all', 'Sınıflar başarıyla silindi.');
    }

    public function editClass($id)
    {
        $siniflar = DB::table('class')->where('id', $id)->get();
        $sinif = $siniflar[0];
        return view('admin.pages.edit-class', compact('sinif'));
    }

    public function updateClass()
    {

        DB::table('class')->where('id', request('id'))->update([
            'sinav_ili' => request('sinav_ili'),
            'universite' => request('universite'),
            'fakulte' => request('fakulte'),
            'kat' => request('kat'),
            'sinif' => request('sinif'),
            'kapasite' => request('kapasite')
        ]);

        return redirect()->intended('admin/siniflar/sinif-listele')
            ->with('message_update', 'Sınıf biilgisi başarıyla güncellendi');
    }


    /* SINAV */

    public function exam()
    {
        $documents = DB::table('sinav_giris_belge')->get();
        $student = DB::table('student_info')->get();
        $classes = DB::table('class')->get();
        $capacity = DB::table('class')->sum('kapasite');
        $sayi = DB::table('kullanilan_sinif_sayisi')->sum('sayi');
        return view('admin.pages.exam', compact('classes', 'capacity', 'documents', 'student', 'sayi'));
    }

    public function examPlace()
    {
        $capacities = DB::table('class')->select('kapasite')->get();
        $sumCapacities = DB::table('class')->sum('kapasite');
        $class = DB::table('class')->get();
        $student = DB::table('student_info')->inRandomOrder()->get();
        $countStudent = DB::table('student_info')->count('id');
        $countClass =  DB::table('class')->count('id');

        $j = 0;
        $a = 0;
        $b = 0;

        if (!empty($class)) {
            if ($j < $countClass && $countStudent > 0) {

                for ($i = $a; $i < $sumCapacities; $i++)
                {
                    if ($i == ($sumCapacities - 1) )
                    {
                        DB::table('class')->where(['universite' => $class[$j]->universite, 'sinif' => $class[$j]->sinif])->update([
                            'yerlesen_ogrenci' => ($b + 1)
                        ]);
                    }

                    if ($b == $capacities[$j]->kapasite)
                    {
                        DB::table('class')->where(['universite' => $class[$j]->universite, 'sinif' => $class[$j]->sinif])->update([
                            'yerlesen_ogrenci' => $b
                        ]);

                        $j = $j + 1;
                        $b = 0;
                    }

                    if ($i == $countStudent)
                    {
                        DB::table('class')->where(['universite' => $class[$j]->universite, 'sinif' => $class[$j]->sinif])->update([
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
        DB::table('class')->update([
            'yerlesen_ogrenci' => 0
        ]);

        return back()
            ->with('delete_message', 'Tüm sınıflar boşaltılı.');
    }

    public  function listExamClass()
    {
        $documents = DB::table('sinav_giris_belge')->get();
        $classes = DB::table('class')->get();
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
