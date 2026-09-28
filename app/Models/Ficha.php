<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ficha extends Model
{
    protected $fillable = [
        'aluno_id', 'nome', 'instrutor', 'data_inicio', 'data_fim', 'observacoes',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
    ];

    public function aluno(): BelongsTo
    {
        return $this->belongsTo(Aluno::class);
    }

    public function itens(): HasMany
    {
        return $this->hasMany(FichaItem::class)->orderBy('dia')->orderBy('ordem');
    }
}