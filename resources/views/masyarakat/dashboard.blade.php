@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
@endsection
@section('sidebar-biodata')
    <span>Welcome</span>
    @endsection

    @section('sidebar-menu')
    <li class="header">Main</li>
    <li class="active open">
        <a href="#myPage" class="has-arrow"><i class="icon-home"></i><span>My Page</span></a>
        <ul>
            <li class="active"><a href="{{ url('masyarakat/dashboard') }}">Dashboard</a></li>
        </ul>
    </li>
    @endsection
@section('content')
<div class="row clearfix mt-5">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>Form Pengaduan</h2>
            </div>
            <div class="body">
                <form action="{{ url('masyarakat/pengaduan') }}" method="POST" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <h6>Data Diri</h6>
                        <br>
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Telp</label>
                        <input type="text" name="telp" class="form-control" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <h6>Pengaduan</h6>
                        <br>
                        <label>Isi Laporan</label>
                        <textarea name="content" class="form-control" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="image" class="dropify" data-max-file-size="2000K" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
    @if (Session::has('dataPengaduan'))
        @php
            $dataPengaduan = Session::get('dataPengaduan')
        @endphp

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover table-custom spacing5"">
                    <thead>
                        <tr>
                            <th style="width: 20px;">#</th>
                            <th>nik</th>
                            <th>name</th>
                            <th>telp</th>
                            <th>Laporan</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPengaduan['pengaduan'] as $pengaduan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dataPengaduan['nik'] }}</td>
                            <td>{{ $dataPengaduan['name'] }}</td>
                            <td>{{ $dataPengaduan['telp'] }}</td>
                            <td>{{ $pengaduan['content'] }}</td>
                            <td>
                                <img width="60" src="{{ asset('images/'. $pengaduan['photo']) }}" alt="-">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
@if (Session::has('message'))
<script>
    let message = `{{ Session::get('message') }}`
    swal(message)
</script>
@endif
<script>

</script>
@endsection
