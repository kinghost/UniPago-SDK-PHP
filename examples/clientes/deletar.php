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
$recursoCliente = new Resource\Cliente($conexao);

/**
 * Atualiza o cliente com id informado, com os dados desejados
 */
$cliente = $recursoCliente->deletar(1);

/**
 *
 */
print_r($cliente);