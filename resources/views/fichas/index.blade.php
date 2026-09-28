<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Fichas de Treino</title>
    <style>
        body { font-family: sans-serif; max-width: 900px; margin: 40px auto; padding: 0 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f3f4f6; }
        a.btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; color: #fff; font-size: 14px; }
        .ver { background: #2563eb; }
        .baixar { background: #16a34a; }
    </style>
</head>
<body>
    <h1>🏋️ Fichas de Treino</h1>

    <table>
        <thead>
            <tr>
                <th>Aluno</th><th>Ficha</th><th>Instrutor</th><th>Período</th><th>PDF</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($fichas as $ficha)
            <tr>
                <td>{{ $ficha->aluno->nome }}</td>
                <td>{{ $ficha->nome }}</td>
                <td>{{ $ficha->instrutor }}</td>
                <td>
                    {{ $ficha->data_inicio->format('d/m/Y') }}
                    @if ($ficha->data_fim) a {{ $ficha->data_fim->format('d/m/Y') }} @endif
                </td>
                <td>
                    <a class="btn ver" href="{{ route('fichas.pdf', $ficha) }}" target="_blank">Visualizar</a>
                    <a class="btn baixar" href="{{ route('fichas.baixar', $ficha) }}">Baixar</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>