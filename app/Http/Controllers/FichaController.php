<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class FichaController extends Controller
{
    public function index()
    {
        $fichas = Ficha::with('aluno')->latest()->get();

        return view('fichas.index', compact('fichas'));
    }

    /** Abre o PDF no navegador (preview). */
    public function visualizar(Ficha $ficha)
    {
        return $this->gerarPdf($ficha)->stream($this->nomeArquivo($ficha));
    }

    /** Força o download do PDF. */
    public function baixar(Ficha $ficha)
    {
        return $this->gerarPdf($ficha)->download($this->nomeArquivo($ficha));
    }

    private function gerarPdf(Ficha $ficha)
    {
        // 1. Busca tudo no banco de uma vez (evita N+1 queries)
        $ficha->load(['aluno', 'itens.exercicio']);

        // 2. Agrupa os exercícios por dia de treino (A, B, C)
        $itensPorDia = $ficha->itens->groupBy('dia');

        // 3. Renderiza a view Blade como PDF
        return Pdf::loadView('fichas.pdf', [
                'ficha'       => $ficha,
                'itensPorDia' => $itensPorDia,
            ])
            ->setPaper('a4', 'portrait');
    }

    private function nomeArquivo(Ficha $ficha): string
    {
        return 'ficha-' . Str::slug($ficha->aluno->nome) . '-' . $ficha->id . '.pdf';
    }
}