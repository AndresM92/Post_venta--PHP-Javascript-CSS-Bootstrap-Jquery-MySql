<?php

class ClientesModel extends Query
{
    private $CC, $nombre, $telefono, $direccion, $id,$estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomers()
    {
        $sql = "SELECT * FROM clientes";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrar_customers(string $CC, string $nombre, string $telefono, string $direccion)
    {

        $this->CC = $CC;
        $verificar = "SELECT * FROM clientes WHERE CC='$this->CC'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $this->nombre = $nombre;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $sql = "INSERT INTO clientes (CC,nombre,telefono,direccion) VALUES (?,?,?,?)";
            $datos = array($this->CC, $this->nombre, $this->telefono, $this->direccion);
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

    public function modi_customer(string $CC, string $nombre,string $telefono ,string $direccion, int $id)
    {

        $this->CC = $CC;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->telefono = $telefono;
        $this->direccion = $direccion;

        $sql = "UPDATE clientes SET CC=?,nombre=?,telefono=?,direccion=? WHERE id=?";
        $datos = array($this->CC, $this->nombre, $this->telefono, $this->direccion, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "upda";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function edit_customer(int $id)
    {
        $sql = "SELECT * FROM clientes WHERE id='$id'";
        $data = $this->select($sql);
        return $data;
    }

    public function delete_customer(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE clientes SET estado=? WHERE id=?";
        $datos = array($this->estado,$this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function reingresar_customer(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE clientes SET estado=? WHERE id=?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
