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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('state');
            $table->string('email');
            $table->string('body');
            $table->string('location');

            $table->primary(['id', 'parent_id']);

            $table->unique('email');
            $table->index('state');
            $table->fullText('body')->language('english');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
