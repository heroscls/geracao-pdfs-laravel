<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
</div>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Orçamentos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        a.btn { padding: 6px 12px; color: #fff; text-decoration: none; border-radius: 4px; }
        .ver { background: #2563eb; } .baixar { background: #16a34a; }
    </style>
</head>
<body>
    <h1>Orçamentos</h1>
    <table>
        <tr><th>#</th><th>Cliente</th><th>Itens</th><th>Ações</th></tr>

        @foreach ($orcamentos as $o)
            <tr>
                <td>{{ $o->id }}</td>
                <td>{{ $o->cliente_nome }}</td>
                <td>{{ $o->itens_count }}</td>
                <td>
                    {{-- Abre o PDF numa nova aba --}}
                    <a class="btn ver" target="_blank" href="{{ route('orcamentos.pdf', $o) }}">Imprimir Orçamento</a>
                    {{-- ?download=1 força o download do arquivo --}}
                    <a class="btn baixar" href="{{ route('orcamentos.pdf', ['orcamento' => $o, 'download' => 1]) }}">Baixar PDF</a>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>