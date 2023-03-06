<?php

namespace Models;

use DateTime;
use Exception;
use Models\model;
use PDO;

class informacao extends model
{
    public string $table_name = 'tb_informacao';
    protected string $id;
    protected string $informacao;
    protected string $dataCadastrada;
    protected string|null $dataAtualizacao;

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
        if ($result == false)
            throw new Exception('A informação a ser cadastrada passou do limite. Que é 250 caracteres.');
        $this->informacao =  $result;
    }

    // Getter e Setter para $dataCadastrada
    public function getDataCadastrada(): string
    {
        return date('d/m/Y H:i:s', strtotime($this->dataCadastrada));
    }

    public function setDataCadastrada(): void
    {
        $this->dataCadastrada = date('Y-m-d H:i:s');
    }

    // Getter e Setter para $dataCadastrada
    public function getDataAtualizacao(): string|null
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

    public function salvar(): bool
    {
        if (database::insertData($this->table_name, [
            'informacao' => $this->informacao,
            'dataCadastrada' => $this->dataCadastrada,
            'quemCadastrou' => $this->quemCadastrou

        ]))
            return true;
        else
            return false;
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

        return $info;
    }
   public static function getInformacaoList():array{
    $informacao = new informacao();
    return database::retrieveAllData($informacao->table_name, get_class($informacao));
  
   }
   public static function buscarPagina(int $limit, int $offset){
    $informacao = new informacao();
    $informacao = database::retrieveDataPage($informacao->table_name,$limit, $offset,get_class($informacao));
    return $informacao;

    
    
   }
}
