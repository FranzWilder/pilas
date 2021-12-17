<!DOCTYPE HTML>

<html>

<head>
    <title>Administraci&oacute;n</title>
    <base href="<?php echo base_url(); ?>">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="static/main/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="static/modules/admin/estilo.css">
   
    <link href="static/main/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
    <!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

    <script type="text/javascript" src="static/main/jquery.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <link rel="icon" href="osinerg.ico" type="image/ico">
    <script>
        $(function() {
            var modalSubirProyecto = new bootstrap.Modal(document.getElementById('modalSubirProyecto'), {})
            $('[data-toggle="tooltip"]').tooltip();


            $("#btnModalSubirProyecto").click(function() {
                modalSubirProyecto.show();
            });
        });
    </script>
    <style>
       
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg" id="cabecera">

        <a class="navbar-brand" href="#"> <img src="static/images/pilaslogo.svg" style="height: 34px; padding-left: 15px;"> Sistema de Gestión de Pilas</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        </div>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown no-arrow">

                <i class="far fa-bell"></i>

                <!-- Dropdown - User Information -->



            </li>
            <li class="nav-item dropdown no-arrow ps-3 pe-3">

                <a href="admin/proyectos/logout"><i class="fas fa-sign-out-alt"></i></a>

            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 barraLateral">

                <br>
                <br>
                <br>
                <br>


                <div class="bg-white" style="border-radius:6px 6px;position:relative">


                    <img src="static/images/usuarios/1/1.png" style="height: 80px;    width: 80px;    position: absolute;    left: calC(50% - 40px);    top: -40px;" alt="">

                    <br>
                    <br>
                    <br>
                    <div class="text-center colorAzul1">
                        <?php echo $this->session->userdata("nombres") . " " . $this->session->userdata("apellidos"); ?>
                    </div>
                    <div class="text-center colorPlomo1">
                    <?php echo $this->session->userdata("cargo")?>
                    </div>


                    <div class="text-center colorAzul3">
                        EMIN
                    </div>

                    <div class="row fondoAzul2" style="height:45px;padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="ps-5 colorAzul2">
                                <a href="admin/proyectos">
                                    <i class="fas fa-home "></i>
                                    Mis Proyectos
                                </a>

                            </div>
                        </div>
                    </div>
                    <div class="row" style="height:45px;padding-top: 10px;">
                        <div class="col-md-12">
                            <div class="ps-5 colorPlomo1">
                                <a href="admin/reportes">
                                    <i class="fas fa-search"></i>
                                    Mis Reportes
                                </a>

                            </div>
                        </div>
                    </div>

                    <?php if ($this->session->userdata("cargo") == "Supervisor"): ?>
                   
                        <div class="row" style="height:45px;padding-top: 10px;">
                            <div class="col-md-12">
                                <div class="ps-5 colorPlomo1">
                                    <a href="admin/usuarios">
                                        <i class="fas fa-user"></i>
                                        Usuarios Activos
                                    </a>


                                </div>
                            </div>
                        </div>
                        <div class="row" style="cursor:pointer">
                            <div class="col-md-12">
    
                                <a id="btnModalSubirProyecto" style="border-radius:0 0 6px 6px;display:block;width:100%;height:45px;padding-top: 10px;text-decoration: none;" class="text-white text-center fondoAzul1">
                                    <span>
    
                                        <i class="fas fa-plus-circle"></i> Subir un proyecto
                                    </span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>


            </div>
            <div class="col-md-10 cuerpo">
                <?php echo $body; ?>
            </div>
        </div>

    </div>

    <div class="modal" tabindex="-1" id="modalSubirProyecto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Subir Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="admin/proyectos/subir" enctype="multipart/form-data" method="post">

                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="nombreProyecto" class="col-sm-4 col-form-label">Nombre del Proyecto</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nombreProyecto" name="nombreProyecto">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="imagen" class="col-sm-4 col-form-label">Archivo Excel</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="imagen" name="imagen">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>