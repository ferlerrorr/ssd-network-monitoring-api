<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Storenetworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storenetworks', function (Blueprint $table) {
            $table->id();
            $table->string('store_code', 100 );
            $table->string('previous_ip', 100 )->nullable();
            $table->string('current_ip', 100 )->nullable();
            $table->bigInteger('previous_timestamp')->nullable();
            $table->bigInteger('current_timestamp')->nullable();
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
        Schema::dropIfExists('storenetworks');
    }
}
