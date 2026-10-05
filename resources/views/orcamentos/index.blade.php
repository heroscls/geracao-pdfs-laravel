<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orçamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-4">
        <h1 class="mb-4">Orçamentos</h1>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Itens</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orcamentos as $o)
                        <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ $o->cliente_nome }}</td>
                            <td>{{ $o->itens_count }}</td>
                            <td>
                                {{-- Abre o PDF numa nova aba --}}
                                <a class="btn btn-primary btn-sm" target="_blank" href="{{ route('orcamentos.pdf', $o) }}">Imprimir Orçamento</a>
                                {{-- ?download=1 força o download do arquivo --}}
                                <a class="btn btn-success btn-sm" href="{{ route('orcamentos.pdf', ['orcamento' => $o, 'download' => 1]) }}">Baixar PDF</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>