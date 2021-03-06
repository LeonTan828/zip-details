<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZipinputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zipinputs', function (Blueprint $table) {
            $table->string('zip_code');
            $table->string('lat');
            $table->string('lng');
            $table->string('city');
            $table->string('state');
            $table->string('timezone_identifier');

            $table->primary('zip_code');
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
        Schema::dropIfExists('zipinputs');
    }
}
