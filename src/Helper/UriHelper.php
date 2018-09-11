<?php
/**
 * This file is part of the unipago/api-sdk-php
 *
 * Classe que define as URLs que serão utilizadas na conexão com a API do UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */
namespace UnipagoApi\Helper;

use UnipagoApi\Connection;
use UnipagoApi\Exception\UnipagoException;

/**
 * Class UriHelper
 * @package UnipagoApi\Helper
 */
class UriHelper
{
    /** @var string URL base da API de Desenvolvimento */
    const DEVELOPMENT_URL = 'http://dev-unipago-api';

    /** @var string URL base da API de Produção */
    const PRODUCTION_URL = 'https://api.unipago.com.br';

    /** @var string URL base da API de Sandbox */
    const SANDBOX_URL = 'https://api.unipago.com.br/sandbox';

    /** @var string URL base do OAuth Server */
    const OAUTH_URL = 'https://oauth.unipago.com.br/';

    /**
     * Retorna a url base da API do UniPago baseado no scope
     *
     * @param string $scope
     * @return string
     * @throws UnipagoException Caso seja solicitado um scope que não exista
     */
    public static function getBaseUrl($scope = Connection::SCOPE_SANDBOX)
    {
        $scope = strtoupper($scope);

        $name = "self::{$scope}_URL";
        if (!defined($name)) {
            throw new UnipagoException('Scope de ambiente de conexão inválido');
        }

        $constant = constant($name);
        if (!$constant) {
            throw new UnipagoException('Não foi possível identificar o ambiente de conexão');
        }

        return $constant;
    }

    /**
     * Retorna a url de OAuth
     *
     * @param string $path
     * @return string
     */
    public static function getOAuthUrl($path = null)
    {
        return self::OAUTH_URL . ltrim($path, '/');
    }

    /**
     * Retorna path do recurso
     *
     * @param string $resourceName
     * @param int $resourceIdentifier [optional]
     * @return string
     */
    public static function getResourcePath($resourceName, $resourceIdentifier = null)
    {
        if ($resourceIdentifier) {
            return sprintf("/%s/%s", $resourceName, $resourceIdentifier);
        }

        return sprintf("/%s", $resourceName);
    }
}
