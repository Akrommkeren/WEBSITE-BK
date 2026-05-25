@extends('layouts.app')

@section('title', 'Grup ' . request('name', 'Umum'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/group.css') }}">
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
            <h2 style="margin: 0; color: #1c1e21; font-size: 1.8rem;">{{ request('name', 'Divisi') }}</h2>
            <p style="margin: 3px 0 0; color: #65676b; font-weight: 500; font-size: 1rem;">
                Grup {{ request('name', 'Divisi') }} Bikin Kreatif
            </p>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="feed" style="width: 100%;">
    <!-- POST BOX (Only for Staff) -->
    @can('is-staff')
    <div class="post-box" style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 25px; transition: 0.3s;">
        <p style="text-align: center;"><b>Update Hari Ini?</b></p>
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="division" value="{{ strtolower(str_replace(' ', '_', request('name', 'general'))) }}">
            <textarea name="content" placeholder="Update apa di grup {{ request('name') }} hari ini?" required style="width: 100%; border: 1px solid #e4e6eb; border-radius: 10px; padding: 12px; margin-bottom: 15px; resize: none; font-family: inherit;"></textarea>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Unggah File/Gambar:</label>
                <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #e4e6eb; border-radius: 8px;">
            </div>
            
            <button type="submit" style="background: #1877f2; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; transition: background 0.3s;">Posting di Grup</button>
        </form>
    </div>
    @endcan

    <!-- POST LIST -->
    <div id="postList">
        @php
            $groupName = strtolower(str_replace(' ', '_', request('name', 'general')));
            $groupPosts = \App\Models\Post::where('division', $groupName)->latest()->get();
        @endphp
        
        @foreach($groupPosts as $post)
        <div class="post">
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
</div>
@endsection
