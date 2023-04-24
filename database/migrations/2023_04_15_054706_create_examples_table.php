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
        Schema::create('examples', function (Blueprint $table) {
            $table->id();
            $table->text('sentence');
            $table->unsignedBigInteger('word_id');
            $table->unsignedBigInteger('source_example_id')->nullable();
            $table->enum('language', Language::toArray());
            $table->timestamps();

            $table->foreign('word_id')
                ->references('id')
                ->on('words');

            $table->foreign('source_example_id')
                ->references('id')
                ->on('examples');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examples');
    }
};
