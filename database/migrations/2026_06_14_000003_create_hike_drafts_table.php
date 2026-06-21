<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hike_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained()->nullOnDelete();
            $table->string('proposed_region_name')->nullable();
            $table->text('proposed_region_description')->nullable();
            $table->string('title');
            $table->text('description');
            $table->enum('difficulty', ['easy', 'moderate', 'hard']);
            $table->float('length_km')->nullable();
            $table->boolean('has_parking')->default(false);
            $table->boolean('is_parking_free')->default(false);
            $table->boolean('needs_climbing_equipment')->default(false);
            $table->boolean('needs_helmet')->default(false);
            $table->enum('status', ['opened', 'completed', 'declined'])->default('opened');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hike_drafts');
    }
};
