@extends('admin.layouts.master')
@section('title', 'Öğrenci Ekle')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Öğrenci Bilgilerini Yükleme</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Öğrenci Bilgileri</li>
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
                    <div class="card callout callout-info">
                        <div class="card-header">
                            Öğrenci Bilgileri
                        </div>
                        <div class="card-body pb-0">
                            <form id="sample_form" action="{{ route('ogrenci-ekle') }}" class="col-sm-6" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input id="token" name="_token" type="hidden" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <input type="file" name="file" id="excel_file">
                                    <button id="button" style="display: none" type="submit" class="btn btn-info">Ekle</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    @if(session('message_error'))
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <span>{{ session('message_error') }}</span>
                        </div>
                    @endif

                    <!-- /.card -->
                    @if(count($students) == 0)
                        <div class="callout callout-info info-b">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz kayıtlı öğrenci bilgileri bulunmamaktadır.</p>
                        </div>
                    @endif

                    <div class="card callout callout-info" id="card" style="display: none">
                        <div class="card-header">
                            <h3 class="card-title">Yeni Eklenecek Öğrenci Bilgileri</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 675px;" id="excel_data">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.4/xlsx.full.min.js"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>

        const excel_file = document.getElementById('excel_file');

        excel_file.addEventListener('change', (event) => {

            let reader = new FileReader();

            let filename = event.target.files[0].name;
            reader.readAsArrayBuffer(event.target.files[0]);
            let extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
            if (extension === '.XLS' || extension === '.XLSX') {

                reader.onload = function (event) {

                    let data = new Uint8Array(reader.result);
                    let work_book = XLSX.read(data, {type: 'array'});
                    let sheet_name = work_book.SheetNames;
                    let sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header: 1})

                    if (sheet_data.length > 0) {
                        let table_output = '<table class="table table-head-fixed text-nowrap">';

                        for (let row = 0; row < sheet_data.length; row++) {
                            if (row === 0) {
                                table_output += '<tr style="font-weight: 700">';
                            }

                            for (let cell = 0; cell < sheet_data[row].length; cell++) {
                                table_output += '<td>' + sheet_data[row][cell] + '</td>';
                            }
                            table_output += '</tr>';
                        }
                        table_output += '</table>';

                        document.getElementById('excel_data').innerHTML = table_output;
                        document.getElementById('card').style.display = 'block';
                        document.getElementById('button').style.display = 'inline-block';
                    }
                }


            } else {
                alert("Lütfen geçerli bir excel dosyası seçin.");
            }

        });

        @if(session('message_success'))
            window.onload = function () {
            toastr.success('Öğrenci bilgileri başarıyla aktarıldı.');
        }
        @endif

            @if(session('message_error'))
            window.onload = function () {
            toastr.error('Yüklemeye çalıştığınız veriler, veritabanında kayıtlı verilerle aynı veya verilerde bir hata var!');
        }
        @endif

        setTimeout(function () {
            $('.alert').slideUp(500);
        }, 3000);

    </script>
@endsection
