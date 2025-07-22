<?php

class Categorias extends Controller
{

    public function __construct()
    {
        session_start();

        if(empty($_SESSION["session_active"])){
            header("location: ".base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        
        $this->views->getView($this, "index");

    }

    public function listar()
    {

        $btn_disabled_reingresar = 'disabled';
        $btn_disabled_eliminar = '';
        $data = $this->model->getCategories();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $btn_disabled_reingresar = 'disabled';
                $btn_disabled_eliminar = '';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $btn_disabled_reingresar = '';
                $btn_disabled_eliminar = 'disabled';
            }

            $data[$i]['acciones'] =
                '<div>
                <button class="btn btn-primary" type="button" onclick="btn_edit_Category(' . $data[$i]['id'] . ');"><i class= "fas fa-edit"></i></button>
                <button id="eliminar_' . $data[$i]['id'] . '" class="btn btn-danger" type="button" '.$btn_disabled_eliminar.' onclick="btn_delete_Category(' . $data[$i]['id'] . ');"><i class= "fas fa-trash-alt"></i></button>
             </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $nombre = $_POST["nombre"];
        $id = $_POST["id"];

        if (empty($nombre)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'info');
        } else {
            if (empty($id)){
                    $data = $this->model->registrar_categories($nombre);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Categoria registrado con éxito', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'La Categoria ya existe', 'icono' => 'info');
                    } else {
                        $msg = array('msg' => 'Error al registrar la Categoria', 'icono' => 'error');
                    }
            } else {
                $data = $this->model->modi_category($nombre,$id);
                if ($data == "upda") {
                    $msg = array('msg' => 'Categoria modificado con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Categoria', 'icono' => 'error');
                }
            }
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->edit_category($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {

        $data = $this->model->delete_category($id,0);
        if ($data == 1) {
            $msg = array('msg' => 'Categoria eliminada con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar la Categoria', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

   /* public function reingresar(int $id)
    {

        $data = $this->model->reingresar_category($id,1);
        if ($data == 1) {
            $msg = array('msg' => 'Categoria reingresado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar la Categoria', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }*/

    public function salir (){
        session_destroy();
        header("location:".base_url);
    }
}
