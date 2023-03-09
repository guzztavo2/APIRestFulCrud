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
    public static function buscar($table_name, array $query = null, string $class = null):array{
        $pdo = self::conectar()->prepare("SELECT * FROM `$table_name` $query[0]");
       
        $pdo->execute($query[1]);
        if($class !== null)
            return($pdo->fetchAll(PDO::FETCH_CLASS, $class));
        
        return $pdo->fetchAll();
        
    
    }
    public static function retrieveDataPage(string $table_name, int $limit, int $offset, string $classname){
        $pdo = dataBase::conectar()->prepare("SELECT * FROM `$table_name` LIMIT ? OFFSET ?");
        $pdo->bindParam(1, $limit, \PDO::PARAM_INT);
        $pdo->bindParam(2, $offset, \PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetchAll(pdo::FETCH_CLASS, $classname);
    }
    public static function retrieveAllData($table_name, string $class = null){
        $pdo = self::conectar()->prepare("SELECT * FROM `$table_name`");
        $pdo->execute();
        if($class !== null)
            return $pdo->fetchAll(PDO::FETCH_CLASS,$class);
        return $pdo->fetchAll();
    }
    public static function update($table_name, array $query){
        $pdo = self::conectar()->prepare("UPDATE `$table_name` SET $query[0]");
        $pdo->execute($query[1]);
    }
    public static function delete($table_name, array $query){
        $pdo = self::conectar()->prepare("DELETE FROM `$table_name` WHERE $query[0]");
        $pdo->execute($query[1]);
    }
}
