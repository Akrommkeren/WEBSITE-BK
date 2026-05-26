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
    <div class="post-box" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 25px; transition: 0.3s;">
        <p style="text-align: center;"><b>Update Hari Ini?</b></p>
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <textarea name="content" placeholder="Apa update perusahaan hari ini?" required style="width: 100%; border: 1px solid #e4e6eb; border-radius: 10px; padding: 12px; margin-bottom: 15px; resize: none; font-family: inherit;"></textarea>
            
            <input type="hidden" name="division" value="{{ Auth::user()->division }}">
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Unggah File/Gambar:</label>
                <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #e4e6eb; border-radius: 8px;">
            </div>
            
            <button type="submit" style="background: #1877f2; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; transition: background 0.3s;">Posting</button>
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
        <!-- Contoh Postingan Staff (Static Example) -->
        @can('is-staff')
        <div class="post">
            <div class="post-header" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('asset/profile-putih.png') }}" style="width: 40px; height: 40px; border-radius: 50%; margin-top: 0;">
                <div>
                    <b style="display: block;">Reecro</b>
                    <small style="color:gray;">
                        Web Developer
                    </small>
                </div>
            </div>
            <div class="post-text" style="margin: 10px 0;">
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('asset/Contoh-design.png') }}" style="width: 100%; border-radius: 10px; margin-top: 0;">
                </div>
                Update hari ini: Fitur integrasi payment gateway untuk project BK-2026-0003 sudah selesai di-deploy ke server staging. Siap untuk ditinjau oleh tim QA.
            </div>
            <div class="post-stats">
                <span>5 Like</span>
                <span>1 Komentar</span>
            </div>
            <div class="post-actions">
                <button style="font-weight: bold; background: none; border: none; cursor: pointer;">Suka</button>
                <button onclick="toggleExampleComments('staff-comment-1')" style="font-weight: bold; background: none; border: none; cursor: pointer;">Komentar</button>
            </div>
            <div id="staff-comment-1" style="display: none; border-top: 1px solid #eee; margin-top: 10px; padding-top: 10px;">
                <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px;">
                    <img src="{{ asset('asset/profile-putih.png') }}" style="width: 35px; height: 35px; border-radius: 50%;">
                    <div style="background: #f0f2f5; padding: 10px 15px; border-radius: 18px; font-size: 0.9rem; flex: 1;">
                        <div style="font-weight: bold; color: #1c1e21;">Akmal</div>
                        <div style="font-size: 0.75rem; color: #65676b; margin-bottom: 5px;">Designer</div>
                        <div style="color: #050505;">Mantap mas, ditunggu updatenya!</div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Contoh Postingan Testimoni (Static Example) -->
        @if(Auth::user()->role === 'customer')
        <div class="post">
            <div class="post-header" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('asset/profile-putih.png') }}" style="width: 40px; height: 40px; border-radius: 50%; margin-top: 0;">
                <div>
                    <b style="display: block;">Reecro</b>
                    <small style="color:gray;">
                        Pelanggan - CV. Pernapasanpetir
                    </small>
                </div>
            </div>
            <div class="post-text" style="margin: 10px 0;">
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('asset/Contoh-web.png') }}" style="width: 100%; border-radius: 10px; margin-top: 0;">
                    <p style="margin: 5px 0 0;"><a href="#" style="color: #1877f2; text-decoration: none; font-size: 0.85rem;">Link Project</a></p>
                </div>
                <div style="color: #ffd700; margin-bottom: 5px;">★★★★★</div>
                Sangat puas dengan hasil desain logo dari tim Silo System. Prosesnya cepat dan komunikasinya sangat lancar. Terima kasih!
            </div>
            <div class="post-stats">
                <span>12 Like</span>
                <span>3 Komentar</span>
            </div>
            <div class="post-actions">
                <button style="font-weight: bold; background: none; border: none; cursor: pointer;">Suka</button>
                <button onclick="toggleExampleComments('customer-comment-1')" style="font-weight: bold; background: none; border: none; cursor: pointer;">Komentar</button>
            </div>
            <div id="customer-comment-1" style="display: none; border-top: 1px solid #eee; margin-top: 10px; padding-top: 10px;">
                <!-- Comment 1 -->
                <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 15px;">
                    <img src="{{ asset('asset/profile-putih.png') }}" style="width: 35px; height: 35px; border-radius: 50%;">
                    <div style="background: #f0f2f5; padding: 10px 15px; border-radius: 18px; font-size: 0.9rem; flex: 1;">
                        <div style="font-weight: bold; color: #1c1e21;">Abdu</div>
                        <div style="font-size: 0.75rem; color: #65676b; margin-bottom: 5px;">Pelanggan - PT. Createlyou Corp</div>
                        <div style="color: #050505;">Sangat memuaskan, desainnya sangat modern!</div>
                    </div>
                </div>
                <!-- Comment 2 -->
                <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 15px;">
                    <img src="{{ asset('asset/profile-putih.png') }}" style="width: 35px; height: 35px; border-radius: 50%;">
                    <div style="background: #f0f2f5; padding: 10px 15px; border-radius: 18px; font-size: 0.9rem; flex: 1;">
                        <div style="font-weight: bold; color: #1c1e21;">Siti Aminah</div>
                        <div style="font-size: 0.75rem; color: #65676b; margin-bottom: 5px;">Pelanggan - Toko Berkah</div>
                        <div style="color: #050505;">Pelayanannya ramah dan hasil sesuai ekspektasi.</div>
                    </div>
                </div>
                <!-- Comment 3 -->
                <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 10px;">
                    <img src="{{ asset('asset/profile-putih.png') }}" style="width: 35px; height: 35px; border-radius: 50%;">
                    <div style="background: #f0f2f5; padding: 10px 15px; border-radius: 18px; font-size: 0.9rem; flex: 1;">
                        <div style="font-weight: bold; color: #1c1e21;">Budi Santoso</div>
                        <div style="font-size: 0.75rem; color: #65676b; margin-bottom: 5px;">Pelanggan - CV. Maju Jaya</div>
                        <div style="color: #050505;">Terima kasih tim Silo System, sukses selalu!</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

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
                <button style="font-weight: bold; background: none; border: none; cursor: pointer;">Suka</button>
                <button style="font-weight: bold; background: none; border: none; cursor: pointer;">Komentar</button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleExampleComments(id) {
        let el = document.getElementById(id);
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }
</script>
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
        <div style="margin-top: 10px; display: flex; gap: 8px; align-items: center;">
            <input type="text" placeholder="Tulis pesan..." style="flex: 1; border: 1px solid #e4e6eb; border-radius: 20px; padding: 10px 15px; font-size: 0.9rem; outline: none; background: #f0f2f5;">
            <button style="background: #1877f2; color: white; border: none; border-radius: 50%; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(24,119,242,0.25);" onmouseover="this.style.background='#166fe5'; this.style.transform='scale(1.05)';" onmouseout="this.style.background='#1877f2'; this.style.transform='scale(1)';">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor" style="margin-left: 2px;"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
            </button>
        </div>
    </div>
    @else
    <!-- CHAT (Staff Only) -->
    <div class="friend-box">
        <p><b>Chat</b></p>
        <div id="friendList">
            @php
                $staffs = \App\Models\User::where('role', 'staff')->get();
            @endphp
            @foreach($staffs as $staff)
            <div class="friend" style="cursor: pointer;" onclick="alert('Buka chat dengan {{ $staff->name }}')">
                <img src="{{ asset('asset/profile-putih.png') }}">
                <span>{{ $staff->name }} ({{ ucfirst($staff->division) }})</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
