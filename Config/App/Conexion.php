<?php

class Conexion
{
    private $connect;

    public function __construct()
    {
        $pdo = "mysql:host=".host.";dbname=".db.";.charset.";
        
        try {
            #$this-> $connect= mysqli_connect('localhost', 'root', 'root', 'pos_venta');
            $this->connect = new PDO($pdo, user, pass);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro en la conexion" . $e->getMessage());
        }

        #mysqli_connect('localhost', 'root', 'root', 'pos_venta');
    }

    public function conect() {
        return $this->connect;
    }
}
