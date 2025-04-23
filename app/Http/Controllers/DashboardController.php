<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Valor;

class DashboardController extends Controller
{
    //puto el que lo lea
    public function dashboard() {

        $valores = Valor::orderBy('created_at', 'desc')->first();

        //dd($valores);

        $humedad = "50";
        $uv = "25";
        $temperatura = "20";
        $date = Carbon::now();
        
        return view('dashboard', compact("humedad", "uv", "temperatura", "date"));
    }
}
