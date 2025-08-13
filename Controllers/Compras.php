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
        $id_usuario = $_SESSION["id_usuario"];
        $verificar = $this->model->checkPermiso($id_usuario, 'compras');
        if (!empty($verificar) || $id_usuario == 16) {
            $this->views->getView($this, "index");
        } else {
            header('location:' . base_url . 'Errors/permisos');
        }
    }

    public function ventas()
    {
        $data = $this->model->getCustomers();
        $this->views->getView($this, "ventas", $data);
    }

    public function historial_ventas()
    {
        $this->views->getView($this, "historial_ventas");
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
        $check_detail = $this->model->consultDetails('detalle', $id_producto, $id_usuario);

        if (empty($check_detail)) {
            $sub_total = $precio * $cantidad;
            $data2 = $this->model->addDetalils('detalle', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);

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
            $data2 = $this->model->updateDetails('detalle', $id_producto, $id_usuario, $precio, $total_cantidad, $sub_total);

            if ($data2 == "modificado") {
                $msg = array('msg' => 'Se agrego la cantidad adicional', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al agregar la cantidad', 'icono' => 'error');
            }
            echo json_encode($msg, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function ingresarVenta()
    {

        $id = $_POST["id"];
        $data = $this->model->getPro($id);
        $id_producto = $data['id'];
        $id_usuario = $_SESSION['id_usuario'];
        $precio = $data['precio_venta'];
        $cantidad = $_POST['cantidad'];
        $sub_total = $precio * $cantidad;
        $check_detail = $this->model->consultDetails('detalle_venta_temp', $id_producto, $id_usuario);

        if (empty($check_detail)) {

            if ($data['cantidad'] >= $cantidad) {
                $sub_total = $precio * $cantidad;
                $data2 = $this->model->addDetalils('detalle_venta_temp', $id_producto, $id_usuario, $precio, $cantidad, $sub_total);
                if ($data2 == "ok") {
                    $msg = array('msg' => 'El producto fue ingresado con exito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al ingresar el producto', 'icono' => 'error');
                }
            } else {
                $msg = array('msg' => 'Stock no disponible:' . $data["cantidad"], 'icono' => 'warning');
            }
        } else {
            $total_cantidad = $check_detail["cantidad"] + $cantidad;
            $sub_total = $total_cantidad * $precio;
            if ($data['cantidad'] < $total_cantidad) {
                $msg = array('msg' => 'Stock no disponible', 'icono' => 'warning');
            } else {
                $data2 = $this->model->updateDetails('detalle_venta_temp', $id_producto, $id_usuario, $precio, $total_cantidad, $sub_total);
                if ($data2 == "modificado") {
                    $msg = array('msg' => 'Se agrego la cantidad adicional', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al agregar la cantidad', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listar($tabla)
    {
        $id_usuario = $_SESSION["id_usuario"];
        $data["detalle"] = $this->model->getDetails($tabla, $id_usuario);
        $data["total_pagar"] = $this->model->calBuy_Sale($tabla, $id_usuario);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarVenta($id_cliente)
    {
        $id_usuario = $_SESSION["id_usuario"];
        $check = $this->model->checkBox($id_usuario);
        if (empty($check)) {
            $msg = array('msg' => 'La caja esta cerrada', 'icono' => 'info');
        } else {
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $total = $this->model->calBuy_Sale('detalle_venta_temp', $id_usuario);
            $data = $this->model->r_sale($id_usuario, $id_cliente, $total["total"], $fecha, $hora);
            if ($data == "ok") {

                $id_venta = $this->model->getId('ventas');
                $details = $this->model->getDetails('detalle_venta_temp', $id_usuario);
                foreach ($details as $row) {
                    $cantidad = $row["cantidad"];
                    $desc = $row["descuento"];
                    $precio = $row["precio"];
                    $id_producto = $row["id_producto"];
                    $sub_total = ($cantidad * $precio) - $desc;
                    $this->model->register_details_sale($id_venta["id"], $id_producto, $cantidad, $desc, $precio, $sub_total);
                    $stock_actual = $this->model->getPro($id_producto);
                    $stock = $stock_actual["cantidad"] - $cantidad;
                    $this->model->updateStock($stock, $id_producto);
                }
                $empty_details = $this->model->emptyDetails('detalle_venta_temp', $id_usuario);
                if ($empty_details == 'ok') {
                    $msg = array('msg' => 'Se ha generado la venta', 'id_venta' => $id_venta["id"], 'icono' => 'warning');
                }
            } else {
                $msg = array('msg' => 'error al realizar la venta', 'icono' => 'error');
            }
        }
        echo json_encode($msg);
        die();
    }

    public function delete($id)
    {

        $data = $this->model->deleteDetail('detalle', $id);
        if ($data == "ok") {
            $msg = array('msg' => 'El producto fue eliminado de la lista', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el producto', 'icono' => 'error');
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function deleteVenta($id)
    {

        $data = $this->model->deleteDetail('detalle_venta_temp', $id);
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
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $total = $this->model->calBuy_Sale('detalle', $id_usuario);
        $data = $this->model->r_buy($total["total"], $fecha, $hora);
        if ($data == "ok") {

            $id_compra = $this->model->getId('compras');
            $details = $this->model->getDetails('detalle', $id_usuario);
            foreach ($details as $row) {
                $cantidad = $row["cantidad"];
                $precio = $row["precio"];
                $id_producto = $row["id_producto"];
                $sub_total = $cantidad * $precio;
                $this->model->register_details_purchase($id_compra["id"], $id_producto, $cantidad, $precio, $sub_total);
                $stock_actual = $this->model->getPro($id_producto);
                $stock = $stock_actual["cantidad"] + $cantidad;
                $this->model->updateStock($stock, $id_producto);
            }
            $empty_details = $this->model->emptyDetails('detalle', $id_usuario);
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
        $pdf->SetFont('Arial', 'B', 7);
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

    public function generarPdfVenta($id_venta)
    {

        $empresa = $this->model->getEmpresa();
        $productos = $this->model->getProSale($id_venta);
        $descuento = $this->model->getDescuento($id_venta);
        $clientes = $this->model->customers_Sale($id_venta);
        $total = 0;

        require('libraries/fpdf/fpdf.php');
        $pdf = new FPDF('P', 'mm', array(83, 200));
        $pdf->AddPage();
        $pdf->SetMargins(5, 0, 0);
        $pdf->SetTitle("Reporte de Venta");
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
        $pdf->Cell(18, 5, $id_venta, 0, 1, 'L');
        $pdf->ln();
        //Encabezado de clientes
        $pdf->SetFillColor(0, 0, 0);
        $pdf->setTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(25, 5, 'Nombre', 0, 0, 'L', true);
        $pdf->Cell(25, 5,  utf8_decode('Teléfono'), 0, 0, 'L', true);
        $pdf->Cell(25, 5, utf8_decode('Dirección'), 0, 1, 'L', true);
        $pdf->setTextColor(0, 0, 0);
        $pdf->Cell(25, 5, $clientes["nombre"], 0, 0, 'L');
        $pdf->Cell(25, 5, $clientes["telefono"], 0, 0, 'L');
        $pdf->Cell(25, 5, $clientes["direccion"], 0, 1, 'L');
        $pdf->Ln();
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
        $pdf->Cell(76, 5, 'Descuento Total', 0, 1, 'R');
        $pdf->Cell(76, 5, number_format($descuento["total"], 2, ',', '.'), 0, 1, 'R');
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
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
                $data[$i]['acciones'] =
                    '<div>
                <button class="btn btn-warning" onclick="btnAnularC(' . $data[$i]['id'] . ')"><i class="fas fa-ban"></i></button>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdf/" . $data[$i]["id"] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                    </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Anulado</span>';
                $data[$i]['acciones'] =
                    '<div>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdf/" . $data[$i]["id"] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
                    </div>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function list_historial_venta()
    {

        $data = $this->model->gethistSales();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] =
                '<div>
                <a class="btn btn-danger" href="' . base_url . "Compras/generarPdfVenta/" . $data[$i]["id"] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function calDescuento($data)
    {

        $array = explode(",", $data);
        $id = $array[0];
        $desc = $array[1];

        if (empty($id) || empty($desc)) {

            $msg = array('msg' => 'error', 'icono' => 'error');
        } else {

            $check_Desc_Actual = $this->model->checkDesc($id);
            $desc_Total = $check_Desc_Actual["descuento"] + $desc;
            $sub_total = ($check_Desc_Actual["cantidad"] * $check_Desc_Actual["precio"]) - $desc_Total;
            $data2 = $this->model->updateDesc($desc_Total, $sub_total, $id);

            if ($data2 == 'ok') {
                $msg = array('msg' => 'Descuento aplicado', 'icono' => 'success');
            } else {
                $msg = array('msg' => 'Error al aplicar el Descuento', 'icono' => 'error');
            }
        }

        echo json_encode($msg);
        die();
    }

    public function anularCompra($id_compra)
    {

        $data = $this->model->getAnularBuy($id_compra);
        $anular = $this->model->getAnular($id_compra);

        foreach ($data as $row) {
            $stock_actual = $this->model->getPro($row["id_producto"]);
            $stock = $stock_actual["cantidad"] - $row["cantidad"];
            $this->model->updateStock($stock, $row["id_producto"]);
        }

        if ($anular == 'ok') {
            $msg = array('msg' => 'La compra fue anulada', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al anular', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
}
