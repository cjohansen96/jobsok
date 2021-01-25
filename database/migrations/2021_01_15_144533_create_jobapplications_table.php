<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobapplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobapplications', function (Blueprint $table) {
            $table->id();
            $table->text('company');
            $table->text('jobtitle');
            $table->text('status');
            $table->date('date_sent');
            $table->date('date_jobexpired');
            $table->text('place');
            $table->text('phone');
            $table->text('applicationlink');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobapplications');
    }
}
