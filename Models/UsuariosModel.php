<?php

class UsuariosModel extends Query
{
    private $usuario, $nombre, $pass, $id_caja, $id, $estado;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuario(string $usuario, string $pass)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'AND pass='$pass'";
        $data = $this->select($sql);
        return $data;
    }

    public function getCajas()
    {
        $sql = "SELECT * FROM cajas WHERE estado=1";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getUsuarios()
    {
        //$sql="SELECT * FROM usuarios";
        $sql = "SELECT u.*, c.id as id_caja ,c.caja FROM usuarios u INNER JOIN cajas c WHERE u.id_caja=c.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrar_usuario(string $usuario, string $nombre, string $pass, int $id_caja)
    {

        $this->usuario = $usuario;
        $verificar = "SELECT * FROM usuarios WHERE usuario='$this->usuario'";
        $existe = $this->select($verificar);
        if (empty($existe)) {
            $this->nombre = $nombre;
            $this->pass = $pass;
            $this->id_caja = $id_caja;
            $sql = "INSERT INTO usuarios (usuario,nombre,pass,id_caja) VALUES (?,?,?,?)";
            $datos = array($this->usuario, $this->nombre, $this->pass, $this->id_caja);
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

    public function modi_user(string $usuario, string $nombre, int $id_caja, int $id)
    {

        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->id = $id;
        $this->id_caja = $id_caja;

        $sql = "UPDATE usuarios SET usuario=?,nombre=?,id_caja=? WHERE id=?";
        $datos = array($this->usuario, $this->nombre, $this->id_caja, $this->id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "upda";
        } else {
            $res = "error";
        }
        return $res;
    }

    public function edit_user(int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id=$id";
        $data = $this->select($sql);
        return $data;
    }

    public function getPass(string $pass,int $id)
    {
        $sql = "SELECT * FROM usuarios WHERE pass='$pass' AND id=$id";
        $data = $this->select($sql);
        return $data;
    }

    public function delete_user(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE usuarios SET estado=0 WHERE id=?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function reingresar_user(int $id, int $estado)
    {
        $this->id = $id;
        $this->estado = $estado;
        $sql = "UPDATE usuarios SET estado=? WHERE id=?";
        $datos = array($this->estado, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    public function modificarPass(string $pass, int $id)
    {
        $this->id = $id;
        $sql = "UPDATE usuarios SET pass=? WHERE id=?";
        $datos = array($pass, $this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
}
