<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bk_posts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['ARTICLE', 'CURHAT_ANONIM'])->default('ARTICLE');
            $table->string('title');
            $table->string('image')->nullable();
            $table->text('content')->nullable();
            $table->string('author')->default('Guru BK');
            $table->string('category')->nullable();
            $table->string('status')->nullable()->default('Dipublikasikan');
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bk_posts');
    }
};