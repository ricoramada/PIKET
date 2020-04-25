<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TabelGuru extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guru_piket', function (Blueprint $table) {
            $table->bigIncrements('id')->primaryKey();
            $table->string('nama_guru');
            $table->string('email');
            $table->string('password');
            $table->string('alamat');
            $table->string('telp');
            $table->timestamp('created_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guru_piket', function (Blueprint $table) {
            //
        });
    }
}
