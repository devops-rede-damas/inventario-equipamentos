@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1 class="mb-4">Relatório de Inventário de Equipamentos</h1>

    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif

    <div class="container mt-4">

        <form method="GET" action="{{ route('report.inventory') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="category" class="form-label">Categoria</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Todas</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['type'] }}"
                                {{ request('category') == $category['type'] ? 'selected' : '' }}>{{ $category['type'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        @foreach ($status as $statu)
                            <option value="{{ $statu['status'] }}"
                                {{ request('statu') == $statu['status'] ? 'selected' : '' }}>{{ $statu['status'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date" class="form-label">Homologação</label>
                    <input type="text" name="homologation" id="homologation" class="form-control"
                        value="{{ request('homologation') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger" onclick="imprimirPdf();">Imprimir PDF</button>
                </div>
            </div>
        </form>


        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Service TAG</th>
                        <th>Setor</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th>Homologação</th>
                        <th>Feito por</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($equipments as $equipment)
                        <tr>
                            <td>{{ $equipment->cod_equipment }}</td>
                            <td>{{ $equipment->location }}</td>
                            <td>{{ $equipment->type }}</td>
                            <td>{{ $equipment->status }}</td>
                            <td>{{ optional(optional($equipment->homologationEquipments->first())->homologation)->homologation_name ?? 'N/A' }}
                            </td>
                            <td>{{ optional(optional($equipment->homologationEquipments->first())->user)->name ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum equipamento encontrado</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    function imprimirPdf() {
        const category = document.getElementById('category').value;
        const status = document.getElementById('status').value;
        const homologation = document.getElementById('homologation').value;

        const params = new URLSearchParams({
            category: category,
            status: status,
            homologation: homologation
        });

        fetch('{{ route('report.inventory.pdf') }}?' + params.toString(), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'report.pdf';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(error => console.error('Error:', error));

    }
</script>
