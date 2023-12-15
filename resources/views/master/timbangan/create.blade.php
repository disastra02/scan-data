@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-4 border-0">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-light back-page bg-transparent border-0"><i class="fa-solid fa-arrow-left"></i></button>
                        <h5 class="fw-bold mb-0">Data Timbangan</h5>
                        <button class="btn btn-light bg-transparent border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Reset Formulir</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <form id="formTimbangan" action="{{ route('timbangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4 border-0">
                    <div class="card-body p-2">
                        <div class="mb-3">
                            <label for="nomorKendaraan" class="form-label">Nomor Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_kendaraan" class="form-control" id="nomorKendaraan" placeholder="Masukkan Nomor Kendaraan" required>
                        </div>
                        
                        <div id="sectionSuratJalan">
                            <div class="card mb-3 mb-4 bg-light border-0">
                                <div class="card-header border-0 bg-secondary-subtle">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            Surat Jalan
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-secondary btn-add-surat" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" type="button"><i class="fa-solid fa-plus"></i>&nbsp; Tambah Surat</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="suratJalan" class="form-label">No Surat Jalan <span class="text-danger">*</span></label>
                                        <input type="text" name="surat_jalan[]" class="form-control" id="suratJalan" placeholder="Masukkan No Surat Jalan" required>
                                        <input type="hidden" name="nomer_surat[]" value="1">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label for="scanBarcode" class="form-label">Scan Barcode</label>
                                        <div class="text-center" id="scanDiv1" style="display: none;">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th class="text-start" width="55%">Kode Barang</th>
                                                        <th class="text-start" width="35%">Berat</th>
                                                        <th class="text-center" width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody1">
                                                </tbody>
                                            </table>
                                            <div class="mb-3" id="loadCamera1"><i class="fa-solid fa-spinner fa-spin-pulse"></i></div>
                                            <div class="mb-3" id="reader1" style="display: none;"></div>
                                        </div>
                                        <button class="btn btn-qr-all btn-success btn-qr-code" data-id="1" type="button"><i class="fa-solid fa-camera"></i> &nbsp; Start Scan </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-4 d-flex flex-column">
                                <button class="btn btn-primary back-page btn-light bg-danger-subtle text-danger border-danger" type="button"><i class="fa-solid fa-xmark"></i> &nbsp; Batal </button>
                            </div>
                            <div class="col-4 d-flex flex-column">
                                <button class="btn btn-primary btn-submit-data" type="button"><i class="fa-solid fa-check"></i> &nbsp; Simpan </button>
                                <button id="submitData" type="submit" class="d-none"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            var statusStream = false, htmlQrCodeAktif = null;
            var idStreamAll = 1, idStreamAktif = 0;
            var arrayDataTimbangan = [];

            // Memulai scan data
            $('body').on('click', '.btn-qr-code', function() {
                let nomerIdStream = $(this).data('id');
                if (htmlQrCodeAktif) {
                    stopScanQr();

                    if (nomerIdStream == idStreamAktif) {
                        statusStream = true;
                    }
                }
                
                if (statusStream) {
                    statusStream = false;
                    stopScanQr();
                    $(this).removeClass('btn-danger');
                    $(this).html('<i class="fa-solid fa-camera"></i> &nbsp; Start Scan');
                } else {
                    statusStream = true;
                    idStreamAktif = nomerIdStream;
                    startScanQr(nomerIdStream, this);
                    $(this).addClass('btn-danger');
                    $(this).html('<i class="fa-solid fa-stop"></i> &nbsp; Stop Scan');
                    $(`#loadCamera${nomerIdStream}`).show();
                    $(`#scanDiv${nomerIdStream}`).show();
                }
            });

            // Hapus data scan
            $('body').on('click', '.btn-remove-qr', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: `Data barang akan dihapus !`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove array
                        let getIndex = arrayDataTimbangan.indexOf(id);
                        arrayDataTimbangan.splice(getIndex, 1);

                        // Remove element
                        $(`#qrValue${id}`).remove();
                    }
                });
            });

            // Hapus data card surat
            $('body').on('click', '.btn-remove-card-surat', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: `Data surat jalan akan dihapus !`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Remove element
                        $(`#cardSuratJalan${id}`).remove();

                        // Show button tambah
                        $('.btn-add-surat').last().show();

                        if (id == idStreamAktif) {
                            stopScanQr();
                        }
                    }
                });
            });

            // Submit data
            $('.btn-submit-data').on('click', function() {
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: `Data akan disimpan !`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit element
                        $('#submitData').trigger('click');
                    }
                });
            });

            // Start Qr
            let startScanQr = (idStream, target) => {
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        var cameraId = devices[1] ? devices[1].id : devices[0].id;
                        
                        const html5QrCode = new Html5Qrcode(`reader${idStream}`);
                        htmlQrCodeAktif = html5QrCode;
                        $(`#loadCamera${idStream}`).hide();
                        $(`#reader${idStream}`).show();

                        html5QrCode.start(
                        cameraId,     // retreived in the previous step.
                        {
                            fps: 10,    // sets the framerate to 10 frame per second
                            qrbox: 250  // sets only 250 X 250 region of viewfinder to
                                        // scannable, rest shaded.
                        },
                        resultQr => {
                            let kodeBarangId = resultQr ? resultQr.substr(0, 7) : 0;
                            let beratBarangId = resultQr ? resultQr.substr(8, 4) / 100 : 0;
                            html5QrCode.pause();
                            
                            Swal.fire({
                                title: "Apakah anda yakin ?",
                                text: `Data dengan kode barang ${kodeBarangId} dan berat ${beratBarangId} kg akan disimpan !`,
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Simpan",
                                cancelButtonText: "Batal",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    let valueQr = `${idStream}-${resultQr}`;

                                    if ($.inArray(valueQr, arrayDataTimbangan) != -1) {
                                        alertCustom("error", "Terjadi Kesalahan !", "Data sudah digunakan.");
                                    } else {
                                        arrayDataTimbangan.push(valueQr);
    
                                        let html = `<tr id="qrValue${valueQr}">
                                                        <td class="text-start">
                                                            ${kodeBarangId}
                                                            <input type="hidden" name="kode_barang[]" value="${kodeBarangId}">
                                                        </td>
                                                        <td class="text-start">
                                                            ${beratBarangId} KG
                                                            <input type="hidden" name="berat_barang[]" value="${beratBarangId}">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger bg-danger-subtle btn-remove-qr border-danger" data-id="${valueQr}" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="text-danger fa-solid fa-trash"></i></button>
                                                            <input type="hidden" name="nomer_barcode[]" value="${idStream}">
                                                        </td>
                                                    </tr>`;
                                        $(`#tbody${idStream}`).append(html);
                                    }
                                    html5QrCode.resume();
                                } else {
                                    html5QrCode.resume();
                                }
                            });
                        },
                        errorMessage => {
                            // console.log(`QR Code no longer in front of camera.`);
                        })
                        .catch(err => {
                            alertCustom("error", "Terjadi Kesalahan !", err);

                            statusStream = false;
                            $(target).removeClass('btn-danger');
                            $(target).html('<i class="fa-solid fa-camera"></i> &nbsp; Start Scan');
                        });
                    }
                }).catch(err => {
                    alertCustom("error", "Terjadi Kesalahan !", err);

                    statusStream = false;
                    $(target).removeClass('btn-danger');
                    $(target).html('<i class="fa-solid fa-camera"></i> &nbsp; Start Scan');
                });
            }

            // Stop Qr
            let stopScanQr = () => {
                if (htmlQrCodeAktif) {
                    $(`.btn-qr-all`).removeClass('btn-danger');
                    $(`.btn-qr-all`).html('<i class="fa-solid fa-camera"></i> &nbsp; Start Scan');

                    htmlQrCodeAktif.stop().then(ignore => {
                        // QR Code scanning is stopped.
                        // console.log("QR Code scanning stopped.");
                        htmlQrCodeAktif.clear();

                    }).catch(err => {
                        // Stop failed, handle it.
                        // console.log("Unable to stop scanning.");
                    });

                    htmlQrCodeAktif = null;
                    statusStream = false;
                }
            }

            // Add Surat Jalan
            $('body').on('click', '.btn-add-surat', function() {
                $(this).hide();
                stopScanQr();

                idStreamAll++;
                let html = `<div class="card mb-3 mb-4 bg-light border-0" id="cardSuratJalan${idStreamAll}">
                                <div class="card-header border-0 bg-secondary-subtle">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            Surat Jalan
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-secondary btn-add-surat" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" type="button"><i class="fa-solid fa-plus"></i>&nbsp; Tambah Surat</button>
                                            &nbsp;
                                            <button type="button" class="btn btn-danger bg-danger-subtle btn-remove-card-surat border-danger" data-id="${idStreamAll}" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"><i class="text-danger fa-solid fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="suratJalan" class="form-label">No Surat Jalan <span class="text-danger">*</span></label>
                                        <input type="text" name="surat_jalan[]" class="form-control" id="suratJalan" placeholder="Masukkan No Surat Jalan" required>
                                        <input type="hidden" name="nomer_surat[]" value="${idStreamAll}">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label for="scanBarcode" class="form-label">Scan Barcode</label>
                                        <div class="text-center" id="scanDiv${idStreamAll}" style="display: none;">
                                            <table class="table align-middle">
                                                <thead>
                                                    <tr>
                                                        <th class="text-start" width="55%">Kode Barang</th>
                                                        <th class="text-start" width="35%">Berat</th>
                                                        <th class="text-center" width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody${idStreamAll}">
                                                </tbody>
                                            </table>
                                            <div class="mb-3" id="loadCamera${idStreamAll}"><i class="fa-solid fa-spinner fa-spin-pulse"></i></div>
                                            <div class="mb-3" id="reader${idStreamAll}" style="display: none;"></div>
                                        </div>
                                        <button class="btn btn-qr-all btn-success btn-qr-code" data-id="${idStreamAll}" type="button"><i class="fa-solid fa-camera"></i> &nbsp; Start Scan </button>
                                    </div>
                                </div>
                            </div>`;

                $('#sectionSuratJalan').append(html);
            });

            let alertCustom = (status, title, text) => {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: status,
                    showConfirmButton: false
                });
            }

            // Button back
            $('.back-page').on('click', function() {
                let url = `{{ route('home') }}`;
                window.location.href = url;
            });
        });
    </script>
@endpush