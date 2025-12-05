<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->integer('artist_code');
            $table->string('name');
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedBigInteger('sales')->default(0);
            $table->string('cover')->nullable();
            $table->timestamps();

            $table->foreign('artist_code')->references('code')->on('artists')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
