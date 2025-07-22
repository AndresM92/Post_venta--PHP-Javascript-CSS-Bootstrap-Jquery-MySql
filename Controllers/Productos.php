<?php

class Productos extends Controller
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
        $data['medidas'] = $this->model->getMeasures();
        $data['categorias'] = $this->model->getCategories();
        $this->views->getView($this, "index", $data);
    }

    public function listar()
    {

        $btn_disabled = 'disabled';
        $btn_disabled_eliminar = '';
        $data = $this->model->getProductos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="'.base_url."Assets/img/".$data[$i]['foto'].'">';
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                $btn_disabled = 'disabled';
                $btn_disabled_eliminar = '';
            } else {
                $data[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                $btn_disabled = '';
                $btn_disabled_eliminar = 'disabled';
            }

            $data[$i]['acciones'] =
                '<div>
                <button class="btn btn-primary" type="button" onclick="btn_edit_Product(' . $data[$i]['id'] . ');"><i class= "fas fa-edit"></i></button>
                <button class="btn btn-danger" type="button"'. $btn_disabled_eliminar.' onclick="btn_delete_Product(' . $data[$i]['id'] . ');"><i class= "fas fa-trash-alt"></i></button>
                <button   id="reingresar_' . $data[$i]['id'] . '" class="btn btn-success"  type="button" ' . $btn_disabled . ' onclick="btn_reingre_Product(' . $data[$i]['id'] . ');"><i class= "fa-solid fa-arrow-up"></i></button>

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
        $codigo = $_POST["codigo"];
        $nombre = $_POST["nombre"];
        $precio_compra = $_POST["precio_compra"];
        $precio_venta = $_POST["precio_venta"];
        //$cantidad = $_POST["cantidad"];
        $id_medida = $_POST["medida"];
        $id_categoria = $_POST["categoria"];
        $img=$_FILES['imagen'];
        $name=$img['name'];
        $tmpname=$img['tmp_name'];
        $destino="Assets/img/".$name;
        $id = $_POST["id"];

        if(empty($name)){
            $name="default.jpg";
        }

        if (empty($codigo) || empty($nombre) || empty($precio_compra)||empty($precio_venta)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'info');
        } else {
            if (empty($id)){
                
                    $data = $this->model->registrar_producto($codigo, $nombre, $precio_compra, $precio_venta, $id_medida, $id_categoria,$name);
                    if ($data == "ok") {
                        $msg = array('msg' => 'Producto registrado con éxito', 'icono' => 'success');
                        move_uploaded_file($tmpname,$destino);
                    } else if ($data == "existe") {
                        $msg = array('msg' => 'El producto ya existe', 'icono' => 'info');
                    } else {
                        $msg = array('msg' => 'Error al registrar el producto', 'icono' => 'error');
                    }
                
            } else {
                $data = $this->model->modi_producto($codigo, $nombre, $precio_compra, $precio_venta, $id_medida, $id_categoria, $name,$id);
                if ($data == "upda") {
                    $msg = array('msg' => 'Producto modificado con éxito', 'icono' => 'success');
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
        $data = $this->model->edit_product($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {

        $data = $this->model->delete_product($id);
        if ($data == 1) {
            $msg = array('msg' => 'Producto eliminado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el Producto', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {

        $data = $this->model->reingresar_product($id, 1);
        if ($data == 1) {
            $msg = array('msg' => 'Producto reingresado con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar el Producto', 'icono' => 'error');
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
