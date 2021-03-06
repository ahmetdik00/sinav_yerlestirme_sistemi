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
                                HATAY MUSTAFA KEMAL ??N??VERS??TES?? ULUSLARARASI ????RENC??<br>
                                SE??ME VE YERLE??T??RME SINAVI SINAV G??R???? BELGES?? <br>
                                (HMK??Y??S-2022) <br>
                                HATAY MUSTAFA KEMAL UNIVERSTY INTERNATIONAL STUDENT <br>
                                SELECTION AND PLACEMENT EXAM RESULTS DOCUMENT <br>
                                (HMK??Y??S-2022)
                            </b>
                        </td>
                        <td style="width: 100px">
                            <img style="width: 97px; height: 120px" src="data:image/png;base64,' . $image2 . '" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td><b>Aday Numaras??</b> / Application <br> Number</td>
                        <td colspan="2">' . $student->aday_no .'</td>
                    </tr>
                    <tr>
                        <td><b>T.C. Kimlik / Y.U. Numaras??</b> / FR Number</td>
                        <td colspan="2">' . $student->kimlik_no .'</td>
                    </tr>
                    <tr>
                        <td><b>ADI  ve SOYADI</b> / Name and Surname</td>
                        <td colspan="2">' .  $student->ad_soyad .'</td>
                    </tr>
                    <tr>
                        <td><b>Baba Ad??</b> / Father name</td>
                        <td colspan="2">' . $student->baba_adi .'</td>
                    </tr>
                    <tr>
                        <td><b>Do??um Yeri</b> / Place of Birth</td>
                        <td colspan="2">' . $student->dogum_yeri .'</td>
                    </tr>
                    <tr>
                        <td><b>Do??um Tarihi</b> / Date of Brith</td>
                        <td colspan="2">' . $student->dogum_tarihi .'</td>
                    </tr>
                    <tr>
                        <td><b>Uyru??u</b> / Nationalty</td>
                        <td colspan="2">' . $student->uyruk .'</td>
                    </tr>
                    <tr>
                        <td><b>SINAV ??L??</b>  / Exam Province</td>
                        <td colspan="2">' . $student->sinav_ili .'</td>
                    </tr>
                    <tr>
                        <td><b>SINAV YER??</b> / Exam Place</td>
                        <td colspan="2">' . $student->universite .'</td>
                    </tr>
                    <tr>
                        <td><b>FAK??LTE</b> / Faculty</td>
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
                        <td><b>SINAV TAR??H??</b> / SAAT?? Exam <br> Date / Time</td>
                        <td colspan="2">' . $student->created_at .'</td>
                </table>
                            <div style="width: 700px; font-size: 10px; margin-right: 20px; margin-left: 20px">
                                <b style="margin-left: 250px">ADAYLARIN D??KKAT??NE</b> <br> <br>

                                1.	S??nav s??resi 120 dakikad??r.<br>
                                2.	S??navda; Temel ????renme Becerileri (40 soru) ve Matematik (40 soru) testi olmak ??zere toplam 80 soru sorulacakt??r.<br>
                                3.	S??nav??n ilk 15 dakikas??ndan gelen adaylar s??nav binas??na al??nmayacakt??r. <br>
                                4.	4 Yanl???? 1 Do??ru cevab?? g??t??rmektedir. <br>
                                5.	Adaylar s??nava; T.C Kimlik Kart??, N??fus C??zdan??, Ge??ici Kimlik Belgesi, S??resi Ge??memi?? Pasaport, ??kamet ??zin Belgesi Evlilik C??zdan??,
                                <br> K.K.T.C Kimlik Belgesi, Pembe-Mavi Kart, ????i??leri Bakanl?????? G???? ??daresi taraf??ndan verilen s??resi ge??erli ???Uluslararas?? Koruma Stat?? Sahibi
                                <br> Kimlik Belgesi??? ile ???Ge??ici Koruma Kimlik Belgesi (Suriye Uyruklular i??in)???  belgelerinden herhangi bir kimlik belgesine ek olarak s??nava giri??
                                <br> Kimlik Belgesi??? ile belgelerinden herhangi bir kimlik belgesine ek olarak s??nava giri?? belgesiyle girebileceklerdir. Say??lan kimlik belgesi eksik olan ve s??nava giri?? belgesi olmayan adaylar s??nava al??nmayacakt??r.
                                <br>
                                6.	Adaylar??n s??nava girebilmeleri i??in gerekli belgeler d??????nda, yanlar??nda ??anta, g??ne?? g??zl??????, ka????t, kitap, defter, not vb. dok??manlar,
                                <br> pergel, a??????l??er, cetvel vb. ara??lar; cep telefonu, bilgisayar, hesap makinesi, tablet telsiz, kamera, kulakl??k vb. ileti??im, depolama, kay??t ve
                                <br> veri aktarma cihazlar??; ruhsatl?? veya resmi ama??l?? olsa bile silah ve silah yerine ge??ebilecek nesneler bulundurmalar?? yasakt??r.
                                <br>
                                7.	S??nava gelirken yan??n??zda kur??un kalem, silgi ve kalemt??ra?? bulundurmal??s??n??z. <br>
                                8.	Ba??vuru s??ras??nda biyometrik foto??raf y??klemeyen veya kimli??inde foto??raf?? net olmayanlar??n yanlar??nda biyometrik foto??raf getirmeleri gerekmektedir.
                                <br><br>

                                <b style="margin-left: 250px">ATTENTION TO CANDIDATES</b> <br><br>

                                1.	Duration for the exam is 120 minutes. <br>
                                2.	A total of 80 questions will be asked,  including The Basic Learning Skills (40 questions) and Mathematics (40 questions) test.
                                <br>
                                3.	Candidates who arrive after the first 15 minutes of the exam will not be admitted to the exam building.
                                <br>
                                4.	4 Wrong lead to 1 correct answer. <br>
                                5.	You can enter the exam with the official cards written below and the exam entrance document. T.C. Identity Card, T.C. Temporary Identity
                                <br> Document, Unaxpired passport, Recidence Permit Certificate, Marriage certificate, K.K.T.C Identity Card, Pink-Blue Card. ???International
                                <br> Protection Status Owner Idenntity Document???  valid for the period given by the ID card or the entrance document will not be allowed to take the exam.
                                <br>
                                6.	Canditates are not allowed to take the exam with the following items: Bags, sunglasses, paper, boks, notebooks, notes, documents,
                                <br> compasses, protractors, rulers, cell phones, computers, calculators, tablets, radios, cameras, headsets, communications, storage,
                                <br> recording and data transfer devices and weapons. <br>
                                7.	You should have a pencil, eraser and sharperner with you when you come to the exam.
                                <br>
                                8.	Who don???t upload a biometric photo during the application process or who dont have a clear photo on their identity card, They have to
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
        return back()->with($dompdf->stream('HMK??Y??S - 2022 SINAV G??R???? BELGES??'));

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
                                    HATAY MUSTAFA KEMAL ??N??VERS??TES?? ULUSLARARASI ????RENC?? <br>
                                    SE??ME VE YERLE??T??RME SINAV SONU?? BELGES??<br>
                                    (HMK??Y??S-2022) <br>
                                    HATAY MUSTAFA KEMAL UNIVERSTY INTERNATIONAL STUDENT <br>
                                    SELECTION AND PLACEMENT EXAM RESULTS DOCUMENT <br>
                                    (HMK??Y??S-2022)
                                </b>
                            </td>
                            <td>
                                <img style="height: 220px; width: 180px" src="data:image/png;base64,' . $image2 . '" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 5px">
                                <strong>S??nav Tarihi: 21 HAZ??RAN 2022, 10:30</strong> / Examination Date: 21 June 2021, 10:30
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Aday Numaras?? </strong>/ Application Number
                            </td>
                            <td colspan="2">
                                ' . $student->aday_no . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>T.C. Kimlik/Y.U. Numaras?? </strong>/ FR Number
                            </td>
                            <td colspan="2">
                                ' . $student->kimlik_no . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Ad?? ve Soyad?? </strong>/ Name and Surname
                            </td>
                            <td colspan="2">
                                ' . $student->ad_soyad . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Baba Ad??</strong> / Middle name
                            </td>
                            <td colspan="2">
                                ' . $student->baba_adi . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Do??um Yeri</strong> / Birth Place
                            </td>
                            <td colspan="2">
                                ' . $student->dogum_yeri . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Do??um Tarihi </strong>/ Date of Brith
                            </td>
                            <td colspan="2">
                                ' . $student->dogum_tarihi . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Uyru??u </strong>/ Nationalty
                            </td>
                            <td colspan="2">
                                ' . $student->uyruk . '
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Puan?? / Score</strong>
                            </td>
                            <td colspan="2">
                                ' . $result->puan . '
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <ol style="padding-top: 1rem; padding-left: 60px">
                        <li>
                            S??nav sonu??lar?? Aday numaras??na g??re
                            <a href="http://yosbelgedogrulama.mku.edu.tr/">
                                <strong>http://yosbelgedogrulama.mku.edu.tr/</strong>
                            </a><br>
                            adresi ??zerinden sorgulanabilmektedir.
                        </li>
                        <li>
                            HMK??Y??S-2022 s??nav??nda adaylara 80 soru sorulmu??, s??nav y??z y??ze
                            yap??lm????t??r.
                        </li>
                        <li>
                            Adaylar??n puanlar??, HMK??Y??S-2022 deki sorulara verdikleri do??ru ve
                            yanl???? cevaplar?? ayr?? ayr?? <br> say??larak 4 yanl???? cevap say??s??n??n 1 do??ru
                            cevab?? eksiltmesi sonucu olu??mu??tur.
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
        return back()->with($dompdf->stream('HMK??Y??S - 2022 SINAV SONU?? BELGES??'));
    }
}
