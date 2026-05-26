@extends('layouts.app')

@section('title', 'Manajerial Admin')

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
    .status-pending { background: #ffeeba; color: #856404; }
    .status-accepted { background: #d4edda; color: #155724; }
    .status-in_progress_web { background: #cce5ff; color: #004085; }
    .status-in_progress_design { background: #cce5ff; color: #004085; }
    .status-completed { background: #d1ecf1; color: #0c5460; }
    .status-rejected { background: #f8d7da; color: #721c24; }

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
    .section-header {
        font-size: 1.05rem;
        margin-bottom: 15px;
        color: #1c1e21;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-header::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
    }
    .feed-full {
        flex: 1;
        padding: 0 10px;
    }
    .btn-action {
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        border: none;
        font-size: 0.85rem;
    }
    .btn-primary { background: #1877f2; color: white; }
    .btn-success { background: #28a745; color: white; }
    .btn-secondary { background: #65676b; color: white; }
</style>
@endsection

@section('content')
<div class="feed-full">
    <div class="manage-card">
        <h2 class="title-daftar-project">Daftar Project</h2>
        
        <!-- BAGIAN 1: PERMINTAAN PROJECT -->
        <div class="section-header">Permintaan Project</div>
        <div style="overflow-x: auto; margin-bottom: 40px;">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>ID Project</th>
                        <th>Nama Perusahaan/Klien</th>
                        <th>Kategori Layanan</th>
                        <th>Status (Tgl Masuk)</th>
                        <th>Target Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $pendingProjects = $projects->where('status', 'pending');
                    @endphp
                    
                    <!-- CONTOH DATA DUMMY PERMINTAAN -->
                    @if($pendingProjects->isEmpty())
                    <tr>
                        <td>BK-2026-0001</td>
                        <td>PT. Maju Bersama</td>
                        <td>Web Dev</td>
                        <td>2026-05-24</td>
                        <td>2026-06-10</td>
                        <td>
                            <button onclick="toggleDetail('req-1')" class="btn-action btn-primary">Tinjau</button>
                        </td>
                    </tr>
                    <tr id="detail-req-1" style="display: none; background: #f8f9fa;">
                        <td colspan="6">
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 15px;">
                                    <p><b>File Lampiran:</b> <a href="#" style="color: #1877f2;">brief_project_maju_bersama.pdf</a></p>
                                    <p><b>Catatan/Detail Permintaan:</b><br>Membutuhkan website company profile dengan fitur katalog produk dan form kontak yang terintegrasi ke email.</p>
                                </div>
                                <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                                    <label style="display: block; font-weight: bold; margin-bottom: 10px;">Tindakan Admin:</label>
                                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                        <select style="padding: 8px; border-radius: 6px; border: 1px solid #ddd; flex: 1;">
                                            <option value="">-- Pilih Divisi Tujuan --</option>
                                            <option value="web">Web Developer</option>
                                            <option value="design">Designer</option>
                                        </select>
                                        <button class="btn-action btn-success">Accept</button>
                                        <button class="btn-action" style="background: #dc3545; color: white;">Reject</button>
                                    </div>
                                    <textarea placeholder="Tambahkan catatan admin di sini..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; height: 60px;"></textarea>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @foreach($pendingProjects as $project)
                    <tr>
                        <td>{{ $project->project_id }}</td>
                        <td>{{ $project->client_name }}</td>
                        <td>{{ $project->service_category }}</td>
                        <td>{{ $project->transaction_date }}</td>
                        <td>{{ $project->target_date ?? '-' }}</td>
                        <td>
                            <button onclick="toggleDetail('{{ $project->id }}')" class="btn-action btn-primary">Tinjau</button>
                        </td>
                    </tr>
                    <tr id="detail-{{ $project->id }}" style="display: none; background: #f8f9fa;">
                        <td colspan="6">
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 15px;">
                                    <p><b>File Lampiran:</b> 
                                        @if($project->attachment)
                                            <a href="{{ asset('storage/' . $project->attachment) }}" target="_blank" style="color: #1877f2;">Lihat Lampiran</a>
                                        @else
                                            Tidak ada file.
                                        @endif
                                    </p>
                                    <p><b>Catatan/Detail Permintaan:</b><br>{{ $project->client_notes ?? 'Tidak ada catatan.' }}</p>
                                </div>
                                <form action="{{ route('management.admin.project.status', $project->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #ddd;">
                                        <label style="display: block; font-weight: bold; margin-bottom: 10px;">Tindakan Admin:</label>
                                        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                                            <select name="status" style="padding: 8px; border-radius: 6px; border: 1px solid #ddd; flex: 1;" required>
                                                <option value="">-- Pilih Divisi Tujuan --</option>
                                                <option value="in_progress_web">Web Developer</option>
                                                <option value="in_progress_design">Designer</option>
                                                <option value="rejected">Reject</option>
                                            </select>
                                            <button type="submit" class="btn-action btn-success">Konfirmasi</button>
                                        </div>
                                        <textarea name="admin_notes" placeholder="Tambahkan catatan admin di sini..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; height: 60px;"></textarea>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- BAGIAN 2: PROJECT (DITERIMA) -->
        <div class="section-header">Project</div>
        <div style="overflow-x: auto;">
            <table class="manage-table">
                <thead>
                    <tr>
                        <th>ID Project</th>
                        <th>Nama Perusahaan/Klien</th>
                        <th>Kategori Layanan</th>
                        <th>Tgl Masuk</th>
                        <th>Target Selesai</th>
                        <th>Divisi</th>
                        <th>Status Progres</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $activeProjects = $projects->where('status', '!=', 'pending');
                    @endphp

                    <!-- CONTOH DATA DUMMY PROJECT AKTIF -->
                    @if($activeProjects->isEmpty())
                    <tr>
                        <td>BK-2026-0002</td>
                        <td>Digital Creative Agency</td>
                        <td>Design</td>
                        <td>2026-05-22</td>
                        <td>2026-05-30</td>
                        <td>Designer</td>
                        <td><span class="status-badge status-in_progress_design">In Progress</span></td>
                        <td>
                            <button onclick="toggleDetail('active-1')" class="btn-action btn-secondary">Detail</button>
                        </td>
                    </tr>
                    <tr id="detail-active-1" style="display: none; background: #f8f9fa;">
                        <td colspan="8">
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 20px;">
                                    <p><b>Catatan Admin:</b> Segera kerjakan logo dan brand identity.</p>
                                    <p><b>Update Progres:</b> Sudah masuk tahap sketsa kasar.</p>
                                    
                                    <div style="margin-top: 15px;">
                                        <p><b>download dokumentasi:</b></p>
                                        <div style="display: flex; gap: 10px;">
                                            <button class="btn-action btn-primary" disabled>File Project</button>
                                            <button class="btn-action btn-primary" disabled>Link project</button>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: flex-end;">
                                    <button class="btn-action btn-success">Serahkan ke Klien</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                    @foreach($activeProjects as $project)
                    <tr>
                        <td>{{ $project->project_id }}</td>
                        <td>{{ $project->client_name }}</td>
                        <td>{{ $project->service_category }}</td>
                        <td>{{ $project->transaction_date }}</td>
                        <td>{{ $project->target_date ?? '-' }}</td>
                        <td>
                            {{ str_contains($project->status, 'web') ? 'Web Developer' : (str_contains($project->status, 'design') ? 'Designer' : '-') }}
                        </td>
                        <td>
                            <span class="status-badge status-{{ $project->status }}">
                                {{ str_replace('_', ' ', ucfirst($project->status)) }}
                            </span>
                        </td>
                        <td>
                            <button onclick="toggleDetail('{{ $project->id }}')" class="btn-action btn-secondary">Detail</button>
                        </td>
                    </tr>
                    <tr id="detail-{{ $project->id }}" style="display: none; background: #f8f9fa;">
                        <td colspan="8">
                            <div style="padding: 20px;">
                                <div style="margin-bottom: 20px;">
                                    <p><b>Catatan Admin:</b> {{ $project->admin_notes ?? '-' }}</p>
                                    <p><b>Update Progres:</b> {{ $project->progress_notes ?? 'Belum ada update' }}</p>

                                    <div style="margin-top: 15px;">
                                        <p><b>download dokumentasi:</b></p>
                                        <div style="display: flex; gap: 10px;">
                                            @if($project->completion_docs)
                                                <a href="{{ asset('storage/' . $project->completion_docs) }}" class="btn-action btn-primary" style="text-decoration: none; display: inline-block;">File Project</a>
                                            @else
                                                <button class="btn-action btn-primary" disabled>File Project</button>
                                            @endif

                                            @if($project->completion_url)
                                                <a href="{{ $project->completion_url }}" target="_blank" class="btn-action btn-primary" style="text-decoration: none; display: inline-block;">Link project</a>
                                            @else
                                                <button class="btn-action btn-primary" disabled>Link project</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: flex-end;">
                                    @if($project->status == 'waiting_confirmation')
                                        <form action="{{ route('management.admin.project.status', $project->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn-action btn-success">Serahkan ke Klien</button>
                                        </form>
                                    @else
                                        <button class="btn-action btn-success" onclick="alert('Menunggu pengerjaan divisi selesai!')" style="opacity: 0.6;">Serahkan ke Klien</button>
                                    @endif
                                </div>
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
                <p>Selamat datang di Panel Admin!</p>
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
    function toggleDetail(id) {
        let el = document.getElementById('detail-' + id);
        el.style.display = (el.style.display === 'none') ? 'table-row' : 'none';
    }
</script>
@endsection
