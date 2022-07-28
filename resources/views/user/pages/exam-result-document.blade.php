@extends('user.layouts.master')
@section('title', 'Sonuç Belgesi')
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
                        <li class="breadcrumb-item active">Exam Result Document</li>
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
                                Exam Result Document
                            </h3>
                        </div>
                        <a class="b" href="{{ route('sonuc-belge-cikti') }}" style="cursor: pointer; position: absolute; top: 80px; right: 28px; padding-left: 50px; line-height: 43px; z-index: 100;">
                            <i class="fa fa-print nav-icon" style="font-size: 30px"></i>
                        </a>
                        <div id="data" class="card-body d-flex flex-column align-items-center">
                            <table class="tabled table-borderedd">

                                <tr style="height: 150px">
                                    <td class="text-center pt-4 pad" style="width: 250px">
                                        <img style="padding: 40px" src="{{ asset('img/image001.png') }}" alt="">
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
                                        <img style="width: 190px; height: 240px" src="{{ asset('img/Foto/' . $student->aday_resim . '.jpg') }}" alt="">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="padding: 5px" colspan="5">
                                        Sınav Tarihi: 21 HAZİRAN 2022, 10:30 <span class="slim">/ Examination Date: 21 June 2021, 10:30</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Aday Numarası <span class="slim">/ Application Number</span></td>
                                    <td colspan="2">{{ $student->aday_no }}</td>
                                </tr>
                                <tr>
                                    <td>T.C. Kimlik/Y.U. Numarası <span class="slim">/ FR Number</span></td>
                                    <td colspan="2">{{ $student->kimlik_no }}</td>
                                </tr>
                                <tr>
                                    <td>Adı ve Soyadı <span class="slim">/ Name and Surname</span></td>
                                    <td colspan="2">{{ $student->ad_soyad }}</td>
                                </tr>
                                <tr>
                                    <td>Baba Adı <span class="slim">/ Middle name</span></td>
                                    <td colspan="2">{{ $student->baba_adi }}</td>
                                </tr>
                                <tr>
                                    <td>Doğum Yeri <span class="slim">/ Birth Place</span></td>
                                    <td colspan="2">{{ $student->dogum_yeri }}</td>
                                </tr>
                                <tr>
                                    <td>Doğum Tarihi <span class="slim">/ Date of Brith</span></td>
                                    <td colspan="2">{{ $student->dogum_tarihi }}</td>
                                </tr>
                                <tr>
                                    <td>Uyruğu <span class="slim">/ Nationalty</span></td>
                                    <td colspan="2">{{ $student->uyruk }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 25px">Puanı / Score</td>
                                    <td colspan="2">{{ $result->puan }}</td>
                                </tr>
                            </table>
                            <div class="pt-3">
                                <ol>
                                    <li>Sınav sonuçları Aday numarasına göre <a class="href" href="http://yosbelgedogrulama.mku.edu.tr/">http://yosbelgedogrulama.mku.edu.tr/</a> adresi<br> üzerinden sorgulanabilmektedir.</li>
                                    <li>HMKÜYÖS-2022 sınavında adaylara 80 soru sorulmuş, sınav yüz yüze yapılmıştır.</li>
                                    <li>Adayların puanları, HMKÜYÖS-2022 deki sorulara verdikleri doğru ve yanlış cevapları ayrı ayrı<br> sayılarak 4 yanlış cevap sayısının 1 doğru cevabı eksiltmesi sonucu oluşmuştur.</li>
                                </ol>
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

