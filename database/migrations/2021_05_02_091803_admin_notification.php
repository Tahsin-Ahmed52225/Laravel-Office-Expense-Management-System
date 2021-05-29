<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_ID');
            $table->unsignedBigInteger('transection_ID');
            $table->unsignedBigInteger('expense_ID')->nullable();
            $table->string('notification');
            $table->integer('type');
            $table->timestamps();




            $table->foreign('user_ID')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('transection_ID')
                ->references('id')->on('transection')
                ->onDelete('cascade');
            $table->foreign('expense_ID')
                ->references('id')->on('expense')
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
