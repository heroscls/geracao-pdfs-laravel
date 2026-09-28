<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrcamentoItem extends Model
{
    protected $table = 'orcamento_itens'; // nome da tabela não segue o plural padrão
    protected $fillable = ['orcamento_id', 'descricao', 'quantidade', 'valor_unitario'];
}