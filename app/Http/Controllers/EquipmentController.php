<?php

namespace App\Http\Controllers;

use App\Equipment;
use Illuminate\Http\Request;
use \PDF;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $equipments = Equipment::all();
        return view('equipments.index', compact('equipments'));
    }
    
    public function create()
    {
        return view('equipments.create');
    }
    
    public function store(Request $request)
    {
       // dd($request->all());
        Equipment::create($request->all());
        return redirect()->route('equipments.index');
    }
    
    public function show(Equipment $equipment)
    {
        return response()->json($equipment);
    }
    
    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }
    
    public function update(Request $request, Equipment $equipment)
    {
        $equipment->update($request->all());
        return redirect()->route('equipments.index')->with('success', 'Equipamento atualizado com sucesso!');
    }
    
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.index')->with('success', 'Equipamento excluído com sucesso!');
    }

    public function reports()
    {
        $categories = Equipment::select('type')->distinct()->get();
        $status = Equipment::select('status')->distinct()->get();
        //$equipments = Equipment::all();

        $equipments = Equipment::with([
            'homologationEquipments' => function ($query) {
                $query->latest('homologation_date')->with('homologation', 'user'); // Relação com Homologation e User
            }
        ])->get();

        //dd($equipments);
        return view('reports.index', compact('equipments', 'categories', 'status'));
    }

    public function equipamentosfiltrados(Request $request)
    {
       // Inicializa a query
        $query = Equipment::with(['homologationEquipments' => function ($q) {
            $q->latest('homologation_date')->with('homologation', 'user');
        }]);

        // Filtros
        if ($request->filled('category')) {
            $query->where('type', $request->category);
        }

        if ($request->filled('status')) {
            if ($request->status !== 'Todos') {
                $query->where('status', $request->status);
            }
        }


        if ($request->filled('homologation')) {
            $query->whereHas('homologationEquipments.homologation', function ($q) use ($request) {
                $q->where('homologation_name', 'LIKE', '%' . $request->homologation . '%');
            });
        }
        $equipments = $query->get();


        $categories = Equipment::select('type')->distinct()->get();
        $status = Equipment::select('status')->distinct()->get();

       // Retorna a view com os dados
        return view('reports.index', [
            'equipments' => $equipments,
            'categories' => $categories,
            'status'=> $status
        ]);
    }


    public function exportPdf(Request $request)
    {
         // Query com os filtros aplicados
    $query = Equipment::with(['homologationEquipments' => function ($q) {
        $q->latest('homologation_date')->with('homologation', 'user');
    }]);

    if ($request->filled('category')) {
        $query->where('type', $request->category);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('homologation')) {
        $query->whereHas('homologationEquipments.homologation', function ($q) use ($request) {
            $q->where('homologation_name', 'LIKE', '%' . $request->homologation . '%');
        });
    }

    $equipments = $query->get();

    // Gerar PDF
    $pdf = PDF::loadView('reports.pdf', compact('equipments'))->setPaper('a4', 'landscape');


    // Baixar ou visualizar
    return $pdf->download('relatorio-inventario.pdf');
    }
    
}
