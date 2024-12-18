@extends('layouts.app')

@section('title', 'Lista de Equipamentos')

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>Equipamentos</h1>
        {{-- <a href="{{ route('equipments.create') }}" class="btn btn-primary">Adicionar Equipamento</a> --}}
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createEquipmentModal">
            Adicionar
        </button>
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


    <table class="table table-striped">
        <thead>
            <tr>
                <th>TAG</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipments as $equipment)
                <tr>
                    <td>{{ $equipment->cod_equipment }}</td>
                    <td>{{ $equipment->status }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#equipmentModal"
                            onclick="showEquipment({{ $equipment->id }})"><i class="fa fa-eye" aria-hidden="true"
                                style="font-size:24px"></i></a>
                        <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#equipmentEditModal"
                            onclick="editEquipment({{ $equipment->id }})"><i class="fa fa-pencil" aria-hidden="true"
                                style="font-size:24px"></i></a>
                        <form action="{{ route('equipments.destroy', $equipment->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Tem certeza que deseja excluir este equipamento?')">
                                <i class="fa fa-trash" aria-hidden="true" style="font-size:24px"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

<!-- Modal Criar-->
<div class="modal fade" id="createEquipmentModal" tabindex="-1" aria-labelledby="createEquipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEquipmentModalLabel">Adicionar Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('equipments.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" disabled selected>Selecione o tipo</option>
                            <option value="Notebook">Notebook</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Smartphone">Smartphone</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">TAG</label>
                        <input type="text" class="form-control" id="cod_equipment" name="cod_equipment"
                            placeholder="Ex.:NT-012345" required>
                    </div>
                    <div class="mb-3">
                        <label for="setor" class="form-label">Setor</label>
                        <select class="form-select" id="location" name="location" required>
                            <option value="" disabled selected>Selecione o setor</option>
                            <option value="DEPOSITO">DEPOSITO</option>
                            <option value="SDT">SDT</option>
                            <option value="RECEPÇÃO">RECEPÇÃO</option>
                            <option value="ENGENHARIA">ENGENHARIA</option>
                            <option value="RELACIONAMENTO">RELACIONAMENTO</option>
                            <option value="MARKETING">MARKETING</option>
                            <option value="RH">RH</option>
                            <option value="DP">DP</option>
                            <option value="COMPRAS">COMPRAS</option>
                            <option value="PROJETO_OU">PROJETO_OU</option>
                            <option value="JURIDICO">JURIDICO</option>
                            <option value="ACDMAV">ACDMAV</option>
                            <option value="FISCAL">FISCAL</option>
                            <option value="CONTABIL">CONTABIL</option>
                            <option value="FINANCEIRO">FINANCEIRO</option>
                            <option value="CONTROLADORIA">CONTROLADORIA</option>
                            <option value="GERENCIA">GERENCIA</option>
                            <option value="ACDMAV MATRIZ">ACDMAV MATRIZ</option>
                            <option value="SOCIAL">SOCIAL</option>
                            <option value="TI">TI</option>
                            <option value="EDUCACIONAL">EDUCACIONAL</option>
                            <option value="AUDITORIO">AUDITORIO</option>
                            <option value="LINUX/ARISTIDES">LINUX/ARISTIDES</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="" disabled selected>Selecione o status atual</option>
                            <option value="Em Uso">Em Uso</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Disponível">Disponível</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="description" name="description" rows="3"
                            placeholder="Detalhes do equipamento, pendências, etc..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="partnumber" class="form-label">Part Number (perfiféricos)</label>
                        <textarea class="form-control" id="partnumber" name="partnumber" rows="1"
                            placeholder="numero do part number"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <textarea class="form-control" id="answerable" name="answerable" rows="1"
                            placeholder="Nome e matrícula do responsável"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="locado" class="form-label">É locado?</label>
                        <select class="form-select" id="locado" name="locado" required>
                            <option value="0" selected>Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="antivirus" class="form-label">Antivírus</label>
                        <select class="form-select" id="antivirus" name="antivirus" required>
                            <option value="0" selected>Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Visualizar-->
<div class="modal fade" id="equipmentModal" tabindex="-1" aria-labelledby="equipmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="equipmentModalLabel">Detalhes do Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>TAG:</strong> <span id="equipmentName"></span></p>
                <p><strong>Tipo:</strong> <span id="equipmentType"></span></p>
                <p><strong>Descrição:</strong> <span id="equipmentDescription"></span></p>
                <p><strong>Localização:</strong> <span id="equipmentLocation"></span></p>
                <p><strong>Status:</strong> <span id="equipmentStatus"></span></p>
                <p><strong>Antivírus:</strong> <span id="equipmentAntivirus"></span></p>
                <p><strong>Responsável:</strong> <span id="equipmentAnswerable"></span></p>
                <p><strong>Part Number:</strong> <span id="equipmentPartNumber"></span></p>
                <p><strong>Locado:</strong> <span id="equipmentLocado"></span></p>
                <p><strong>Última Atualização:</strong> <span id="equipmentUltimaData"></span></p>
            </div>
        </div>
    </div>
</div>


<!-- Modal Editar-->
<div class="modal fade" id="equipmentEditModal" tabindex="-1" aria-labelledby="equipmentEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEquipmentModalLabel">Editar Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEquipmentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="Etype" name="type" required>
                            <option value="" disabled selected>Selecione o tipo</option>
                            <option value="Notebook">Notebook</option>
                            <option value="Desktop">Desktop</option>
                            <option value="Smartphone">Smartphone</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">TAG</label>
                        <input type="text" class="form-control" id="Ecod_equipment" name="cod_equipment"
                            placeholder="Ex.:NT-012345" required>
                    </div>
                    <div class="mb-3">
                        <label for="setor" class="form-label">Setor</label>
                        <select class="form-select" id="Elocation" name="location" required>
                            <option value="" disabled selected>Selecione o setor</option>
                            <option value="DEPOSITO">DEPOSITO</option>
                            <option value="SDT">SDT</option>
                            <option value="RECEPÇÃO">RECEPÇÃO</option>
                            <option value="ENGENHARIA">ENGENHARIA</option>
                            <option value="RELACIONAMENTO">RELACIONAMENTO</option>
                            <option value="MARKETING">MARKETING</option>
                            <option value="RH">RH</option>
                            <option value="DP">DP</option>
                            <option value="COMPRAS">COMPRAS</option>
                            <option value="PROJETO_OU">PROJETO_OU</option>
                            <option value="JURIDICO">JURIDICO</option>
                            <option value="ACDMAV">ACDMAV</option>
                            <option value="FISCAL">FISCAL</option>
                            <option value="CONTABIL">CONTABIL</option>
                            <option value="FINANCEIRO">FINANCEIRO</option>
                            <option value="CONTROLADORIA">CONTROLADORIA</option>
                            <option value="GERENCIA">GERENCIA</option>
                            <option value="ACDMAV MATRIZ">ACDMAV MATRIZ</option>
                            <option value="SOCIAL">SOCIAL</option>
                            <option value="TI">TI</option>
                            <option value="EDUCACIONAL">EDUCACIONAL</option>
                            <option value="AUDITORIO">AUDITORIO</option>
                            <option value="LINUX/ARISTIDES">LINUX/ARISTIDES</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="Estatus" name="status" required>
                            <option value="" disabled selected>Selecione o status atual</option>
                            <option value="Em Uso">Em Uso</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Disponível">Disponível</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="partnumber" class="form-label">Part Number (perfiféricos)</label>
                        <textarea class="form-control" id="Epartnumber" name="partnumber" rows="1"
                            placeholder="numero do part number"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="Edescription" name="description" rows="3"
                            placeholder="Detalhes do equipamento, pendências, etc..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <textarea class="form-control" id="Eanswerable" name="answerable" rows="1"
                            placeholder="Nome e matrícula do responsável"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="antivirus" class="form-label">É locado?</label>
                        <select class="form-select" id="Elocado" name="locado" required>
                            <option value="0" selected>Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="antivirus" class="form-label">Antivírus</label>
                        <select class="form-select" id="Eantivirus" name="antivirus" required>
                            <option value="0" selected>Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log('App Loaded');
    });

    function showEquipment(id) {
        fetch(`/equipments/${id}`)
            .then(response => response.json())
            .then(data => {
                // Preencher os dados no modal
                document.getElementById('equipmentName').textContent = data.cod_equipment;
                document.getElementById('equipmentType').textContent = data.type;
                document.getElementById('equipmentLocation').textContent = data.location;
                document.getElementById('equipmentStatus').textContent = data.status;
                document.getElementById('equipmentAntivirus').textContent = data.antivirus ? 'Sim' : 'Não';
                document.getElementById('equipmentAnswerable').textContent = data.answerable;
                document.getElementById('equipmentUltimaData').textContent = new Date(data.updated_at)
                    .toLocaleDateString('pt-BR');
                document.getElementById('equipmentPartNumber').textContent = data.partnumber;
                document.getElementById('equipmentLocado').textContent = data.locado == 1 ? 'Sim' : 'Não';
            })
            .catch(error => {
                console.error('Erro ao carregar os detalhes do equipamento:', error);
            });
    }

    function editEquipment(id) {
        fetch(`/equipments/${id}`)
            .then(response => response.json())
            .then(data => {
                // Preencher os dados no modal
                document.getElementById('Etype').value = data.type;
                document.getElementById('Ecod_equipment').value = data.cod_equipment;
                document.getElementById('Elocation').value = data.location;
                document.getElementById('Estatus').value = data.status;
                document.getElementById('Edescription').value = data.description;
                document.getElementById('Eanswerable').value = data.answerable;
                document.getElementById('Eantivirus').value = data.antivirus;
                document.getElementById('Epartnumber').value = data.partnumber;
                document.getElementById('Elocado').value = data.locado;

                const form = document.getElementById('editEquipmentForm');
                form.action = `{{ route('equipments.update', '') }}/${id}`;
            })
            .catch(error => {
                console.error('Erro ao carregar os detalhes do equipamento:', error);
            });
    }
</script>
