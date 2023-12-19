<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Master\Letter;
use App\Models\Master\Timbangan;
use App\Models\Master\Transport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['totalKendaraan'] = Transport::count(); 
        $data['totalSurat'] = Letter::count(); 
        $data['totalBerat'] = Timbangan::sum('berat_barang'); 
        $data['totalChecker'] = User::where('id_jenis', 2)->count();
        $data['kendaraan'] = Transport::orderBy('id', 'DESC')->get();

        return view('web.dashboard.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
