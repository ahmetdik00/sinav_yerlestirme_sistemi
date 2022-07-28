@extends('admin.layouts.master')
@section('title', 'Sınıf Listesi')
@section('head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sınıf Listesi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Sınıf Listesi</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    @if(count($classes) == 0)
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz kayıtlı sınıf bilgileri bulunmamaktadır.</p>
                        </div>
                    @endif

                    <div class="card card-success" style="display: {{ (count($classes) > 0) ? '' : 'none'}}">
                        <div class="card-header">
                            <h3 class="card-title col-sm-6">Kayıtlı Sınıf Bilgileri</h3>

                            <h3 class="card-title col-sm-6 text-right" style="display: {{ (count($students) == 0) ? 'none' : ''}}">Listenin:
                                <a href="{{ route('ogrenciler') }}/sil" onclick="return confirm('Tüm öğrenci bilgilerini silmek istiyor musunuz?')" class="btn btn-danger a">
                                    <i class="fa fa-trash-alt" title="Sil"></i>
                                    <span>Hepsini Sil</span>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 685px;">
                            <table class="table table-head-fixed text-nowrap">
                                <tr>
                                    <th>Şehir</th>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Sinif</th>
                                    <th>Kontenjan</th>
                                </tr>
                                @foreach($classes as $class)
                                    <tr>
                                        <td>{{ $class->sinav_ili }}</td>
                                        <td>{{ $class->universite }}</td>
                                        <td>{{ $class->fakulte }}</td>
                                        <td>{{ $class->sinif }}</td>
                                        <td>{{ $class->kapasite }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
                <!-- Modal -->
                <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">

                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Kayıtlı Öğrenci Bilgileri</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0" style="height: 670px;">
                                    <table class="table table-head-fixed text-nowrap">
                                        <tr>
                                            <th>Şehir</th>
                                            <th>Üniversite</th>
                                            <th>Fakülte</th>
                                            <th>Sınıf</th>
                                            <th>Sıra</th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
    </section>
@endsection
@section('foot')

    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>


        @if(session('message_success'))
            window.onload = function () {
            toastr.success('Sınıflar başarıyla eklendi.');
        }
        @endif

            @if(session('message_warning'))
            window.onload = function () {
            toastr.warning('Lütfen herhangi bir dosya seçin...');
        }
        @endif

            @if(session('message_danger'))
            window.onload = function () {
            toastr.error('Yüklemeye çalıştığınız veriler, veritabanında kayıtlı verilerle aynı veya verilerde bir hata var!');
        }
        @endif

            @if(session('delete'))
            window.onload = function () {
            toastr.success('Sınıf başarıyla silindi.');
        }
        @endif


            @if(session('delete_all'))
            window.onload = function () {
            toastr.success('Sınıflar başarıyla silindi.');
        }
        @endif

    </script>
@endsection
