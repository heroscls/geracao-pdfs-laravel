- Listagem de orçamentos com o nome do cliente e a quantidade de itens.
- Botão "Imprimir Orçamento": abre o PDF em uma nova aba do navegador.
- Botão "Baixar PDF": baixa o arquivo direto, com o nome orcamento-{id}.pdf.
- PDF em A4 retrato, com cabeçalho, dados do cliente, tabela de itens, total, observações e rodapé com data e hora.
- Valores no padrão brasileiro com ponto e vírgula e datas no formato dd/mm/aaaa.

Tecnologias

- PHP 8.2 ou superior;
- Laravel;
- barryvdh/laravel-dompdf;
- MySQL como banco padrão, mas qualquer banco suportado pelo Laravel funciona;
- Front-end apenas com HTML e CSS dentro da view Blade "pdf", enquanto na view index é utilizado html junto do bootstrap.

Como funciona

1. O usuário acessa /orcamentos e vê a lista de orçamentos, mostrando:id, nome do cliente, quantidade de itens e dois botões(Imprimir Orçamento e Baixar PDF).
2. Ao clicar em um botão, o navegador chama /orcamentos/{id}/pdf.
3. A rota aciona o método pdf do OrcamentoController.
4. O controller busca o orçamento e carrega seus itens de uma só vez, evitando consultas repetidas.
5. Os dados são enviados para a view orcamentos.pdf, que monta o documento em HTML e CSS.
6. O DomPDF converte esse HTML em PDF e define o papel como A4 em retrato.
7. Se a URL tiver o parâmetro download=1, o arquivo é baixado. Caso contrário, é exibido no navegador.

Rotas

- GET /orcamentos (orcamentos.index): lista os orçamentos.
- GET /orcamentos/{orcamento}/pdf (orcamentos.pdf): exibe o PDF no navegador.
- GET /orcamentos/{orcamento}/pdf?download=1 (orcamentos.pdf): baixa o PDF.

Modelo de dados

Tabela orcamentos: id, cliente_nome, cliente_email, validade (data), observacoes (opcional) e timestamps.

Tabela orcamento_itens: id, orcamento_id (chave estrangeira para orcamentos, com delete cascade), descricao, quantidade, valor_unitario (decimal 10,2) e timestamps.

Relacionamento: um Orcamento tem muitos OrcamentoItem. O model Orcamento possui o atributo calculado total, que soma quantidade vezes valor unitário de todos os itens, e converte a validade para data, o que permite formatá-la com format('d/m/Y').

Como rodar o projeto

Requisitos: PHP 8.2 ou superior, Composer e MySQL.

1. Entre na pasta do projeto e execute `composer install` ou 'composer update'.
2. Copie o arquivo de ambiente com `cp .env.example .env` e gere a chave com `php artisan key:generate`.
3. Crie um banco de dados vazio, por exemplo chamado orcamentos.
4. No .env, preencha DB_DATABASE, DB_USERNAME e DB_PASSWORD. Defina também CACHE_STORE=file e QUEUE_CONNECTION=sync, pois o projeto não usa cache em banco nem filas.
5. Execute `php artisan migrate --seed` para criar as tabelas e inserir um orçamento de exemplo (cliente Maria Silva, com 3 itens).
6. Inicie o servidor com `php artisan serve`.
7. Abra http://localhost:8000/orcamentos.

Como construir o sistema do zero

1. Crie o projeto com `composer create-project laravel/laravel geracao-pdfs-laravel` e instale o pacote com `composer require barryvdh/laravel-dompdf`. O registro é automático, sem configuração adicional.
2. Configure a conexão com o banco no .env.
3. Gere os models e as migrations com `php artisan make:model Orcamento -m` e `php artisan make:model OrcamentoItem -m`.
4. Nas migrations, defina as colunas descritas na seção de modelo de dados. Use o mesmo nome de tabela no método down, com dropIfExists.
5. No model Orcamento, libere os campos em fillable, converta validade para data, crie o relacionamento itens com hasMany e o atributo calculado total. No model OrcamentoItem, informe a tabela orcamento_itens, porque o nome não segue o plural padrão do Laravel.
6. Crie o OrcamentoSeeder com um orçamento e alguns itens, chame-o no DatabaseSeeder e rode `php artisan migrate --seed`.
7. Crie o controller com `php artisan make:controller OrcamentoController`. O método index lista os orçamentos com withCount('itens'). O método pdf carrega os itens, usa Pdf::loadView com a view orcamentos.pdf, aplica setPaper('a4', 'portrait') e devolve download() ou stream(), conforme o parâmetro download.
8. Registre as duas rotas em routes/web.php, com os nomes orcamentos.index e orcamentos.pdf.
9. Crie a view orcamentos/index.blade.php com uma tabela e os dois botões de cada linha.
10. Crie a view orcamentos/pdf.blade.php com o layout do documento, e todo o CSS dentro da tag style.
11. Teste abrindo /orcamentos, clicando nos dois botões e acessando um ID inexistente para ver o erro 404.

Estrutura dos arquivos principais

- app/Http/Controllers/OrcamentoController.php: métodos index e pdf.
- app/Models/Orcamento.php e app/Models/OrcamentoItem.php: models e relacionamento.
- database/migrations: criação das tabelas orcamentos e orcamento_itens.
- database/seeders/OrcamentoSeeder.php: dados de exemplo.
- resources/views/orcamentos/index.blade.php: tela da lista.
- resources/views/orcamentos/pdf.blade.php: layout do PDF.
- routes/web.php: rotas.

## Boas práticas com o DomPDF

- Não use Flexbox nem Grid. O DomPDF suporta CSS 2.1 e parte do CSS 3. Para alinhar elementos, use tabelas, float, margin e padding.
- Mantenha a meta charset UTF-8 e a fonte DejaVu Sans, que já vem com o pacote e exibe acentos corretamente.
- Escreva o CSS dentro da própria view. Arquivos de CSS carregados por URL podem falhar, dependendo do servidor.
- Em imagens, use o caminho do arquivo no servidor com public_path, e não uma URL.
- Defina o tamanho da página com setPaper no controller e, se quiser, com a regra @page no CSS.
- Para forçar uma nova página, use page-break-after: always.
- Para um rodapé em todas as páginas, use position: fixed com bottom: 0, como neste projeto.
- Carregue os relacionamentos antes de enviar os dados à view, para evitar o problema de várias consultas ao banco.

Problemas comuns

- Erro "Unknown database": o banco não existe ou o DB_DATABASE está errado. Crie o banco e confira o .env;
- Erro "No application encryption key": falta gerar a chave. Rode `php artisan key:generate`;
- Erro "Table cache doesn't exist": o .env está com CACHE_STORE=database sem a tabela. Use CACHE_STORE=file;
- Acentos aparecem como interrogação no PDF: confira o charset UTF-8 e a fonte DejaVu Sans;
- Imagem quebrada no PDF: troque a URL por public_path.
- Layout desmontado no PDF: o CSS usa Flexbox ou Grid. Refaça com tabelas ou float;
- Página 404 em /orcamentos/999/pdf: é o comportamento esperado para um ID inexistente;

## Roteiro do seminário (20 minutos)
Bloco 1 - Antonio
No desenvolvimento de sistemas web, especialmente em setores como saúde e finanças, as informações sobre pacientes, históricos médicos e laudos precisam ser emitidos de forma oficial e segura.

Quando não há uma solução integrada para geração de relatórios, o fluxo de trabalho depende de processos manuais. Esse cenário gera problemas e possíveis problemas.

Como o Laravel Resolve essa Demanda
O Laravel trata esse processo unindo seu sistema nativo a motores de renderização.

Ferramentas, Pacotes e Arquitetura da Solução
Integração do Pacote barryvdh/laravel-dompdf;
Eloquent ORM;
Views Blade;

PDF significa Portable Document Format, que traduzido do inglês quer dizer formato portátil de documento.

Bloco 2:
Deixe o VS Code aberto, com o terminal visível e a fonte grande.
Tempo
O que fazer na tela
O que falar (sugestão)
03:00 – 03:45
Terminal: composer require barryvdh/laravel-dompdf
"Depois do Integrante A explicar o problema, vou mostrar como resolvemos. Tudo começa com um único comando do Composer. O pacote se registra sozinho no Laravel (auto-discovery), sem precisar mexer em config/app.php."
03:45 – 04:30
Mostrar make:model Orcamento -m e make:controller. Abrir a pasta de migrations
"Usamos o Artisan para gerar Model, Migration e Controller. Temos duas tabelas: orcamentos e orcamento_itens, ligadas por chave estrangeira. Isso é o clássico 1 para N."
04:30 – 05:30
Abrir Orcamento.php. Destacar hasMany e o accessor getTotalAttribute
"No Model, o hasMany diz que um orçamento tem vários itens. E criei um accessor que calcula o total, então na view basta escrever $orcamento->total. A regra de negócio fica no Model, não no HTML."
05:30 – 06:15
Abrir .env (banco MySQL) e routes/web.php
"No .env configuramos o MySQL. Nas rotas, o ponto-chave é o {orcamento}: o Laravel faz o route model binding, busca o registro sozinho e devolve 404 automático se o ID não existir."
06:15 – 07:30
Abrir o Controller. Percorrer 3 passos: load → Pdf::loadView → stream/download
"O Controller tem 3 passos. 1) carrega os itens; 2) o Pdf::loadView pega uma view Blade normal, passa os dados e converte em PDF; 3) stream abre no navegador e download força o arquivo. Um único método atende os dois botões, mudando só o parâmetro ?download=1."
07:30 – 08:00
Abrir pdf.blade.php. Destacar @page { size: A4 }, DejaVu Sans e as tabelas
"A view é HTML comum com CSS pensado para papel: @page define A4 e margens. Atenção: o DomPDF não suporta flexbox nem grid, então o layout é feito com tabelas."

Bloco 3:
Combine com o Integrante A quem opera e quem narra. Se você opera, siga esta ordem:
Sucesso (08:00–10:30): abrir /orcamentos, clicar em Imprimir Orçamento (abre em nova aba) e depois em Baixar PDF (arquivo baixa).
Bastidores (10:30–12:30): no phpMyAdmin/DBeaver, rodar SELECT * FROM orcamentos; SELECT * FROM orcamento_itens; e mostrar que os valores do PDF são os do banco. Depois alterar um valor no banco, gerar o PDF de novo e mostrar que mudou. Isso prova que os dados são dinâmicos.
Exceção (12:30–14:00): acessar /orcamentos/999/pdf (ID inexistente) e mostrar a página 404 do Laravel. Explicar: "Não escrevi nenhum if, foi o route model binding."
Extra (14:00–15:00): mostrar ?download=1 na URL e explicar a diferença entre stream e download.

Bloco 4

o Pegadinhas do Tema:
Acentos quebrados (Ã§, ?): faltou <meta charset="UTF-8"> ou a fonte não suportava acentos. Solução: DejaVu Sans.
Layout desmontado: usamos flexbox/grid(display: grid/flex) e o DomPDF ignorou. O DomPDF só entende CSS 2.1, então use tb, tr e td e float(float: left /right acompanhada de larguras em porcentagem(width: 50 %). ).
Imagem/logo não aparece: o DomPDF não busca URLs externas por padrão. Use <img src="{{ public_path('images/logo.png') }}" alt="Logo">  ou converta para base64(<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}"> ) ou ative enable_remote no config/dompdf.php).
CSS não aplica: o CSS precisa estar dentro do próprio Blade (<style>). Assets do Vite/Mix não funcionam no PDF.
o Dica de Ouro: monte primeiro o HTML no navegador (retorne a view direto com return view('orcamentos.pdf', ...)) para acertar o layout rápido e só depois troque por Pdf::loadView. Em documentos com muitos itens, considere gerar o PDF em Job (fila) para não travar a requisição.

Bloco 5
DomPDF é PHP puro e não precisa instalar nada no servidor. Há outras bibliotecas mais modernas, mas exigem binários externos (wkhtmltopdf/Chrome).
"Dá para salvar o PDF no servidor?" Sim: Storage::put('orcamentos/orc-1.pdf', $pdf->output());
"Dá para enviar por e-mail?" Sim, anexando $pdf->output() no Mailable.
ESCRITA NO QUADRO:
BLOCO 1:
barryvdh/laravel-dompdf
PDF significa Portable Document Format

BLOCO 2:
composer require barryvdh/laravel-dompdf
load → Pdf::loadView → stream/download


BLOCO 4:
Ã§, ?(DejaVu Sans)
@page { size: A4 }
public_path('logo.png')
enable_remote
<style>
BLOCO 4:
Storage::put('orcamentos/orc-1.pdf', $pdf->output());
$pdf->output() no Mailable.
