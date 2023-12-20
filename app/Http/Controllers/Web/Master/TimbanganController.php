<?php

namespace App\Http\Controllers\Web\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Barang;
use App\Models\Master\Letter;
use App\Models\Master\Timbangan;
use App\Models\Master\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Throwable;

class TimbanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $data['page'] = 'manual';
        $data['user'] = Auth::user();
        $data['kendaraan'] = Transport::where('created_by', $data['user']->id)->orderBy('id', 'DESC')->get();

        return view('web.cek_manual.index', $data);
    }

    public function create()
    {
        $data['barang'] = Barang::orderBy('id', 'DESC')->get();

        return view('web.cek_manual.create', $data);
    }

    public function store(Request $req)
    {
        try {

            // User created
            $user = Auth::user();

            // Validation

            // Save transport
            $transport = Transport::create([
                'no_kendaraan' => strtoupper($req->input('nomor_kendaraan')),
                'created_by' => $user->id
            ]);

            // Surat Jalan & Timbangan
            $dataAllSuratJalan = $req->input('nomer_surat');
            $dataAllBarcode = $req->input('nomer_barcode');

            foreach ($dataAllSuratJalan as $keySurat => $dtSurat) {
                $suratJalan = Letter::create([
                    'no_surat' => $req->input('surat_jalan.'.$keySurat),
                    'id_transport' => $transport->id,
                    'created_by' => $user->id
                ]);

                if ($dataAllBarcode) {
                    foreach ($dataAllBarcode as $keyBarcode => $dtBarcode) {
                        if ($dtSurat != $dtBarcode) {
                            break;
                        } 
        
                        Timbangan::create([
                            'id_letter' => $suratJalan->id,
                            'kode_barang' => $req->input('kode_barang.'.$keyBarcode),
                            'berat_barang' => $req->input('berat_barang.'.$keyBarcode),
                            'created_by' => $user->id
                        ]);
        
                        unset($dataAllBarcode[$keyBarcode]);
                    }
                }
            }

            Session::flash('success', 'Berhasil menambahkan data.');
            return redirect()->route('w-cek-manual.index');
        } catch (Throwable $e) {
            Session::flash('error', 'Terjadi sesuatu kesalahan pada server.');
            return redirect()->route('w-cek-manual.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
