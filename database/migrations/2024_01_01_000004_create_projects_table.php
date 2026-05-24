<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('project_id')->unique();
            $table->string('service_category'); // Web Dev, Design, Content
            $table->date('transaction_date');
            $table->date('target_date')->nullable();
            $table->string('attachment')->nullable();
            $table->text('client_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'in_progress_web', 'in_progress_design', 'waiting_confirmation', 'completed', 'revision'])->default('pending');
            
            // Progress details
            $table->text('progress_notes')->nullable();
            $table->string('completion_docs')->nullable(); // File upload
            $table->string('completion_url')->nullable(); // Repo/Design URL
            $table->text('staff_notes')->nullable(); // Notes from WebDev/Designer
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
