<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Letter;
use App\Models\Master\Timbangan;
use App\Models\Master\Transport;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class TimbanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        //
    }

    public function create()
    {
        return view('master.timbangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
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

        return redirect()->route('home');
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
