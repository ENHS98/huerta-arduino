<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Valor;

class DashboardController extends Controller
{
    //puto el que lo lea
    public function dashboard() {

        $humedad =null;
        $uv = null;
        $temperatura = null;
        $date = null;

        $valores = Valor::orderBy('created_at', 'desc')->first();

        if ($valores) {
            $humedad = $valores->humedad;
            $uv = $valores->uv;
            $temperatura = $valores->temperatura;
            $date = Carbon::parse($valores->created_at);
        }
        
        return view('dashboard', compact("humedad", "uv", "temperatura", "date"));
    }

    public function postValores(Request $request) {
        
        $valores = new Valor();
        $valores->temperatura = $request->input('temperatura');
        $valores->humedad = $request->input('humedad');
        $valores->uv = $request->input('uv');
        $valores->save();

        return response()->json(['success' => true]);
    }

    public function datosDelDia()
    {
        $hoy = now()->startOfDay();
        $datos = Valor::where('created_at', '>=', $hoy)
            ->orderBy('created_at')
            ->get(['temperatura', 'humedad', 'uv', 'created_at']);

        return response()->json($datos);
    }
}
