@extends('layouts.app')

@section('title', 'Web Developer Management')

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
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-in_progress_web { background: #cce5ff; color: #004085; }
    .status-revision { background: #f8d7da; color: #721c24; }
</style>
@endsection

@section('content')
<div class="manage-card">
    <h2>Project Web Development Aktif</h2>
    <div style="overflow-x: auto;">
        <table class="manage-table">
            <thead>
                <tr>
                    <th>ID Project</th>
                    <th>Nama Klien</th>
                    <th>Target Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>{{ $project->project_id }}</td>
                    <td>{{ $project->client_name }}</td>
                    <td>{{ $project->target_date ?? 'N/A' }}</td>
                    <td>
                        <span class="status-badge status-{{ $project->status }}">
                            {{ str_replace('_', ' ', ucfirst($project->status)) }}
                        </span>
                    </td>
                    <td>
                        <button onclick="showUpdateForm('{{ $project->id }}')" style="background: #1877f2; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Update Progress</button>
                    </td>
                </tr>
                <tr id="form-{{ $project->id }}" style="display: none; background: #f9f9f9;">
                    <td colspan="5">
                        <div style="padding: 15px;">
                            <p><b>Catatan dari Admin:</b> {{ $project->admin_notes ?? '-' }}</p>
                            <form action="{{ route('management.project.progress', $project->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 10px;">
                                    <div>
                                        <label>Penjelasan Progress</label>
                                        <textarea name="progress_notes" style="width: 100%; padding: 8px; margin-top: 5px;" required>{{ $project->progress_notes }}</textarea>
                                    </div>
                                    <div>
                                        <label>Catatan ke Admin/Klien</label>
                                        <textarea name="staff_notes" style="width: 100%; padding: 8px; margin-top: 5px;">{{ $project->staff_notes }}</textarea>
                                    </div>
                                    <div>
                                        <label>Dokumentasi (File)</label>
                                        <input type="file" name="completion_docs" style="width: 100%; padding: 8px; margin-top: 5px;">
                                    </div>
                                    <div>
                                        <label>URL (Repository/Live)</label>
                                        <input type="url" name="completion_url" value="{{ $project->completion_url }}" style="width: 100%; padding: 8px; margin-top: 5px;" placeholder="https://github.com/...">
                                    </div>
                                </div>
                                <button type="submit" style="margin-top: 15px; background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                    Kirim Progress Selesai
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada project aktif saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function showUpdateForm(id) {
        let el = document.getElementById('form-' + id);
        el.style.display = (el.style.display === 'none') ? 'table-row' : 'none';
    }
</script>
@endsection
