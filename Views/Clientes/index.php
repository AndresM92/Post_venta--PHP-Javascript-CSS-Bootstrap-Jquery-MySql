<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Clientes</li>
</ol>
<button class="btn btn-primary mb-2" onclick="frmCustomers();">Nuevo <i class="fas fa-plus"></i></button>
<table class="table table-light" id="ta_Clientes">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>CC</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div id="new_customer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmCustomerr" onsubmit="register_customer(event)">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="cc">cc</label>
                        <input id="cc" class="form-control" type="text" name="cc" placeholder="Documento de identidad">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre del cliente">
                    </div>

                    <div class="form-group">
                        <label for="telefono">telefono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="telefono">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Direccion</label>
                        <textarea id="direccion" class="form-control" name="direccion" placeholder="direccion"></textarea>
                    </div>

                    <button id="btnAction" class="btn btn-primary" type="submit">Registrar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
    <?php include "Views/Templates/footer.php"; ?>