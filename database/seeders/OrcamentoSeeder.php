<?php

namespace Database\Seeders;

use App\Models\Orcamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orcamento = Orcamento::create([
            'cliente_nome'  => 'Maria Silva',
            'cliente_email' => 'maria@email.com',
            'validade'      => now()->addDays(15),
            'observacoes'   => 'Pagamento em até 3x no cartão. Prazo de entrega: 10 dias úteis.',
        ]);

        // Cria 3 itens ligados a esse orçamento
        $orcamento->itens()->createMany([
            ['descricao' => 'Desenvolvimento de site institucional', 'quantidade' => 1, 'valor_unitario' => 3500.00],
            ['descricao' => 'Hospedagem anual',                      'quantidade' => 1, 'valor_unitario' => 480.00],
            ['descricao' => 'Hora de suporte técnico',               'quantidade' => 5, 'valor_unitario' => 90.00],
        ]);
    }
}
