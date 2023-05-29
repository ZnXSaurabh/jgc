<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create1556515103983ProposalsTable extends Migration
{
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedInteger('candidate_id');
            $table->longText('proposal_text');
            $table->string('budget')->nullable();
            $table->string('delivery_time')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->datetime('rejected_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        // Schema::table('proposals', function($table) {
        //     $table->unsignedBigInteger('job_id');
        //     $table->unsignedInteger('candidate_id');
        //     $table->foreign('job_id')->references('id')->on('jobs');
        //     $table->foreign('candidate_id')->references('id')->on('users');
        // });
    }

    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
