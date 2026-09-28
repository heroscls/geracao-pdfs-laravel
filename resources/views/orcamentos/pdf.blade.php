<!DOCTYPE html>
<html lang="pt-BR">
<head>
    {{-- UTF-8 é obrigatório para acentos saírem corretos no PDF --}}
    <meta charset="UTF-8">
    <title>Orçamento #{{ $orcamento->id }}</title>

    <style>
        /* Define a página como A4 com margem de 1,5 cm */
        @page { size: A4 portrait; margin: 1.5cm; }

        /* DejaVu Sans é a fonte embutida que suporta acentos no DomPDF */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #222; }

        h1 { font-size: 22px; margin: 0; color: #1e3a8a; }
        .cabecalho { border-bottom: 3px solid #1e3a8a; padding-bottom: 10px; margin-bottom: 20px; }
        .info p { margin: 3px 0; }

        /* ATENÇÃO: DomPDF NÃO entende flexbox nem grid. Use tabelas! */
        table.itens { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.itens th { background: #1e3a8a; color: #fff; padding: 8px; text-align: left; }
        table.itens td { border-bottom: 1px solid #ddd; padding: 8px; }
        .direita { text-align: right; }

        .total { margin-top: 15px; text-align: right; font-size: 16px; font-weight: bold; }
        .obs { margin-top: 30px; padding: 10px; background: #f3f4f6; }
        .rodape { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>

    <div class="cabecalho">
        <h1>ORÇAMENTO Nº {{ str_pad($orcamento->id, 4, '0', STR_PAD_LEFT) }}</h1>
    </div>

    {{-- Dados dinâmicos vindos do banco --}}
    <div class="info">
        <p><strong>Cliente:</strong> {{ $orcamento->cliente_nome }}</p>
        <p><strong>E-mail:</strong> {{ $orcamento->cliente_email }}</p>
        <p><strong>Válido até:</strong> {{ $orcamento->validade->format('d/m/Y') }}</p>
    </div>

    <table class="itens">
        <thead>
            <tr>
                <th>Descrição</th>
                <th class="direita">Qtd</th>
                <th class="direita">Valor Unit.</th>
                <th class="direita">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            {{-- Um loop cria uma linha para cada item do orçamento --}}
            @foreach ($orcamento->itens as $item)
                <tr>
                    <td>{{ $item->descricao }}</td>
                    <td class="direita">{{ $item->quantidade }}</td>
                    {{-- number_format(valor, casas, sep. decimal, sep. milhar) = formato brasileiro --}}
                    <td class="direita">R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                    <td class="direita">R$ {{ number_format($item->quantidade * $item->valor_unitario, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- $orcamento->total usa o accessor que criamos no Model --}}
    <div class="total">TOTAL: R$ {{ number_format($orcamento->total, 2, ',', '.') }}</div>

    @if ($orcamento->observacoes)
        <div class="obs"><strong>Observações:</strong><br>{{ $orcamento->observacoes }}</div>
    @endif

    <div class="rodape">Documento gerado em {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>