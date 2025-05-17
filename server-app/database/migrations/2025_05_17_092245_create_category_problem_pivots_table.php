<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_problem_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_id')->constrained(
                'problems'
            )->onDelete('cascade');
            $table->foreignId('category_problem_id')->constrained(
                'category_problems'
            )->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_problem_pivots');
    }
};
