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
 * Dados necessários para criação do cliente
 */
$dados = [
    'nome' => 'Cliente Teste',
    'endereco' => 'Rua Teste 402, 1212 B3',
    'bairro' => 'Teste',
    'cidade' => 'Porto Alegre',
    'pais' => 'Brasil',
    'cep' => '99999999',
    'telefone_principal' => '51999999999',
    'email_contato' => 'teste@unipago.com.br',
    'email_cobranca' => 'teste@unipago.com.br',
    'cpf_cnpj' => '999999999',
    'estado' => 'RS'
];

/**
 * Cria o cliente com os dados informados e retorna o status da transação
 */
$clientes = $recursoCliente->criar($dados);

/**
 *
 */
echo '<pre>';
print_r($clientes);
echo '</pre>';