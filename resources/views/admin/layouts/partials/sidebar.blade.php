<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin') }}" class="brand-link  mb-2">
        <img src="{{ asset('img/image001.png') }}" alt="MKU Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a class="nav-link  {{ (request()->is('admin') || request()->is('admin/ogrenciler*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Öğrenci İşlemleri
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ogrenci-listele') }}" class="nav-link {{ (request()->is('admin/ogrenciler/ogrenci-listele')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğrenci Listesi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ogrenciler') }}" class="nav-link {{ (request()->is('admin/ogrenciler')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Öğrenci Dosyadan Yükle</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a class="nav-link  {{ (request()->is('admin/siniflar*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users nav-icon"></i>
                        <p>
                            Sınıf İşlemleri
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sinif-listele') }}" class="nav-link {{ (request()->is('admin/siniflar/sinif-listele')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınıflar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sinif-ekle') }}" class="nav-link {{ (request()->is('admin/siniflar/sinif-ekle')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Yeni Sınıf Ekle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siniflar') }}" class="nav-link {{ (request()->is('admin/siniflar')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınıfları Dosyadan Yükle</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a class="nav-link  {{ (request()->is('admin/sinav*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users nav-icon"></i>
                        <p>
                            Sınav İşlemleri
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sinav') }}" class="nav-link  {{ (request()->is('admin/sinav')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınav Yerleştirme</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sinav-siniflari') }}" class="nav-link  {{ (request()->is('admin/sinav/sinav-siniflari')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınav Sınıfları</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sinav-sonuclari') }}" class="nav-link  {{ (request()->is('admin/sinav/sinav-sonuclari')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sınav Sonuçları Yükle</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
