<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBalancesHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_balances_historical', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_user')->unsigned();
            $table->integer('fk_balance')->unsigned();
            $table->decimal('balance', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fk_user')->on('users')->references('id');
            $table->foreign('fk_balance')->on('user_balances')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_balances_historical');
    }
}
