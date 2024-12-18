@extends('layouts.app')

@section('title', 'Lista de Homologações')

@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h1>Homologações</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createHomologationModal">
            Nova Homologação
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
                <th>#</th>
                <th>Nome</th>
                <th>Data inicial</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($homologations as $homologation)
                <tr onclick="window.location='{{ route('homologations.show', $homologation->id) }}'" style="cursor: pointer;">
                    <td>{{ $homologation->id }}</td>
                    <td>{{ $homologation->homologation_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($homologation->homologation_date_initial)->format('d/m/Y') }}</td>
                    <td>{{ $homologation->homologation_status }}</td>
                    {{-- <td>
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
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

<!-- Modal Criar-->
<div class="modal fade" id="createHomologationModal" tabindex="-1" aria-labelledby="createHomologationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createHomologationModalLabel">Nova Homologação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('homologations.store') }}" method="POST">

               
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="homologation_name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="homologation_name" name="homologation_name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Data Inicial</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="instruction" class="form-label">Instruções</label>
                        <textarea class="form-control" id="instruction" name="instruction" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="equipments" class="form-label">Equipamentos Elegíveis</label>
                       
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="select_all" onclick="toggleAll(this)">
                        <label class="form-check-label" for="select_all">
                            Selecionar Todos os Equipamentos
                        </label>
                    </div>
                    @foreach ($equipmentsByLocation as $location => $equipments)
                        <div class="mb-3">
                            <h5>{{ $location }}</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="select_all_{{ $location }}" onclick="toggleLocation('{{ $location }}', this)">
                                <label class="form-check-label" for="select_all_{{ $location }}">
                                    Selecionar Todos do Setor
                                </label>
                            </div>
                            @foreach ($equipments as $equipment)
                                <div class="form-check">
                                    <input class="form-check-input equipment-checkbox {{ $location }}" type="checkbox" id="equipment_{{ $equipment->id }}" name="equipments[]" value="{{ $equipment->id }}">
                                    <label class="form-check-label" for="equipment_{{ $equipment->id }}">
                                        {{ $equipment->cod_equipment }} - {{ $equipment->type }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <script>
                        function toggleAll(source) {
                            const checkboxes = document.querySelectorAll('.equipment-checkbox');
                            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
                        }

                        function toggleLocation(location, source) {
                            const checkboxes = document.querySelectorAll(`.${location}`);
                            checkboxes.forEach(checkbox => checkbox.checked = source.checked);
                        }
                    </script>
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
<div class="modal fade" id="equipmentModal" tabindex="-1" aria-labelledby="equipmentModalLabel" aria-hidden="true">
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
                <h5 class="modal-title" id="createHomologationModalLabel">Editar Equipamento</h5>
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
                            <option value="SST">SST</option>
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
                            <option value="Homologado">Homologado</option>
                            <option value="Para Homologar">Para Homologar</option>
                            <option value="Disponível">Disponível</option>
                        </select>
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
                document.getElementById('equipmentDescription').textContent = data.description;
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

                const form = document.getElementById('editEquipmentForm');
                form.action = `{{ route('equipments.update', '') }}/${id}`;
            })
            .catch(error => {
                console.error('Erro ao carregar os detalhes do equipamento:', error);
            });
    }
</script>
