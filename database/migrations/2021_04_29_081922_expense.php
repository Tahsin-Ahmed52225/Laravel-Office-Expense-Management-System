<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Expense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_ID');
            $table->unsignedBigInteger('transection_ID');
            $table->integer('amount');
            $table->string('expense_details');
            $table->string('remarks');
            $table->string('type');
            $table->date('date');
            $table->timestamps();


            $table->foreign('user_ID')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('transection_ID')
                ->references('id')->on('transection')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
