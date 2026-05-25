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
            <div id="groupDropdown" class="group-dropdown" style="display: none;">
                <a href="{{ route('group', ['name' => 'Admin']) }}" class="group-item" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('asset/profile-putih.png') }}"> Admin
                </a>
                <a href="{{ route('group', ['name' => 'Web Developer']) }}" class="group-item" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('asset/profile-putih.png') }}"> Web Developer
                </a>
                <a href="{{ route('group', ['name' => 'Designer']) }}" class="group-item" style="text-decoration: none; color: inherit;">
                    <img src="{{ asset('asset/profile-putih.png') }}"> Designer
                </a>
                <p onclick="showCreateGroupModal()" class="group-item" style="cursor: pointer; padding-left: 49px; font-weight: normal; color: #65676b;">
                    Grup Baru
                </p>
            </div>
        @endif

        @can('is-staff')
        <p onclick="toggleManagementMenu()" class="menu-item">Manajerial</p>
        <div id="managementDropdown" class="group-dropdown" style="display: none;">
            <a href="{{ route('management.admin') }}" class="group-item" style="text-decoration: none; color: inherit;">
                <img src="{{ asset('asset/profile-putih.png') }}"> Admin
            </a>
            <a href="{{ route('management.web_dev') }}" class="group-item" style="text-decoration: none; color: inherit;">
                <img src="{{ asset('asset/profile-putih.png') }}"> Web Developer
            </a>
            <a href="{{ route('management.designer') }}" class="group-item" style="text-decoration: none; color: inherit;">
                <img src="{{ asset('asset/profile-putih.png') }}"> Designer
            </a>
            <p onclick="showCreateManagementModal()" class="group-item" style="cursor: pointer; padding-left: 49px; font-weight: normal; color: #65676b;">
                Manajerial Baru
            </p>
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

<!-- MODALS -->
<div id="createGroupModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
    <div style="background: white; margin: 5% auto; padding: 25px; border-radius: 15px; width: 40%; max-height: 85vh; overflow-y: auto; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Buat Grup Baru</h3>
            <button onclick="closeGroupModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Grup</label>
                <input type="text" placeholder="Contoh: Tim Creative" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            
            <div id="groupFields" style="margin-bottom: 20px;">
                <p style="font-weight: bold; margin-bottom: 10px;">Field Input:</p>
            </div>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                <p style="margin-top: 0; font-size: 0.9rem; color: #65676b; margin-bottom: 10px;">Tambah Field Baru:</p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <button type="button" onclick="addField('text')" style="padding: 5px 10px; border: 1px solid #1877f2; background: white; color: #1877f2; border-radius: 5px; cursor: pointer;">+ Teks</button>
                    <button type="button" onclick="addField('textarea')" style="padding: 5px 10px; border: 1px solid #1877f2; background: white; color: #1877f2; border-radius: 5px; cursor: pointer;">+ Textarea</button>
                    <button type="button" onclick="addField('dropdown')" style="padding: 5px 10px; border: 1px solid #1877f2; background: white; color: #1877f2; border-radius: 5px; cursor: pointer;">+ Dropdown</button>
                    <button type="button" onclick="addField('file')" style="padding: 5px 10px; border: 1px solid #1877f2; background: white; color: #1877f2; border-radius: 5px; cursor: pointer;">+ File</button>
                    <button type="button" onclick="addField('url')" style="padding: 5px 10px; border: 1px solid #1877f2; background: white; color: #1877f2; border-radius: 5px; cursor: pointer;">+ URL</button>
                </div>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeGroupModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer;">Batal</button>
                <button type="button" onclick="alert('Grup berhasil dibuat!')" style="padding: 10px 20px; border: none; background: #1877f2; color: white; border-radius: 8px; font-weight: bold; cursor: pointer;">Simpan Grup</button>
            </div>
        </form>
    </div>
</div>

<div id="createManagementModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
    <div style="background: white; margin: 10% auto; padding: 25px; border-radius: 15px; width: 35%; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0;">Buat Manajerial Baru</h3>
            <button onclick="closeManagementModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Nama Manajerial Divisi</label>
                <input type="text" placeholder="Contoh: Social Media Specialist" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            
            <p style="color: #65676b; font-size: 0.9rem;">Menyesuaikan kebutuhan field setiap divisi secara otomatis...</p>
            
            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 25px;">
                <button type="button" onclick="closeManagementModal()" style="padding: 10px 20px; border: 1px solid #ddd; background: white; border-radius: 8px; cursor: pointer;">Batal</button>
                <button type="button" onclick="alert('Manajerial baru berhasil ditambahkan!')" style="padding: 10px 20px; border: none; background: #1877f2; color: white; border-radius: 8px; font-weight: bold; cursor: pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showCreateGroupModal() { document.getElementById('createGroupModal').style.display = 'block'; }
    function closeGroupModal() { document.getElementById('createGroupModal').style.display = 'none'; }
    function showCreateManagementModal() { document.getElementById('createManagementModal').style.display = 'block'; }
    function closeManagementModal() { document.getElementById('createManagementModal').style.display = 'none'; }

    function addField(type) {
        let container = document.getElementById('groupFields');
        let div = document.createElement('div');
        div.style.background = '#f0f2f5';
        div.style.padding = '10px';
        div.style.borderRadius = '8px';
        div.style.marginBottom = '10px';
        
        let label = '';
        switch(type) {
            case 'text': label = 'Teks Input'; break;
            case 'textarea': label = 'Textarea'; break;
            case 'dropdown': label = 'Dropdown'; break;
            case 'file': label = 'File Upload'; break;
            case 'url': label = 'URL Input'; break;
        }
        
        div.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                <span style="font-size: 0.8rem; font-weight: bold; color: #65676b;">${label}</span>
                <button type="button" onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: red; cursor: pointer; font-weight: bold;">Hapus</button>
            </div>
            <input type="text" placeholder="Nama field (Contoh: Link Asset)" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
        `;
        container.appendChild(div);
    }
</script>
@yield('scripts')
</body>
</html>
