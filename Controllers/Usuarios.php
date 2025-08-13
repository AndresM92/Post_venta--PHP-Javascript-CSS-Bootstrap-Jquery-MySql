<?php

class Usuarios extends Controller
{

    public function __construct()
    {
        session_start();
        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION["session_active"])) {
            header("location: " . base_url);
        }

        $id_usuario = $_SESSION["id_usuario"];
        $verificar = $this->model->checkPermiso($id_usuario, 'usuarios');
        if (!empty($verificar) || $id_usuario == 16) {
            $data['cajas'] = $this->model->getCajas();
            $this->views->getView($this, "index", $data);
        } else {
            header('location:' . base_url . 'Errors/permisos');
        }
    }

    public function listar()
    {

        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';

                if ($data[$i]['id'] == 16) {
                    $data[$i]['acciones'] = '<div>
                        <span class="badge bg-primary">Administrador</span>
                    </div>';
                } else {
                    $data[$i]['acciones'] =
                        '<div>
                    <a class="btn btn-dark" href="' . base_url . 'Usuarios/permisos/' . $data[$i]['id'] . '"><i class= "fas fa-key"></i></a>
                    <button class="btn btn-primary" type="button" onclick="btn_edit_User(' . $data[$i]['id'] . ');"><i class= "fas fa-edit"></i></button>
                    <button class="btn btn-danger" type="button" onclick="btn_delete_User(' . $data[$i]['id'] . ');"><i class= "fas fa-trash-alt"></i></button>
                </div>';
                }
            } else {
                $data[$i]['estado'] = '<div><span class="badge bg-danger">Inactivo</span></div>';
                $data[$i]['acciones'] = '<div>
                 <button id="reingresar_' . $data[$i]['id'] . '" class="btn btn-success"  type="button"  onclick="btn_reingre_User(' . $data[$i]['id'] . ');"><i class= "fa-solid fa-arrow-up"></i></button>
                 </div>';
            }
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
            $hash = hash("SHA256", $pass);
            $data = $this->model->getUsuario($usuario, $hash);
            if ($data) {
                $_SESSION["id_usuario"] = $data["id"];
                $_SESSION["usuario"] = $data["usuario"];
                $_SESSION["nombre"] = $data["nombre"];
                $_SESSION["session_active"] = true;
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

        $data = $this->model->reingresar_user($id, 1);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario reingresado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el usuario', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function cambiarPass()
    {

        $actual = $_POST["clave_actual"];
        $nueva = $_POST["clave_nueva"];
        $confirmar = $_POST["confirmar_clave"];

        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($nueva != $confirmar) {
                $msg = array('msg' => 'Las contraseñas no coinciden', 'icono' => 'warning');
            } else {
                $id = $_SESSION["id_usuario"];
                $hash = hash("SHA256", $actual);
                $data = $this->model->getPass($hash, $id);

                if (!empty($data)) {

                    $check = $this->model->modificarPass(hash("SHA256", $nueva), $id);
                    if ($check == 1) {
                        $msg = array('msg' => 'Contraseña modificada con exito', 'icono' => 'success');
                    } else {
                        $msg = array('msg' => 'Error al modificar la contraseña', 'icono' => 'error');
                    }
                } else {
                    $msg = array('msg' => 'Error al modificar la contraseña', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function permisos($id)
    {
        if (empty($_SESSION["session_active"])) {
            header("location: " . base_url);
        }
        $data['datos'] = $this->model->getPermisos();
        $permisos = $this->model->getDetallePermisos($id);
        $data['asigandos'] = array();

        foreach ($permisos as $p) {
            $data['asignados'][$p['id_permiso']] = true;
        }

        $data['id_usuario'] = $id;
        $this->views->getView($this, "permisos", $data);
    }

    public function registrarPermisos()
    {
        $msg = '';
        $id_usuario = $_POST['id_usuario'];
        $delete = $this->model->deletePermisos($id_usuario);
        if ($delete == 'ok') {
            foreach ($_POST['permisos'] as $id_permiso) {
                $msg = $this->model->registrarPermisos($id_usuario, $id_permiso);
            }
            if ($msg == 'ok') {
                $msg = array('msg' => 'Permisos Asignados', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al asignar los permisos', 'icono' => 'error');
            }
        } else {
            $msg = array('msg' => 'Error al eliminar los permisos anteriores', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    }

    public function salir()
    {
        session_destroy();
        header("location:" . base_url);
    }
}
