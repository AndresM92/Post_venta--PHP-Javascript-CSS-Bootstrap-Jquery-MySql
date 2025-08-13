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
        $id_usuario=$_SESSION["id_usuario"];
        $verificar=$this->model->checkPermiso($id_usuario,'configuracion');
        if (!empty($verificar) || $id_usuario==16) {
            $data=$this->model->getEmpresa();
            $this->views->getView($this,"index",$data);
        }else{
            header('location:'.base_url.'Errors/permisos');
        }
        $data = $this->model->getEmpresa();
        $this->views->getView($this, "index", $data);
    }

    public function home()
    {
        $data["usuarios"] = $this->model->getData("usuarios");
        $data["clientes"] = $this->model->getData("clientes");
        $data["productos"] = $this->model->getData("productos");
        $data["ventas"] = $this->model->getSales("ventas");
        $this->views->getView($this, "home", $data);
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

    public function reportStock()
    {

        $data = $this->model->getStockMin();
        echo json_encode($data);
        die();
    }

    public function reportProVentas()
    {
        $data = $this->model->getMSales();
        echo json_encode($data);
        die();
    }
}
