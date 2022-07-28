@extends('admin.layouts.master')
@section('title', 'Sınav Sonuçları Yükleme')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sınav Sonuçları</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Sınav Sonuçları</li>
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
                    <div class="card callout callout-info">
                        <div class="card-header">
                            Sınıf Sonuçları Yükleme
                        </div>
                        <div class="card-body pb-0">
                            <form class="card-title col-sm-6" action="{{ route('sinav-sonuclari-yukle') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="file" name="file" id="excel_file">
                                    <button id="button" style="display: none" type="submit" class="btn btn-info">Ekle</button>
                                </div>
                            </form>

                            @if(count($results) > 0)
                                <h3 class="card-title col-sm-6 text-right">Sonuçların:
                                    <a href="{{ route('sonucları-sil') }}" onclick="return confirm('Tüm sınav sonuç bilgilerini silmek istiyor musunuz?')" class="btn btn-danger a">
                                        <i class="fa fa-trash-alt" title="Sil"></i>
                                        <span>Hepsini Sil</span>
                                    </a>
                                </h3>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <span>{{ session('message_danger') }}</span>
                    @if(count($results) == 0)
                        <div class="callout callout-info">
                            <h5><i class="icon fas fa-info mr-2"></i> Bilgi!</h5>

                            <p>Henüz sınav sonuçları yüklenmedi.</p>
                        </div>
                    @endif

                    <div class="card callout callout-info" id="card" style="display: none">
                        <div class="card-header">
                            <h3 class="card-title">Yeni Yüklenecek Sınav Sonuç Bilgileri</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 585px;" id="excel_data">

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card callout callout-info" id="card" style="display: {{ (count($results) > 0) ? '' : 'none'}}">
                        <div class="card-header">
                            <h3 class="card-title">Sınav Sonuçları</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 585px;" id="excel_data">
                            <table class="table table-head-fixed text-nowrap">
                                <tr style="font-weight: 700">
                                    <th>Email</th>
                                    <th>Puan</th>
                                </tr>
                                @foreach($results as $result)
                                    <tr>
                                        <td>{{ $result->email }}</td>
                                        <td>{{ $result->puan }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
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
                    let sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1})

                    if (sheet_data.length > 0)
                    {
                        let table_output = '<table class="table table-head-fixed text-nowrap">';

                        for (let row = 0; row < sheet_data.length; row++)
                        {
                            if (row === 0)
                            {
                                table_output += '<tr style="font-weight: 700">';
                            }

                            for (let cell = 0; cell < sheet_data[row].length; cell++)
                            {
                                table_output += '<td>' +sheet_data[row][cell]+ '</td>';
                            }
                            table_output += '</tr>';
                        }
                        table_output += '</table>';

                        document.getElementById('excel_data').innerHTML = table_output;
                        document.getElementById('card').style.display = 'block';
                        document.getElementById('button').style.display = 'inline-block';
                    }
                }


            }else{
                alert("Lütfen geçerli bir excel dosyası seçin.");
            }

        });

        @if(session('message_success'))
            window.onload = function () {
            toastr.success('Sınav sonuçları başarıyla eklendi.');
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
            toastr.success('Sonuçlar başarıyla silindi.');
        }
        @endif


        @if(session('delete_all'))
            window.onload = function () {
            toastr.success('Sınıflar başarıyla silindi.');
        }
        @endif

    </script>
@endsection
