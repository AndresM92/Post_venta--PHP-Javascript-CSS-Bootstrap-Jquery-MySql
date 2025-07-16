<?php

class CajasModel extends Query
{
    private $caja,$id,$estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getBoxes()
    {
        $sql = "SELECT * FROM cajas";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrar_boxes(string $caja)
    {

        $this->caja = $caja;
        $verificar = "SELECT * FROM cajas WHERE caja='$this->caja'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO cajas (caja) VALUES (?)";
            $datos = array($this->caja);
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

    public function modi_box(string $caja, int $id)
    {

        $this->caja = $caja;
        $this->id = $id;

        $sql = "UPDATE cajas SET caja=? WHERE id=?";
        $datos = array($this->caja,$this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "upda";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function edit_box(int $id)
    {
        $sql = "SELECT * FROM cajas WHERE id='$id'";
        $data = $this->select($sql);
        return $data;
    }

    public function delete_box(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE cajas SET estado=? WHERE id=?";
        $datos = array($this->estado,$this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function reingresar_box(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE cajas SET estado=? WHERE id=?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
