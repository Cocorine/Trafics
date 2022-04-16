<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraficsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trafics', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(2);
            $table->datetime('in_time');
            $table->datetime('out_time')->nullable();
            $table->string('temperature');
            $table->string('Motif')->nullable();
            $table->string('Observation')->nullable();
            $table->foreignId('user_id')->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('trafics');
    }
}
