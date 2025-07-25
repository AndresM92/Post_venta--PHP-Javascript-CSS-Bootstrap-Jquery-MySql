<?php

class ComprasModel extends Query
{
    private $nombre, $id, $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getProCod(string $cod)
    {

        $sql = "SELECT * FROM productos WHERE codigo='$cod' ";
        $data = $this->select($sql);
        return $data;
    }

    public function getPro(int $id)
    {

        $sql = "SELECT * FROM productos WHERE id= $id ";
        $data = $this->select($sql);
        return $data;
    }

    public function addDetalils(int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {

        $sql = "INSERT INTO detalle (id_producto, id_usuario, precio, cantidad, sub_total) VALUES(?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getDetails(int $id)
    {

        $sql = "SELECT d.*, p.id AS id_pro,p.descripcion FROM detalle d 
                INNER JOIN productos p 
                ON d.id_producto=p.id WHERE d.id_usuario= $id ";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function calBuy(int $id_usuario)
    {

        $sql = "SELECT SUM(sub_total) AS total FROM detalle WHERE id_usuario=$id_usuario";
        $data = $this->select($sql);
        return $data;
    }

    public function deleteDetail(int $id)
    {

        $sql = "DELETE FROM detalle WHERE id=?";
        $delete=array($id);
        $data = $this->save($sql,$delete);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }
}
