<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Inventário</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }

        /* Linhas intercaladas */
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:nth-child(odd) { background-color: #ffffff; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Relatório de Inventário de Equipamentos</h2>
    <p style="text-align: center;">Data e Hora Atual: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>TAG</th>
                <th>Setor</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Homologação</th>
                <th>Resultado</th>
                <th>Observação</th>
                <th>Feito por</th>
                <th>Quando</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($equipments as $equipment)
                <tr>
                    <td>{{ $equipment->cod_equipment }}</td>
                    <td>{{ $equipment->location }}</td>
                    <td>{{ $equipment->type }}</td>
                    <td>{{ $equipment->status }}</td>
                    <td>
                        @if ($equipment->homologationEquipments->isNotEmpty())
                            {{ $equipment->homologationEquipments->first()->homologation->homologation_name ?? ' ' }}
                        @else
                             
                        @endif
                    </td>
                    <td>
                        @if ($equipment->homologationEquipments->isNotEmpty())
                            {{ $equipment->homologationEquipments->first()->homologation->status ?? ' ' }}
                        @else
                             
                        @endif
                    </td>
                    <td>
                        @if ($equipment->homologationEquipments->isNotEmpty())
                            {{ $equipment->homologationEquipments->first()->observations ?? ' ' }}
                        @else
                             
                        @endif
                    </td>
                    <td>
                        @if ($equipment->homologationEquipments->isNotEmpty())
                            {{ $equipment->homologationEquipments->first()->user->name ?? ' ' }}
                        @else
                             
                        @endif
                    </td>
                    <td>
                        @if ($equipment->homologationEquipments->isNotEmpty())
                            {{ $equipment->homologationEquipments->first()->updated_at->format('d/m/Y H:i:s') }}
                        @else
                             
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
