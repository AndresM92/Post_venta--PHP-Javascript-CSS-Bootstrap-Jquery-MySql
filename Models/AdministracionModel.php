<?php

class AdministracionModel extends Query
{
    private $caja, $id, $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }

    public function getData(string $table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table";
        $data = $this->select($sql);
        return $data;
    }

    public function getSales()
    {
        $sql = "SELECT COUNT(*) AS total FROM ventas WHERE fecha > CURDATE()";
        $data = $this->select($sql);
        return $data;
    }

    public function modificar(string $nombre, string $telefono, string $direccion, string $mensaje, int $id)
    {
        $sql = "UPDATE configuracion SET nombre=?, telefono=?, direccion=?, mensaje=? WHERE id=?";
        $datos = array($nombre, $telefono, $direccion, $mensaje, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getStockMin()
    {
        $sql = "SELECT * FROM productos WHERE cantidad >8 ORDER BY cantidad DESC LIMIT 2";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getMSales()
    {
        $sql = "SELECT d.id_producto,d.cantidad,p.id,p.descripcion, SUM(d.cantidad) AS total 
        FROM detalle_ventas d
        INNER JOIN productos p 
        ON p.id=d.id_producto GROUP BY d.id_producto, d.cantidad ORDER BY d.cantidad DESC LIMIT 2";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function checkPermiso(int $id_usuario, string $nombre){

        $sql="SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso 
              FROM permisos p 
              INNER JOIN detalle_permisos d
              ON p.id=d.id_permiso
              WHERE d.id_usuario=$id_usuario
              AND p.permiso='$nombre'";

        $data=$this->selectAll($sql);
        return $data;
    }
}
