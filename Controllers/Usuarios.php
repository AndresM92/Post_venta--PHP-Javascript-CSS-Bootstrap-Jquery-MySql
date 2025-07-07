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


        //print_r($this->model->getUsuarios());
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
            }
            $data[$i]['acciones'] =
                '<div>
                <button class="btn btn-primary" type="button" onclick="btn_edit_User(' . $data[$i]['id'] . ');">Editar</button>
                <button class="btn btn-danger" type="button" onclick="btn_delete_User();">Eliminar</button>
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
            $clave = $_POST["clave"];
            $data = $this->model->getUsuario($usuario, $clave);
            if ($data) {
                $_SESSION["id_usuario"] = $data["id"];
                $_SESSION["usuario"] = $data["usuario"];
                $_SESSION["nombre"] = $data["nombre"];
                $msg = array('msg' => 'Iniciando sesion', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Iniciando sesion', 'icono' => 'error');
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
        $hash= hash("SHA256",$pass);

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
}
