<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Iniciar Sesion</title>
    <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
    <script src="<?php echo base_url; ?>Assets/js/all.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url; ?>Assets/js/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url; ?>Assets/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>

    <script src="<?php echo base_url; ?>Assets/js/sweetalert2.all.min.js"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Iniciar Sesion</h3>
                                </div>
                                <div class="card-body">
                                    <form id="frmLoginn" method="post" onsubmit="frmLogin(event)"><!-- onsubmit="frmlogin(event)"-->
                                        <div class="form-floating mb-3">
                                            <input name="usuario" class="form-control" id="usuario" type="text" placeholder="Ingrese Usuario" />
                                            <label><i class="fas fa-user"></i>Usuario</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="clave" id="clave" type="password" placeholder="Ingrese contraseña" />
                                            <label><i class="fas fa-key"></i>Contraseña</label>
                                        </div>
                                        <div class="alert alert-danger text-center d-none" id="alerta" role="alert"></div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Login</button> <!--/*onclick="validar_login(event);*/"-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Visit my page <a href=""></a></div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?php echo base_url; ?>Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url; ?>Assets/js/funciones.js"></script>
    <script>
        const base_url = "<?php echo base_url; ?>";
    </script>
    <script src="<?php echo base_url; ?>Assets/js/scripts.js"></script>
</body>

</html>