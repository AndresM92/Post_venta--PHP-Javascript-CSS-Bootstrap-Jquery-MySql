<?php include "Views/Templates/header.php"; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Nueva Compra</h4>  
</div>
    <div class="card-body">
        <form action="" id="frmBuy">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="id" name="id">
                        <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Codigo de Barras" onkeyup="search_Codigo(event)">
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
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cant" onkeyup="Calc_Price(event)" disabled>
                        <label for="cantidad">Cant</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">                      
                        <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio Compra" disabled>
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
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>Id</th>
            <th>Descripcion</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tblDetails">
    </tbody>
</table>
<div class="row">
    <div class="col-md-4 ms-auto">
        <div class="form-group">
            <label for="total" class="fw-bold">Total</label>
            <input id="total" class="form-control" type="text" name="total" placeholder="Total" disabled>
            <button class="btn btn-primary mt-2 w-100" type="button" onclick="generate_Purchase_Sale(1)">Generar Compra</button>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>