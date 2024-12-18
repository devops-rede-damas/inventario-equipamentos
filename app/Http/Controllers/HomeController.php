<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Form;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$forms = Form::orderBy('created_at', 'desc')->get();
        //dd($forms);
        //return view('home', ['requisicoes' => $forms]);
        return view('home');
    }

     /**
     * Submit the form to application.
     *
     * @return success message if form submitted successfully
     */
    public function formSubmit(Request $request)
    {
        $request->validate([
            'nNotaFiscal' => 'required',
            'nPedidoCompra' => 'required',
            'valorTotalNF' => 'required',
            'vencimento' => 'required',
            'codFilial' => 'required',
            'codColigada' => 'required',
            'finalidade' => 'required',
            'nMovimento' => 'required',
            'formPagamento' => 'required',
            'codTMV' => 'required',
        ]);

        $existingForm = Form::where('nPedidoCompra', $request->nPedidoCompra)->first();
        if ($existingForm) {
            return redirect()->back()->with('error', 'O número do pedido de compra já existe.');
        }

        $form = new Form();
        $form->user_id = auth()->user()->id;
        $form->nNotaFiscal = $request->nNotaFiscal;
        $form->nPedidoCompra = $request->nPedidoCompra;
        $form->valorTotalNF = $request->valorTotalNF;
        $form->vencimento = $request->vencimento;
        $form->codFilial = $request->input('codFilial');
        $form->codColigada = $request->codColigada;
        $form->finalidade = $request->input('finalidade');
        $form->nMovimento = $request->nMovimento;
        $form->formPagamento = $request->formPagamento;
        $form->RPA = "NÃO";
        $form->codTMV = $request->codTMV;
        $form->created_at = now();
        $form->save();

        return redirect()->back()->with('success', 'Enviado com sucesso!');
    }
}
