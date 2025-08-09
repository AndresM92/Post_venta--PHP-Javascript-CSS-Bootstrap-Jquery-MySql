<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Panel Adimn</title>
    <link href="<?php echo base_url; ?>Assets/css/style.min.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/css/estilos.css" rel="stylesheet" />
    <link href="<?php echo base_url; ?>Assets/DataTables/datatables.min.css" rel="stylesheet">
    <script src="<?php echo base_url; ?>Assets/js/all.js" crossorigin="anonymous"></script>
    <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?php echo base_url; ?>Administracion/home">Pos Venta</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!" data-bs-toggle="modal" data-bs-target="#changePass">Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="<?php echo base_url; ?>Usuarios/salir">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs mr-2 fa-2x"></i></div>
                            Administracion
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down "></i></div>
                        </a>

                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Usuarios"><i class="fas fa-user mr-2 text-primary"></i>Usuarios</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Administracion"><i class="fas fa-tools mr-2 text-primary"></i>Configuracion</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseCaja" aria-expanded="false" aria-controls="collapseCaja">
                            <div class="sb-nav-link-icon"><i class="fas fa-box mr-2 fa-2x"></i></div>
                            Cajas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down "></i></div>
                        </a>

                        <div class="collapse" id="collapseCaja" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Cajas"><i class="fas fa-box mr-2 text-primary"></i>Cajas</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Cajas/arqueo"><i class="fas fa-tools mr-2 text-primary"></i>Arqueo Caja</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="<?php echo base_url; ?>Clientes">
                            <div class="sb-nav-link-icon"><i class="fas fa-users mr-2 fa-2x"></i></div>
                            Clientes
                        </a>

                        <a class="nav-link" href="<?php echo base_url; ?>Medidas">
                            <div class="sb-nav-link-icon"><i class="fas fa-scale-unbalanced mr-2 fa-2x"></i></div>
                            Medidas
                        </a>

                        <a class="nav-link" href="<?php echo base_url; ?>Categorias">
                            <div class="sb-nav-link-icon"><i class="fa fa-table-list mr-2 fa-2x"></i></div>
                            Categorias
                        </a>

                        <a class="nav-link" href="<?php echo base_url; ?>Productos">
                            <div class="sb-nav-link-icon"><i class="fas fa-product-hunt mr-2 fa-2x"></i></div>
                            Productos
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCompras" aria-expanded="false" aria-controls="collapseCompras">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x"></i></div>
                            Entradas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down "></i></div>
                        </a>

                        <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Compras"><i class="fas fa-shopping-cart mr-2 text-primary"></i>Nueva Compra</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Compras/historial"><i class="fas fa-list mr-2 text-primary"></i>Historial Compras</a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseVenta" aria-expanded="false" aria-controls="collapseVenta">
                            <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x"></i></div>
                            Salidas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down "></i></div>
                        </a>

                        <div class="collapse" id="collapseVenta" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url; ?>Compras/ventas"><i class="fas fa-shopping-cart mr-2 text-primary"></i>Nueva Venta</a>
                                <a class="nav-link" href="<?php echo base_url; ?>Compras/historial_ventas"><i class="fas fa-list mr-2 text-primary"></i>Historial Ventas</a>
                            </nav>
                        </div>

                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">