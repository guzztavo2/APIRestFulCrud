<?php 
namespace Models;

use Models\model;

class informacao extends model
{
    public string $table_name = 'tb_informacao';
    protected string $id;
    protected string $informacao;
    protected string $dataCadastrada;
    protected user $quemCadastrou;



    
}