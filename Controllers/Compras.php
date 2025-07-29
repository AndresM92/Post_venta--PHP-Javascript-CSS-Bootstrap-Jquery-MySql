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
        $check_detail = $this->model->consultDetails($id_producto, $id_usuario);

        if (empty($check_detail)) {
            $sub_total = $precio * $cantidad;
            $data2 = $this->model->addDetalils($id_producto, $id_usuario, $precio, $cantidad, $sub_total);

            if ($data2 == "ok") {
                $msg = array('msg' => 'El producto fue ingresado con exito', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al ingresar el producto', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            $total_cantidad = $check_detail["cantidad"] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            $data2 = $this->model->updateDetails($id_producto, $id_usuario, $precio, $total_cantidad, $sub_total);

            if ($data2 == "modificado") {
                $msg = array('msg' => 'Se agrego la cantidad adicional', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al agregar la cantidad', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
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

    public function registrarCompra()
    {
        $id_usuario = $_SESSION["id_usuario"];
        $total = $this->model->calBuy($id_usuario);
        $data = $this->model->r_buy($total["total"]);
        if ($data == "ok") {

            $id_compra = $this->model->id_compra();
            $details = $this->model->getDetails($id_usuario);
            foreach ($details as $row) {
                $cantidad = $row["cantidad"];
                $precio = $row["precio"];
                $id_producto = $row["id_producto"];
                $sub_total = $cantidad * $precio;
                $this->model->register_details_purchase($id_compra["id"], $id_producto, $cantidad, $precio, $sub_total);
                $stock_actual=$this->model->getPro($id_producto);
                $stock=$stock_actual["cantidad"] + $cantidad;
                $this->model->updateStock($stock,$id_producto);
            }
            $empty_details = $this->model->emptyDetails($id_usuario);
            if ($empty_details == 'ok') {

                $msg = array('msg' => 'Se ha generado la Compra', 'id_compra' => $id_compra["id"]);
            }
        } else {
            $msg = array('msg' => 'error al realizar la compra', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generarPdf($id_compra)
    {

        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProBuy($id_compra);
        $total = 0;

        require('libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(83, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle("Reporte de Compra");
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(65, 10, $empresa["nombre"], 0, 1, 'C');
        $pdf->Image(base_url . 'Assets/img/logo.png', 60, 18, 15, 15);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'NIT: ', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa["nit"], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa["telefono"], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, utf8_decode('Dirección: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $empresa["direccion"], 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(18, 5, 'Folio:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $id_compra, 0, 1, 'L');
        $pdf->ln();
        //Encabezado de productos
        $pdf->SetFillColor(0, 0, 0);
        $pdf->setTextColor(255, 255, 255);
        $pdf->Cell(10, 5, 'Cant', 0, 0, 'L', true);
        $pdf->Cell(33, 5,  utf8_decode('Descripcion'), 0, 0, 'L', true);
        $pdf->Cell(15, 5, 'Precio', 0, 0, 'L', true);
        $pdf->Cell(19, 5, 'Sub Total', 0, 1, 'L', true);
        $pdf->setTextColor(0, 0, 0);
        foreach ($productos as $row) {
            $total = $total + $row["sub_total"];
            $pdf->Cell(10, 5, $row["cantidad"], 0, 0, 'L');
            $pdf->Cell(33, 5, utf8_decode($row["descripcion"]), 0, 0, 'L');
            $pdf->Cell(15, 5, $row["precio"], 0, 0, 'L');
            $pdf->Cell(19, 5, number_format($row["sub_total"], 2, ',', '.'), 0, 1, 'L');
        }
        $pdf->ln();
        $pdf->Cell(76, 5, 'Total a Pagar', 0, 1, 'R');
        $pdf->Cell(76, 5, number_format($total, 2, ',', '.'), 0, 1, 'R');


        $pdf->Output();
    }

    public function historial()
    {

        $this->views->getView($this, "historial");
    }

    public function list_historial()
    {

        $data = $this->model->gethistBuys();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] =
            '<div>
                <a class="btn btn-danger" href="'.base_url."Compras/generarPdf/".$data[$i]["id"].'" target="_blank"><i class="fas fa-file-pdf"></i></a>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
