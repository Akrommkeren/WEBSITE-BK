@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<!-- FEED -->
<div class="feed" style="width: 100%;">
    <!-- POST BOX (Staff) -->
    @can('is-staff')
    <div class="post-box">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="content" placeholder="Apa update perusahaan hari ini?" required>
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
                <input type="file" name="image" accept="image/*" style="width: auto; flex: 1; margin-bottom: 0;">
                <select name="division" style="padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                    <option value="general">Umum</option>
                    <option value="admin">Admin</option>
                    <option value="web_dev">Web Dev</option>
                    <option value="designer">Designer</option>
                </select>
            </div>
            <button type="submit">Posting</button>
        </form>
    </div>
    @endcan

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

    <!-- POST LIST -->
    <div id="postList">
        @foreach($posts as $post)
        <div class="post">
            <div class="post-header">
                <b>{{ $post->user->name }}</b>
                <span style="background: #e4e6eb; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-left: 5px;">
                    {{ ucfirst($post->division) }}
                </span>
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
            <div class="post-stats">
                <span>0 Like</span>
                <span>0 Komentar</span>
            </div>
            <div class="post-actions">
                <button>❤️ Suka</button>
                <button>💬 Komentar</button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('sidebar-right')
<!-- SIDEBAR RIGHT -->
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
            <!-- Message examples -->
            <div style="align-self: flex-start; background: #f0f2f5; padding: 8px 12px; border-radius: 15px; max-width: 80%; font-size: 0.9rem;">
                Halo! Ada yang bisa kami bantu?
            </div>
            <div style="align-self: flex-end; background: #1877f2; color: white; padding: 8px 12px; border-radius: 15px; max-width: 80%; font-size: 0.9rem;">
                Saya ingin tanya progres project saya.
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
    <!-- DIVISI KAMI (Staff Only) -->
    <div class="friend-box">
        <p><b>Divisi Kami</b></p>
        <div id="friendList">
            <div class="friend">
                <img src="{{ asset('asset/profile-putih.png') }}">
                <span>Admin Silo</span>
            </div>
            <div class="friend">
                <img src="{{ asset('asset/profile-putih.png') }}">
                <span>Web Developer</span>
            </div>
            <div class="friend">
                <img src="{{ asset('asset/profile-putih.png') }}">
                <span>Designer</span>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
