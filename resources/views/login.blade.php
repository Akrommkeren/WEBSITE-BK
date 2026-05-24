<!DOCTYPE html>
<html>
<head>
  <title>Login - Silo System</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="logo">
  <img src="{{ asset('asset/logo-bk.png') }}">
</div>

<div class="auth-container">
  <div class="container">
    <h2>Login</h2>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
  </div>
</div>
</body>
</html>
