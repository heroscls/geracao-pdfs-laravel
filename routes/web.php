use App\Http\Controllers\OrcamentoController;

// Tela com a lista de orçamentos
Route::get('/orcamentos', [OrcamentoController::class, 'index'])->name('orcamentos.index');

// Gera o PDF. {orcamento} faz o Laravel buscar o registro pelo ID sozinho.
// Se o ID não existir, ele retorna 404 automaticamente (route model binding).
Route::get('/orcamentos/{orcamento}/pdf', [OrcamentoController::class, 'pdf'])->name('orcamentos.pdf');