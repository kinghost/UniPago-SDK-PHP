<?php
/**
 * Carregando o autoload
 */
require "../../vendor/autoload.php";

/**
 * Importando as classes
 */
use UnipagoApi\Connection;
use UnipagoApi\Resource;

/**
 * Aqui devem ser informados seu client_id e client_secret
 * que podem ser gerados no Unipago
 */
$client_id = 'CLIENT_ID';
$client_secret = 'CLIENT_SECRET';

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
 * Retorna todos os clientes cadastrados no formato array
 */
$clientes = $recursoCliente->listar();

/**
 *  Retorna o cliente com o ID que deseja, retorno o formato array
 */
$cliente = $recursoCliente->buscar(1);

/**
 *
 */
echo '<pre>';
print_r($clientes);
echo '</pre>';