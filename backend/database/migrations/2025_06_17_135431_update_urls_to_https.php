<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateUrlsToHttps extends Migration
{
    public function up()
    {
        // Update audio table
        DB::table('audio')->update([
            'image_link' => DB::raw("REPLACE(image_link, 'http://', 'https://')"),
            'cropped_image' => DB::raw("REPLACE(cropped_image, 'http://', 'https://')"),
            'mp3_file' => DB::raw("REPLACE(mp3_file, 'http://', 'https://')")
        ]);

        // Update photoshops table
        DB::table('photoshops')->update([
            'image_link' => DB::raw("REPLACE(image_link, 'http://', 'https://')"),
            'cropped_image' => DB::raw("REPLACE(cropped_image, 'http://', 'https://')")
        ]);

        // Update programmings table
        DB::table('programmings')->update([
            'image_link' => DB::raw("REPLACE(image_link, 'http://', 'https://')"),
            'cropped_image' => DB::raw("REPLACE(cropped_image, 'http://', 'https://')")
        ]);
    }

    public function down()
    {
        // Update audio table
        DB::table('audio')->update([
            'image_link' => DB::raw("REPLACE(image_link, 'https://', 'http://')"),
            'cropped_image' => DB::raw("REPLACE(cropped_image, 'https://', 'http://')"),
            'mp3_file' => DB::raw("REPLACE(mp3_file, 'https://', 'http://')")
        ]);

        // Update photoshops table
        DB::table('photoshops')->update([
            'image_link' => DB::raw("REPLACE(image_link, 'https://', 'http://')"),
            'cropped_image' => DB::raw("REPLACE(cropped_image, 'https://', 'http://')")
        ]);

        // Update programmings table
        DB::table('programmings')->update([
            'image_link' => DB::raw("REPLACE(image_link, 'https://', 'http://')"),
            'cropped_image' => DB::raw("REPLACE(cropped_image, 'https://', 'http://')")
        ]);
    }
}
