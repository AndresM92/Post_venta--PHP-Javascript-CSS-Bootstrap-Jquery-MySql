<?php

class Query extends Conexion
{
    public $pdo, $con, $sql,$datos;
    protected $query;

    public function __construct()
    {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
    }

    public function select(string $sql)
    {
        //$this->sql = $sql;
        $query = $this->con->prepare($sql);
        $query->execute();
        $data= $query->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

        public function selectAll(string $sql)
    {
        //$this->sql = $sql;
        $query = $this->con->prepare($sql);
        $query->execute();
        $data= $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function save(string $sql,array $datos) {
        $this->sql=$sql;
        $this-> datos=$datos;
        $insert=$this->con->prepare($this->sql);
        $data= $insert->execute($this->datos);

        if ($data){
            $res=1;

        }else{
            $res=0;
        }
        return $res;
    }
}
