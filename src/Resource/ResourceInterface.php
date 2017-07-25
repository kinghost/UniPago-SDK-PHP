<?php
/**
 * This file is part of the unipago/api-sdk-php
 *
 * Define interface de recurso de API do UniPago
 *
 * @copyright Copyright (c) UniPago <suporte@unipago.com.br>
 * @license https://creativecommons.org/licenses/by/4.0/ Creative Commons Attribution Share Alike 4.0
 * @link https://packagist.org/packages/unipago/api-sdk-php Packagist
 * @link https://github.com/kinghost/UniPago-SDK-PHP GitHub
 */
namespace UnipagoApi\Resource;

/**
 * Interface ResourceInterface
 */
interface ResourceInterface
{
    /**
     * Criar um novo registro do recurso
     *
     * @param array $data
     * @return array|false
     */
    public function criar(array $data);

    /**
     * Alterar os dados de um registro existente
     *
     * @param int $id
     * @param array $data
     * @return array|false
     */
    public function alterar($id, array $data);

    /**
     * Retorna a listagem de registros do recurso
     *
     * @param int $page
     * @param array $filter
     * @return array
     */
    public function listar($page, array $filter);

    /**
     * Busca um recurso por ID
     *
     * @param $id
     * @return mixed
     */
    public function buscar($id);

    /**
     * Excluir um registro por ID
     *
     * @param $id
     * @return mixed
     */
    public function deletar($id);
}