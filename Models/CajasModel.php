<?php

class CajasModel extends Query
{
    private $caja, $id, $estado, $monto_inicial, $fecha_apertura;

    public function __construct()
    {
        parent::__construct();
    }

    public function getBoxes(string $table)
    {
        $sql = "SELECT * FROM $table";
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

    public function registrar_Arqueo(int $id_usuario, string $monto_inicial, string $fecha_apertura)
    {

        $this->monto_inicial = $monto_inicial;
        $this->fecha_apertura = $fecha_apertura;

        $verificar = "SELECT * FROM cierre_caja WHERE id_usuario=$id_usuario AND estado=1";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $sql = "INSERT INTO cierre_caja (id_usuario,monto_inicial,fecha_apertura) VALUES (?,?,?)";
            $datos = array($id_usuario, $monto_inicial, $fecha_apertura);
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
        $datos = array($this->caja, $this->id);
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
        $datos = array($this->estado, $this->id);
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

    public function getSales(int $id_usuario)
    {
        $sql = "SELECT total,SUM(total) AS total FROM ventas WHERE id_usuario=$id_usuario AND estado=1 AND apertura=1 GROUP BY total";
        $data = $this->select($sql);
        return $data;
    }

    public function get_all_Sales(int $id_usuario)
    {
        $sql = "SELECT COUNT(total) AS total FROM ventas WHERE id_usuario=$id_usuario AND estado=1 AND apertura=1 GROUP BY total";
        $data = $this->select($sql);
        return $data;
    }


    public function getMonto_Inicial(int $id_usuario)
    {
        $sql = "SELECT id,monto_inicial FROM cierre_caja WHERE id_usuario=$id_usuario AND estado=1";
        $data = $this->select($sql);
        return $data;
    }

    public function update_Arqueo(string $m_final, string $cierre, string $t_ventas, string $m_general, int $id)
    {

        $sql = "UPDATE cierre_caja SET monto_final=?,fecha_cierre=?,total_ventas=?,monto_total=?,estado=? WHERE id=?";
        $datos = array($m_final, $cierre, $t_ventas, $m_general, 0, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function updateApertura(int $id)
    {

        $sql = "UPDATE ventas SET apertura=? WHERE id_usuario=?";
        $datos = array(0, $id);
        $this->save($sql, $datos);
    }

    public function btnArqueo()
    {
        $sql = "SELECT estado FROM cierre_caja WHERE estado=1";
        $data = $this->select($sql);
        return $data;
    }

    public function checkPermiso(int $id_usuario, string $nombre)
    {

        $sql = "SELECT p.id,p.permiso, d.id,d.id_usuario,d.id_permiso 
              FROM permisos p 
              INNER JOIN detalle_permisos d
              ON p.id=d.id_permiso
              WHERE d.id_usuario=$id_usuario
              AND p.permiso='$nombre'";

        $data = $this->selectAll($sql);
        return $data;
    }
}
