<!DOCTYPE html>
<html>
<head>
  <title>Register - Silo System</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="logo">
  <img src="{{ asset('asset/logo-bk.png') }}">
</div>

<div class="auth-container">
  <div class="container">
    <h2>Register</h2>
    @if($errors->any())
        <div style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        
        <div style="margin-bottom: 15px; text-align: left;">
            <label style="display: block; margin-bottom: 5px;">Daftar Sebagai:</label>
            <select name="role" id="role-select" onchange="toggleDivision()" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="customer">Pelanggan</option>
                <option value="staff">Staff Perusahaan</option>
            </select>
        </div>

        <div id="division-container" style="display: none; margin-bottom: 15px; text-align: left;">
            <label style="display: block; margin-bottom: 5px;">Divisi:</label>
            <select name="division" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="admin">Admin</option>
                <option value="web_dev">Web Developer</option>
                <option value="designer">Designer</option>
            </select>
        </div>

        <button type="submit">Register</button>
    </form>
    <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
  </div>
</div>

<script>
    function toggleDivision() {
        const role = document.getElementById('role-select').value;
        const divContainer = document.getElementById('division-container');
        divContainer.style.display = (role === 'staff') ? 'block' : 'none';
    }
</script>
</body>
</html>
