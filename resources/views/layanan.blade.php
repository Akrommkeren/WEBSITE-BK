@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
<div class="feed" style="width: 100%;">
    <div class="service-box" style="background: white; padding: 25px; border-radius: 15px; transition: 0.3s;">
        <p style="text-align: center;"><b>Permintaan Layanan</b></p>
        
        <form style="margin-top: 20px;">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Nama Perusahaan</label>
                <input type="text" placeholder="Masukkan nama perusahaan" style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Kategori Layanan</label>
                <select style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
                    <option value="website">Website</option>
                    <option value="design">Design</option>
                    <option value="content_vidio">Content Vidio</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Dokumentasi (Opsional)</label>
                <input type="file" style="width: 100%; padding: 10px; border: 1px solid #e4e6eb; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Detail Permintaan</label>
                <textarea placeholder="Jelaskan kebutuhan Anda secara detail..." style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit; resize: vertical; height: 150px;"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #1c1e21;">Tanggal Target Selesai</label>
                <input type="date" style="width: 100%; padding: 12px; border: 1px solid #e4e6eb; border-radius: 8px; font-family: inherit;">
            </div>

            <button type="button" onclick="alert('Permintaan Anda akan dikirim ke Admin!')" style="width: 100%; padding: 12px; background: #1877f2; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 0.85rem; transition: background 0.3s;">
                Kirim Permintaan
            </button>
        </form>
    </div>
</div>
<style>
    .service-box:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    .friend-box:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

@section('sidebar-right')
<div class="sidebar-right">
    <div class="friend-box" style="background: white; border-radius: 15px; padding: 15px; display: flex; flex-direction: column; height: 400px; transition: 0.3s;">
        <p style="margin-top: 0; border-bottom: 1px solid #f0f2f5; padding-bottom: 10px; text-align: center;"><b>Admin</b></p>
        <div id="chatMessages" style="flex: 1; overflow-y: auto; padding: 10px; display: flex; flex-direction: column; gap: 10px;">
            <div style="align-self: flex-start; background: #f0f2f5; padding: 8px 12px; border-radius: 15px; max-width: 80%; font-size: 0.9rem;">
                Halo! Silakan isi form layanan jika ada permintaan baru.
            </div>
        </div>
        <div style="margin-top: 10px; display: flex; gap: 5px;">
            <input type="text" placeholder="Tulis pesan..." style="flex: 1; border: 1px solid #e4e6eb; border-radius: 20px; padding: 8px 15px; font-size: 0.85rem;">
            <button style="background: #1877f2; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
            </button>
        </div>
    </div>
</div>
@endsection
