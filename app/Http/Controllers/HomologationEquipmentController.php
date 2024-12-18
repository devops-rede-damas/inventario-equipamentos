<?php

namespace App\Http\Controllers;

use App\HomologationEquipment;
use App\Equipment;
use App\Homologation;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;

class HomologationEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HomologationEquipment  $homologationEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(HomologationEquipment $homologationEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HomologationEquipment  $homologationEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(HomologationEquipment $homologationEquipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HomologationEquipment  $homologationEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomologationEquipment $homologationEquipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HomologationEquipment  $homologationEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomologationEquipment $homologationEquipment)
    {
        //
    }

    public function markAbsent($homologationequipment)
    {

        
        $homologationEquipment = HomologationEquipment::where('id', $homologationequipment)->first();
        $homologationEquipment->status = 'reprovado';
        $homologationEquipment->observations = 'Equipamento não homologado - ausente da sala';
        $homologationEquipment->save();

        $homologation = Homologation::where('id', $homologationEquipment->homologation_id)->first();
        //dd($this->temEquipamentoPendente($homologationEquipment->homologation_id));
        if ($homologation->homologation_status == 'A iniciar') {
            $homologation->homologation_status = 'Em andamento';
            $homologation->save();
        }  elseif ($this->temEquipamentoPendente($homologationEquipment->homologation_id) == false) {
            $homologation->homologation_status = 'Concluído';
            $homologation->save();
        }

        
        return redirect()->route('homologations.show', ['homologation' => $homologationEquipment->homologation_id]);
    }

    public function readQRCode(Request $request)
    {
        $equipment = Equipment::where('cod_equipment', $request->equipmentName)->first();
        $homologationEquipment = HomologationEquipment::where('equipment_id', $equipment->id)->where('homologation_id',$request->homologationId)->first();
        
        if ($homologationEquipment == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Equipamento não encontrado'
            ]);
        }

        $homologationEquipment->status = $request->status;
        $homologationEquipment->observations = $request->observation;
        $homologationEquipment->save();

        if ($request->status_equip) {
            $equipment->status = $request->status_equip;
            $equipment->save();
        }

        $homologation = Homologation::where('id', $homologationEquipment->homologation_id)->first();
        if ($homologation->homologation_status == 'A iniciar') {
            $homologation->homologation_status = 'Em andamento';
            $homologation->save();
        } elseif ($this->temEquipamentoPendente($homologationEquipment->homologation_id) == false) {
            $homologation->homologation_status = 'Concluído';
            $homologation->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $homologationEquipment
        ]);
        //return redirect()->route('homologations.show', ['homologation' => $homologationEquipment->homologation_id]);
    }


    public function temEquipamentoPendente($homologationId){
        return HomologationEquipment::where('homologation_id', $homologationId)->where('status', 'A iniciar')->count() > 0;
    }
}
