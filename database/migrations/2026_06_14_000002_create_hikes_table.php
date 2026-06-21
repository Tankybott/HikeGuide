<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->enum('difficulty', ['easy', 'moderate', 'hard']);
            $table->float('length_km')->nullable();
            $table->boolean('has_parking')->default(false);
            $table->boolean('is_parking_free')->default(false);
            $table->boolean('needs_climbing_equipment')->default(false);
            $table->boolean('needs_helmet')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hikes');
    }
};
