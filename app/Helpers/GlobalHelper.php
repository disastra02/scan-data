<?php

use App\Models\Master\Letter;
use App\Models\Master\Timbangan;
use App\Models\User;

if ( !function_exists('getJumlahSurat') )
{
    function getJumlahSurat($id){
        $hasil = Letter::where("id_transport", $id)->count(); 

        return $hasil;
    }
}

if ( !function_exists('getJumlahBerat') )
{
    function getJumlahBerat($id){
        $total = 0;
        $dataSurat = Letter::where("id_transport", $id)->get();

        foreach($dataSurat as $dt) {
            $berat = Timbangan::where("id_letter", $dt->id)->sum('berat_barang');
            $total = $total + $berat;
        }

        return $total;
    }
}

if ( !function_exists('getJumlahBeratLetter') )
{
    function getJumlahBeratLetter($id){
        $hasil = Timbangan::where("id_letter", $id)->sum('berat_barang');

        return $hasil;
    }
}

if ( !function_exists('getUser') )
{
    function getUser($id){
        $hasil = User::where("id", $id)->first();

        return $hasil;
    }
}


?>