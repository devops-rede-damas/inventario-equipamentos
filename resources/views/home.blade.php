@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Formulário') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <br>
                        <div class="content">
                            <div class="container-fluid" style="max-width: 100%;">
                                <!-- Small boxes (Stat box) -->
                                {{-- <form method="POST" action="{{ route('form.submit') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nNotaFiscal">N° da Nota Fiscal</label>
                                                <input type="text" class="form-control" id="nNotaFiscal"
                                                    name="nNotaFiscal" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nPedidoCompra">N° do Pedido de Compra</label>
                                                <input type="text" class="form-control" id="nPedidoCompra"
                                                    name="nPedidoCompra" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="valorTotalNF">Valor Total da Nota Fiscal</label>
                                                <input type="text" class="form-control" id="valorTotalNF"
                                                    name="valorTotalNF" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="vencimento">Vencimento</label>
                                                <input type="text" class="form-control" id="vencimento"
                                                    name="vencimento" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="codFilial">Filial</label>
                                                <select class="form-control" id="codFilial" name="codFilial" required>
                                                    <option value="">Selecione a Filial</option>
                                                    <option value="10.847.762/0002-62">Santa Sofia </option>
                                                    <option value="10.847.762/0003-43">Santa Cristina</option>
                                                    <option value="10.847.762/0004-24">Colégio Nossa Senhora da Graça
                                                    </option>
                                                    <option value="10.847.762/0006-96">Colégio Imaculada</option>
                                                    <option value="10.847.762/0007-77">Santa Cecília - Fortaleza</option>
                                                    <option value="10.847.762/0009-39">São Francisco</option>
                                                    <option value="10.847.762/0010-72">Madalena Sofia</option>
                                                    <option value="10.847.762/0012-34">Regina Mundi</option>
                                                    <option value="10.847.762/0013-15">Colégio Damas</option>
                                                    <option value="10.847.762/0015-87">Colégio Regina Pacis</option>
                                                    <option value="10.847.762/0016-68">Faculdade Damas</option>
                                                    <option value="10.847.762/0017-49">Regina Coeli</option>
                                                    <option value="10.847.762/0021-25">Escola Nossa Senhora das Graças
                                                    </option>
                                                    <option value="10.847.762/0023-97">Colégio Santa Magano</option>
                                                    <option value="10.847.762/0024-78">Colégio Santa Cecília - Eusébio
                                                    </option>
                                                    <option value="10.847.762/0023-97">Colégio Santa Sofia - Magano</option>
                                                    <option value="10.847.762/0024-78">Colégio Santa Cecília - Eusébio
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="codColigada">Código da Coligada</label>
                                                <input type="text" class="form-control" id="codColigada"
                                                    name="codColigada" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="finalidade">Finalidade</label>
                                                <select class="form-control" id="finalidade" name="finalidade" required>
                                                    <option value="">Selecione a Finalidade</option>
                                                    <option value="1.2.02">ENTRADA DE NF - NÃO AFETA ESTOQUE / SIMPLES FATURAMENTO</option>
                                                    <option value="1.2.04">NF IMOBILIZADO</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="nMovimento">N° do Movimento</label>
                                                <input type="text" class="form-control" id="nMovimento"
                                                    name="nMovimento" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="formPagamento">Forma de Pagamento</label>
                                                <input type="text" class="form-control" id="formPagamento"
                                                    name="formPagamento" required>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label for="RPA">RPA</label>
                                                <input type="text" class="form-control" id="RPA" name="RPA" required>
                                            </div> --}}
                                           {{-- <div class="form-group">
                                                <label for="codTMV">Código TMV</label>
                                                <input type="text" class="form-control" id="codTMV" name="codTMV" required>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form> --}}

                                <br>

                                <div class="form-group">
                                    <label for="searchPedidoCompra">Pesquisar por N° do Pedido de Compra</label>
                                    <input type="text" class="form-control" id="searchPedidoCompra"
                                        placeholder="Digite o N° do Pedido de Compra">
                                </div>

                                <br>
                                <div class="table-responsive">
                                    {{-- <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N° da Nota Fiscal</th>
                                                <th>N° do Pedido de Compra</th>
                                                <th>Valor Total da Nota Fiscal</th>
                                                <th>Vencimento</th>
                                                <th>Código da Filial</th>
                                                <th>Código da Coligada</th>
                                                <th>Finalidade</th>
                                                <th>N° do Movimento</th>
                                                <th>Forma de Pagamento</th>
                                                <th>Código TMV</th>
                                                @if (Auth::user()->name == 'Admin')
                                                <th>RPA</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($requisicoes as $requisicao)
                                                <tr>
                                                    <td>{{ $requisicao->nNotaFiscal }}</td>
                                                    <td>{{ $requisicao->nPedidoCompra }}</td>
                                                    <td>{{ $requisicao->valorTotalNF }}</td>
                                                    <td>{{ $requisicao->vencimento }}</td>
                                                    <td>
                                                        @switch($requisicao->codFilial)
                                                            @case('10.847.762/0002-62')
                                                                Santa Sofia
                                                                @break
                                                            @case('10.847.762/0003-43')
                                                                Santa Cristina
                                                                @break
                                                            @case('10.847.762/0004-24')
                                                                Colégio Nossa Senhora da Graça
                                                                @break
                                                            @case('10.847.762/0006-96')
                                                                Colégio Imaculada
                                                                @break
                                                            @case('10.847.762/0007-77')
                                                                Santa Cecília - Fortaleza
                                                                @break
                                                            @case('10.847.762/0009-39')
                                                                São Francisco
                                                                @break
                                                            @case('10.847.762/0010-72')
                                                                Madalena Sofia
                                                                @break
                                                            @case('10.847.762/0012-34')
                                                                Regina Mundi
                                                                @break
                                                            @case('10.847.762/0013-15')
                                                                Colégio Damas
                                                                @break
                                                            @case('10.847.762/0015-87')
                                                                Colégio Regina Pacis
                                                                @break
                                                            @case('10.847.762/0016-68')
                                                                Faculdade Damas
                                                                @break
                                                            @case('10.847.762/0017-49')
                                                                Regina Coeli
                                                                @break
                                                            @case('10.847.762/0021-25')
                                                                Escola Nossa Senhora das Graças
                                                                @break
                                                            @case('10.847.762/0023-97')
                                                                Colégio Santa Magano
                                                                @break
                                                            @case('10.847.762/0024-78')
                                                                Colégio Santa Cecília - Eusébio
                                                                @break
                                                            @default
                                                                Desconhecido
                                                        @endswitch
                                                    </td>
                                                    <td>{{ $requisicao->codColigada }}</td>
                                                    <td>
                                                        @switch($requisicao->finalidade)
                                                            @case('1.2.02')
                                                                ENTRADA DE NF - NÃO AFETA ESTOQUE / SIMPLES FATURAMENTO
                                                                @break
                                                            @case('1.2.04')
                                                                NF IMOBILIZADO
                                                                @break
                                                            @default
                                                                Desconhecido
                                                        @endswitch
                                                    </td>
                                                    <td>{{ $requisicao->nMovimento }}</td>
                                                    <td>{{ $requisicao->formPagamento }}</td>
                                                    <td>{{ $requisicao->codTMV }}</td>
                                                    @if (Auth::user()->name == 'Admin')
                                                    <td>{{ $requisicao->RPA }}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var phoneInput = document.getElementById('fone');
        phoneInput.addEventListener('input', function(e) {
            var x = e.target.value.replace(/\D/g, '');
            x = x.match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchPedidoCompra');
        searchInput.addEventListener('input', function() {
            var filter = searchInput.value.toUpperCase();
            var table = document.querySelector('.table');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    });
</script>
