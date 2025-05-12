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
        Schema::table('programmings', function (Blueprint $table) {
            if (!Schema::hasColumn('programmings', 'image_link')) {
                $table->string('image_link')->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programmings', function (Blueprint $table) {
            if (Schema::hasColumn('programmings', 'image_link')) {
                $table->dropColumn('image_link');
            }
        });
    }
}; 