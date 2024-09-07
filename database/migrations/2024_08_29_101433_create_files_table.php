<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pôvodný názov súboru
            $table->string('filename'); // Unikátny názov súboru
            $table->string('mimes', 255); // MIME typ súboru
            $table->string('extension', 10); // Prípona súboru
            $table->unsignedBigInteger('size'); // Veľkosť súboru v bajtoch
            $table->morphs('fileable'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
