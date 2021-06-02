<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandardTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_time', function (Blueprint $table) {
            $table->id();
            $table->double('secretary_time');
            $table->double('fieldDelegate_time');
            $table->double('auditor_time');

            $table->double('executiveDirector_time');
            $table->double('Managing_partner_time');
            $table->double('reviser_time');
            $table->double('revisingManager_time');
            $table->double('helper_time');
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
        Schema::dropIfExists('standard_time');
    }
}
