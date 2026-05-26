@extends('layouts.app')

@section('title', 'Manajerial Web Developer')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .manage-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: none;
        transition: box-shadow 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }
    .manage-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
    }
    .manage-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .manage-table th, .manage-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    .manage-table th {
        background: #f8f9fa;
        color: #65676b;
        font-weight: 500;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .manage-table td {
        font-size: 0.95rem;
        color: #1c1e21;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-in_progress_web { background: #cce5ff; color: #004085; }
    .status-revision { background: #f8d7da; color: #721c24; }
    .status-completed { background: #d4edda; color: #155724; }

    .title-daftar-project {
        text-align: center;
        font-size: 1rem;
        font-weight: bold;
        color: #1c1e21;
        border-bottom: 1px solid #f0f2f5;
        padding-bottom: 15px;
        margin-bottom: 25px;
        margin-top: 0;
    }
    .feed-full {
        flex: 1;
        padding: 0 10px;
    }
</style>
@endsection

@section('content')
<div class="feed-full">
    <div class="manage-card">
        <h2 class="title-daftar-project">Daftar Project</h2>
        
        <div style="overflow-x: auto;">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>ID Project</th>
                        <th>Nama Perusahaan/Klien</th>
                        <th>Kategori Layanan</th>
                        <th>Tgl Masuk</th>
                        <th>Target Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- CONTOH DATA DUMMY WEB DEV -->
                    @if($projects->isEmpty())
                    <tr>
                        <td>BK-2026-0003</td>
                        <td>E-Commerce Store</td>
                        <td>Web Dev</td>
                        <td>2026-05-23</td>
                        <td>2026-06-05</td>
                        <td><span class="status-badge status-in_progress_web">In Progress</span></td>
                        <td>
                            <button onclick="toggleUpdateForm('dummy-1')" style="background: #1877f2; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: bold;">Update Progres</button>
                        </td>
                    </tr>
                    <tr id="form-dummy-1" style="display: none; background: #f0f2f5;">
                        <td colspan="7">
                            <div style="padding: 20px;">
                                <div style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #ddd;">
                                    <h4 style="margin-top: 0;">Detail Project</h4>
                                    <p><b>Catatan Klien:</b> Integrasi payment gateway Midtrans.</p>
                                    <p><b>Instruksi Admin:</b> Prioritaskan keamanan data transaksi.</p>
                                </div>

                                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                                    <h4 style="margin-top: 0;">Update Progres & Hasil</h4>
                                    <div style="margin-bottom: 15px;">
                                        <label style="display: block; font-weight: bold; margin-bottom: 5px;">Status Progres / Keterangan</label>
                                        <textarea placeholder="Update progres pengerjaan saat ini..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; height: 80px;"></textarea>
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                                        <div>
                                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">File Project (Zip/Image/PDF)</label>
                                            <input type="file" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                        </div>
                                        <div>
                                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Link Project (Github/Live Demo)</label>
                                            <input type="url" placeholder="https://..." style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                        </div>
                                    </div>
                                    <div style="display: flex; justify-content: flex-end;">
                                        <button type="button" class="btn-action" style="background: #28a745; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer; font-weight: bold;" onclick="alert('Data diserahkan ke admin!')">Serahkan ke Admin</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->project_id }}</td>
                        <td>{{ $project->client_name }}</td>
                        <td>{{ $project->service_category }}</td>
                        <td>{{ $project->transaction_date }}</td>
                        <td>{{ $project->target_date ?? '-' }}</td>
                        <td>
                            <span class="status-badge status-{{ $project->status }}">
                                {{ str_replace('_', ' ', ucfirst($project->status)) }}
                            </span>
                        </td>
                        <td>
                            <button onclick="toggleUpdateForm('{{ $project->id }}')" style="background: #1877f2; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: bold;">Update Progres</button>
                        </td>
                    </tr>
                    <tr id="form-{{ $project->id }}" style="display: none; background: #f0f2f5;">
                        <td colspan="7">
                            <div style="padding: 20px;">
                                <div style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #ddd;">
                                    <h4 style="margin-top: 0;">Detail Project</h4>
                                    <p><b>Catatan Klien:</b> {{ $project->client_notes ?? '-' }}</p>
                                    <p><b>Instruksi Admin:</b> {{ $project->admin_notes ?? '-' }}</p>
                                </div>

                                <form action="{{ route('management.project.progress', $project->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
                                        <h4 style="margin-top: 0;">Update Progres & Hasil</h4>
                                        <div style="margin-bottom: 15px;">
                                            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Status Progres / Keterangan</label>
                                            <textarea name="progress_notes" placeholder="Update progres pengerjaan saat ini..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; height: 80px;" required>{{ $project->progress_notes }}</textarea>
                                        </div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                                            <div>
                                                <label style="display: block; font-weight: bold; margin-bottom: 5px;">File Project (Zip/Image/PDF)</label>
                                                <input type="file" name="completion_docs" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                            </div>
                                            <div>
                                                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Link Project (Github/Live Demo)</label>
                                                <input type="url" name="completion_url" value="{{ $project->completion_url }}" placeholder="https://..." style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px;">
                                            </div>
                                        </div>
                                        <div style="display: flex; justify-content: flex-end;">
                                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 25px; border-radius: 6px; cursor: pointer; font-weight: bold;">Serahkan ke Admin</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('sidebar-right')
<div class="sidebar-right">
    <div class="notif-box">
        <p><b>Notifikasi</b></p>
        <div id="notifList">
            <div class="notif-item">
                <p>Ada project baru untuk divisi Web Dev!</p>
                <small>Baru saja</small>
            </div>
        </div>
        <button>Lihat Semua</button>
    </div>

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

@section('scripts')
<script>
    function toggleUpdateForm(id) {
        let el = document.getElementById('form-' + id);
        el.style.display = (el.style.display === 'none') ? 'table-row' : 'none';
    }
</script>
@endsection
