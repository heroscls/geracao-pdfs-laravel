<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Treino - {{ $ficha->aluno->nome }}</title>
    <style>
        @page { margin: 30px 35px 50px 35px; }

        /* DejaVu Sans vem com o DomPDF e suporta acentos (á, ç, ã...) */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }

        .header { background: #111827; color: #fff; padding: 14px 18px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p  { margin: 4px 0 0; font-size: 11px; color: #d1d5db; }

        .info { width: 100%; margin: 14px 0; border-collapse: collapse; }
        .info td { padding: 6px 8px; border: 1px solid #e5e7eb; }
        .info .label { background: #f3f4f6; font-weight: bold; width: 18%; }

        h2 { background: #2563eb; color: #fff; padding: 6px 10px; margin: 18px 0 0; font-size: 13px; }

        table.treino { width: 100%; border-collapse: collapse; }
        table.treino th { background: #e5e7eb; padding: 6px; border: 1px solid #d1d5db; text-align: left; }
        table.treino td { padding: 6px; border: 1px solid #d1d5db; }
        table.treino tr:nth-child(even) td { background: #f9fafb; }
        .center { text-align: center; }

        .obs { margin-top: 18px; padding: 10px; border: 1px dashed #9ca3af; background: #fffbeb; }

        /* Cada dia de treino começa em uma nova página (exceto o primeiro) */
        .dia + .dia { page-break-before: always; }
    </style>
</head>
<body>

    {{-- Rodapé com numeração de páginas --}}
    <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->get_font("DejaVu Sans", "normal");
            $pdf->page_text(490, 805, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 8, [0.4, 0.4, 0.4]);
        }
    </script>

    <div class="header">
        <h1>FICHA DE TREINO</h1>
        <p>{{ $ficha->nome }}</p>
    </div>

    <table class="info">
        <tr>
            <td class="label">Aluno</td>
            <td>{{ $ficha->aluno->nome }}</td>
            <td class="label">Objetivo</td>
            <td>{{ $ficha->aluno->objetivo ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Instrutor</td>
            <td>{{ $ficha->instrutor }}</td>
            <td class="label">Idade</td>
            <td>{{ $ficha->aluno->data_nascimento->age }} anos</td>
        </tr>
        <tr>
            <td class="label">Início</td>
            <td>{{ $ficha->data_inicio->format('d/m/Y') }}</td>
            <td class="label">Término</td>
            <td>{{ $ficha->data_fim?->format('d/m/Y') ?? '-' }}</td>
        </tr>
    </table>

    {{-- Um bloco por dia de treino --}}
    @foreach ($itensPorDia as $dia => $itens)
        <div class="dia">
            <h2>Treino {{ $dia }} — {{ $itens->pluck('exercicio.grupo_muscular')->unique()->implode(' / ') }}</h2>

            <table class="treino">
                <thead>
                    <tr>
                        <th style="width:5%">#</th>
                        <th>Exercício</th>
                        <th class="center" style="width:10%">Séries</th>
                        <th class="center" style="width:12%">Reps</th>
                        <th class="center" style="width:12%">Carga</th>
                        <th class="center" style="width:13%">Descanso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itens as $item)
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td>{{ $item->exercicio->nome }}</td>
                            <td class="center">{{ $item->series }}</td>
                            <td class="center">{{ $item->repeticoes }}</td>
                            <td class="center">{{ $item->carga ?? '-' }}</td>
                            <td class="center">{{ $item->descanso_segundos }}s</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

    @if ($ficha->observacoes)
        <div class="obs">
            <strong>Observações:</strong><br>
            {{ $ficha->observacoes }}
        </div>
    @endif

</body>
</html>