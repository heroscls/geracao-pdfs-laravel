<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FichaItem extends Model
{
    protected $table = 'ficha_itens';

    protected $fillable = [
        'ficha_id', 'exercicio_id', 'dia', 'ordem',
        'series', 'repeticoes', 'carga', 'descanso_segundos',
    ];

    public function ficha(): BelongsTo
    {
        return $this->belongsTo(Ficha::class);
    }

    public function exercicio(): BelongsTo
    {
        return $this->belongsTo(Exercicio::class);
    }
}