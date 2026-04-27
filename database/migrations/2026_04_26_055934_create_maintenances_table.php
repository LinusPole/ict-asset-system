<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')->constrained()->onDelete('cascade');

            $table->string('issue_reported');
            $table->string('reported_by');

            $table->string('technician_assigned')->nullable();

            $table->enum('status', [
                'Pending',
                'In Progress',
                'Completed',
                'Rejected'
            ])->default('Pending');

            $table->decimal('repair_cost', 12, 2)->nullable();

            $table->date('reported_date');
            $table->date('completed_date')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};