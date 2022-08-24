<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_id')->nullable();
            $table->string('month')->nullable();
            $table->string('week')->nullable();
            $table->string('name')->nullable();
            $table->integer('analisys_state')->nullable();
            $table->integer('contract_state')->nullable();
            $table->string('negotiator')->nullable();
            $table->text('partner_info')->nullable();
            $table->string('mwp')->nullable();
            $table->string('mwn')->nullable();
            $table->text('extra_inputs')->nullable();
            $table->integer('summary')->nullable();
            $table->integer('set')->nullable();
            $table->integer('km_set')->nullable();
            $table->integer('technology')->nullable();
            $table->string('state')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
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
        Schema::dropIfExists('lands');
    }
}
