<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')->constrained()->onDelete('cascade');

            $table->string('action'); // Created, Updated, Deleted
            $table->string('performed_by'); // User name

            $table->text('description')->nullable(); // What changed

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};