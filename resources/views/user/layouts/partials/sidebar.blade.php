<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('user') }}" class="brand-link  mb-2">
        <img src="{{ asset('img/Foto/'. $student->aday_resim .'.jpg') }}" alt="MKU Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 35px">
        <span class="brand-text font-weight-light">{{ $student->ad_soyad }}</span>
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
                    <a href="{{ route('user') }}" class="nav-link  {{ (request()->is('kullanici*')) ? 'active' : '' }}">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Belgeler
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($count > 0)
                            <li class="nav-item">
                                <a href="{{ route('giris-belge') }}" class="nav-link {{ (request()->is('kullanici/giris-belge')) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sınav Giriş Belgesi</p>
                                </a>
                            </li>
                        @endif
                        @if($countSonuc > 0)
                        <li class="nav-item">
                            <a href="{{ route('sonuc-belge') }}" class="nav-link {{ (request()->is('kullanici/sonuc-belge')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Sınav Sonuç Belgesi
                                </p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
