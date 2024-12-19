@extends('layouts.app')

@section('title', '{{ $homologation->homologation_name }}')

<style>
    #reader-container {
        position: relative;
        width: 300px;
        height: 300px;
        border: 2px solid #333;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #output {
        margin-top: 20px;
        font-size: 1.2rem;
        color: #555;
    }

    video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

@section('content')
    {{-- <div class="d-flex justify-content-between mb-4">
        <h1>{{ $homologation->homologation_name }}</h1>
    </div> --}}

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

    <div class="text-center mb-4">
        <h1 class="h3 text-primary fw-bold">{{ $homologation->homologation_name }}</h1>
        <p class="text-success fw-semibold fs-5">{{ $homologation->homologation_status }}</p>
        <p class="text-muted">{{ $homologation->instruction }}</p>
    </div>

    <!-- Barra de busca -->
    <div class="row mb-4">
        <div class="col-md-11">
            <input type="text" class="form-control" placeholder="Digite o service tag do equipamento" id="search"
                onkeyup="search()" />
        </div>

        <div class="col-md-1">
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#equipmentModal">
                <img src="{{ asset('qrcode.png') }}" alt="QR Code" class="rounded" style="width: 30px; height: 30px;" />
            </button>
        </div>
    </div>

    <!-- Cards -->
    <div class="row" id="equipment-cards">
        @foreach ($homologationEquipments as $item)
            {{-- {{$item}} --}}
            <div class="col-md-12 mb-3">
                <div class="card border-{{ $item['status'] == 'reprovado' ? 'danger' : ($item['status'] == 'aprovado' ? 'success' : $item['status_color']) }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <!-- Informações -->
                        <div class="d-flex align-items-center" name="card">
                            <img @if ($item->equipment->type == 'Notebook') src="{{ asset('laptop.png') }}"
                                @elseif ($item->equipment->type == 'Desktop')
                                    src="{{ asset('desktop.png') }}"
                                @elseif ($item->equipment->type == 'Smartphone')
                                    src="{{ asset('fone.png') }}"
                                @else
                                    src="{{ asset('default.png') }}" @endif
                                alt="Ícone" class="me-3 rounded" style="width: 50px; height: 50px;" />
                            <div>
                                <p class="mb-1 fw-bold">{{ $item->equipment->cod_equipment }}</p>
                                <p class="text-muted mb-0">{{ $item['status'] }}</p>

                                @if ($item['status'] == 'A iniciar')
                                    <button class="btn btn-warning btn-sm"
                                        onclick="window.location.href='{{ route('homologations.absent', $item->id) }}'">
                                        Marcar como ausente
                                    </button>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<!-- Modal -->
<div class="modal" id="equipmentModal" tabindex="-1" aria-labelledby="equipmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="equipmentModalLabel">Ler QR CODE do Equipamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="you-qr-result"></div>
                <h4>Ler QR Code</h4>
                <div style="display: flex; justify-content: center;">
                    <div id="my-qr-reader" style="width:500px;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal HTML -->
<div id="qrCodeModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="qrCodeForm">
                    <div class="form-group">
                        <label for="equipmentName">TAG</label>
                        <input type="text" class="form-control" id="equipmentName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status">
                            <option value="aprovado">Aprovado</option>
                            <option value="reprovado">Reprovado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Mover para status</label>
                        <select class="form-select" id="status_equip" name="status_equip" required>
                            <option value="Manter" selected>Manter atual</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Disponível">Disponível</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="observation">Observação</label>
                        <textarea class="form-control" id="observation" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('html5-qrcode.min.js') }}"></script>
<script>
    function search() {
        var input, filter, cards, cardContainer, title, i;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        cardContainer = document.getElementById("equipment-cards");
        cards = cardContainer.getElementsByClassName("col-md-12");
        for (i = 0; i < cards.length; i++) {
            title = cards[i].querySelector(".fw-bold");
            if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }

    function domReady(fn) {
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(fn, 1);
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    domReady(function() {
        var myqr = document.getElementById('my-qr-reader');
        var lastResult, countResults = 0;

        function onScanSuccess(decodeText, decodeResult) {
            if (decodeText != lastResult) {
                ++countResults;
                lastResult = decodeText;

                document.getElementById('equipmentName').value = decodeText;
                const modal = bootstrap.Modal.getInstance(document.getElementById('equipmentModal'));
                modal.hide();
                $('#qrCodeModal').modal('show');
                // alert("You qr is : " + decodeText, decodeResult);
                // myqr.innerHTML = `<b>${countResults}</b> - ${decodeText}`;
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "my-qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);
    });

    document.getElementById('qrCodeForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var equipmentName = document.getElementById('equipmentName').value;
        var status = document.getElementById('status').value;
        var observation = document.getElementById('observation').value;
        var homologationId = '{{ $homologation->id }}';
        var status_equip = document.getElementById('status_equip').value;

        $.ajax({
            url: "{{ route('read-qrcode') }}",
            type: 'POST',
            data: {
                equipmentName: equipmentName,
                status: status,
                observation: observation,
                homologationId: homologationId,
                status_equip: status_equip,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.error) {
                    alert(response.message);
                    return;
                } else{
                    alert('Formulário enviado com sucesso!');
                    window.location.href = '{{ route('homologations.show', $homologation->id) }}';
                }
            },
            error: function(xhr, status, error) {
                // alert(xhr);
                // alert(status);
                // alert(error);
                alert('Ocorreu um erro ao enviar o formulário.');
            }
        });
        $('#qrCodeModal').modal('hide');
    });
</script>
