<?php

namespace Models;

use PDO;

class dataBase
{

    private static PDO $pdo;


    public static function conectar()
    {
        if (isset(self::$pdo))
            return self::$pdo;

        self::$pdo = new PDO('mysql:host=' . DATABASE_CONFIGS['HOST'] . ';dbname=' . DATABASE_CONFIGS['DB_NAME'] . '', DATABASE_CONFIGS['USERNAME'], DATABASE_CONFIGS['PASSWORD']);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$pdo;
    }

    public static function criarTabela($nomeTabela, string $columnData){
        $pdo = database::conectar()->prepare('CREATE TABLE IF NOT EXISTS `'.$nomeTabela.'`('.$columnData.');');
        $pdo->execute();
    }
    public static function insertData($table_name, array $keysAndValues):bool{
        $keys = array_keys($keysAndValues);
        $values = array_values($keysAndValues);
        $pdoAttr = array_map(function($item){
           return "?";
           
        },$values);
        $pdo = self::conectar()->prepare("INSERT INTO `".$table_name."` (".implode(',',$keys).") VALUES (".implode(',',$pdoAttr).")");
       
        if($pdo->execute($values))
            return true;
        return false;
    
    }
    public static function buscar($table_name, array $query, string $class = null):false|user{
        $pdo = self::conectar()->prepare("SELECT * FROM `$table_name` $query[0]");
        $pdo->execute($query[1]);
        if($class !== null){
            $pdo->setFetchMode(PDO::FETCH_CLASS, $class);
            return($pdo->fetch(PDO::FETCH_CLASS));
        }
        
    
    }
    public static function update($table_name, array $query){
        $pdo = self::conectar()->prepare("UPDATE `$table_name` SET $query[0]");
        $pdo->execute($query[1]);
    }
}
