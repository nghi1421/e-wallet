<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

//1: chuyển tiền ví điện tử
//2: chuyển tiền đến tài khoản ngân hàng
//3: nạp tiền từ tài khoản ngân hàng đã được liên kết
//4: nhận tiền từ một user ví điện tử

            $table->tinyInteger('type');


            $table->json('source');
            $table->json('des');

            $table->string('note', 200)->nullable();
            $table->decimal("money", 19, 4);

//0: thất bại (failed)
//1: đang xử lí (processing)
//2: thành công (success)
            $table->tinyInteger("status");

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
        Schema::dropIfExists('payments');
    }
}
