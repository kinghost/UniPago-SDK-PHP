<?php 

namespace UnipagoApi\Resource;

use UnipagoApi\Connection;

/**
 * Class AbstractResource
 * @package UnipagoApi\Resource
 */
class AbstractResource implements ResourceInterface
{
    /**
     * Returned erros
     * @var array
     */
    protected $erros;

    /**
     * @var string
     */
    protected $resourceName = '';

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * AbstractResource constructor.
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    protected function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @param $dados
     * @return mixed
     */
    public function criar($dados)
    {
        $response = $this->connection->send(Connection::POST, sprintf("/%s", $this->getResourceName()), $dados);
        
        $parsedBody = json_decode($response->getBody()->getContents());
        if (property_exists($parsedBody, 'errors')) {
            $this->setErros($parsedBody->errors);

            return false;
        }

        return $parsedBody;
    }

    /**
     * @param $id
     * @param $dados
     * @return mixed
     */
    public function alterar($id, $dados)
    {
        try {
            $response = $this->connection->send(Connection::PUT, sprintf("/%s/%s", $this->getResourceName(), $id), $dados);
            return $response;
        } catch (\Exception $e) {
            $this->setErros([
                'message' => $e->getMessage(),
                'status' => $e->getResponse()->getStatusCode()
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function listar($pagina = 1, $ordem = '', $filtro = [])
    {
        $url = sprintf("/%s", $this->getResourceName());

        $url = $url . '?page=' . $pagina;

        $response = $this->connection->send(Connection::GET, $url);

        $returnData = json_decode( (string) $response->getBody(), true);

        if ( ! empty($returnData['meta']['pagination'])) {
            $this->setPaginador($returnData['meta']['pagination']);
        }

        return $returnData['data'];
    }

    private function setPaginador($paginator) {
        $this->paginador = $paginator;
    }

    public function getPaginador() {
        return $this->paginador;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function buscar($id)
    {
        try {
            $response = $this->connection->send(Connection::GET, sprintf("/%s/%s", $this->getResourceName(), $id));
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            $this->setErros([
                'message' => $e->getMessage(),
                'status' => $e->getResponse()->getStatusCode()
            ]);
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function deletar($id)
    {
        try {
            $response = $this->connection->send(Connection::DELETE, sprintf("/%s/%s", $this->getResourceName(), $id));
            return $response->getStatusCode() == 200;
        } catch (\Exception $e) {
            $this->setErros([
                'message' => $e->getMessage(),
                'status' => $e->getResponse()->getStatusCode()
            ]);
        }
    }

    /**
     * Gets the Returned erros.
     *
     * @return array
     */
    public function getErros()
    {
        return $this->errors;
    }

    /**
     * Sets the Returned erros.
     *
     * @param array $errors the errors
     *
     * @return self
     */
    protected function setErros(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }
}
