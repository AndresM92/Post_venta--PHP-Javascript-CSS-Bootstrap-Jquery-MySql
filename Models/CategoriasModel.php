<?php

class CategoriasModel extends Query
{
    private $nombre,$id,$estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM categorias";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrar_categories(string $nombre)
    {

        $this->nombre = $nombre;
        $verificar = "SELECT * FROM categorias WHERE nombre='$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO categorias (nombre) VALUES (?)";
            $datos = array($this->nombre);
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

    public function modi_category(string $nombre, int $id)
    {

        $this->nombre = $nombre;
        $this->id = $id;

        $sql = "UPDATE categorias SET nombre=? WHERE id=?";
        $datos = array($this->nombre,$this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "upda";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function edit_category(int $id)
    {
        $sql = "SELECT * FROM categorias WHERE id='$id'";
        $data = $this->select($sql);
        return $data;
    }

    public function delete_category(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "DELETE FROM categorias WHERE id=?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function reingresar_category(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE categorias SET estado=? WHERE id=?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
