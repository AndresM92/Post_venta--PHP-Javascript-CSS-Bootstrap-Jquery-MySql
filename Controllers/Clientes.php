<?php

class Clientes extends Controller
{

    public function __construct()
    {
        #$model = new UsuariosModel();
        session_start();

        if (empty($_SESSION["session_active"])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }

    public function index()
    {
        $id_usuario = $_SESSION["id_usuario"];
        $verificar = $this->model->checkPermiso($id_usuario, 'clientes');
        if (!empty($verificar) || $id_usuario == 16) {
            $this->views->getView($this, "index");
        } else {
            header('location:' . base_url . 'Errors/permisos');
        }
    }

    public function listar()
    {

        $btn_disabled_reingresar = 'disabled';
        $btn_disabled_eliminar = '';
        $data = $this->model->getCustomers();
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
                <button class="btn btn-primary" type="button" onclick="btn_edit_Customer(' . $data[$i]['id'] . ');"><i class= "fas fa-edit"></i></button>
                <button id="eliminar_' . $data[$i]['id'] . '" class="btn btn-danger" type="button" ' . $btn_disabled_eliminar . ' onclick="btn_delete_Customer(' . $data[$i]['id'] . ');"><i class= "fas fa-trash-alt"></i></button>
                <button id="reingresar_' . $data[$i]['id'] . '"class="btn btn-success"  type="button" ' . $btn_disabled_reingresar . ' onclick="btn_reingre_Customer(' . $data[$i]['id'] . ');"><i class= "fa-solid fa-arrow-up"></i></button>

             </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {

        $id_usuario = $_SESSION["id_usuario"];
        $verificar = $this->model->checkPermiso($id_usuario, 'registrar_clientes');
        if (!empty($verificar) || $id_usuario == 16) {
            $cc = $_POST["cc"];
            $nombre = $_POST["nombre"];
            $telefono = $_POST["telefono"];
            $direccion = $_POST["direccion"];
            $id = $_POST["id"];

            if (empty($nombre) || empty($cc) || empty($telefono) || empty($direccion)) {
                $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'info');
            } else {
                if (empty($id)) {
                    $data = $this->model->registrar_customers($cc, $nombre, $telefono, $direccion);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Cliente registrado con éxito', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El cliente ya existe', 'icono' => 'info');
                    } else {
                        $msg = array('msg' => 'Error al registrar el cliente', 'icono' => 'error');
                    }
                } else {
                    $data = $this->model->modi_customer($cc, $nombre, $telefono, $direccion, $id);
                    if ($data == "upda") {
                        $msg = array('msg' => 'Cliente modificado con éxito', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar el cliente', 'icono' => 'error');
                    }
                }
            }
        } else {
            $msg = array('msg' => 'No tienes permisos para registar clientes', 'icono' => 'warning');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->edit_customer($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {

        $data = $this->model->delete_customer($id, 0);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente eliminado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el usuario', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {

        $data = $this->model->reingresar_customer($id, 1);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente reingresado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el cliente', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        session_destroy();
        header("location:" . base_url);
    }
}
