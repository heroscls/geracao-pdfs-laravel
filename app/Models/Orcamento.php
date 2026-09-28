<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    // Campos que podem ser preenchidos em massa (create/seed)
    protected $fillable = ['cliente_nome', 'cliente_email', 'validade', 'observacoes'];

    // Transforma a coluna "validade" em objeto Carbon (facilita formatar a data)
    protected $casts = ['validade' => 'date'];

    // Relacionamento: 1 orçamento TEM MUITOS itens
    public function itens()
    {
        return $this->hasMany(OrcamentoItem::class);
    }

    // Accessor: permite usar $orcamento->total em qualquer lugar
    public function getTotalAttribute(): float
    {
        // Soma (quantidade x valor unitário) de cada item
        return $this->itens->sum(fn ($item) => $item->quantidade * $item->valor_unitario);
    }
}