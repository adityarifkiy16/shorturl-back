<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('url', function (Blueprint $table) {
            $table->string('shorturl'); // Adjust the type and length according to your needs
        });

        DB::table('url')->update([
            'shorturl' => DB::raw('originalurl')
        ]);

        Schema::table('url', function (Blueprint $table) {
            $table->dropColumn('originalurl');
        });

        Schema::table('url', function (Blueprint $table) {
            $table->string('shorturl')->change(); // Adjust the type and length if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('url', function (Blueprint $table) {
            $table->string('shorturl'); // Adjust the type and length according to your needs
        });

        DB::table('url')->update([
            'shorturl' => DB::raw('originalurl')
        ]);

        Schema::table('url', function (Blueprint $table) {
            $table->dropColumn('originalurl');
        });

        Schema::table('url', function (Blueprint $table) {
            $table->string('shorturl')->change(); // Adjust the type and length if needed
        });
    }
};
