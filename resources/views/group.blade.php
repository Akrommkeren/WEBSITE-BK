@extends('layouts.app')

@section('title', 'Grup ' . request('name', 'Umum'))

@section('styles')
<link rel="stylesheet" href="{{ asset('css/group.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<div class="feed" style="width: 100%;">
    <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
        <img src="{{ asset('asset/profile-putih.png') }}" style="width: 60px; height: 60px; border-radius: 10px;">
        <div>
            <h2 style="margin: 0;">Grup {{ request('name', 'Divisi') }}</h2>
            <p style="margin: 5px 0 0; color: gray;">Ruang update informasi khusus divisi {{ request('name', 'terkait') }}.</p>
        </div>
    </div>

    <!-- POST BOX (Only for Staff) -->
    @can('is-staff')
    <div class="post-box">
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="division" value="{{ strtolower(str_replace(' ', '_', request('name', 'general'))) }}">
            <input type="text" name="content" placeholder="Update apa di grup {{ request('name') }} hari ini?" required>
            <input type="file" name="image" accept="image/*" style="margin-bottom: 10px;">
            <button type="submit">Posting di Grup</button>
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

        @if($groupPosts->isEmpty())
            <p style="text-align: center; color: gray; padding: 20px; background: white; border-radius: 10px;">Belum ada update di grup ini.</p>
        @endif
    </div>
</div>
@endsection
