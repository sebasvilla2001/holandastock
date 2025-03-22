<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Panel de Administración</title>
        <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url; ?>Assets/DataTables/datatables.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="<?php echo base_url; ?>Assets/css/select2.min.css" rel="stylesheet" />
        <script src="<?php echo base_url; ?>Assets/js/all.min.js" crossorigin="anonymous"></script>
        
    </head>


    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">HOLANDASTOCK</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url;?>Usuarios/salir">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-cogs fa-2x text-info"></i></div>
                                  Administración
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url;?>Usuarios"><i class="fas fa-user mr-2 text-success"></i> Usuarios</a>
                                    <a class="nav-link" href="<?php echo base_url;?>Administracion"><i class="fas fa-tools mr-2 text-success"></i></i>Configuración de la Empresa</a>
                                    <a class="nav-link" href="<?php echo base_url;?>Roles_Permisos"><i class="fas fa-user-shield mr-2 text-success"></i>Roles y Permisos</a>
                                    <a class="nav-link" href="<?php echo base_url;?>BitAcceso"><i class="fas fa-user-check mr-2 text-success"></i></i>Bitácora de Acceso</a>
                                    <a class="nav-link" href="<?php echo base_url;?>BitMov"><i class="fas fa-exchange-alt mr-2 text-success"></i>Bitácora de Movimientos</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="<?php echo base_url;?>Cajas">
                                <div class="sb-nav-link-icon"><i class="fas fa-coins mr-2 fa-2x text-info"></i></div>
                                  Cajas
                            </a>
                            <a class="nav-link" href="<?php echo base_url;?>Clientes">
                                <div class="sb-nav-link-icon"><i class="fas fa-users fa-2x text-info"></i></div>
                                  Clientes
                            </a>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProductos" aria-expanded="false" aria-controls="collapseProductos">
                                <div class="sb-nav-link-icon"><i class="fab fa-product-hunt fa-2x text-info"></i></div>
                                  Productos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseProductos" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url;?>Productos"><i class="fab fa-product-hunt mr-2 text-success"></i> Productos</a>
                                    <a class="nav-link" href="<?php echo base_url;?>Categorias"><i class="fas fa-tags mr-2 text-success"></i>Categorías de los Productos</a>
                                    <a class="nav-link" href="<?php echo base_url;?>Medidas"><i class="fas fa-balance-scale mr-2 text-success"></i></i>Medidas de los Productos</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompras" aria-expanded="false" aria-controls="collapseCompras">
                                <div class="sb-nav-link-icon"><i class="fas fa-box fa-2x text-info"></i></div>
                                  Entradas
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseCompras" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url;?>Compras"><i class="fas fa-shopping-cart mr-2 text-success"></i> Nueva Compra</a>
                                    <a class="nav-link" href="<?php echo base_url;?>Compras/historial"><i class="fas fa-receipt mr-2 text-success"></i>Historial de Compras</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSalida" aria-expanded="false" aria-controls="collapseSalida">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-cart fa-2x text-info"></i></div>
                                  Salidas
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseSalida" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="<?php echo base_url;?>Ventas"><i class="fas fa-shopping-cart mr-2 text-success"></i> Nueva Venta</a>
                                    <a class="nav-link" href="<?php echo base_url;?>Ventas/historial"><i class="fas fa-receipt mr-2 text-success"></i>Historial de Ventas</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="<?php echo base_url;?>Acercade">
                                <div class="sb-nav-link-icon"><i class="fas fa-info-circle fa-2x text-info"></i></div>
                                  Acerca De
                            </a>
                            <a class="nav-link" href="<?php echo base_url;?>Ayuda">
                                <div class="sb-nav-link-icon"><i class="fas fa-question-circle fa-2x text-info text-info"></i></div>
                                 Centro de Ayuda
                            </a>


                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid mt-2">
                       
                 
               
