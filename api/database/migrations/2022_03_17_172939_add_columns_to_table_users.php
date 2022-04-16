<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->string('operation_name')->nullable();
            $table->string('account_verification_token')->nullable();
            $table->string('account_verification_gateway')->nullable();
            $table->timestamp('account_verification_request_at')->nullable();
            $table->boolean('account_verified')->default(0);
            $table->timestamp('account_verified_at')->nullable();
            $table->boolean('reset_password')->default(0);
            $table->timestamp('password_update_at')->nullable();
            $table->string('last_password_remember')->nullable();
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
            
            $table->dropColumn(['operation_name','account_verification_token', 'account_verification_gateway', 'account_verification_request_at', 'account_verified', 'account_verified_at', 'reset_password', 'password_update_at', 'last_password_remember']);

            //$table->dropColumn(['reset_password_code', 'reset_password_gateway', 'reset_password', 'reset_request_at', 'password_update_at']);

            //$table->dropColumn(['account_verification_code', 'last_password_remember', 'account_verification_gateway', 'account_verification_request_at', 'account_verified', 'account_verified_at']);

        });
    }
}
