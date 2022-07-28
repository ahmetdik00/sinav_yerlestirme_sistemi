<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $count =  DB::table('sinav_giris_belge')->where('kimlik_no', session('kimlik_no'))->count('kimlik_no');
        $countSonuc =  DB::table('sinav_sonuc_belge')->where('email', session('email'))->count('email');
        $students = DB::table('student_info')->where('kimlik_no', session('kimlik_no'))->get();
        $student = $students[0];
        return view('user.index', compact('student', 'count', 'countSonuc'));
    }

    public function entryDocument()
    {
        $count =  DB::table('sinav_giris_belge')->where('kimlik_no', session('kimlik_no'))->count('kimlik_no');
        $countSonuc =  DB::table('sinav_sonuc_belge')->where('email', session('email'))->count('email');
        $students =  DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.kimlik_no', session('kimlik_no'))
            ->get();
        $student = $students[0];
        return view('user.pages.exam-entry-document', compact('student', 'count', 'countSonuc'));
    }

    public function entryDocumentPrintOut()
    {
        $students =  DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.kimlik_no', session('kimlik_no'))
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

    public function resultDocument()
    {
        $count =  DB::table('sinav_giris_belge')->where('kimlik_no', session('kimlik_no'))->count('kimlik_no');
        $countSonuc =  DB::table('sinav_sonuc_belge')->where('email', session('email'))->count('email');
        $students =  DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.kimlik_no', session('kimlik_no'))
            ->get();
        $results =  DB::table('sinav_sonuc_belge')->where('email', session('email'))->get();
        $student = $students[0];
        $result = $results[0];
        return view('user.pages.exam-result-document', compact('student', 'count', 'result', 'countSonuc'));
    }

    public function resultDocumentPrintOut()
    {
        $students =  DB::table('sinav_giris_belge')
            ->join('student_info', 'sinav_giris_belge.aday_no', '=', 'student_info.aday_no')
            ->select('sinav_giris_belge.*', 'student_info.aday_resim')
            ->where('sinav_giris_belge.kimlik_no', session('kimlik_no'))
            ->get();
        $results =  DB::table('sinav_sonuc_belge')->where('email', session('email'))->get();
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
}
