@extends('layouts.app')

@section('title', 'Admin Management')

@section('styles')
<style>
    .manage-card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .manage-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .manage-table th, .manage-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .manage-table th {
        background: #f8f9fa;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-pending { background: #ffeeba; color: #856404; }
    .status-accepted { background: #d4edda; color: #155724; }
    .status-in_progress { background: #cce5ff; color: #004085; }
    .status-completed { background: #d1ecf1; color: #0c5460; }
</style>
@endsection

@section('content')
<div class="manage-card">
    <h2>Input Data Klien Baru</h2>
    <form action="{{ route('management.admin.project.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label>Nama Klien/Perusahaan</label>
                <input type="text" name="client_name" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" required>
            </div>
            <div>
                <label>Kategori Layanan</label>
                <select name="service_category" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" required>
                    <option value="Web Dev">Web Dev</option>
                    <option value="Design">Design</option>
                    <option value="Content">Content</option>
                </select>
            </div>
            <div>
                <label>Tanggal Transaksi</label>
                <input type="date" name="transaction_date" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;" required>
            </div>
            <div>
                <label>Target Selesai</label>
                <input type="date" name="target_date" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
            <div>
                <label>Lampiran</label>
                <input type="file" name="attachment" class="form-control" style="width: 100%; padding: 8px; margin-top: 5px;">
            </div>
        </div>
        <div style="margin-top: 15px;">
            <label>Catatan dari Klien</label>
            <textarea name="client_notes" style="width: 100%; padding: 8px; margin-top: 5px;" rows="3"></textarea>
        </div>
        <button type="submit" style="margin-top: 15px; background: #1877f2; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
            Simpan & Proses Data
        </button>
    </form>
</div>

<div class="manage-card">
    <h2>Daftar Project & Database Klien</h2>
    <div style="overflow-x: auto;">
        <table class="manage-table">
            <thead>
                <tr>
                    <th>ID Project</th>
                    <th>Nama Klien</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td>{{ $project->project_id }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td>{{ $project->service_category }}</td>
                    <td>
                        <span class="status-badge status-{{ $project->status }}">
                            {{ str_replace('_', ' ', ucfirst($project->status)) }}
                        </span>
                    </td>
                    <td>
                        <button onclick="showDetail('{{ $project->id }}')" style="background: #6c757d; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Detail</button>
                    </td>
                </tr>
                <tr id="detail-{{ $project->id }}" style="display: none; background: #f9f9f9;">
                    <td colspan="5">
                        <div style="padding: 15px;">
                            <p><b>Catatan Admin:</b> {{ $project->admin_notes ?? '-' }}</p>
                            <p><b>Catatan Staff:</b> {{ $project->staff_notes ?? '-' }}</p>
                            @if($project->completion_url)
                                <p><b>Link Hasil:</b> <a href="{{ $project->completion_url }}" target="_blank">{{ $project->completion_url }}</a></p>
                            @endif
                            <form action="{{ route('management.admin.project.status', $project->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                                    <select name="status" style="padding: 5px;">
                                        <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="accepted" {{ $project->status == 'accepted' ? 'selected' : '' }}>Terima (Acc)</option>
                                        <option value="in_progress_web" {{ $project->status == 'in_progress_web' ? 'selected' : '' }}>Kirim ke Web Dev</option>
                                        <option value="in_progress_design" {{ $project->status == 'in_progress_design' ? 'selected' : '' }}>Kirim ke Designer</option>
                                        <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Selesai (End)</option>
                                        <option value="revision" {{ $project->status == 'revision' ? 'selected' : '' }}>Revisi</option>
                                    </select>
                                    <input type="text" name="admin_notes" placeholder="Catatan Tambahan" style="padding: 5px; flex: 1;">
                                    <button type="submit" style="background: #28a745; color: white; border: none; padding: 5px 15px; border-radius: 3px; cursor: pointer;">Update</button>
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

<script>
    function showDetail(id) {
        let el = document.getElementById('detail-' + id);
        el.style.display = (el.style.display === 'none') ? 'table-row' : 'none';
    }
</script>
@endsection
