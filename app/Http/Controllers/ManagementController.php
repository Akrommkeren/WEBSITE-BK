<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    public function adminIndex()
    {
        $projects = Project::latest()->get();
        return view('management.admin', compact('projects'));
    }

    public function webDevIndex()
    {
        $projects = Project::whereIn('status', ['in_progress_web', 'revision'])
                           ->where('service_category', 'Web Dev')
                           ->latest()->get();
        return view('management.web_dev', compact('projects'));
    }

    public function designerIndex()
    {
        $projects = Project::whereIn('status', ['in_progress_design', 'revision'])
                           ->where('service_category', 'Design')
                           ->latest()->get();
        return view('management.designer', compact('projects'));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'service_category' => 'required|in:Web Dev,Design,Content',
            'transaction_date' => 'required|date',
            'target_date' => 'nullable|date',
            'attachment' => 'nullable|file|max:5120',
            'client_notes' => 'nullable|string',
        ]);

        $year = date('Y');
        $count = Project::whereYear('created_at', $year)->count() + 1;
        $projectId = 'BK-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }

        Project::create([
            'client_name' => $request->client_name,
            'project_id' => $projectId,
            'service_category' => $request->service_category,
            'transaction_date' => $request->transaction_date,
            'target_date' => $request->target_date,
            'attachment' => $attachmentPath,
            'client_notes' => $request->client_notes,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Data klien berhasil ditambahkan!');
    }

    public function updateProjectStatus(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        $project->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $project->admin_notes,
        ]);

        return back()->with('success', 'Status project berhasil diperbarui!');
    }

    public function updateProgress(Request $request, Project $project)
    {
        $request->validate([
            'progress_notes' => 'required|string',
            'completion_docs' => 'nullable|file|max:5120',
            'completion_url' => 'nullable|url',
            'staff_notes' => 'nullable|string',
        ]);

        $docsPath = $project->completion_docs;
        if ($request->hasFile('completion_docs')) {
            $docsPath = $request->file('completion_docs')->store('completion', 'public');
        }

        $project->update([
            'progress_notes' => $request->progress_notes,
            'completion_docs' => $docsPath,
            'completion_url' => $request->completion_url,
            'staff_notes' => $request->staff_notes,
            'status' => 'waiting_confirmation',
        ]);

        return back()->with('success', 'Progress berhasil dikirim ke Admin!');
    }
}
