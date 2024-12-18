<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    protected $fillable = [
        'nNotaFiscal',
        'nPedidoCompra',
        'valorTotalNF',
        'vencimento',
        'codFilial',
        'codColigada',
        'finalidade',
        'nMovimento',
        'formPagamento',
        'RPA',
        'codTMV',
    ];
}
