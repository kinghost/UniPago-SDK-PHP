<?php

require "../../vendor/autoload.php";

use UnipagoApi\Connection;

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

echo "<pre>Access_token: <br />";
print_r($conexao->accessToken);
echo "</pre>";