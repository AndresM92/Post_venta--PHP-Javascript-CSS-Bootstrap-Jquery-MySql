<?php include "Views/Templates/header.php"; ?>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cajas</li>
</ol>



<button id="btn_open_arqueo" class="btn btn-primary mb-2 <?php echo $data != "" ? 'd-none' : '' ?>" type="button" onclick="frmArqueoBox();"><i class="fas fa-plus"></i>Abrir Caja</button>
<button id="btn_close_arqueo" class="btn btn-warning mb-2 <?php echo $data == "" ? 'd-none' : '' ?>" type="button" onclick="close_box();"><i class="fas fa-close"></i>Cerrar Caja</button>




<table class="table table-dark table-bordered" id="ta_Arqueo">
    <thead class="thead-dark">
        <tr>
            <th>Id</th>
            <th>Monto_Inicial</th>
            <th>Monto_Final</th>
            <th>Fecha_Apertura</th>
            <th>Fecha_Cierre</th>
            <th>Total Ventas</th>
            <th>Monto Total</th>
            <th>Estado</th>
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
                <form method="post" id="frmOpenBox" onsubmit="Open_Arqueo(event)">
                    <div class="form-floating mb-3">
                        <input type="hidden" id="id" name="id">
                        <input id="monto_inicial" class="form-control" type="text" name="monto_inicial" placeholder="Monto Inicial" required>
                        <label for="monto_inicial">Monto inicial</label>
                    </div>

                    <div id="ocultar_campos">
                        <div class="form-floating mb-3">
                            <input meth id="monto_final" class="form-control" name="monto_final" type="text" disabled>
                            <label for="monto_final">Monto Final</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input id="total_ventas" class="form-control" name="total_ventas" type="text" disabled>
                            <label for="total_ventas">Total Ventas</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input id="monto_general" class="form-control" name="monto_general" type="text" disabled>
                            <label for="monto_general">Monto Total</label>
                        </div>
                    </div>


                    <button id="btnAction" class="btn btn-primary" type="submit">Abrir</button>
                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "Views/Templates/footer.php"; ?>