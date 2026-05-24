<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Silo System</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @yield('styles')
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-left">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('asset/logo-bksn.png') }}" class="navbar-logo">
        </a>
    </div>
    <div class="nav-right">
        @auth
            <span id="username">{{ Auth::user()->name }}</span>
            <div class="profile-menu">
                <img src="{{ asset('asset/profile-biru.png') }}" class="avatar" onclick="toggleMenu()">
                <div id="dropdown" class="dropdown">
                    <p onclick="window.location.href='{{ route('profile') }}'">Profil</p>
                    <p onclick="window.location.href='{{ route('editprofile') }}'">Edit Profil</p>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <p onclick="document.getElementById('logout-form').submit();">Keluar</p>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" style="color: white; text-decoration: none;">Login</a>
        @endauth
    </div>
</div>

<!-- MAIN -->
@yield('header')
<div class="main">
    @auth
    <!-- SIDEBAR LEFT -->
    <div class="sidebar-left">
        <p><b>Menu</b></p>
        <a href="{{ route('dashboard') }}" class="menu-item" style="display: block; text-decoration: none; color: inherit;">Beranda</a>
        <a href="{{ route('profile') }}" class="menu-item" style="display: block; text-decoration: none; color: inherit;">Profil</a>
        
        @if(Auth::user()->role === 'customer')
            <a href="{{ route('layanan') }}" class="menu-item" style="display: block; text-decoration: none; color: inherit;">Layanan</a>
            <a href="{{ route('progres') }}" class="menu-item" style="display: block; text-decoration: none; color: inherit;">Progres</a>
        @else
            <p onclick="toggleGroupMenu()" class="menu-item">Grup</p>

            <!-- GROUP MENU -->
            <div class="group-menu">
                <div id="groupDropdown" class="group-dropdown">
                    <a href="{{ route('group', ['name' => 'Admin']) }}" class="group-item" style="text-decoration: none; color: inherit;">
                        <img src="{{ asset('asset/profile-putih.png') }}"> Admin
                    </a>
                    <a href="{{ route('group', ['name' => 'Web Developer']) }}" class="group-item" style="text-decoration: none; color: inherit;">
                        <img src="{{ asset('asset/profile-putih.png') }}"> Web Developer
                    </a>
                    <a href="{{ route('group', ['name' => 'Designer']) }}" class="group-item" style="text-decoration: none; color: inherit;">
                        <img src="{{ asset('asset/profile-putih.png') }}"> Designer
                    </a>
                </div>
            </div>
        @endif

        @can('is-staff')
        <p onclick="toggleManagementMenu()" class="menu-item" style="color: #1877f2; font-weight: bold;">Manajerial</p>
        <div id="managementDropdown" class="group-dropdown" style="display: none;">
            @can('is-admin')
            <a href="{{ route('management.admin') }}" class="group-item" style="text-decoration: none; color: inherit;">
                <img src="{{ asset('asset/grup-admin.png') }}"> Admin Panel
            </a>
            @endcan
            @can('is-web-dev')
            <a href="{{ route('management.web_dev') }}" class="group-item" style="text-decoration: none; color: inherit;">
                <img src="{{ asset('asset/grup-webdeveloper.png') }}"> Web Dev Panel
            </a>
            @endcan
            @can('is-designer')
            <a href="{{ route('management.designer') }}" class="group-item" style="text-decoration: none; color: inherit;">
                <img src="{{ asset('asset/grup-designer.png') }}"> Designer Panel
            </a>
            @endcan
            <p onclick="alert('Fitur buat grup baru belum dihubungkan ke backend')" style="font-weight: normal; padding-left: 15px;">Buat grup baru</p>
        </div>
        @endcan
    </div>
    @endauth

    <div class="content" style="flex: 1;">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    @auth
    @yield('sidebar-right')
    @endauth
</div>

<script>
    function toggleMenu() {
        let menu = document.getElementById("dropdown");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    function toggleGroupMenu() {
        let menu = document.getElementById("groupDropdown");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    function toggleManagementMenu() {
        let menu = document.getElementById("managementDropdown");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    window.onclick = function(event) {
        if (!event.target.matches('.avatar')) {
            let dropdowns = document.getElementsByClassName("dropdown");
            for (let i = 0; i < dropdowns.length; i++) {
                let openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    }
</script>
@yield('scripts')
</body>
</html>
