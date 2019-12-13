<?php

class QueryBuilder{

    protected $pdo;

    public function __construct($pdo){
        
        $this->pdo = $pdo;
    }

    public function select($sql){

        $statement = $this->pdo->prepare($sql['sql']);
        if(isset($sql['bind_sql'])){
            $statement->execute($sql['bind_sql']);
        }else{
            $statement->execute();  
        }
        return $statement->fetchAll(PDO::FETCH_CLASS);

    }

    public function insert($sql){
       
        try{
            $statement = $this->pdo->prepare($sql['sql']);
            $statement->execute($sql['bind_sql']);
            return $this->pdo->lastInsertId();
        }catch(Exception $e){
            die('Houve algum problema na inclusão dessa informação');
        }

    }

    public function dml($sql){

        try{
            $statement = $this->pdo->prepare($sql['sql']);
            $statement->execute($sql['bind_sql']);
        }catch(Exception $e){
            die('Houve algum problema na exclusão/alteração dessa informação');
        }

    }

}

?>