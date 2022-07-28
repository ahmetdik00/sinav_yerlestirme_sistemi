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
                    <h1>Sınav Sınıf Listeleri</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Sınav Sınıf Listeleri</li>
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
                    @if(count($documents) == 0)
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz kayıtlı sınav sınıf bilgileri bulunmamaktadır.</p>
                        </div>
                    @endif
                    <div class="card callout callout-info" style="display: {{ (count($documents) > 0) ? '' : 'none'}}">
                        <div class="card-header">
                            <h3 class="card-title">Kayıtlı sınav sınıf Bilgileri</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Sınıf</th>
                                    <th>Öğrenci Sayısı</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $class)
                                    <tr>
                                        <td>{{ $class->universite }}</td>
                                        <td>{{ $class->fakulte }}</td>
                                        <td>{{ $class->sinif }}</td>
                                        <td>
                                            <span style="font-size: 15px" class="badge badge-{{ ($class->yerlesen_ogrenci == 0) ? 'danger' : 'success' }}">{{ $class->yerlesen_ogrenci }}</span>
                                        </td>
                                        <td class="tdc text-center">
                                            <a href="{{ route('sinif-goruntule', [$class->universite, $class->sinif]) }}" class="btn btn-info a" title="Görüntüle">
                                                <i class="fa fa-eye"></i>
                                                <span>Görüntüle</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Sınıf</th>
                                    <th>Öğrenci Sayısı</th>
                                    <th>İşlemler</th>
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
            toastr.success('Sınıflar başarıyla aktarıldı.');
        }
        @endif

        @if(session('message_delete'))
            window.onload = function () {
            toastr.success('Sınıf başarıyla silindi.');
        }
        @endif

        @if(session('message_update'))
            window.onload = function () {
            toastr.success('Sınıf bilgisi başarıyla düzenlendi.');
        }
        @endif
    </script>
@endsection
