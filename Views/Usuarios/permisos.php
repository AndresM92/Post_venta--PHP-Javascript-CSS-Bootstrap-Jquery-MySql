<?php include "Views/Templates/header.php"; ?>

<div class="col-md-6 mx-auto">
    <div class="card">

        <div class="card-header text-center bg-primary text-white">
            Asignar permisos
        </div>
        <div class="card-body">
            <form id="frm_permisos" onsubmit="reg_permisos(event)">
                <div class="row">
                    <?php foreach ($data['datos'] as $row) { ?>
                        <div class="col-md-4 text-center text-capitalize p-2">
                            <label for=""><?php echo $row['permiso'];?></label><br>
                            <div class="checkbox_permisos">

                                <input type="checkbox" name="permisos[]" value="<?php echo $row['id'];?>" 
                                    <?php echo isset($data['asignados'][$row['id']])? 'checked':''; ?>>

                                <svg viewBox="0 0 35.6 35.6">
                                    <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
                                    <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
                                    <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87">
                                    </polyline>
                                </svg>
                            </div>
                        </div>
                    <?php } ?>
                    <input type="hidden" name="id_usuario" value="<?php echo $data['id_usuario'];?>">
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-primary">Asignar Permisos</button>
                    <a href="<?php echo base_url;?>Usuarios" class="btn btn-outline-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>