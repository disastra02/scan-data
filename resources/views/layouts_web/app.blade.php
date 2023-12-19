<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- SweetAlert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <style>
        .main-background::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 320px;
            --bs-bg-opacity: 1;
            background-color: rgba(var(--bs-success-rgb),var(--bs-bg-opacity))!important;
            z-index: -1;
        }

        .h-90 {
            height: 95%;
        }
    </style>
    @stack('css')
</head>
<body class="bg-white">
    {{-- <div id="app"> --}}
        <nav class="navbar navbar-expand-lg">
            <div class="container p-3">
                <a class="navbar-brand fw-bolder" href="#"><h4 class="mb-1">Warehouse</h4></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto ms-4 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="#">Data Master</a>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data Master
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Master User</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="{{ asset('images/dummy.jpg') }}" class="rounded float-end" width="40" alt="...">
                    </a> 
                </div>
            </div>
        </nav>

        <main class="main-background">
            <div class="container py-4 px-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active text-white" aria-current="page">Home</li>
                    </ol>
                </nav>

                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="card-title mb-4">
                            <h3 class="fw-bold mb-0">Summary Dashboard</h3>
                            <span class="text-black-50">Lorem ipsum dolor</span>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-secondary-subtle text-secondary border-0">
                                            <div class="card-body">
                                                <h3 class="fw-bold mb-4"><i class="fa-solid fa-truck"></i></h3>
                                                <h3 class="fw-bold mb-0">{{ $totalKendaraan }}</h3>
                                                <span>Total Kendaraan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-primary-subtle text-primary border-0">
                                            <div class="card-body">
                                                <h3 class="fw-bold mb-4"><i class="fa-solid fa-envelope"></i></h3>
                                                <h3 class="fw-bold mb-0">{{ $totalSurat }}</h3>
                                                <span>Total Surat</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-success-subtle text-success border-0">
                                            <div class="card-body">
                                                <h3 class="fw-bold mb-4"><i class="fa-solid fa-weight-scale"></i></h3>
                                                <h3 class="fw-bold mb-0">{{ $totalBerat }} KG</h3>
                                                <span>Total Berat</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-danger-subtle text-danger border-0">
                                            <div class="card-body">
                                                <h3 class="fw-bold mb-4"><i class="fa-solid fa-user"></i></h3>
                                                <h3 class="fw-bold mb-0">{{ $totalChecker }}</h3>
                                                <span>Total Checker</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <div class="card-title mb-4">
                                            <h3 class="fw-bold mb-0">Pengecekan Barang</h3>
                                            <span class="text-black-50">Lorem ipsum dolor</span>
                                        </div>
                                        <table class="table">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Pembuat</th>
                                                <th scope="col">Nomor Kendaraan</th>
                                                <th scope="col">Total Surat</th>
                                                <th scope="col">Total Berat</th>
                                                <th scope="col">Waktu</th>
                                                <th scope="col">Aksi</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              @forelse ($kendaraan as $item)
                                                  <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ getUser($item->created_by) ? getUser($item->created_by)->name : '-' }}</td>
                                                    <td>{{ $item->no_kendaraan }}</td>
                                                    <td>{{ getJumlahSurat($item->id) }} Surat</td>
                                                    <td>{{ getJumlahBerat($item->id) }} KG</td>
                                                    <td>{{ $item->created_at }}</td>
                                                    <td><button class="btn btn-primary">Detail</button></td>
                                                  </tr>
                                              @empty
                                                  <tr>
                                                    <td colspan="7" class="text-center text-danger">Tidak ada data.</td>
                                                  </tr>
                                              @endforelse
                                            </tbody>
                                          </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </main>

        <!-- Bootstrap Script -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>

        <!-- Chart Js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @stack('scripts')
        <script>
            const ctx = document.getElementById('myChart');

            new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Aktivitas Checker'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
            });
        </script>

    {{-- </div> --}}
</body>
</html>
