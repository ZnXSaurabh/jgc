<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()
    {

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('jobid')->unique();
            $table->longText('description',2000)->nullable();
            $table->string('no_of_vacancy');
            $table->string('minimum_exp_req');
            $table->string('minimum_qualification');
            $table->string('salary')->nullable();
            $table->string('location_preference');
            $table->string('gender_preference');
            $table->string('attachment')->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('jobs', function($table) {
            $table->unsignedInteger('user_id'); 
            $table->integer('jobtype_id')->unsigned();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedInteger('location_id');
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('jobtype_id')->references('id')->on('job_types');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('designation_id')->references('id')->on('designations');
            $table->foreign('location_id')->references('id')->on('locations');
       });

    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::dropIfExists('jobs');

    }

}

