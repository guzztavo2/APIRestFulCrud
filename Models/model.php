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
        $info = $this->getThisVars();
        $info = array_keys($info);
        $info = array_splice($info, 1);

        if (get_class($this) == 'Models\\user')
            $info = $this->modelUserQuerry($info);
        else if (get_class($this) == 'Models\\informacao')
            $info = $this->modelInformacaoQuerry($info);

        database::criarTabela($this->table_name, $info);
    }
    private function modelUserQuerry(array $queryInicial): string
    {
        $queryInicial[0] = '`' . $queryInicial[0] . '` int NOT NULL AUTO_INCREMENT';
        $queryInicial[1] = '`' . $queryInicial[1] . '` varchar(100) NOT NULL UNIQUE';
        $queryInicial[2] = '`' . $queryInicial[2] . '` varchar(100) NOT NULL';
        $queryInicial[3] = '`' . $queryInicial[3] . '` varchar(100)';
        $queryInicial[4] = '`' . $queryInicial[4] . '` varchar(100)';

        $queryInicial = implode(',', $queryInicial);
        $queryInicial .= ', PRIMARY KEY (`id`)';
        return $queryInicial;
    }

    private function modelInformacaoQuerry(array $queryInicial): string
    {
        $queryInicial[0] = '`' . $queryInicial[0] . '` int NOT NULL AUTO_INCREMENT';
        $queryInicial[1] = '`' . $queryInicial[1] . '` varchar(250) NOT NULL';
        $queryInicial[2] = '`' . $queryInicial[2] . '` DATETIME NOT NULL';
        $queryInicial[3] = '`' . $queryInicial[3] . '` int NOT NULL';

        $queryInicial = implode(',', $queryInicial);
        $queryInicial .= ', PRIMARY KEY (`id`), FOREIGN KEY (`quemCadastrou`) REFERENCES `tb_user`(`id`)';
    
        return $queryInicial;
    }
}
