<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('server_ip');
            $table->string('client_ip');
            $table->integer('client_port');
            $table->string('client_location')->nullable();
            $table->string('remote_ip');
            $table->integer('remote_port');
            $table->integer('bytes_received')->default(0);
            $table->integer('bytes_sent')->default(0);
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
