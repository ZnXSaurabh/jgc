<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobAppliedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applieds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('job_id')->unsigned()->nullable();
            $table->boolean('status')->default(0);
            $table->date('applied_date');            
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('job_applieds', function($table) {
            $table->unsignedInteger('candidate_id')->nullable();
            // $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('candidate_id')->references('id')->on('users');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applieds');
    }
}
