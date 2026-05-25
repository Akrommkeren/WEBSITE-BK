@extends('layouts.app')

@section('title', 'Edit Profil')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/editprofile.css') }}">
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
    <div class="edit-container" style="background: white; padding: 25px; border-radius: 15px; transition: 0.3s;">
        <h3 style="margin-top: 0; color: #1c1e21; border-bottom: 1px solid #f0f2f5; padding-bottom: 15px; margin-bottom: 20px;">Edit Profil</h3>
        
        <form>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21; font-size: 0.9rem;">Nama Lengkap</label>
                    <input type="text" value="{{ Auth::user()->name }}" style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21; font-size: 0.9rem;">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21; font-size: 0.9rem;">Nama Perusahaan</label>
                    <input type="text" placeholder="Contoh: PT. Maju Bersama" style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21; font-size: 0.9rem;">Bidang Perusahaan</label>
                    <input type="text" placeholder="Contoh: Teknologi Informasi" style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
                </div>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21; font-size: 0.9rem;">Alamat</label>
                <textarea placeholder="Alamat lengkap..." style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit; resize: vertical; height: 100px;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="alert('Fitur update profil akan segera hadir!')" style="padding: 10px 25px; border: none; border-radius: 8px; background: #1877f2; color: white; font-weight: bold; cursor: pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
<style>
    .edit-container:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
