<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aluno extends Model
{
    protected $fillable = ['nome', 'email', 'data_nascimento', 'objetivo'];

    protected $casts = ['data_nascimento' => 'date'];

    public function fichas(): HasMany
    {
        return $this->hasMany(Ficha::class);
    }
}