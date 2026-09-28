<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use Barryvdh\DomPDF\Facade\Pdf; // Facade do DomPDF
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{
    // Mostra a lista de orçamentos com os botões
    public function index()
    {
        // withCount('itens') traz a quantidade de itens sem carregar todos eles
        $orcamentos = Orcamento::withCount('itens')->latest()->get();

        return view('orcamentos.index', compact('orcamentos'));
    }

    // Gera o PDF de um orçamento
    public function pdf(Request $request, Orcamento $orcamento)
    {
        // 1) Carrega os itens do orçamento (evita várias consultas na view)
        $orcamento->load('itens');

        // 2) Renderiza a view Blade como PDF, enviando os dados dinâmicos do banco
        $pdf = Pdf::loadView('orcamentos.pdf', ['orcamento' => $orcamento])
                  ->setPaper('a4', 'portrait'); // A4 em pé

        $nomeArquivo = "orcamento-{$orcamento->id}.pdf";

        // 3) Se a URL tiver ?download=1, força o download.
        //    Caso contrário, abre no navegador (visualização/impressão).
        if ($request->boolean('download')) {
            return $pdf->download($nomeArquivo);
        }

        return $pdf->stream($nomeArquivo);
    }
}