<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('category_id')->after('image')->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('category', 100)->default('noticias')->after('image');
        });
    }
};
