@extends('layouts.frame')

@section('content')
 <div class="row">
      <div class="col-lg-12 margin-tb">
         <div class="pull-left mt-2">
            <h2>JURUSAN TEKNOLOGI INFORMASI - A KHOLIFATUL ARDLI</h2>
      </div>
 <div class="float-right my-2">
    <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input Mahasiswa</a>
         </div>
      </div>
 </div>
      @if ($message = Session::get('success'))
 <div class="alert alert-success">
   <p>{{ $message }}</p>
 </div>
      @endif

      <p>Cari Data Mahasiswa :</p>
	 <form action="{{ url()->current() }}">
    <div class="col-md-11">
        <input type="text" name="keyword" class="form-control" placeholder="Search users...">
    </div>
    <div class="col-md-1">
        <button type="submit" class="btn btn-primary">
            Search
        </button>
    </div>
     </form>

 <table class="table table-bordered">
      <tr>
      <th>Nim</th>
      <th>Nama</th>
      <th>Kelas</th>
      <th>Jurusan</th>
      <th>Email</th>
      <th>Alamat</th>
      <th>Tanggal_lahir</th>
      <th width="280px">Action</th>
      </tr>
      @foreach ($paginate as $mhs)
      <tr>
      <td>{{ $mhs ->nim }}</td>
      <td>{{ $mhs ->nama }}</td>
      <td>{{ $mhs ->kelas->nama_kelas }}</td>
      <td>{{ $mhs ->jurusan }}</td>
      <td>{{ $mhs ->email }}</td>
      <td>{{ $mhs ->alamat }}</td>
      <td>{{ $mhs ->tanggal_lahir }}</td>

      <td>
      <form action="{{ route('mahasiswa.destroy',['mahasiswa'=>$mhs->nim]) }}" method="POST">
      <a class="btn btn-info" href="{{ route('mahasiswa.show',$mhs->nim) }}">Show</a>
      <a class="btn btn-primary" href="{{ route('mahasiswa.edit',$mhs->nim) }}">Edit</a>
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Delete</button>
      </form>
      </td>
      </tr>
      @endforeach
      </table>
      {{ $paginate->links() }}
@endsection