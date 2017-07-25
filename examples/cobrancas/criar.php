<?php
/**
 * Carregando o autoload
 */
require __DIR__ . '/../../vendor/autoload.php';

/**
 * Importando as classes
 */
use UnipagoApi\Connection;
use UnipagoApi\Resource;

/**
 * Aqui devem ser informados seu client_id e client_secret
 * que podem ser gerados no Unipago
 */
$client_id = getenv('CLIENT_ID');
$client_secret = getenv('CLIENT_SECRET');

/**
 * Deve ser informado o ambiente que deseja utilizar Connection::SCOPE_SANDBOX
 * ou Connection::SCOPE_PRODUCTION
 */
$conexao = new Connection(Connection::SCOPE_SANDBOX, $client_id, $client_secret);

/**
 * Instância do recurso de Cliente que será utilizada, onde deve ser passada a conexão
 */
$recursoCobranca = new Resource\Cobranca($conexao);

/**
 * Dados necessários para criação da cobrança avulsa
 */
$dados = [
    'items' => [
        '0' => [
            'nome' => 'Teste',
            'valor_unitario' => 123.45,
            'quantidade' => 3
        ],
    ],
    'data_vencimento' => '26/01/2018',
    'cliente' => 1
];

/**
 * Cria o cliente com os dados informados e retorna um array com o status da transação
 */
$cobranca = $recursoCobranca->criar($dados);

/**
 *
 */
echo '<pre>';
print_r($cobranca);
echo '</pre>';