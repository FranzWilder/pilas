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
  
    <div class="container-fluid">
        <div class="row">
         
            <div class="col-md-12">
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