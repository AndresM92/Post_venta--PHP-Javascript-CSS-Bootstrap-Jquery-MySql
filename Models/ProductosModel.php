<?php

class ProductosModel extends Query
{
    private $codigo, $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria,$id,$estado,$foto;

    public function __construct()
    {
        parent::__construct();
    }

    public function getMeasures()
    {
        $sql = "SELECT * FROM medidas WHERE estado=1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM categorias WHERE estado=1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getProductos()
    {
        $sql = "SELECT p.*, m.id AS id_medida, m.nombre AS medida, c.id AS id_cat, c.nombre AS categoria FROM productos p 
                INNER JOIN medidas m ON p.id_medida=m.id
                INNER JOIN categorias c ON p.id_categoria =c.id 
                ";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrar_producto(string $codigo, string $descripcion, string $precio_compra, string $precio_venta,int $id_medida, int $id_categoria,string $img)
    {

        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->foto = $img;

        $verificar = "SELECT * FROM productos WHERE codigo='$this->codigo'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO productos (codigo,descripcion,precio_compra,precio_venta,id_medida,id_categoria,foto) VALUES (?,?,?,?,?,?,?)";
            $datos = array($this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta,$this->id_medida,$this->id_categoria,$this->foto);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }

    public function modi_producto(string $codigo, string $descripcion, string $precio_compra, string $precio_venta,int $id_medida, int $id_categoria,string $img, int $id)
    {

        $this->codigo = $codigo;
        $this->descripcion = $descripcion;
        $this->precio_compra = $precio_compra;
        $this->precio_venta = $precio_venta;
        $this->id_medida = $id_medida;
        $this->id_categoria = $id_categoria;
        $this->foto = $img;
        $this->id=$id;

        $sql = "UPDATE productos SET codigo=?,descripcion=?,precio_compra=?,precio_venta=?,id_medida=?,id_categoria=?,foto=? WHERE id=?";
        $datos = array($this->codigo, $this->descripcion, $this->precio_compra, $this->precio_venta,$this->id_medida,$this->id_categoria,$this->foto, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "upda";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function edit_product(int $id)
    {
        $sql = "SELECT * FROM productos WHERE id='$id'";
        $data = $this->select($sql);
        return $data;
    }

    public function delete_product(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE productos SET estado=0 WHERE id=?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function reingresar_product(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE productos SET estado=? WHERE id=?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
