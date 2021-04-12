<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelasiKelasMahasiwaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::table('mahasiswa', function (Blueprint $table){
            $table->dropColumn('kelas');
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        schema::table('mahasiswa', function(Blueprint $table){
            $table->string('kelas');
            $table->dropForeign(['kelas_id']);
        });
    }
}
