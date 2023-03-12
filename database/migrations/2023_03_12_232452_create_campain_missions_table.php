<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campain_missions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->double('binding_fee')->default(0);
			$table->double('daily_profit')->default(0);
			$table->integer('contract_term')->default(0);
	        $table->longText('content')->nullable();
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
        Schema::dropIfExists('campain_missions');
    }
};
