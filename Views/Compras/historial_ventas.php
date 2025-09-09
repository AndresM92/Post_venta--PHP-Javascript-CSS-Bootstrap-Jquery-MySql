<?php include "Views/Templates/header.php"; ?>

<div class="my-4">

    <form action="<?php echo base_url?>" method="POST">
        <div class="d-flex justify-content-sm-evenly">
            <label for="desde">Desde <input type="date"></label>
            <label for="desde">Hasta <input type="date"></label>
            <button type="button" class="btn btn-primary">Filtrar</button>
        </div>
    </form>

    <div class="card my-3">
        <div class="card-header bg-dark text-white">
            Ventas
        </div>
        <div class="card-body">
            <table class="table table-light" id="t_historial_sale">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Clientes</th>
                        <th>Total</th>
                        <th>Fecha Compra</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include "Views/Templates/footer.php"; ?>