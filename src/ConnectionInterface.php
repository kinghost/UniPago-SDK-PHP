<?php
/**
 * This file is part of the kinghost/UniPago-SDK-PHP
 *
 * Define interface de conexão com UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */
namespace UnipagoApi;

/**
 * Interface ConnectionInterface
 * @package UnipagoApi
 */
interface ConnectionInterface
{
    /** @const string Scope de ambiente de Produção */
    const SCOPE_PRODUCTION = 'production';

    /** @const string Scope de ambiente de Sandbox */
    const SCOPE_SANDBOX = 'sandbox';

    /** @var string GET HTTP METHOD*/
    const GET = 'GET';

    /** @var string POST HTTP METHOD*/
    const POST = 'POST';

    /** @var string PUT HTTP METHOD*/
    const PUT = 'PUT';

    /** @var string DELETE HTTP METHOD*/
    const DELETE = 'DELETE';

    /** @var string Mensagem para metodo não implementado */
    const METHOD_NOT_IMPLEMENTED = 'Method not implemented';

    /**
     * ConnectionInterface constructor.
     *
     * @param string $scope
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct($scope, $client_id, $client_secret);

    /**
     * Envia requisição para a API do UniPago
     *
     * @param string $method
     * @param string $url
     * @param array $data [optional]
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function send($method, $url, $data);

    /**
     * Requisita access token para OAuth UniPago
     *
     * @param string $scope
     * @param string $clientId
     * @param string $clientSecret
     * @return string
     * @throws Exception\UnipagoException
     */
    public function getAccessToken($scope, $clientId, $clientSecret);
}