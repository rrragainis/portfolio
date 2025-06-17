<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddWebpSupport extends Migration
{
    public function up()
    {
        // Add webp_image_link and webp_cropped_image columns to photoshops table
        DB::statement('ALTER TABLE photoshops ADD COLUMN webp_image_link VARCHAR(255) AFTER image_link');
        DB::statement('ALTER TABLE photoshops ADD COLUMN webp_cropped_image VARCHAR(255) AFTER cropped_image');

        // Add webp_image_link and webp_cropped_image columns to audio table
        DB::statement('ALTER TABLE audio ADD COLUMN webp_image_link VARCHAR(255) AFTER image_link');
        DB::statement('ALTER TABLE audio ADD COLUMN webp_cropped_image VARCHAR(255) AFTER cropped_image');

        // Add webp_image_link and webp_cropped_image columns to programmings table
        DB::statement('ALTER TABLE programmings ADD COLUMN webp_image_link VARCHAR(255) AFTER image_link');
        DB::statement('ALTER TABLE programmings ADD COLUMN webp_cropped_image VARCHAR(255) AFTER cropped_image');
    }

    public function down()
    {
        // Remove webp columns from photoshops table
        DB::statement('ALTER TABLE photoshops DROP COLUMN webp_image_link');
        DB::statement('ALTER TABLE photoshops DROP COLUMN webp_cropped_image');

        // Remove webp columns from audio table
        DB::statement('ALTER TABLE audio DROP COLUMN webp_image_link');
        DB::statement('ALTER TABLE audio DROP COLUMN webp_cropped_image');

        // Remove webp columns from programmings table
        DB::statement('ALTER TABLE programmings DROP COLUMN webp_image_link');
        DB::statement('ALTER TABLE programmings DROP COLUMN webp_cropped_image');
    }
} 