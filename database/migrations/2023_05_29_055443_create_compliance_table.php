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
        Schema::create('compliance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname',500)->nullable();
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('category')->nullable();
            $table->string('message',2000)->nullable();
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance');
    }
};
