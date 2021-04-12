<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahKolomBaru extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('email', 20)->after('jurusan')->nullable()->unique();
            $table->string('alamat', 100)->after('jurusan')->nullable()->unique();
            $table->string('tanggal_lahir', 20)->after('jurusan')->nullable()->unique();
        });

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('alamat');  
            $table->dropColumn('tanggal_lahir');  

        });
    }
}
