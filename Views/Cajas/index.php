<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cajas</li>
</ol>
<button class="btn btn-primary mb-2" onclick="frmBoxes();">Nuevo <i class="fas fa-plus"></i></button>
<table class="table table-light" id="ta_Cajas">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Caja</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div id="new_box" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nueva Caja</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmBoxx" onsubmit="register_Box(event)">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="caja">caja</label>
                        <input id="caja" class="form-control" type="text" name="caja" placeholder="Nombre Caja">
                    </div>
                    <button id="btnAction" class="btn btn-primary" type="submit">Registrar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
    <?php include "Views/Templates/footer.php"; ?>