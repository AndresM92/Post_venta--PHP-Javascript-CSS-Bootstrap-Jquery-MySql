<?php

class MedidasModel extends Query
{
    private $nombre,$id,$estado,$nombre_corto;

    public function __construct()
    {
        parent::__construct();
    }

    public function getMeasures()
    {
        $sql = "SELECT * FROM medidas";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrar_measures(string $nombre,string $nombre_corto)
    {

        $this->nombre = $nombre;
        $this->nombre_corto = $nombre_corto;
        $verificar = "SELECT * FROM medidas WHERE nombre='$this->nombre'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO medidas (nombre,nombre_corto) VALUES (?,?)";
            $datos = array($this->nombre,$this->nombre_corto);
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

    public function modi_measure(string $nombre, string $nombre_corto, int $id)
    {
        $this->nombre=$nombre;
        $this->nombre_corto = $nombre_corto;
        $this->id = $id;

        $sql = "UPDATE medidas SET nombre=?, nombre_corto=? WHERE id=?";
        $datos = array($this->nombre,$this->nombre_corto,$this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "upda";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function edit_measure(int $id)
    {
        $sql = "SELECT * FROM medidas WHERE id='$id'";
        $data = $this->select($sql);
        return $data;
    }

    public function delete_measure(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "DELETE FROM medidas WHERE id=?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

   /* public function reingresar_box(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE cajas SET estado=? WHERE id=?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    } */
}
