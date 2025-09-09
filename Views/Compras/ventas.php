<?php include "Views/Templates/header.php"; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Nueva Venta</h4>
    </div>
    <div class="card-body">
        <form action="" id="frmSale">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="id" name="id">
                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Codigo de Barras" onkeyup="search_Codigo_Sale(event)">
                        <label for="codigo"><i class="fas fa-barcode"></i> Codigo de Barras</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripcion del Producto" disabled>
                        <label for="nombre">Descripcion</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cant" onkeyup="Calc_Price_Sale(event)" disabled>
                        <label for="cantidad">Cant</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio Venta" disabled>
                        <label for="precio">Precio</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">

                        <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="SubTotal" disabled>
                        <label for="sub_total">SubTotal</label>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<table class="table table-dark table-bordered table-hover">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Aplicar</th>
            <th>Descuento</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tblDetails_Sale">
    </tbody>
</table>
<div class="row">
    <div class="col-md-4">
        <div>
            <label for="cliente_Search">Seleccionar Cliente</label>
            <select id="cliente_Search" class="form-control" name="cliente_Search">
                <?php foreach ($data as $row) { ?>
                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3 ms-auto">
        <div>
            <label for="total" class="fw-bold">Total</label>
            <input id="total" class="form-control" type="text" name="total" placeholder="Total" disabled>
            <button class="btn btn-primary mt-2 w-100" type="button" onclick="generate_Purchase_Sale(2)">Generar venta</button>
        </div>
    </div>
    <?php include "Views/Templates/footer.php"; ?>