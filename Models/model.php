<?php

namespace Models;


class model
{
    public function __construct()
    {
        $this->criarTabela();
    }

    protected function getThisVars()
    {
        return get_class_vars(get_class($this));
    }
    private function criarTabela()
    {
        $info = array_keys($this->getThisVars());
        $info = array_splice($info,1);

        $class_name = get_class($this);
        switch ($class_name) {
            case 'Models\\user':
                $info = $this->getModelUserQuery($info);
                break;
            case 'Models\\informacao':
                $info = $this->getModelInformacaoQuery($info);
                break;
            default:
                throw new \Exception("Tabela não encontrada para a classe '$class_name'");
        }
    
        database::criarTabela($this->table_name, $info);
    }
    
    private function getModelUserQuery(array $columns): string
    {
        $columns[0] = $this->createAutoIncrementColumn($columns[0]);
        $columns[1] = $this->createUniqueColumn($columns[1], 100);
        $columns[2] = $this->createColumn($columns[2], 100);
        $columns[3] = $this->createColumn($columns[3], 100);
        $columns[4] = $this->createColumn($columns[4], 100);
    
        $columns[] = 'PRIMARY KEY (`id`)';
        return implode(',', $columns);
    }
    
    private function getModelInformacaoQuery(array $columns): string
    {
        $columns[0] = $this->createAutoIncrementColumn($columns[0]);
        $columns[1] = $this->createColumn($columns[1], 250);
        $columns[2] = '`' . $columns[2] . '` DATETIME NOT NULL';
        $columns[3] = '`' . $columns[3] . '` DATETIME NOT NULL';
        $columns[4] = '`' . $columns[4] . '` int NOT NULL';
    
        $columns[] = 'PRIMARY KEY (`id`), FOREIGN KEY (`quemCadastrou`) REFERENCES `tb_user`(`id`)';
        return implode(',', $columns);
    }
    
    private function createAutoIncrementColumn(string $name): string
    {
        return '`' . $name . '` int NOT NULL AUTO_INCREMENT';
    }
    
    private function createUniqueColumn(string $name, int $length): string
    {
        return '`' . $name . '` varchar(' . $length . ') NOT NULL UNIQUE';
    }
    
    private function createColumn(string $name, int $length): string
    {
        return '`' . $name . '` varchar(' . $length . ')';
    }
    

    protected function filterVarString($var, int $maxLenght, int $minLenght)
    {
        $var = filter_var($var, FILTER_DEFAULT);
        if (strlen($var) > $maxLenght || strlen($var) < $minLenght) {
            return false;
        }
        return $var;
    }
}
