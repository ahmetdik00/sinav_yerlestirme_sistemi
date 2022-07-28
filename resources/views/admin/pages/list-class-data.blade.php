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
                <div class="col-sm-6 text-right">
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
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    @if(count($classes) == 0)
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz kayıtlı sınıf bilgileri bulunmamaktadır.</p>
                        </div>
                    @endif
                    <div class="card callout callout-info" style="display: {{ (count($classes) > 0) ? '' : 'none'}}">
                        <div class="card-header">
                            <h3 class="card-title col-sm-6">Kayıtlı sınıf Bilgileri</h3>

                            <h3 class="card-title col-sm-6 text-right">Listenin:
                                <a href="{{ route('siniflar') }}/sil" onclick="return confirm('Tüm öğrenci bilgilerini silmek istiyor musunuz?')" class="btn btn-danger a">
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
                                    <th>Şehir</th>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Kat</th>
                                    <th>Sınıf</th>
                                    <th>Kontenjan</th>
                                    <th>İşlemler</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $class)
                                    <tr>
                                        <td>{{ $class->sinav_ili }}</td>
                                        <td>{{ $class->universite }}</td>
                                        <td>{{ $class->fakulte }}</td>
                                        <td>{{ $class->kat }}</td>
                                        <td>{{ $class->sinif }}</td>
                                        <td>{{ $class->kapasite }}</td>
                                        <td class="tdc text-center">
                                            <a style="pointer-events: {{ ($documents == 0) ? '' : 'none' }}" href="{{ route('sinif-duzenle') }}/{{ $class->id }}" class="btn btn-warning" title="Düzenle">
                                                <i class="fa fa-edit"></i>
                                                <span>Düzenle</span>
                                            </a>
                                            <a style="pointer-events: {{ ($documents == 0) ? '' : 'none' }}" href="{{ route('sinif-listele') }}/sil/{{ $class->id }}" title="Sil" onclick="return confirm('Gerçekten seçili sınıfı silmek istiyor musunuz?')" class="btn btn-danger a">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Sil</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Şehir</th>
                                    <th>Üniversite</th>
                                    <th>Fakülte</th>
                                    <th>Kat</th>
                                    <th>Sınıf</th>
                                    <th>Kontenjan: <span class="badge badge-info f-s">{{ $capacity }}</span></th>
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
