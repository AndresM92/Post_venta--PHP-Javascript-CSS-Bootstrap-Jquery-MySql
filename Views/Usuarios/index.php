<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Usuarios</li>
</ol>
<button class="btn btn-primary mb-2" onclick="frmUsers();">Nuevo <i class="fas fa-plus"></i></button>
<table class="table table-light" id="ta_Usuarios">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Caja</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<div id="new_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Usuario</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmUsuario" onsubmit="register_user(event)">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                    </div>
                    <div class="row" id="passwords">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pass">Contraseña</label>
                                <input id="pass" class="form-control" type="password" name="pass" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmar">Confirmar Contraseña</label>
                                <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar Contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="caja">Caja</label>
                        <select id="caja" class="custom-select" name="caja">
                            <?php foreach ($data["cajas"] as $row) { ?>
                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["caja"]; ?> </option>
                           <?php } ?>
                            
                        </select>
                    </div>
                    <button id="btnAction" class="btn btn-primary" type="submit" >Registrar</button> <!--onclick="register_user(event)"-->
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>      
                </form>
            </div>
        </div>
    </div>
    <?php include "Views/Templates/footer.php"; ?>