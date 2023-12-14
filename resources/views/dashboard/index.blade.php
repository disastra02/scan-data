@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h1 class="fw-bold">Checker</h2>
                            <h6 class="mb-0 text-black-50">Summary Dashboard</h5>
                        </div>
                        <div class="col-4">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{ asset('images/dummy.jpg') }}" class="rounded float-end" width="50" alt="...">
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="card border-0">
                                <div class="card-body p-0 text-center">
                                    <h6 class="text-black-50">Kendaraan</h6>
                                    <h5 class="mb-0 fw-bold">{{ $totalKendaraan }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-0">
                                <div class="card-body p-0 text-center">
                                    <h6 class="text-black-50">Surat</h6>
                                    <h5 class="mb-0 fw-bold">{{ $totalSurat }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card border-0">
                                <div class="card-body p-0 text-center">
                                    <h6 class="text-black-50">Berat</h6>
                                    <h5 class="mb-0 fw-bold">{{ $totalBerat }} KG</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="fw-bold mb-0">Data Timbangan</h5>
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            <a href="{{ route('timbangan.create') }}" class="btn btn-primary" type="button"><i class="fa-solid fa-plus"></i> &nbsp; Tambah</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12" style="display: none;">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="fw-bold mb-0">Filter</h5>
                        </div>
                        <div class="col-4">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Hari Ini</option>
                                <option value="1">Minggu Ini</option>
                                <option value="2">Bulan Ini</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            @forelse ($kendaraan as $item)
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h6 class="mb-1 text-black-50">Nomor Kendaraan</h6>
                                    <h5 class="mb-0 fw-bold">{{ $item->no_kendaraan }}</h5>
                                </div>
                                <div class="col-3 d-flex justify-content-end">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Detail</a></li>
                                            <li><a class="dropdown-item" href="#">Perbarui</a></li>
                                            <li><a class="dropdown-item" href="#">Hapus</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-6 mb-3">
                                    <h6 class="mb-1 text-black-50">Surat Jalan</h6>
                                    <h5 class="mb-0 fw-bold">{{ getJumlahSurat($item->id) }}</h5>
                                </div>
                                <div class="col-6 mb-3">
                                    <h6 class="mb-1 text-black-50">Total Berat</h6>
                                    <h5 class="mb-0 fw-bold">{{ getJumlahBerat($item->id) }} KG</h5>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-1 text-black-50">Tanggal</h6>
                                    <h5 class="mb-0 fw-bold">{{ $item->created_at->format('Y-m-d'); }}</h5>
                                </div>
                                <div class="col-6">
                                    <h6 class="mb-1 text-black-50">Waktu</h6>
                                    <h5 class="mb-0 fw-bold">{{ $item->created_at->format('H:i'); }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <span class="text-center">Tidak ada data.</span>
            @endforelse
        </div>
    </div>
</div>
@endsection
