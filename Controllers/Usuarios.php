<?php

class Usuarios extends Controller
{

    public function __construct()
    {
        #$model = new UsuariosModel();
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $data['cajas'] = $this->model->getCajas();
        $this->views->getView($this, "index", $data);
        #$model = new UsuariosModel();
        #print_r($model->getUsuario());

    }

    public function listar()
    {

        $btn_disabled = 'disabled';
        //print_r($this->model->getUsuarios());
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $btn_disabled = 'disabled';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $btn_disabled = '';
            }

            $data[$i]['acciones'] =
                '<div>
                <button class="btn btn-primary" type="button" onclick="btn_edit_User(' . $data[$i]['id'] . ');"><i class= "fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button" onclick="btn_delete_User(' . $data[$i]['id'] . ');"><i class= "fas fa-trash-alt"></i></button>

                
                <button   id="reingresar_' . $data[$i]['id'] . '" class="btn btn-success"  type="button" '.$btn_disabled.' onclick="btn_reingre_User(' . $data[$i]['id'] . ');"><i class= "fa-solid fa-arrow-up"></i></button>

             </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function validar()
    {
        if (empty($_POST['usuario']) || empty($_POST["clave"])) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'error');
        } else {
            $usuario = $_POST["usuario"];
            $pass = $_POST["clave"];
            $hash=hash("SHA256",$pass);
            $data = $this->model->getUsuario($usuario, $hash);
            if ($data) {
                $_SESSION["id_usuario"] = $data["id"];
                $_SESSION["usuario"] = $data["usuario"];
                $_SESSION["nombre"] = $data["nombre"];
                $msg = array('msg' => 'Iniciando sesion', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'No se pudo iniciar sesion', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $usuario = $_POST["usuario"];
        $nombre = $_POST["nombre"];
        $pass = $_POST["pass"];
        $confirmar = $_POST["confirmar"];
        $caja = $_POST["caja"];
        $id = $_POST["id"];
        $hash = hash("SHA256", $pass);

        if (empty($usuario) || empty($nombre) || empty($caja)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'info');
            //$msg = "Todos los campos son obligatorios";
        } else {
            if (empty($id)) {
                if ($pass != $confirmar) {
                    $msg = array('msg' => 'Las contraseñas no son iguales', 'icono' => 'error');
                    //$msg = "Las contraseñas no coinciden";
                } else {
                    $data = $this->model->registrar_usuario($usuario, $nombre, $hash, $caja);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Cliente registrado con éxito', 'icono' => 'success');
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El usuario ya existe', 'icono' => 'info');
                    } else {
                        $msg = array('msg' => 'Error al registrar el usuario', 'icono' => 'error');
                    }
                }
            } else {
                $data = $this->model->modi_user($usuario, $nombre, $caja, $id);
                //print_r($data);
                if ($data == "upda") {
                    $msg = array('msg' => 'Usuario modificado con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar el usuario', 'icono' => 'error');
                }
            }
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->edit_user($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {

        $data = $this->model->delete_user($id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario eliminado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el usuario', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {

        $data = $this->model->reingresar_user($id,1);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario reingresado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el usuario', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
