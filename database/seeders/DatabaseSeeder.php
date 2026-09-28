<?php

namespace Database\Seeders;

use App\Models\Aluno;
use App\Models\Exercicio;
use App\Models\Ficha;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $aluno = Aluno::create([
            'nome'            => 'João da Silva',
            'email'           => 'joao@email.com',
            'data_nascimento' => '1995-04-12',
            'objetivo'        => 'Hipertrofia',
        ]);

        $ex = collect([
            ['Supino reto',        'Peito'],
            ['Crucifixo inclinado', 'Peito'],
            ['Tríceps corda',      'Tríceps'],
            ['Puxada frontal',     'Costas'],
            ['Remada baixa',       'Costas'],
            ['Rosca direta',       'Bíceps'],
            ['Agachamento livre',  'Pernas'],
            ['Leg press 45°',      'Pernas'],
            ['Cadeira extensora',  'Pernas'],
        ])->map(fn ($e) => Exercicio::create([
            'nome' => $e[0], 'grupo_muscular' => $e[1],
        ]));

        $ficha = Ficha::create([
            'aluno_id'    => $aluno->id,
            'nome'        => 'Hipertrofia – Fase 1',
            'instrutor'   => 'Prof. Carlos Mendes',
            'data_inicio' => now(),
            'data_fim'    => now()->addWeeks(8),
            'observacoes' => 'Beber água entre as séries e manter a técnica antes de aumentar a carga.',
        ]);

        // [índice do exercício, dia, ordem, séries, reps, carga, descanso]
        $itens = [
            [0, 'A', 1, 4, '8-10', '40kg', 90],
            [1, 'A', 2, 3, '12',   '14kg', 60],
            [2, 'A', 3, 3, '12',   '25kg', 60],
            [3, 'B', 1, 4, '10',   '50kg', 90],
            [4, 'B', 2, 3, '12',   '45kg', 60],
            [5, 'B', 3, 3, '12',   '12kg', 60],
            [6, 'C', 1, 4, '8',    '60kg', 120],
            [7, 'C', 2, 4, '12',   '150kg', 90],
            [8, 'C', 3, 3, '15',   '35kg', 60],
        ];

        foreach ($itens as [$i, $dia, $ordem, $series, $reps, $carga, $desc]) {
            $ficha->itens()->create([
                'exercicio_id'      => $ex[$i]->id,
                'dia'               => $dia,
                'ordem'             => $ordem,
                'series'            => $series,
                'repeticoes'        => $reps,
                'carga'             => $carga,
                'descanso_segundos' => $desc,
            ]);
        }
    }
}