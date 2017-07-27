<?php
/**
 * This file is part of the unipago/api-sdk-php
 *
 * Classe define os metodos comuns aos recursos da API UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */
namespace UnipagoApi\Resource;

use UnipagoApi\Connection;
use UnipagoApi\Helper\UriHelper;

/**
 * Class AbstractResource
 * @package UnipagoApi\Resource
 */
abstract class AbstractResource implements ResourceInterface
{
    /** @var array Erros da última ação */
    protected $erros;

    /** @var Connection Conexão com OAuth do UniPago */
    protected $connection;

    /** @var array Metadados de paginação */
    protected $paginador;

    /**
     * Inicializa a conexão OAuth
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Retorna o nome do recurso
     *
     * @return string
     */
    protected function getResourceName()
    {
        return constant(get_class($this) . "::RESOURCE_NAME");
    }

    /**
     * Criar um novo registro do recurso
     *
     * @param array $dados
     * @return array|false Dados do registro criado. FALSE é retornado em caso de erros.
     */
    public function criar(array $dados)
    {
        if (empty($dados)) {
            return false;
        }

        try {
            $response = $this->connection->send(Connection::POST, UriHelper::getResourcePath($this->getResourceName()), $dados);
            $parsedBody = json_decode((string) $response->getBody(), true);

            if (array_key_exists('errors', $parsedBody)) {
                $this->setErros($parsedBody['errors']);

                return false;
            }
        } catch (\Exception $exception) {
            $this->setErros([
                'message' => $exception->getMessage(),
                'status'  => $exception->getResponse()->getStatusCode()
            ]);

            return false;
        }

        return $parsedBody;
    }

    /**
     * Alterar os dados de um registro existente
     *
     * @param int $id
     * @param array $dados
     * @return array|false Dados do registro alterado. FALSE é retornado em caso de erros.
     */
    public function alterar($id, array $dados)
    {
        try {
            $response = $this->connection->send(Connection::PUT, UriHelper::getResourcePath($this->getResourceName(), $id), $dados);
            $parsedBody = json_decode((string) $response->getBody(), true);

            if (array_key_exists('errors', $parsedBody)) {
                $this->setErros($parsedBody['errors']);

                return false;
            }
        } catch (\Exception $exception) {
            $this->setErros([
                'message' => $exception->getMessage(),
                'status'  => $exception->getResponse()->getStatusCode()
            ]);

            return false;
        }

        return $parsedBody;
    }

    /**
     * Retorna a listagem de registros do recurso
     *
     * @param int $pagina [optional] Página a ser buscada
     * @param array $filtro [optional] Filtrar listagem por campos
     * @return array
     */
    public function listar($pagina = 1, array $filtro = [])
    {
        $dados = array_filter([
            'page' => $pagina,
            'filter' => $filtro
        ]);

        $response = $this->connection->send(Connection::GET, UriHelper::getResourcePath($this->getResourceName()), $dados);
        $result = json_decode((string) $response->getBody(), true);

        if (!empty($result['meta']['pagination'])) {
            $this->setPaginador($result['meta']['pagination']);
        }

        if (empty($result['data'])) {
            return [];
        }

        return $result['data'];
    }

    /**
     * Define metadados de paginação
     *
     * @param array $paginator
     */
    private function setPaginador(array $paginator)
    {
        $this->paginador = $paginator;
    }

    /**
     * Retorna metadados de paginação
     *
     * @return array
     */
    public function getPaginador()
    {
        return $this->paginador;
    }

    /**
     * Busca um recurso por ID
     *
     * @param int $id
     * @return array|false|null Dados do registro alterado. FALSE é retornado em caso de erros. NULL caso não encontre o registro
     */
    public function buscar($id)
    {
        try {
            $response = $this->connection->send(Connection::GET, UriHelper::getResourcePath($this->getResourceName(), $id));
            $parsedBody = json_decode((string) $response->getBody(), true);

            if (array_key_exists('data', $parsedBody)) {
                return $parsedBody['data'];
            }

            if (array_key_exists('errors', $parsedBody)) {
                $this->setErros($parsedBody['errors']);

                return false;
            }
        } catch (\Exception $exception) {
            $this->setErros([
                'message' => $exception->getMessage(),
                'status'  => $exception->getResponse()->getStatusCode()
            ]);

            return false;
        }

        return null;
    }

    /**
     * Excluir um registro por ID
     *
     * @param int $id
     * @return bool TRUE em caso de sucesso. FALSE caso contrário.
     */
    public function deletar($id)
    {
        try {
            $response = $this->connection->send(Connection::DELETE, UriHelper::getResourcePath($this->getResourceName(), $id));

            return $response->getStatusCode() == 200;
        } catch (\Exception $e) {
            $this->setErros([
                'message' => $e->getMessage(),
                'status'  => $e->getResponse()->getStatusCode()
            ]);
        }

        return false;
    }

    /**
     * Retorna lista de erros da última requisição
     *
     * @return array Lista de erros da útlima requisição
     */
    public function getErros()
    {
        return $this->erros;
    }

    /**
     * Define os erros da última requisição
     *
     * @param array $errors Lista de erros da última requisição
     * @return $this
     */
    protected function setErros(array $errors)
    {
        $this->erros = $errors;

        return $this;
    }
}
