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
<div class="modal fade" id="my_modal" tabindex="-1" aria-labelledby="my_modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmUsuario" onsubmit="register_user(event)">
                    <input type="hidden" id="id" name="id">
                    <div class="form-floating mb-3">
                        <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario">
                        <label for="usuario">Usuario</label>
                        
                    </div>
                    <div class="form-floating mb-3">
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                        <label for="nombre">Nombre</label>
                        
                    </div>
                    <div class="row" id="passwords">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="pass" class="form-control" type="password" name="pass" placeholder="Contraseña">
                                <label for="pass">Contraseña</label>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar Contraseña">
                                <label for="confirmar">Confirmar Contraseña</label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <select id="caja" class="form-control" name="caja">
                            <?php foreach ($data["cajas"] as $row) { ?>
                                <option value="<?php echo $row["id"]; ?>"><?php echo $row["caja"]; ?> </option>
                           <?php } ?>
                        </select>
                        <label for="caja">Caja</label>
                    </div>
                    <button id="btnAction" class="btn btn-primary" type="submit" >Registrar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>      
                </form>
            </div>
        </div>
    </div>
</div>
    <?php include "Views/Templates/footer.php"; ?>