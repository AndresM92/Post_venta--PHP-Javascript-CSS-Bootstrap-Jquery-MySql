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

    public function getCustomers()
    {
        $sql = "SELECT * FROM clientes WHERE estado=1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getPro(int $id)
    {

        $sql = "SELECT * FROM productos WHERE id= $id ";
        $data = $this->select($sql);
        return $data;
    }

    public function consultDetails(string $table, int $id_producto, int $id_usuario)
    {
        $sql = "SELECT * FROM $table WHERE id_producto= $id_producto AND id_usuario=$id_usuario";
        $data = $this->select($sql);
        return $data;
    }

    public function addDetalils(string $table, int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {

        $sql = "INSERT INTO $table (id_producto, id_usuario, precio, cantidad, sub_total) VALUES(?,?,?,?,?)";
        $datos = array($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }




    public function getDetails(string $table, int $id)
    {

        $sql = "SELECT d.*, p.id AS id_pro,p.descripcion FROM $table d 
                INNER JOIN productos p 
                ON d.id_producto=p.id WHERE d.id_usuario= $id ";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function calBuy_Sale(string $tabla, int $id_usuario)
    {

        $sql = "SELECT SUM(sub_total) AS total FROM $tabla WHERE id_usuario=$id_usuario";
        $data = $this->select($sql);
        return $data;
    }

    public function deleteDetail(string $tabla, int $id)
    {

        $sql = "DELETE FROM $tabla WHERE id=?";
        $delete = array($id);
        $data = $this->save($sql, $delete);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function updateDetails(string $table, int $id_producto, int $id_usuario, string $precio, int $cantidad, string $sub_total)
    {

        $sql = "UPDATE detalle SET precio=? , cantidad=?, sub_total=? WHERE id_producto=? AND id_usuario=?";
        $datos = array($precio, $cantidad, $sub_total, $id_producto, $id_usuario);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function r_buy(string $total)
    {

        $sql = "INSERT INTO compras (total) VALUES(?)";
        $datos = array($total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function r_sale(int $id_cliente, string $total)
    {

        $sql = "INSERT INTO ventas (id_cliente,total) VALUES(?,?)";
        $datos = array($id_cliente, $total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getId(string $tabla)
    {

        $sql = "SELECT MAX(id) AS id FROM $tabla";
        $data = $this->select($sql);
        return $data;
    }

    public function register_details_purchase(int $id_compra, int $id_producto, int $cantidad, string $precio, string $sub_total)
    {

        $sql = "INSERT INTO detalle_compras (id_compra,id_producto,cantidad,precio,sub_total) VALUES(?,?,?,?,?)";
        $datos = array($id_compra, $id_producto, $cantidad, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function register_details_sale(int $id_venta, int $id_producto, int $cantidad, string $precio, string $sub_total)
    {

        $sql = "INSERT INTO detalle_ventas (id_venta,id_producto,cantidad,precio,sub_total) VALUES(?,?,?,?,?)";
        $datos = array($id_venta, $id_producto, $cantidad, $precio, $sub_total);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }

    public function emptyDetails(string $tabla, int $id_usuario)
    {
        $sql = "DELETE FROM $tabla WHERE id_usuario=?";
        $delete = array($id_usuario);
        $data = $this->save($sql, $delete);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function getProBuy(int $id_compra)
    {
        $sql = "SELECT c.*,d.*,p.id,p.descripcion 
        FROM compras c
        INNER JOIN detalle_compras d 
        ON c.id=d.id_compra
        INNER JOIN productos p 
        ON p.id=d.id_producto
        WHERE c.id=$id_compra";

        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProsale(int $id_venta)
    {
        $sql = "SELECT v.*,d.*,p.id,p.descripcion
        FROM ventas v
        INNER JOIN detalle_ventas d 
        ON v.id=d.id_venta
        INNER JOIN productos p 
        ON p.id=d.id_producto 
        WHERE v.id=$id_venta";

        $data = $this->selectAll($sql);
        return $data;
    }

    public function gethistBuys()
    {
        $sql = "SELECT * FROM compras";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function customers_Sale(int $id)
    {
        $sql = "SELECT v.id, v.id_cliente, c.* FROM ventas v
        INNER JOIN clientes c 
        ON c.id= v.id_cliente
        WHERE v.id=$id";
        $data = $this->select($sql);
        return $data;
    }
    public function updateStock(int $cantidad, int $id_producto)
    {
        $sql = "UPDATE productos SET cantidad=? WHERE id=?";
        $datos = array($cantidad, $id_producto);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
