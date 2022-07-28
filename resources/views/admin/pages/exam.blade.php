@extends('admin.layouts.master')
@section('title', 'Sınav Yerleştirme')
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
                    <h1>Sınav İşlemleri</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Sınav İşlemleri</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @if(count($documents) > 0)
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-graduate"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">{{ count($documents) }}</span>
                            <span class="info-box-text">Öğrenci yerleşti</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-user-graduate"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">{{ abs(count($student) - count($documents)) }}</span>
                            <span class="info-box-text">Öğrenci Yerleşmedi</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">{{ $sayi }}</span>
                            <span class="info-box-text">Sınıf Ayarlandı</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fa fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-number">{{ count($classes) - $sayi }}</span>
                            <span class="info-box-text">Sınıf Ayarlanmadı</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card callout callout-info">
                        <div class="card-body">
                            <h3 class="card-title" style="display: {{ (count($documents) > 0) ? 'none' : ''}}"> Sınıflara:
                                <a href="{{ route('sinif-yerlestir') }}" class="btn btn-info a">
                                    <span>Yerleştir</span>
                                </a>
                            </h3>
                            <h3 class="card-title" style="display: {{ (count($documents) == 0) ? 'none' : ''}}">Yerleşenlerin:
                                <a href="{{ route('sinav') }}/sil" onclick="return confirm('Gerçekten tüm sınıfları silmek istiyor musunuz?')" class="btn btn-danger a">
                                    <i class="fa fa-trash-alt" title="Sil"></i>
                                    <span>Hepsini Sil</span>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    @if(count($classes) == 0)
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz kayıtlı sınıf bilgileri bulunmamaktadır.</p>
                        </div>
                    @endif

                    <div class="card callout callout-info" style="display: {{ (count($classes) > 0) ? '' : 'none'}}">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Şehir</th>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Sınıf</th>
                                    <th>Kontenjan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $class)
                                    <tr>
                                        <td>{{ $class->sinav_ili }}</td>
                                        <td>{{ $class->universite }}</td>
                                        <td>{{ $class->fakulte }}</td>
                                        <td>{{ $class->sinif }}</td>
                                        <td>{{ $class->kapasite }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Şehir</th>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Sınıf</th>
                                    <th>Toplam Kontenjan: <b class="badge badge-warning f-s">{{ $capacity }}</b></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('foot')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        @if(session('message_success'))
            window.onload = function () {
            toastr.success('Öğrenciler başarıyla yerleştirildi.');
        }
        @endif

        @if(session('message_warning'))
            window.onload = function () {
            toastr.warning('Yerleştirmeye çalıştığınız öğrenciler daha önce yerleştirildi.');
        }
        @endif

        @if(session('message_error'))
            window.onload = function () {
            toastr.error('Var olmayan sınıflara öğrenci ataması yapamazsınız!');
        }
        @endif

        @if(session('message_uyari'))
            window.onload = function () {
            toastr.warning('Öğrenci sayısı toplam kontenjanı geçti yenı sınıflar ekleyiniz!');
        }
        @endif

        @if(session('message_error2'))
            window.onload = function () {
            toastr.error('Var olmayan öğrenclerin sınıflara ataması yapılamaz!');
        }
        @endif

        @if(session('delete_message'))
            window.onload = function () {
            toastr.success('Bütün sınıflar başarıyla boşaltıldı.');
        }
        @endif



    </script>
@endsection
