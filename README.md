Biblioteca para consumo da API do UniPago
=====
Esta biblioteca foi desenvolvida para facilitar a utilização da API do Unipago, oferencendo todos os recursos disponíveis de forma prática e simplificada.
Para a correta utilização deste SDK, é necessária a utilização da Linguagem PHP com versão igual ou superior a 5.6.0.
Documentação das entradas e saidas

## Instalação

Você pode utilizar o <b>Composer</b> ou simplesmente <b>Efetuar o Download</b>

## Composer

Orientamos a instalação pelo [composer](https://getcomposer.org/). Siga as  instruções de instalação se você ainda não tiver o composer instalado.
Uma vez instalado o composer, execute o seguinte comando na raíz do seu projeto para instalar o pacote:

```sh
    composer require unipago/api-sdk-php
```

Finalmente, tenha certeza de incluir o autoloader:

```php
    require_once '/path/to/your-project/vendor/autoload.php';
```
## Autenticação com OAuth2

Utilizamos a tecnologia [OAuth2](https://oauth.net/2/) para autenticação do sistema. 
Para gerar as chaves de autenticação no sistema você deve acessar o [UniPago](https://unipago.com.br/configuracoes-api/listar).
Para testar as suas chaves, você pode utilizar o script de exemplo abaixo:


```php
<?php
/**
* Carregando o autoload
*/
require __DIR__ . '/../vendor/autoload.php';

/**
* Importando as classes
*/
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

```

## Exemplo Básico

Listando Clientes
```php
<?php
/**
* Carregando o autoload
*/
require __DIR__ . '/../vendor/autoload.php';

/**
* Importando as classes
*/
use UnipagoApi\Connection;
use UnipagoApi\Resource;

/**
* Aqui devem ser informados seu client_id e client_secret 
* que podem ser gerados no Unipago
*/
$client_id = 'SEU CLIENT ID';
$client_secret = 'SEU CLIENT SECRET';

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
* Retorna todos os clientes cadastrados no formato JSON
*/
$clientes = $recursoCliente->listar();

print_r($clientes);

```