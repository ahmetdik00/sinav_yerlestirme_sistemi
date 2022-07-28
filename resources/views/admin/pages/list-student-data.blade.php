@extends('admin.layouts.master')
@section('title', 'Öğrenci Listesi')
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
                    <h1>Öğrenci Listesi</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Öğrenci Listesi</li>
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
                    @if(count($students) == 0)
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz kayıtlı öğrenci bilgileri bulunmamaktadır.</p>
                        </div>
                    @endif

                    <div class="card callout callout-info" style="display: {{ (count($students) > 0) ? '' : 'none'}}">
                        <div class="card-header">
                            <h3 class="card-title col-sm-6">Kayıtlı Öğrenci Bilgileri</h3>

                            <h3 class="card-title col-sm-6 text-right" style="display: {{ (count($students) == 0) ? 'none' : ''}}">Listenin:
                                <a href="{{ route('ogrenciler') }}/sil" onclick="return confirm('Tüm öğrenci bilgilerini silmek istiyor musunuz?')" class="btn btn-danger a">
                                    <i class="fa fa-trash-alt" title="Sil"></i>
                                    <span>Hepsini Sil</span>
                                </a>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Aday No</th>
                                    <th>Aday</th>
                                    <th>Kimlik No</th>
                                    <th>E-Posta</th>
                                    <th>Telefon Numarası</th>
                                    <th>Adı Soyadı</th>
                                    <th>Cinsiyet</th>
                                    <th>Baba Adı</th>
                                    <th>Doğum Yeri</th>
                                    <th>Doğum Tarihi</th>
                                    <th>Uyruk</th>
                                    @if($countEntry > 0)
                                        <th>İşlemler</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->aday_no }}</td>
                                        <td>
                                            <img style="width: 50px; height: 50px;" src="{{ asset('img/Foto/' . $student->aday_resim . '.jpg') }}" alt="">
                                        </td>
                                        <td>{{ $student->kimlik_no }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->tel_no }}</td>
                                        <td>{{ $student->ad_soyad }}</td>
                                        <td>{{ $student->cinsiyet }}</td>
                                        <td>{{ $student->baba_adi }}</td>
                                        <td>{{ $student->dogum_yeri }}</td>
                                        <td>{{ $student->dogum_tarihi }}</td>
                                        <td>{{ $student->uyruk }}</td>

                                        @if($countEntry > 0)
                                            <td class="td text-center">
                                                <a href="{{ route('giris-belgesi', $student->aday_no) }}" class="btn btn-info a" title="Giriş Belgesi">
                                                    <i class="fa fa-eye"></i>
                                                    <span>Giriş Belgesi</span>
                                                </a>
                                                @if($countResult > 0)
                                                    <a href="{{ route('sonuc-belgesi', [$student->aday_no, $student->email]) }}" class="btn btn-primary a" title="Sonuç Belgesi">
                                                        <i class="fa fa-eye"></i>
                                                        <span>Sonuç Belgesi</span>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Aday No</th>
                                    <th>Aday</th>
                                    <th>Kimlik No</th>
                                    <th>E-Posta</th>
                                    <th>Telefon Numarası</th>
                                    <th>Adı Soyadı</th>
                                    <th>Cinsiyet</th>
                                    <th>Baba Adı</th>
                                    <th>Doğum Yeri</th>
                                    <th>Doğum Tarihi</th>
                                    <th>Uyruk</th>
                                    @if($countEntry > 0)
                                        <th>İşlemler</th>
                                    @endif
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
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
            toastr.success('Öğrenciler başarıyla aktarıldı.');
        }
        @endif

        @if(session('message_deleteAllsuccess'))
            window.onload = function () {
            toastr.success('Öğrenci bilgileri başarıyla silindi.');
        }
        @endif
    </script>
@endsection
