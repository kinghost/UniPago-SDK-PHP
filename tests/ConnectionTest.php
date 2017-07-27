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

use PHPUnit\Framework\TestCase;

/**
 * Class ConnectionTest
 * @package UnipagoApi\Test
 */
class ConnectionTest extends TestCase
{
    /**
     * Test class_exists
     */
    public function testDummy()
    {
        $this->assertTrue(class_exists('UnipagoApi\\Connection', false));
    }
}