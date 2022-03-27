@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
@endsection
@section('sidebar-biodata')
    <span>Welcome,</span>
    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>
    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY" style="right: auto;">
        <li><a href="{{ url('/logout') }}"><i class="icon-power"></i>Logout</a></li>
    </ul>
@endsection

@section('sidebar-menu')
    <li class="header">Main</li>
    <li class="active open">
        <a href="#myPage" class="has-arrow"><i class="icon-home"></i><span>My Page</span></a>
        <ul>
            <li class="active"><a href="{{ url('petugas/dashboard') }}">Pengaduan Masyarakat</a></li>
            <li><a href="{{ url('petugas/account-masyarakat') }}">Manajemen Masyarakat</a></li>
        </ul>
    </li>
@endsection
@section('content')
<div class="row clearfix mt-5">
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-users"></i></div>
                    <div class="ml-4">
                        <span>Total "Sedang dilakukan"</span>
                        <h4 class="mb-0 font-weight-medium text-todo">{{ $totalTodo }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-green text-white rounded-circle"><i class="fa fa-users"></i></div>
                    <div class="ml-4">
                        <span>Total "Sedang berlangsung"</span>
                        <h4 class="mb-0 font-weight-medium text-inprogress">{{ $totalInprogress }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="body">
                <div class="d-flex align-items-center">
                    <div class="icon-in-bg bg-blue text-white rounded-circle"><i class="fa fa-users"></i></div>
                    <div class="ml-4">
                        <span>Total "Selesai"</span>
                        <h4 class="mb-0 font-weight-medium text-done">{{ $totalDone }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if (Auth::user()->role === 'petugas')
<div class="col-lg-12 col-md-12">
    <button class="btn btn-primary" type="button">
        Cetak Data Pengaduan
    </button>
</div>
@endif
    <div class="col-lg-12 col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-custom spacing5" id="table_pengaduan">
                <thead>
                    <tr>
                        <th style="width: 20px;">#</th>
                        <th>Date</th>
                        <th>NIK</th>
                        <th>Content</th>
                        <th>Photo</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="renderPengaduan">
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('petugas.modals._update_pengaduan')
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    getPengaduan()
    let dataPengaduan = {}

    const months = {
        0: 'January',
        1: 'February',
        2: 'March',
        3: 'April',
        4: 'May',
        5: 'June',
        6: 'July',
        7: 'August',
        8: 'September',
        9: 'October',
        10: 'November',
        11: 'December'
    }

    function getPengaduan() {
        let url = `{{ url('petugas/database/pengaduan') }}`

        $.ajax({
            type: "get",
            url: url,
            success: function (response) {
                dataPengaduan = response.data
                renderPengaduan(response.data)
                $('.text-todo').html(response.totalTodo);
                $('.text-inprogress').html(response.totalInprogress);
                $('.text-done').html(response.totalDone);
            },
            error: function (e) {
                swal('error!', 'Gagal mengambil data pengaduan', 'error')
            }
        });
    }

    function renderPengaduan(data) {
        let html = ``
        let no = 1
        $.each(data, function (key, pengaduan) {
            let d = new Date(pengaduan.created_at)
            const year = d.getFullYear()
            const date = d.getDate()
            const monthIndex = d.getMonth()
            const monthName = months[monthIndex]

            html += `
            <tr onclick="showModalUpdatePengaduan('${pengaduan.id}')">
                <td>${ no++ }</td>
                <td>${date} ${monthName} ${year}</td>
                <td>${pengaduan.nik}</td>
                <td class="cursor-pointer">
                    <div class="text-wrap" style="width:23rem">
                        ${pengaduan.content}
                    </div>
                </td>
                <td>
                    ${pengaduan.photo !== null ? `<img width="60" src="/images/${pengaduan.photo}" alt="-">` : '-'}
                </td>
                <td>`
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
            html += `</td>
                <td>
                    <button type="button" class="btn btn-sm btn-default" onclick="showModalUpdatePengaduan('${pengaduan.id}')" title="Update Pengaduan"><i class="fa fa-pencil"></i></button>
                </td>
            </tr>

            `
        });

        $("#renderPengaduan").html(html);
        $(document).ready( function () {
            $('#table_pengaduan').DataTable();
        });
    }

    function showModalUpdatePengaduan(pengaduanId) {
        let pengaduan = dataPengaduan.find(thisPengaduan => thisPengaduan.id === pengaduanId);
        $("#updatePengaduan").find(`input[name=status][type=radio][value=${pengaduan.status}]`).prop('checked', true)
        $("#updatePengaduan").find(`input[name=pengaduan_id][type=hidden]`).val(pengaduan.id)

        $("#updatePengaduan").modal('show')
    }

    function updatePengaduan() {
        let url = `{{ url('petugas/pengaduan') }}`
        let pengaduan_id = $("#updatePengaduan").find(`input[name=pengaduan_id][type=hidden]`).val()
        let status = $("#updatePengaduan").find(`input[name=status][type=radio]:checked`).val()

        $.ajax({
            type: "patch",
            url: url,
            data: {
                pengaduan_id,
                status
            },
            success: function (response) {
                swal('success!', 'Berhasil mengubah pengaduan', 'success')
                $("#updatePengaduan").modal('hide')
                getPengaduan()
            },
            error: function (e) {
                swal('error!', 'Gagal mengubah pengaduan', 'error')
            }
        });
    }
</script>
@endsection
