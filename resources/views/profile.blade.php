@extends('layouts.app')

@section('title', 'Profil')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('header')
<div class="profile-header" style="background: white; margin-bottom: 20px;">
    <div class="cover-photo" style="height: 230px; background: linear-gradient(to right, #1877f2, #00c6ff); width: 100%;"></div>
    <div class="profile-info-bar" style="padding: 20px 60px 40px 60px; display: flex; align-items: center; gap: 20px; position: relative;">
        <div class="profile-avatar-container" style="width: 160px; height: 160px; border-radius: 50%; background: white; padding: 5px; margin-top: -80px; display: flex; align-items: center; justify-content: center; border: 4px solid #1877f2; z-index: 10;">
            <img src="{{ asset('asset/profile-biru.png') }}" style="width: 100%; height: 100%; border-radius: 50%;">
        </div>
        <div class="profile-details" style="margin-top: -15px; margin-left: 15px;">
            <h2 style="margin: 0; color: #1c1e21; font-size: 1.5rem;">{{ Auth::user()->name }}</h2>
            <p style="margin: 3px 0 0; color: #65676b; font-weight: 500; font-size: 0.95rem;">
                @if(Auth::user()->role === 'customer')
                    Pelanggan
                @else
                    {{ ucfirst(Auth::user()->role) }} {{ Auth::user()->division !== 'none' ? '- ' . ucfirst(Auth::user()->division) : '' }}
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="feed" style="width: 100%;">
    <!-- POST BOX (Customer) -->
    @if(Auth::user()->role === 'customer')
    <div class="post-box" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 25px; transition: 0.3s;">
        <p style="text-align: center;"><b>Update Testimoni</b></p>
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea name="content" placeholder="Bagaimana hasil project Anda? Ceritakan di sini..." required style="width: 100%; border: 1px solid #e4e6eb; border-radius: 10px; padding: 12px; margin-bottom: 15px; resize: none; font-family: inherit;"></textarea>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Rating:</label>
                <div class="rating-input" style="display: flex; align-items: center; gap: 5px;">
                    <div class="stars" style="display: flex; gap: 5px; color: #ffd700; font-size: 1.8rem;">
                        @for($i = 1; $i <= 5; $i++)
                        <label style="cursor: pointer;">
                            <input type="radio" name="rating" value="{{ $i }}" style="display: none;">
                            <span class="star" onclick="setRating({{ $i }})">☆</span>
                        </label>
                        @endfor
                    </div>
                </div>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Unggah File/Gambar:</label>
                <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #e4e6eb; border-radius: 8px;">
            </div>
            
            <input type="hidden" name="division" value="general">
            <button type="submit" style="background: #1877f2; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; transition: background 0.3s;">Posting</button>
        </form>
    </div>
    <style>
        .post-box:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        .friend-box:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }
        .star {
            transition: 0.2s;
        }
    </style>
    <script>
        function setRating(val) {
            let stars = document.querySelectorAll('.star');
            stars.forEach((star, index) => {
                if (index < val) {
                    star.innerText = '★';
                } else {
                    star.innerText = '☆';
                }
            });
        }
    </script>
    @endif

    <div id="postList">
        @foreach(Auth::user()->posts()->latest()->get() as $post)
        <div class="post" style="background: white; padding: 15px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <div class="post-header">
                <b>{{ $post->user->name }}</b>
                <small style="display:block;color:gray;">
                    {{ $post->created_at->diffForHumans() }}
                </small>
            </div>
            <div class="post-text" style="margin: 10px 0;">
                {!! nl2br(e($post->content)) !!}
            </div>
            @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" style="width: 100%; border-radius: 10px;">
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('sidebar-right')
<div class="sidebar-right">
    <!-- NOTIFIKASI -->
    <div class="notif-box">
        <p><b>Notifikasi</b></p>
        <div id="notifList">
            <div class="notif-item">
                <p>Selamat datang di Silo System!</p>
                <small>Baru saja</small>
            </div>
        </div>
        <button>Lihat Semua</button>
    </div>

    <!-- ADMIN CHAT (Customer Only) -->
    @if(Auth::user()->role === 'customer')
    <div class="friend-box" style="background: white; border-radius: 15px; padding: 15px; display: flex; flex-direction: column; height: 400px; transition: 0.3s;">
        <p style="margin-top: 0; border-bottom: 1px solid #f0f2f5; padding-bottom: 10px; text-align: center;"><b>Admin</b></p>
        <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 10px; display: flex; flex-direction: column; gap: 10px;">
            <div style="align-self: flex-start; background: #f0f2f5; padding: 8px 12px; border-radius: 15px; max-width: 80%; font-size: 0.9rem;">
                Halo! Ada yang bisa kami bantu?
            </div>
        </div>
        <div style="margin-top: 10px; display: flex; gap: 5px;">
            <input type="text" placeholder="Tulis pesan..." style="flex: 1; border: 1px solid #e4e6eb; border-radius: 20px; padding: 8px 15px; font-size: 0.85rem;">
            <button style="background: #1877f2; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
            </button>
        </div>
    </div>
    @else
    <div class="friend-box">
        <p><b>Divisi Kami</b></p>
        <div id="friendList">
            <div class="friend">
                <img src="{{ asset('asset/profile-putih.png') }}">
                <span>Admin Silo</span>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
