<?php

use App\Enums\Language;
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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_word_id')->nullable();
            $table->string('word');
            $table->unsignedBigInteger('theme_id')->nullable();
            $table->enum('language', Language::toArray());
            $table->timestamps();

            $table->foreign('source_word_id')
                ->references('id')
                ->on('words');

            $table->foreign('theme_id')
                ->references('id')
                ->on('themes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
