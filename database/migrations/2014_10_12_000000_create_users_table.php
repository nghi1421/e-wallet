<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->string('phone_number', 15);

            $table->primary('phone_number');

            $table->string('name', 50);
            $table->date('dob')->nullable();
            $table->string('address', 100)->nullable();
            $table->decimal('balance',19,4)->default(0);

            $table->string('password',200);
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
        Schema::dropIfExists('users');
    }
}
