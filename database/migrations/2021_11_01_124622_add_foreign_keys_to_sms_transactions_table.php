<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSmsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_transactions', function (Blueprint $table) {
            $table->foreign(['payment_id'], 'sms_transactions_ibfk_1')->references(['id'])->on('payment_transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_transactions', function (Blueprint $table) {
            $table->dropForeign('sms_transactions_ibfk_1');
        });
    }
}
