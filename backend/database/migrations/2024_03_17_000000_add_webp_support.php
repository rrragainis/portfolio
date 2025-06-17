<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add columns to photoshops table
        Schema::table('photoshops', function (Blueprint $table) {
            $table->string('webp_image_link')->nullable();
            $table->string('webp_cropped_image')->nullable();
        });

        // Add columns to audio table
        Schema::table('audio', function (Blueprint $table) {
            $table->string('webp_image_link')->nullable();
            $table->string('webp_cropped_image')->nullable();
        });

        // Add columns to programmings table
        Schema::table('programmings', function (Blueprint $table) {
            $table->string('webp_image_link')->nullable();
            $table->string('webp_cropped_image')->nullable();
        });
    }

    public function down()
    {
        // Remove columns from photoshops table
        Schema::table('photoshops', function (Blueprint $table) {
            $table->dropColumn(['webp_image_link', 'webp_cropped_image']);
        });

        // Remove columns from audio table
        Schema::table('audio', function (Blueprint $table) {
            $table->dropColumn(['webp_image_link', 'webp_cropped_image']);
        });

        // Remove columns from programmings table
        Schema::table('programmings', function (Blueprint $table) {
            $table->dropColumn(['webp_image_link', 'webp_cropped_image']);
        });
    }
}; 