<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Productos</li>
</ol>
<button class="btn btn-primary mb-2" onclick="frmProducts();">Nuevo <i class="fas fa-plus"></i></button>
<table class="table table-light" id="ta_Productos">
    <thead class="thead-dark">
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
<div id="new_product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Nuevo Producto</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmProduct" onsubmit="register_product(event)">
                    <input type="hidden" id="id" name="id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo">Codigo de Barras</label>
                                <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Codigo de barras">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Descripcion</label>
                                <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio_compra">Precio Compra</label>
                                <input id="precio_compra" class="form-control" type="text" name="precio_compra" placeholder="Precio Compra">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio_venta">Precio Venta</label>
                                <input id="precio_venta" class="form-control" type="text" name="precio_venta" placeholder="Precio Venta">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medida">Medidas</label>
                                <select id="medida" class="custom-select" name="medida">
                                    <?php foreach ($data["medidas"] as $row) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="categoria">Categorias</label>
                                <select id="categoria" class="custom-select" name="categoria">
                                    <?php foreach ($data["categorias"] as $row) { ?>
                                        <option value="<?php echo $row["id"]; ?>"><?php echo $row["nombre"]; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
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
    <?php include "Views/Templates/footer.php"; ?>