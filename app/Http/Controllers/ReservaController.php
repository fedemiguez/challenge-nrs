<?php

namespace App\Http\Controllers;

use App\Butaca;
use App\Reserva;
use Illuminate\Http\Request;
use DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservas = Reserva::paginate(15);
        return response()->json(['reservas' => $reservas], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'cantidad' => 'required|integer',
        ]);
        
        $reservas = Reserva::with('butacas')->where('fecha_reserva', $request->fecha)->get();

        if($reservas){
            $cantidadReservada = $reservas->sum('cantidad');
            if($cantidadReservada + $request->cantidad <= 50){
                return response()->json(['reservas' => $reservas], 200);
            }else{
                return response()->json(['errors' => ['No queda mas lugar para esa fecha']], 409);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'butacas.required' => 'Seleccione al menos 1 butaca.',
            'butacas.max' => 'La cantidad de butacas seleccionadas es mayor a la cantidad de personas ingresadas',
            'butacas.min' => 'La cantidad de butacas seleccionadas es menor a la cantidad de personas ingresadas'
        ];
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_reserva' => 'required|date',
            'cantidad' => 'required|integer',
            'butacas' => "required|array|max:$request->cantidad|min:$request->cantidad"
        ], $messages);
        try {
			DB::beginTransaction();
            $reserva = Reserva::create($request->all());
            foreach($request->butacas as $butaca){
                $butacaExplode = explode('-', $butaca);
                Butaca::create([
                    'reserva_id' => $reserva->id,
                    'columna' => $butacaExplode[0],
                    'fila' => $butacaExplode[1],
                ]);
            }
            DB::commit();
            return response()->json(['reserva' => $reserva], 200);
        }
        catch(Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
