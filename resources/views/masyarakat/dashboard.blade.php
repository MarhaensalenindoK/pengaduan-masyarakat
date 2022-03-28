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
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2>List Pengaduan Anda</h2>
            </div>
            <div class="body">
                <form>
                    @csrf
                    <div class="form-group">
                        <h6>Silahkan isi NIK</h6>
                        <p>Mengambil laporan berdasarkan NIK</p>
                        <br>
                        <label>NIK</label>
                        <input type="text" id="nik_masyarakat" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="showPengaduan()">Tampilkan Pengaduan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="table-responsive">
            <table class="table table-hover table-custom spacing5" id="table_pengaduan" style="display: none;">
                <thead>
                    <tr>
                        <th style="width: 20px;">#</th>
                        <th>nik</th>
                        <th>name</th>
                        <th>telp</th>
                        <th>Laporan</th>
                        <th>Foto</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="renderPengaduan">

                </tbody>
            </table>
        </div>
    </div>

    @if (Session::has('dataPengaduan'))
        @php
            $dataPengaduan = Session::get('dataPengaduan')
        @endphp

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover table-custom spacing5">
                    <thead>
                        <tr>
                            <th style="width: 20px;">#</th>
                            <th>nik</th>
                            <th>name</th>
                            <th>telp</th>
                            <th>Laporan</th>
                            <th>Foto</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPengaduan['pengaduan'] as $pengaduan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dataPengaduan['nik'] }}</td>
                            <td>{{ $dataPengaduan['name'] }}</td>
                            <td>{{ $dataPengaduan['telp'] }}</td>
                            <td>
                                <div class="text-wrap" style="width:23rem">
                                    {{ $pengaduan['content'] }}
                                </div>
                            </td>
                            <td>
                                @if ($pengaduan['photo'] !== null)
                                <img width="60" src="{{ asset('images/'. $pengaduan['photo']) }}" alt="-">
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @switch($pengaduan['status'])
                                    @case('todo')
                                    <span class="badge badge-primary">Sedang dilakukan</span>
                                        @break
                                    @case('inprogress')
                                    <span class="badge badge-warning">Sedang berlangsung</span>
                                        @break
                                    @default
                                    <span class="badge badge-success">Selesai</span>
                                @endswitch
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let dataPengaduan = {}

    function showPengaduan() {
        let nik = $("#nik_masyarakat").val()

        $.ajax({
            type: "get",
            url: "{{ url('masyarakat/pengaduan') }}",
            data: {
                nik
            },
            success: function (response) {
                renderPengaduan(response.data)
            },
            error: function (e) {
                swal('error!', 'Gagal mengambil data pengaduan Anda!', 'error')
            }
        });
    }

    function renderPengaduan(data) {
        let html = ``
        let no = 1
        $.each(data, function (key, pengaduan) {
            html += `
            <tr>
                <td>${no++}</td>
                <td>${pengaduan.masyarakat.nik}</td>
                <td>${pengaduan.masyarakat.name}</td>
                <td>${pengaduan.masyarakat.telp}</td>
                <td>
                    <div class="text-wrap" style="width:23rem">
                        ${pengaduan.content}
                    </div>
                </td>
                <td>
                    ${pengaduan.photo !== null ? `<img width="60" src="/images/${pengaduan.photo}" alt="-">` : '-'}
                </td>
                <td>
                `
                switch (pengaduan.status) {
                    case 'todo':
                    html += `<span class="badge badge-primary">Sedang dilakukan</span>`

                        break;
                    case 'inprogress':
                    html += `<span class="badge badge-warning">Sedang berlangsung</span>`
                        break;
                    default:
                        html += `<span class="badge badge-success">Selesai</span>`
                        break;
                }
            html += `
                </td>
            </tr>
            `
        });

        $("#renderPengaduan").html(html);
        $("#table_pengaduan").show('slow');
    }
</script>
@endsection
