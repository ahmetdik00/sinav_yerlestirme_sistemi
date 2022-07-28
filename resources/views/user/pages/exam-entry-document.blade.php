@extends('user.layouts.master')
@section('title', 'Giriş Belgesi')
@section('head')
    <style>
        <!--
        /* Font Definitions */
        @font-face {
            font-family: "Cambria Math";
            panose-1: 2 4 5 3 5 4 6 3 2 4;
        }

        @font-face {
            font-family: Tahoma;
            panose-1: 2 11 6 4 3 5 4 4 2 4;
        }

        @font-face {
            font-family: "Segoe UI";
            panose-1: 2 11 5 2 4 2 4 2 2 3;
        }

        /* Style Definitions */
        p.MsoNormal, li.MsoNormal, div.MsoNormal {
            margin: 0in;
            font-size: 12.0pt;
            font-family: "Times New Roman", serif;
        }

        span.Gvdemetni27ptKaln {
            mso-style-name: "Gövde metni \(2\) + 7 pt\.Kalın";
            font-family: "Tahoma", sans-serif;
            font-variant: normal !important;
            color: black;
            position: relative;
            top: 0pt;
            letter-spacing: 0pt;
            font-weight: bold;
            font-style: normal;
            text-decoration: none;
        }

        span.Gvdemetni2 {
            mso-style-name: "Gövde metni \(2\)_";
            mso-style-link: "Gövde metni \(2\)";
            font-family: "Tahoma", sans-serif;
            background: white;
        }

        p.Gvdemetni20, li.Gvdemetni20, div.Gvdemetni20 {
            mso-style-name: "Gövde metni \(2\)";
            mso-style-link: "Gövde metni \(2\)_";
            margin: 0in;
            text-indent: -44.0pt;
            line-height: 11.5pt;
            background: white;
            font-size: 9.5pt;
            font-family: "Tahoma", sans-serif;
        }

        @page WordSection1 {
            size: 595.3pt 841.9pt;
            margin: 70.9pt 70.9pt 70.9pt 70.9pt;
        }

        div.WordSection1 {
            page: WordSection1;
        }

        -->
    </style>
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user') }}">Home</a></li>
                        <li class="breadcrumb-item active">Exam Entry Document</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card callout callout-info" style="background-color: #fffffc;">
                        <div class="card-header">
                            <h3 class="card-title">
                                Exam Entry Document
                            </h3>
                        </div>
                        <a class="b" href="{{ route('giris-belge-cikti') }}" style="cursor: pointer; position: absolute; top: 80px; right: 28px; padding-left: 50px; line-height: 43px; z-index: 100;">
                            <i class="fa fa-print nav-icon" style="font-size: 30px  "></i>
                        </a>
                        <div id="data" class="card-body d-flex flex-column align-items-center">
                            <table class="tabled table-borderedd" style="width:auto;">
                                <tr style="height: 150px">
                                    <td class="text-center pt-4 pad" style="width: 250px">
                                        <img style="" src="{{ asset('img/image001.png') }}" alt="">
                                    </td>
                                    <td style="text-align: center">
                                        T.C. <br>
                                        HATAY MUSTAFA KEMAL ÜNİVERSİTESİ <br>
                                        ULUSLARARASI ÖĞRENCİ SEÇME VE YERLEŞTİRME SINAV SONUÇ BELGESİ <br>
                                        (HMKÜYÖS-2022) <br>
                                        HATAY MUSTAFA KEMAL UNIVERSTY INTERNATIONAL STUDENT <br>
                                        SELECTION AND PLACEMENT EXAM RESULTS DOCUMENT <br>
                                        (HMKÜYÖS-2022)
                                    </td>
                                    <td style="width: 200px;">
                                        <img style="width: 190px; height: 180px" src="{{ asset('img/Foto/' . $student->aday_resim . '.jpg') }}" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        Aday Numarası /
                                        <span class="slim">Application Number</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->aday_no }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        T.C. Kimlik / Y.U. Numarası /
                                        <span class="slim">FR Number</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->kimlik_no }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        ADI  ve SOYADI /
                                        <span class="slim">Name and Surname</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->ad_soyad }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        Baba Adı /
                                        <span class="slim">Father name</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->baba_adi }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        Doğum Yeri /
                                        <span class="slim">Place of Birth</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->dogum_yeri }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        Doğum Tarihi /
                                        <span class="slim">Date of Brith</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->dogum_tarihi }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        Uyruğu /
                                        <span class="slim">Nationalty</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->uyruk }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        SINAV İLİ  /
                                        <span class="slim">Exam Province</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->sinav_ili }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        SINAV YERİ /
                                        <span class="slim">Exam Place</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->universite }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        FAKÜLTE /
                                        <span class="slim">Faculty</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->fakulte }}</td>
                                </tr>
                                <tr>
                                <tr>
                                    <td class="pad">
                                        KAT /
                                        <span class="slim">Floor</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->kat }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        SINIF NO /
                                        <span class="slim">Class Number</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->sinif }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        SIRA NUMARASI /
                                        <span class="slim">Seat Number</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->sira }}</td>
                                </tr>
                                <tr>
                                    <td class="pad">
                                        SINAV TARİHİ /
                                        <span class="slim">SAATİ Exam <br> Date / Time</span>
                                    </td>
                                    <td class="slim pad" colspan="2">{{ $student->created_at }}</td>
                                </tr>
                            </table>
                            <div style="width: 750px">
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
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </section>
@endsection

