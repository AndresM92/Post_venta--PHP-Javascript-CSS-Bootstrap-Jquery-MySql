<?php

class Administracion extends Controller
{
    public function __construct()
    {

        session_start();

        if (empty($_SESSION["session_active"])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        $data = $this->model->getEmpresa();
        $this->views->getView($this, "index", $data);
    }

    public function modificar()
    {

        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $direccion = $_POST["direccion"];
        $mensaje = $_POST["mensaje"];
        $id = $_POST["id"];

        $data = $this->model->modificar($nombre, $telefono, $direccion, $mensaje, $id);
        if ($data == "ok") {
            $msg = array('msg' => 'Datos de la empresa modificados con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al modificar los datos de la empresa', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
