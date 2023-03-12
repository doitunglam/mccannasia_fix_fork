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
        Schema::table('campains', function (Blueprint $table) {
			$table->unsignedBigInteger('mission_id')->nullable();
			$table->boolean('is_hot')->default(0);
			$table->boolean('is_beginner')->default(0);
			$table->string('campain_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('campains', function (Blueprint $table) {

		    $table->dropColumn('mission_id');
		    $table->dropColumn('is_hot');
		    $table->dropColumn('is_beginner');
		    $table->dropColumn('campain_category');
	    });
    }
};
