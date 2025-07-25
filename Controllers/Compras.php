<?php

class Compras extends Controller
{

    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {

        $this->views->getView($this, "index");
    }

    public function buscarCodigo($cod)
    {

        $data = $this->model->getProCod($cod);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ingresar()
    {

        $id = $_POST["id"];
        $data = $this->model->getPro($id);
        $id_producto = $data['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $data['precio_compra'];
        $cantidad = $_POST['cantidad'];
        $sub_total = $precio * $cantidad;
        $data2 = $this->model->addDetalils($id_producto, $id_usuario, $precio, $cantidad, $sub_total);

        if ($data2 == "ok") {
            $msg = array('msg' => 'El producto fue ingresado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al ingresar el producto', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar()
    {
        $id_usuario = $_SESSION["id_usuario"];
        $data["detalle"] = $this->model->getDetails($id_usuario);
        $data["total_pagar"] = $this->model->calBuy($id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {

        $data = $this->model->deleteDetail($id);
        if ($data == "ok") {
            $msg = array('msg' => 'El producto fue eliminado de la lista', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el producto', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
