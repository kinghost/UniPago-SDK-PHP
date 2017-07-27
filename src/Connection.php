<?php
/**
 * This file is part of the unipago/api-sdk-php
 *
 * Classe responsável por realizar a autorização e conexão com a API do UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */
namespace UnipagoApi;

use GuzzleHttp\Client as GuzzleClient;
use League\OAuth2\Client\Provider\GenericProvider;
use UnipagoApi\Exception\UnipagoException;
use UnipagoApi\Helper\UriHelper;

/**
 * Class Connection
 * @package UnipagoApi
 */
class Connection implements ConnectionInterface
{
    /** @var string API base URL */
    private $apiUrl;

    /** @var string OAuth Access Token */
    public $accessToken;

    /**
     * Client constructor.
     *
     * @param string $scope
     * @param string $client_id
     * @param string $client_secret
     * @throws UnipagoException
     */
    public function __construct($scope, $client_id, $client_secret)
    {
        $this->apiUrl = UriHelper::getBaseUrl($scope);
        $this->accessToken = $this->getAccessToken($scope, $client_id, $client_secret);
    }

    /**
     * Envia requisição para a API do UniPago
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function send($method, $url, $data = array())
    {
        $client = new GuzzleClient();
        $options['headers'] = $this->buildHeaders();

        /**
         * Efetua o request
         */
        if (!empty($data)) {
            if ($method == self::POST || $method == self::PUT) {
                $options['form_params'] = $data;
            }

            if ($method === self::GET) {
                $url .= '?' . http_build_query($data);
            }
        }

        return $client->request($method, $this->apiUrl . $url, $options);
    }

    /**
     * Solicita Access Token para o OAuth do UniPago
     *
     * @param string $scope
     * @param string $clientId
     * @param string $clientSecret
     * @return string
     * @throws UnipagoException Caso não consiga realizar a autorização via OAuth
     */
    public function getAccessToken($scope, $clientId, $clientSecret)
    {
        $provider = new GenericProvider([
            'clientId'                => $clientId,
            'clientSecret'            => $clientSecret,
            'urlAuthorize'            => UriHelper::getOAuthUrl('/oauth/authorize'),
            'urlAccessToken'          => UriHelper::getOAuthUrl('/oauth/access_token'),
            'urlResourceOwnerDetails' => UriHelper::getOAuthUrl('/me')
        ]);

        try {
            // Try to get an access token using the client credentials grant.
            $accessToken = $provider->getAccessToken('client_credentials', ['scope' => $scope]);

            return $accessToken->getToken();
        } catch (\Exception $exception) {
            // Failed to get the access token
            throw new UnipagoException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Monta cabeçalho de requisição, adicionando o access_token
     *
     * @return array              
     */
    private function buildHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken
        ];
    }
}