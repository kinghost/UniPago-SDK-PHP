<?php

/**
 * This file is part of the unipago/api-sdk-php
 *
 * Define testes do helper de URLs da API do UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */

namespace UnipagoApi\Test;

use PHPUnit\Framework\TestCase;
use UnipagoApi\Helper\UriHelper;

/**
 * Class UriHelperTest
 *
 * @package UnipagoApi\Test
 */
class UriHelperTest extends TestCase
{
    /**
     * @expectedException \UnipagoApi\Exception\UnipagoException
     */
    public function testInvalidScopeThrowsException()
    {
        UriHelper::getBaseUrl(uniqid());
    }
}