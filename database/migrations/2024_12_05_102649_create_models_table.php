<?php

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
        Schema::create('models', function (Blueprint $table) {
            $table->id(); // id - int, primary key
            $table->string('name', 15); // name - varchar(15)
            $table->unsignedBigInteger('section_id'); // section_id - int
            $table->string('url', 100); // url - varchar(100)
            $table->text('description'); // description - text
            $table->json('permission'); // permission - JSON
            $table->timestamps(); 

            // Foreign key constraint
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

            // Indexes
            $table->index('section_id'); // Index on section_id
            $table->index('name'); // Index on name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
