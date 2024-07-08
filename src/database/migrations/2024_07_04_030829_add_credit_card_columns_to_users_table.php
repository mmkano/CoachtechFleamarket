<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditCardColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('credit_card_number')->nullable()->after('stripe_customer_id');
            $table->string('credit_card_expiration')->nullable()->after('credit_card_number');
            $table->string('credit_card_cvc')->nullable()->after('credit_card_expiration');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('credit_card_number');
            $table->dropColumn('credit_card_expiration');
            $table->dropColumn('credit_card_cvc');
        });
    }
}
