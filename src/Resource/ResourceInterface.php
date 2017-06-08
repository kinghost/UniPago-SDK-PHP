<?php

namespace UnipagoApi\Resource;

/**
 * Interface ResourceInterface
 */
interface ResourceInterface
{
    /**
     * @param $data
     * @return mixed
     */
    public function criar($data);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function alterar($id, $data);

    /**
     * @return mixed
     */
    public function listar($page, $order, $filter);

    /**
     * @param $id
     * @return mixed
     */
    public function buscar($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deletar($id);
}