<?php include "Views/Templates/header.php"; ?>

<div class="row mt-2">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary">
            <div class="card-body d-flex text-white">
                Usuarios
                <i class="fas fa-user fa-2x ml-auto"></i>
            </div>
            <div class="card-footer d-flex alig-items-center justify-content-between">
                <a href="<?php echo base_url; ?>Usuarios" class="text-white">Ver Detalle</a>
                <span class="text-white"><?php echo $data["usuarios"]["total"]; ?></span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success">
            <div class="card-body d-flex text-white">
                Clientes
                <i class="fas fa-users fa-2x ms-auto"></i>
            </div>
            <div class="card-footer d-flex alig-items-center justify-content-between">
                <a href="<?php echo base_url; ?>Clientes" class="text-white">Ver Detalle</a>
                <span class="text-white"><?php echo $data["clientes"]["total"]; ?></span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger">
            <div class="card-body d-flex text-white">
                Productos
                <i class="fab fa-product-hunt fa-2x ms-auto"></i>
            </div>
            <div class="card-footer d-flex alig-items-center justify-content-between">
                <a href="<?php echo base_url; ?>Productos" class="text-white">Ver Detalle</a>
                <span class="text-white"><?php echo $data["productos"]["total"]; ?></span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning">
            <div class="card-body d-flex text-white">
                Ventas por Día
                <i class="fas fa-cash-register fa-2x ms-auto"></i>
            </div>
            <div class="card-footer d-flex alig-items-center justify-content-between">
                <a href="<?php echo base_url; ?>Compras/historial_ventas" class="text-white">Ver Detalle</a>
                <span class="text-white"><?php echo $data["ventas"]["total"]; ?></span>
            </div>
        </div>
    </div>

</div>

<div class="row mt-2">
    <div class="col-xl-6 col-ms-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Productos con Stock minimo
            </div>
            <div class="card-body">
                <canvas id="stockMin" width="200" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-ms-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Productos mas vendidos
            </div>
            <div class="card-body">
                <canvas id="stockVen" width="200" height="100"></canvas>
            </div>
        </div>
    </div>

</div>

<?php include "Views/Templates/footer.php"; ?>