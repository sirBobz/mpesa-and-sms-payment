<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSmsTypeToSmsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('sms_type_id')->nullable()->index('sms_type_id');
            $table->foreign(['sms_type_id'], 'sms_transactions_ibfk_2')->references(['id'])->on('sms_types')->onUpdate('CASCADE')->onDelete('CASCADE');
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
            $table->dropForeign('sms_transactions_ibfk_2');
        });
    }
}
