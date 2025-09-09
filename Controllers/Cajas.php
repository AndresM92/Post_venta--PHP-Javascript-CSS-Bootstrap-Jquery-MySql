<?php

class Cajas extends Controller
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
        $id_usuario = $_SESSION["id_usuario"];
        $verificar = $this->model->checkPermiso($id_usuario, 'cajas');
        if (!empty($verificar) || $id_usuario == 16) {
            $this->views->getView($this, "index");
        } else {
            header('location:' . base_url . 'Errors/permisos');
        }
    }

    public function arqueo()
    {
        $data=$this->model->btnArqueo();
        $this->views->getView($this, "arqueo",$data);
    }

    public function abrirArqueo()
    {
        $monto_inicial = $_POST["monto_inicial"];
        $fecha_apertura = date("Y-m-d");
        $id_usuario = $_SESSION["id_usuario"];
        $id = $_POST["id"];

        if (empty($monto_inicial)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'info');
        } else {
            if ($id == "") {
                $data = $this->model->registrar_Arqueo($id_usuario, $monto_inicial, $fecha_apertura);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja abierta con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Caja ya esta abierta ', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al abrir la caja ', 'icono' => 'error');
                }
            } else {
                $monto_final = $this->model->getSales($id_usuario);
                $total_ventas = $this->model->get_all_Sales($id_usuario);
                $m_inicial = $this->model->getMonto_Inicial($id_usuario);
                $general = $monto_final["total"] + $m_inicial["monto_inicial"];
                $data = $this->model->update_Arqueo($monto_final["total"], $fecha_apertura, $total_ventas["total"], $general, $m_inicial["id"]);
                if ($data == "ok") {
                    $this->model->updateApertura($id_usuario);
                    $msg = array('msg' => 'Caja Cerrada con exito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'Error al cerrar la caja', 'icono' => 'warning');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function listar()
    {

        $btn_disabled_reingresar = 'disabled';
        $btn_disabled_eliminar = '';
        $data = $this->model->getBoxes('cajas');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $btn_disabled_reingresar = 'disabled';
                $btn_disabled_eliminar = '';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Inactivo</span>';
                $btn_disabled_reingresar = '';
                $btn_disabled_eliminar = 'disabled';
            }

            $data[$i]['acciones'] =
                '<div>
                <button class="btn btn-primary" type="button" onclick="btn_edit_Box(' . $data[$i]['id'] . ');"><i class= "fas fa-edit"></i></button>
                <button id="eliminar_' . $data[$i]['id'] . '" class="btn btn-danger" type="button" ' . $btn_disabled_eliminar . ' onclick="btn_delete_Box(' . $data[$i]['id'] . ');"><i class= "fas fa-trash-alt"></i></button>
                <button id="reingresar_' . $data[$i]['id'] . '"class="btn btn-success"  type="button" ' . $btn_disabled_reingresar . ' onclick="btn_reingre_Box(' . $data[$i]['id'] . ');"><i class= "fa-solid fa-arrow-up"></i></button>

             </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar_arqueo()
    {

        $btn_disabled_reingresar = 'disabled';
        $btn_disabled_eliminar = '';
        $data = $this->model->getBoxes('cierre_caja');
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Abierta</span>';
                $btn_disabled_reingresar = 'disabled';
                $btn_disabled_eliminar = '';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Cerrada</span>';
                $btn_disabled_reingresar = '';
                $btn_disabled_eliminar = 'disabled';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        $caja = $_POST["caja"];
        $id = $_POST["id"];

        if (empty($caja)) {
            $msg = array('msg' => 'Todos los campos son obligatorios', 'icono' => 'info');
        } else {
            if (empty($id)) {
                $data = $this->model->registrar_boxes($caja);
                if ($data == "ok") {
                    $msg = array('msg' => 'Caja registrada con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La Caja ya existe', 'icono' => 'info');
                } else {
                    $msg = array('msg' => 'Error al registrar la Caja', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modi_box($caja, $id);
                if ($data == "upda") {
                    $msg = array('msg' => 'Caja modificada con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar la Caja', 'icono' => 'error');
                }
            }
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar(int $id)
    {
        $data = $this->model->edit_box($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function eliminar(int $id)
    {

        $data = $this->model->delete_box($id, 0);
        if ($data == 1) {
            $msg = array('msg' => 'Caja eliminada con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar la Caja', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reingresar(int $id)
    {

        $data = $this->model->reingresar_box($id, 1);
        if ($data == 1) {
            $msg = array('msg' => 'Caja reingresada con exito', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al reingresar la Caja', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getVentas()
    {
        $id_usuario = $_SESSION["id_usuario"];
        $data["monto_total"] = $this->model->getSales($id_usuario);
        $data["total_ventas"] = $this->model->get_all_Sales($id_usuario);
        $data["inicial"] = $this->model->getMonto_Inicial($id_usuario);
        $data["monto_general"] = $data["monto_total"]["total"] + $data["inicial"]["monto_inicial"];
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        session_destroy();
        header("location:" . base_url);
    }
}
