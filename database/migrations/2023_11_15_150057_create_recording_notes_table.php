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
        Schema::create('recording_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recording_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('file')->nullable();
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recording_notes');
    }
};
