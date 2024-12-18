<?php
namespace App\Http\Controllers;

use App\Homologation;
use Illuminate\Http\Request;
use App\Equipment;
use App\HomologationEquipment;

class HomologationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homologations = Homologation::all();
        $equipmentsByLocation = Equipment::all()->groupBy('location');
        return view('homologations.index', compact('homologations', 'equipmentsByLocation'));
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
        //cria homologação
        $homologation = new Homologation();
        $homologation->homologation_name = $request->homologation_name;
        $homologation->homologation_date_initial = $request->start_date;
        $homologation->homologation_date_final = '1990-01-01 12:00:00';
        $homologation->instruction = $request->instruction;
        $homologation->homologation_status = "A iniciar";
        $homologation->save();

        //atualiza equipamentos para homologação
        $equipments = Equipment::whereIn('id', $request->equipments)->get();
        foreach ($equipments as $equipment) {
            //$equipment->statushomol = "Para homologar";
            //$equipment->save();

            //lista de homologações
            $homologation_equipment = new HomologationEquipment();
            $homologation_equipment->homologation_id = $homologation->id;
            $homologation_equipment->equipment_id = $equipment->id;
            $homologation_equipment->status = "A iniciar";
            $homologation_equipment->user_id = 1;
            $homologation_equipment->homologation_date = '1990-01-01 12:00:00';
            $homologation_equipment->observations = '';
            $homologation_equipment->save();
        }
        return redirect()->route('homologations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Homologation  $homologation
     * @return \Illuminate\Http\Response
     */
    public function show(Homologation $homologation)
    {
        $homologation = Homologation::findOrFail($homologation->id);

        $homologationEquipments = HomologationEquipment::where('homologation_id', $homologation->id)
                                                ->with(['user', 'equipment'])
                                                ->get();

        return view('homologations.show', compact('homologation', 'homologationEquipments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Homologation  $homologation
     * @return \Illuminate\Http\Response
     */
    public function edit(Homologation $homologation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Homologation  $homologation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homologation $homologation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homologation  $homologation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homologation $homologation)
    {
        //
    }
}
