<?php

namespace Models;

use DateTime;
use Exception;
use Models\model;

class informacao extends model
{
    public string $table_name = 'tb_informacao';
    protected string $id;
    protected string $informacao;
    protected string $dataCadastrada;
    protected string $dataAtualizacao;

    protected int $quemCadastrou;


    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    // Getter e Setter para $informacao
    public function getInformacao(): string
    {
        return $this->informacao;
    }

    public function setInformacao(string $informacao): void
    {
        $result = $this->filterVarString($informacao, 250, 5);
        if($result == false)
        throw new Exception('A informação a ser cadastrada passou do limite. Que é 250 caracteres.');
        $this->informacao =  $result;
    }

    // Getter e Setter para $dataCadastrada
    public function getDataCadastrada(): string
    {
        return date('d/m/Y H:i:s',strtotime($this->dataCadastrada));
    }

    public function setDataCadastrada(): void
    {
        $this->dataCadastrada = date('Y-m-d H:i:s');
    }

    // Getter e Setter para $dataCadastrada
    public function getDataAtualizacao(): string
    {
        return $this->dataAtualizacao;
    }

    public function setDataAtualizacao(string $dataAtualizacao): void
    {
        $this->dataAtualizacao = $dataAtualizacao;
    }
    // Getter e Setter para $quemCadastrou
    public function getQuemCadastrou(): user
    {
        return user::buscarPorID($this->quemCadastrou);
    }

    public function setQuemCadastrou(user $quemCadastrou): void
    {
        $this->quemCadastrou = $quemCadastrou->getID();
    }

    public function salvar()
    {
        if (database::insertData($this->table_name, ['informacao' => $this->getInformacao(), 'dataCadastrada' => $this->getDataCadastrada(), 'quemCadastrou' => $this->getQuemCadastrou()->getID()]))
            return ['success' => 'Informação registrado com sucesso!'];
        else
            return ['fail' => 'Não foi possivel registrar a informação!'];
    }
    public function getJsonObject()
    {
        return json_encode(get_object_vars($this));
    }
    public static function novaInformacao(string $informacao, user $quemCadastrou): informacao
    {
        $info = new informacao();
        $info->setInformacao($informacao);
        $info->setQuemCadastrou($quemCadastrou);
        $info->setDataCadastrada(date('d/m/Y H:i:s'));
        echo $info->getDataCadastrada();
        
        return $info;
    }
}
