<!DOCTYPE HTML>

<html>

<head>
    <title>Administraci&oacute;n</title>
    <base href="<?php echo base_url(); ?>">
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="static/main/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="static/modules/admin/estilo.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Exo">
    <link href="static/main/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

    <script type="text/javascript" src="static/main/jquery.js"> </script>
    <script type="text/javascript" src="static/main/bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" href="osinerg.ico" type="image/ico">

    <style>
    body {
        font-family: Exo;
    }

    #cabecera {
        background: #000;
        color: white;

    }

    #cabecera a {
        color: white;
    }

    .barraLateral {
        background: #EBE9E9;
        height: 100%;
    }

    .barraLateral i {
        color: #a4abb3;
        font-size: 18px;
        width: 30px;
        text-align: center;
    }

    .cuerpo {
        background: #f0f4f7;
        margin-top: 10px;
    }

    a.barraEnlace {
        text-decoration: none;
        border-style: solid;
        border-width: 0 1px 1px 1px;
        color: #4b4b4b;
        text-align: center;
        vertical-align: middle;
        display: block;
        width: 100%;
        height: 50px;
        padding-top: 13px;
        /* padding-left: 20px; */
        border-color: black;
    }

    a.barraEnlace:hover {
        background: #ddd;
        color: #181818;
    }

    a.barraEnlace:hover i{
       
        color: #181818;
    }
    </style>
</head>

<body style="background:#eee;">
    <nav class="navbar navbar-expand-lg" id="cabecera">
        <a class="navbar-brand" href="#">JMC Racing</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="admin/entregas">Entrega <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin/clientes">Configuraciones Generales</a>
                </li>

                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Usuario</span>

                        <i class="fas fa-user"></i>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="admin/logout" style="color:black">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Cerrar sesión
                        </a>
                    </div>
                </li>

            </ul>

        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 barraLateral">
                <div class="row">
                    <a class="barraEnlace" href="admin/entregas"><i class="fas fa-car-crash"></i> Entrega</a>

                </div>
            </div>
            <div class="col-md-10 cuerpo">
                <?php echo $body; ?>
            </div>
        </div>

    </div>
</body>

</html>