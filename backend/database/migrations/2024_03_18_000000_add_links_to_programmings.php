<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('programmings', function (Blueprint $table) {
            $table->string('github_repo')->nullable()->after('english_description');
            $table->string('website_link')->nullable()->after('github_repo');
        });
    }

    public function down()
    {
        Schema::table('programmings', function (Blueprint $table) {
            $table->dropColumn(['github_repo', 'website_link']);
        });
    }
}; 