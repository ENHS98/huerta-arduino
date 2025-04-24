<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Valor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        
        $valores = Valor::create([
            'temperatura' => $request->input('temperatura'),
            'humedad' => $request->input('humedad'),
            'uv' => $request->input('uv')
        ]);

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

    public function historial(Request $request)
    {
        $query = Valor::query();
    
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
    
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
    
        $historial = $query->orderBy('created_at', 'desc')->paginate(10);
    
        return view('historial', compact('historial'));
    }    
    

    public function historialShow($id)
    {
        $historial = Valor::findOrFail($id);
        return view('historialShow', compact('historial'));
    }

    public function solicitar()
    {
        $esp32_ip = "http://192.168.176.55/enviar";

        $response = Http::timeout(10)->get($esp32_ip);

        return redirect()->route('dashboard')->with('success', 'Datos solicitados al ESP32');
    }
}
