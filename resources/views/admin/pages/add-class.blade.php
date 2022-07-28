@extends('admin.layouts.master')
@section('title', 'Sınıf Ekle')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sınıf Ekleme İşlemleri</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item active">Sınıf Ekleme</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card callout callout-info">
                        <div class="card-header">
                            <h3 class="card-title">Sınıf Ekle</h3>
                        </div>
                        <div class="card-body">
                            <!-- Date -->
                            <form class="form-group-lg"  action="{{ route('sinif-ekle') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label>Şehir:</label>
                                    <input type="text" name="sinav_ili" class="form-control" required/>
                                </div>

                                <div class="form-group">
                                    <label>Üniversite:</label>
                                    <input type="text" name="universite" class="form-control"required/>
                                </div>

                                <div class="form-group">
                                    <label>Fakülte:</label>
                                    <input type="text" name="fakulte" class="form-control"required/>
                                </div>

                                <div class="form-group">
                                    <label>Kat:</label>
                                    <input type="text" name="kat" class="form-control"required/>
                                </div>

                                <div class="form-group">
                                    <label>Sınıf:</label>
                                    <input type="text" name="sinif" class="form-control"required/>
                                </div>

                                <div class="form-group">
                                    <label>Kapasite:</label>
                                    <input type="number" name="kapasite" class="form-control"required/>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-info" style="width: 100px">Ekle</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </section>
@endsection
@section('foot')
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <script>

        @if(session('message_success'))
            window.onload = function () {
            toastr.success('Ekleme işlemi başarıyla tamamlandı.');
        }
        @endif

        @if(session('message_danger'))
            window.onload = function () {
            toastr.error('Ekleme işlemi yapılamadı.');
        }
        @endif

    </script>

@endsection
