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
$recursoCobranca = new Resource\Cobranca($conexao);

/**
 * Lista todas as cobranças, retorno array
 */
$cobrancas = $recursoCobranca->listar();

/**
 * Busca cobranças por ID
 */
$cobranca = $recursoCobranca->buscar(1000);

/**
 *
 */
echo '<pre>';
print_r($cobrancas);
echo '</pre>';
