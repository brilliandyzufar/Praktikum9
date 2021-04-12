<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Mahasiswa;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
            $mahasiswa = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
            $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
            //menambahkan paginate pada index
            return view('index', ['mahasiswa' => $mahasiswa,'paginate'=>$paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('create', ['kelas' => $kelas]);
    }

    public function cari(\Illuminate\Http\Request $request)
    {
        $mahasiswa = mahasiswa::when($request->keyword, function ($query) use ($request) {
            $query->where('nim', 'like', "%{$request->keyword}%")
                ->orWhere('nama', 'like', "%{$request->keyword}%");
        })->get();
        return view('mahasiswa.detail', compact('mahasiswa'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
            $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_lahir' => 'required',
    ]);
        //fungsi eloquent untuk menambah data
            $mahasiswa = new Mahasiswa;
            $mahasiswa->nim = $request->get('Nim');
            $mahasiswa->nama = $request->get('Nama');
            $mahasiswa->jurusan = $request->get('Jurusan');
            $mahasiswa->email = $request->get('Email');
            $mahasiswa->alamat = $request->get('Alamat');
            $mahasiswa->tanggal_lahir = $request->get('Tanggal_lahir');
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');
            //fungsi eloquent Belongto
            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
            $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
            return view('detail', ['Mahasiswa' => $Mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
            $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
            $kelas = Kelas::all();
            return view('edit', compact('Mahasiswa', 'kelas'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
         $request->validate([
        'Nim' => 'required',
        'Nama' => 'required',
        'Kelas' => 'required',
        'Jurusan' => 'required',
        'Email' => 'required',
        'Alamat' => 'required',
        'Tanggal_lahir' => 'required'
    ]);
    
    $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();;
    $mahasiswa->nim = $request->get('Nim');
    $mahasiswa->nama = $request->get('Nama');
    $mahasiswa->jurusan = $request->get('Jurusan');
    $mahasiswa->email = $request->get('Email');
    $mahasiswa->alamat = $request->get('Alamat');
    $mahasiswa->tanggal_lahir = $request->get('Tanggal_lahir');
    $mahasiswa->save();

    $kelas = new Kelas;
    $kelas->id = $request->get('Kelas');
    //fungsi eloquent Belongto
    $mahasiswa->kelas()->associate($kelas);
    $mahasiswa->save();
        //fungsi eloquent untuk mengupdate data inputan kita
        //Mahasiswa::find($Nim)->update($request->all());
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
            //Mahasiswa::find($Nim)->delete();
            DB::table('mahasiswa')->where('nim',$Nim)->delete();
            return redirect()->route('mahasiswa.index')-> with('success', 'Mahasiswa Berhasil Dihapus');
    }
}