<script>
$(function() {
    let controller = "<?php echo $controller ?>";
    $(".btnEliminar").click(function() {
        let id = $(this).attr("id");
        $("#modalEliminar").attr("elId", id);
        $("#modalEliminar").modal();
    });

    $("#btnAceptar").click(function() {
        window.location = "admin/" + controller + "/eliminarPago/<?php echo $idClientes ?>/" + $("#modalEliminar").attr("elId");
    });
});
</script>

<br>

<div class="card">
    <h5 class="card-header">Pagos</h5>
    <div class="card-body">
        <!-- <h5 class="card-title">Special title treatment</h5> -->

        <div class="row">
            <div class="col-md-12">
                <a href="admin/<?php echo $controller ?>/agregarPagos/<?php echo $idClientes ?>" class="btn btn-outline-info"> <i
                        class="fas fa-plus"  data-toggle="tooltip" data-placement="top" title="Agregar Pago"></i></a>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <tr>
                        <th>Fecha</th>
                        <th>Nombres</th>
                        <th>Monto</th>
                        <th>Acciones</th>    
                    </tr>

                    <?php foreach($pagos as $key=>$value): ?>
                    <tr>
                        <td><?php echo substr($value->fechaPago,0,10) ?></td>
                        <td><?php echo $value->nombresCompletos ?></td>
                        <td><?php echo $value->monto ?></td>

                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend" id="button-addon3">
                                    
                                    <button id="<?php echo $value->id ?>" class="btn btn-outline-danger btnEliminar"  data-toggle="tooltip" data-placement="top" title="Anular Pago"><i class="far fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    </div>

</div>


<div elId="" class="modal" tabindex="-1" role="dialog" id="modalEliminar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminación de <?php echo ucwords($controller) ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Desea eliminar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-outline-success" id="btnAceptar">Aceptar</button>
            </div>
        </div>
    </div>
</div>