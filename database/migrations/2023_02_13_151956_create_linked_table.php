<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked', function (Blueprint $table) {
            $table->id();

            $table->string('phone_number',15);
            $table->foreign('phone_number')->references("phone_number")->on('users');

            $table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references("id")->on('banks');

            $table->string('bank_account_number', 20);

            $table->boolean('checked');
            
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
        Schema::dropIfExists('linked');
    }
}
