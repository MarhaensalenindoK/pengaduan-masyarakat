@extends('layout')

@section('css')
@endsection

@section('content')
<div id="main-content" class="w-100 p-0">
    <div class="container-fluid p-0">
        <div class="row-clearfix mx-5 mt-5 text-center">
            <div class="card">
                <div class="body border-radius-15-important">
                    <div class="row">
                        <div class="col-md-6 md-3">
                            <img src="{{ asset('images/landingpage/megaphone.png') }}" alt="image" class="img-fluid">
                        </div>
                        <div class="col-md-6 md-3">
                            <p class="font-50 mb-0 text-info font-weight-700">
                                Selamat Datang
                            </p>
                            <p class="font-30 mb-5 text-info">di Website Pengaduan Masyarakat</p>
                            <p class="text-muted font-16">
                                Selamat datang di Website Pengaduan Masyarakat.
                                Website ini dimaksudkan sebagai sarana publikasi untuk memberikan informasi mengenai Pengaduan Masyarakat.

                                Kritik dan saran yang ada sangat kami harapkan guna penyempurnaan website ini dimasa akan datang.

                                Semoga website ini memberikan manfaat dan inspirasi bagi para pembaca.
                                Jangan lupa follow sosial media kami, agar selalu terupdate dengan berita terbaru.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-clearfix mx-5 mt-6 text-center">
            <div class="card">
                <div class="card-title text-info">
                    <h5>Pengaduan</h5>
                </div>
                <div class="body border-radius-15-important">

                    <div class="row slider h-50 mx-auto" id="renderPengaduan">
                        @foreach ($dataPengaduan['data'] as $pengaduan)
                            <div class="mx-2 cursor-pointer">
                                <div class="card">
                                    <div class="body text-center" style="min-height: 23rem;">
                                        @if ($pengaduan['photo'] !== null)
                                        <img width="50" src="{{ asset('images/' . $pengaduan['photo']) }}" class="card-img-top" alt="{{ asset('images/login-img.png') }}">
                                        @endif
                                        <p class="card-text text-truncate">{{ $pengaduan['content'] }}</p>
                                        <a href="javascript:void(0)" class="badge badge-primary">{{ $pengaduan['masyarakat']['name'] ?? '-' }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row-clearfix mx-5 mt-5 text-center">
            <div class="card">
                <div class="body border-radius-15-important bg-info">
                    <div class="row">
                        <div class="col-md-6 md-3">
                            <img src="{{ asset('images/landingpage/note.png') }}" alt="image" class="img-fluid">
                        </div>
                        <div class="col-md-5 md-3 mt-6 ">
                            <p class="font-25 mb-0 text-white font-weight-500">
                                Masuk untuk mendapatkan berbagai macam pelayanan pelaporan dari kami
                            </p>
                                <button type="button" class="btn btn-primary font-25 w-50 rounded-pill mt-4" onclick="window.open(`/masyarakat/dashboard`, '_blank')">Masuk</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-dark text-white pt-5 pb-4 mt-6">

        <div class="container text-center text-md-left mt-6">

            <div class="row text-center text-md-left">

                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-2 class ">
                    <img width="50" src="{{ asset('images/login-img.png') }}" alt="" class="img-fluid mx-auto" >
                    <span class="font-weight-700 font-20 color-grey-1">Reporting It</span>
                    <p>sebuah sistem informasi prosedur pelayanan masyarakat berbasis web yang digunakan untuk mendata, mengelola dan memantau jalur informasi pelayanan pelaporan masyarakat</p>

                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-white">Company</h5>
                <p>
                    <a href="javascript:void(0)" class="text-white text-decoration-none"> Press lereases </a>
                </p>
                <p>
                    <a href="javascript:void(0)" class="text-white text-decoration-none"> Mission</a>
                </p>
                <p>
                    <a href="javascript:void(0)" class="text-white text-decoration-none"> Srategy</a>
                </p>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-white">About</h5>
                <p>
                    <a href="javascript:void(0)" class="text-white text-decoration-none"> Carrier</a>
                </p>
                <p>
                    <a href="javascript:void(0)" class="text-white text-decoration-none"> Team</a>
                </p>
                <p>
                    <a href="javascript:void(0)" class="text-white text-decoration-none"> Clients</a>
                </p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 font-weight-bold text-white" >Find Us On</h5>
                    <div class="row">
                        <div class="col-md-0">
                            <div class="col-md-1">
                                <i class="fa fa-facebook"></i>
                            </div>
                        </div>
                        <div class="col-md-0">
                            <div class="col-md-1">
                                <i class="fa fa-twitter"></i>
                            </div>
                        </div>
                        <div class="col-md-0">
                            <div class="col-md-1">
                                <i class="fa fa-instagram"></i>
                            </div>
                        </div>
                        <div class="col-md-0">
                            <i class="fa fa-linkedin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <hr class=" mb-4 mt-10">

            <div class="row align-items-center">

                <div class="col-md-7 mt-4 col-lg-12 text-center">
                    <p>	Copyright ©2022 All rights reserved : Marhaensalenindo Komara's</p>
                </div>

            </div>

        </div>

    </div>

    </footer>
@endsection

@section('script')
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#renderPengaduan').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 2,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
        ]
    });

    function detailClinicPage(clinicId) {
        window.open(`/${clinicId}/detail-clinic`, '_blank');
    }

    function searchClinic(e) {
        let value = $("#searchInput").val();
        if (value != '') {
            let keyword = value.toLowerCase();
            filtered_clinics = clinics.filter(function(clinic){
                    name = clinic.name.toLowerCase();
                return name.indexOf(keyword) > -1;
            });

            renderClinic(filtered_clinics)
        } else {
            renderClinic(clinics)
        }
    }

    function renderClinic(data) {
        let html = ``

        $.each(data, function (key, clinic) {
            html += `
                <div class="mx-2 cursor-pointer" onclick="detailClinicPage(${clinic.id})">
                    <div class="card">
                        <div class="body text-center" style="min-height: 23rem;">
                            <img src="{{ asset('images/landingpage/hospital-icon.png') }}" alt="" class="img-fluid mx-auto">
                            <p class="font-24">
                                ${clinic.name}
                            </p>
                            <p class="font-18 text-muted">
                                ${clinic.address}
                            </p>
                        </div>
                    </div>
                </div>
            `
        });

        $("#renderClinic").html(html);
    }
</script>
@endsection
