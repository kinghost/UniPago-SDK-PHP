<?php

/**
 * This file is part of the unipago/api-sdk-php
 *
 * Define testes de conexão/autorização com a API do UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */

namespace UnipagoApi\Test;

use Dotenv\Dotenv;
use Lcobucci\JWT\Parser;
use PHPUnit\Framework\TestCase;
use UnipagoApi\Connection;

/**
 * Class ConnectionTest
 *
 * @package UnipagoApi\Test
 */
class ConnectionTest extends TestCase
{
    /**
     * @expectedException \UnipagoApi\Exception\UnipagoException
     */
    public function testInvalidScopeThrowsException()
    {
        new Connection(uniqid(), uniqid(), uniqid());
    }

    /**
     * @expectedException \UnipagoApi\Exception\UnipagoException
     */
    public function testInvalidClientCredentialsThrowsException()
    {
        new Connection(Connection::SCOPE_SANDBOX, uniqid(), uniqid());
    }

    /**
     * Carrega clientId e clientSecret do arquivo .env caso já não tenha sido definido
     *
     * @return array
     */
    private function getClientCredentials(string $env)
    {
        if (!getenv($env . '_CLIENT_ID') || !getenv($env . '_CLIENT_SECRET')) {
            $dotenv = new Dotenv(dirname(__DIR__));
            $dotenv->load();
        }

        return [
            getenv($env . '_CLIENT_ID'),
            getenv($env . '_CLIENT_SECRET')
        ];
    }

    public function testGenerateProductionAccessToken()
    {
        list($clientId, $clientSecret) = $this->getClientCredentials('PRODUCTION');

        $connection = new Connection(Connection::SCOPE_PRODUCTION, $clientId, $clientSecret);

        $this->assertInternalType('string', $connection->accessToken);
        $this->assertRegExp('/^.*\..*\..*$/', $connection->accessToken);

        return $connection;
    }

    /**
     * @param Connection $connection
     *
     * @depends testGenerateProductionAccessToken
     */
    public function testProductionAccessTokenHasProductionScope(Connection $connection)
    {
        $parser = new Parser();
        $token = $parser->parse($connection->accessToken);

        $this->assertContains(Connection::SCOPE_PRODUCTION, $token->getClaim('scopes'));
    }

    public function testGenerateSandboxAccessToken()
    {
        list($clientId, $clientSecret) = $this->getClientCredentials('SANDBOX');

        $connection = new Connection(Connection::SCOPE_SANDBOX, $clientId, $clientSecret);

        $this->assertInternalType('string', $connection->accessToken);
        $this->assertRegExp('/^.*\..*\..*$/', $connection->accessToken);

        return $connection;
    }

    /**
     * @param Connection $connection
     *
     * @depends testGenerateSandboxAccessToken
     */
    public function testSandboxAccessTokenHasSandboxScope(Connection $connection)
    {
        $parser = new Parser();
        $token = $parser->parse($connection->accessToken);

        $this->assertContains(Connection::SCOPE_SANDBOX, $token->getClaim('scopes'));
    }

    /**
     * @param Connection $connection
     *
     * @depends testGenerateSandboxAccessToken
     */
    public function testInvalidMethodReturnsBadRequest(Connection $connection)
    {
        $response = $connection->send(uniqid(), uniqid());

        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * @param Connection $connection
     *
     * @depends testGenerateSandboxAccessToken
     */
    public function testInvalidUrlReturnsNotFoundResponse(Connection $connection)
    {
        $httpMethods = [
            Connection::GET,
            Connection::POST,
            Connection::PUT,
            Connection::DELETE
        ];

        foreach ($httpMethods as $method) {
            $response = $connection->send($method, uniqid());

            $this->assertEquals(404, $response->getStatusCode());
        }
    }
}
