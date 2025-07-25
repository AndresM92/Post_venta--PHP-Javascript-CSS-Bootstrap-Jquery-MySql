<?php

class ComprasModel extends Query
{
    private $nombre,$id,$estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProCod(string $cod){

        $sql="SELECT * FROM productos WHERE codigo='$cod' ";
        $data= $this->select($sql);
        return $data;

    }
}
