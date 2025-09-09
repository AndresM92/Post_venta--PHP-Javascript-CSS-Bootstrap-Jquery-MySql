<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>
<button class="btn btn-primary mb-2" onclick="frmProducts();">Nuevo <i class="fas fa-plus"></i></button>
<div class="table-responsive">
    <table class="table table-striped " id="ta_Productos">
        <thead class="table-dark">
            <tr>
                <th>Id</th>
                <th>Imagen</th>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="my_modal" tabindex="-1" aria-labelledby="my_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmProduct" onsubmit="register_product(event)">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="hidden" id="id" name="id">
                                <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Codigo de barras">
                                <label for="codigo">Codigo de Barras</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                                <label for="nombre">Descripcion</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input id="precio_compra" class="form-control" type="text" name="precio_compra" placeholder="Precio Compra">
                                <label for="precio_compra">Precio Compra</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input id="precio_venta" class="form-control" type="text" name="precio_venta" placeholder="Precio Venta">
                                <label for="precio_venta">Precio Venta</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating mb-3">
                                <select id="medida" class="form-control" name="medida">
                                    <?php foreach ($data["medidas"] as $row) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?> </option>
                                    <?php } ?>
                                </select>
                                <label for="medida">Medidas</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-floating mb-3">
                                <select id="categoria" class="form-control" name="categoria">
                                    <?php foreach ($data["categorias"] as $row) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?> </option>
                                    <?php } ?>
                                </select>
                                <label for="categoria">Categorias</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mb-4">
                                <label>Foto</label>
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>
                                        <span id="icon-cerrar"></span>
                                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview_foto(event)">
                                        <input type="hidden" id="foto_actual" name="foto_actual">
                                        <img class="img-thumbnail" id="img-preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="btnAction" class="btn btn-primary" type="submit">Registrar</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>