<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hike_drafts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('hike_drafts', function (Blueprint $table) {
            $table->enum('status', ['opened', 'completed', 'declined'])->default('opened');
        });
    }
};
