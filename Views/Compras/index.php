<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Nueva Compra</li>
</ol>
<div class="card">
    <div class="card-body">
        <form action="" id="frmBuy">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="codigo">Codigo de Barras</label>
                        <input type="hidden" id="id" name="id">
                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Codigo de Barras" onkeyup="search_Codigo(event)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="nombre">Descripcion</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripcion del Producto" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="cantidad">Cant</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cant" onkeyup="Calc_Price(event)">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio Compra" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="sub_total">SubTotal</label>
                        <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="SubTotal" disabled>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
<table class="table table-light">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div class="row">
    <div class="col-md-4 ml-auto">
        <div class="form-group">
            <label for="total" class="font-weight-bold">Total</label>
            <input id="total" class="form-control" type="text" name="total" placeholder="Total" disabled>
            <button class="btn btn-primary mt-2 btn-block" type="button">Generar Compra</button>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>