<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentMethodToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('credit_card_expiration')->nullable();
            $table->string('credit_card_cvc')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_branch_name')->nullable();
            $table->string('bank_branch_code')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_type')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('convenience_store')->nullable();
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
            $table->dropColumn('payment_method');
            $table->dropColumn('credit_card_number');
            $table->dropColumn('credit_card_expiration');
            $table->dropColumn('credit_card_cvc');
            $table->dropColumn('bank_account_number');
            $table->dropColumn('bank_branch_name');
            $table->dropColumn('bank_branch_code');
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_account_type');
            $table->dropColumn('bank_account_holder');
            $table->dropColumn('convenience_store');
        });
    }
}
