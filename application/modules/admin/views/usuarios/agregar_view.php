<div class="row">
    <div class="col-md-12">



    </div>
</div>

<br>

<div class="card">
    <h5 class="card-header">Agregar <?php echo ucwords($controller) ?></h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6"> 
                <form method="post">
                    <?php helper_form_text("nombres","Nombres") ?>
                    <?php helper_form_text("apellidoPaterno","Apellido Paterno") ?>
                    <?php helper_form_text("apellidoMaterno","Apellido Materno") ?>
                    <?php helper_form_select("idTipoDocumentos","Tipo de Documento",$tipoDocumentos) ?>
                    <?php helper_form_text("documento","Documento") ?>
                    <?php helper_form_text("direccion","Dirección") ?>
                    <?php helper_form_text("correo","Correo","","email") ?>

                    <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Guardar</button>
                </form>
            </div>
        </div>

    </div>

</div>