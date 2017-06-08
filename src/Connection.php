<?php 

namespace UnipagoApi;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use Guzzle\Http\Exception\ClientErrorResponseException;
use UnipagoApi\Connection;

/**
* Client for Unipago Api
*/
class Connection 
{

    /**
     * @const string Scope for production environment
     */
    const SCOPE_PRODUCTION = 'production';

    /**
     * @const string  Scope for sandbox environment
     */
    const SCOPE_SANDBOX = 'sandbox';

    /**
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * @var string
     */
    const GET = 'GET';

    /**
     * @var string
     */
    const PUT = 'PUT';

    /**
     * @var string
     */
    const POST = 'POST';

    /**
     * @var string
     */
    const METHOD_NOT_IMPLEMENTED = 'Method not implemented';

    /**
     * @var string
     */
    private $apiUrl;

    /**
     * Client constructor.
     * @param $scope
     * @param $client_id
     * @param $client_secret
     * @internal param $config
     */
    public function __construct($scope, $client_id, $client_secret)
    {

        if (in_array($scope, [self::SCOPE_PRODUCTION, self::SCOPE_SANDBOX]) == false) {
            throw new \InvalidArgumentException('Invalid Scope: ' . $scope);
        }

        $this->accessToken = $this->getAccessToken($scope, $client_id, $client_secret);
        $this->apiUrl = ($scope == self::SCOPE_PRODUCTION) ? 'http://api.unipago.com.br' : 'http://api.unipago.com.br/sandbox';
    }

    /**
     * @param $method
     * @param $url
     * @param array $data
     * @return mixed
     */
    public function send($method, $url, $data = array())
    {
        $headers = $this->buildHeaders();

        $client = new GuzzleClient();
        $options['headers'] = $headers;
        //$options['http_errors'] = false;

        /**
         * Efetua o request
         */
        if ($method == self::POST || $method == self::PUT) {
            $options['form_params'] = $data;
        }

        return $client->request($method, $this->getApiUrl() . $url, $options);
    }

    /**
     * @param string $scope
     * @param string $clientId
     * @param string $clientSecret
     * @return string
     */
    public function getAccessToken($scope, $clientId, $clientSecret)
    {
        $oauth_url = 'http://oauth.unipago.com.br';

        $provider = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => $clientId,    // The client ID assigned to you by the provider
            'clientSecret'            => $clientSecret,    // The client password assigned to you by the provider
            'urlAuthorize'            => $oauth_url . '/oauth/authorize',
            'urlAccessToken'          => $oauth_url . '/oauth/access_token',
            'urlResourceOwnerDetails' => $oauth_url . '/me'
        ]);

        try {
            // Try to get an access token using the client credentials grant.
            $accessToken = $provider->getAccessToken('client_credentials', ['scope' => $scope]);

            return $accessToken->getToken();
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // Failed to get the access token
            exit($e->getMessage());
        }
    }

    /**
     * Monta cabeçalho de requisição, adicionando o access_token
     * @return array              
     */
    private function buildHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken
        ];
    }

    /**
     * @return mixed
     */
    private function getApiUrl()
    {
        return $this->apiUrl;
    }
}