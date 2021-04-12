<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //Model Eloquent
use App\Models\Kelas;

class Mahasiswa extends Model
{
    protected $table='mahasiswa'; // Eloquent akan membuat model mahasiswa menyimpan record ditabel mahasiswa
    protected $primaryKey = 'id_mahasiswa'; // Memanggil isi DB Dengan primarykey
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
     'Nim',
     'Nama',
     'Kelas_id',
     'Jurusan',
     'Email',
     'Alamat',
     'Tanggal_lahir',
     ];

     public function kelas(){
         return $this->belongsTo(Kelas::class);
     }
}
