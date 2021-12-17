<script>
$(function() {

    $("#btnEnviar").click(function() {
        let fechaInicio = $("#fechaInicio").val(),
            fechaFin = $("#fechaFin").val(),
            factura = $("#factura").is(":checked");

        window.location = "admin/reportes/repuestos/" + fechaInicio + "/" + fechaFin + "/" + factura
    });

    
});
</script>

<br>

<div class="card">
    <h5 class="card-header">Repuestos Usados</h5>
    <div class="card-body">
        <!-- <h5 class="card-title">Special title treatment</h5> -->
        <div class="row">
            <div class="col-md-8">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="fechaInicio">Fecha Inicio</label>
                    </div>
                    <input type="date" class="form-control" id="fechaInicio" value="<?php echo $fechaInicio ?>">
                    <div class="input-group-append">
                        <label class="input-group-text" for="fechaFin">Fecha Fin</label>
                    </div>
                    <input type="date" class="form-control" id="fechaFin"  value="<?php echo $fechaFin ?>">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <input type="checkbox" aria-label="Factura" id="factura" <?php echo (($factura=="false")?"":"checked") ?>  >
                        </div>
                    </div>
                    <div class="input-group-append">
                        <label class="input-group-text" for="factura">Factura</label>
                    </div>

                    <div class="input-group-append">
                        <input type="button" class="btn btn-outline-success" id="btnEnviar" value="Enviar">
                    </div>


                    
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Repuesto</th>
                        <th>Venta</th>
                        <th>Cantidad</th>
                        <th>Placa</th>
                        <th>Cliente</th>
                    </tr>
                    <?php $total=0; ?>
                    <?php foreach($repuestos as $key=>$value): ?>
                    <tr>

                        <td><?php echo $key+1 ?></td>
                        <td><?php echo substr($value->fechaServicio,0,10) ?></td>
                        <td><?php echo $value->descripcion ?></td>
                        <td><?php echo $value->monto;$total+=$value->monto ?></td>
                        <td><?php echo $value->cantidad ?></td>
                        <td><?php echo $value->placa ?></td>
                        <td><?php echo $value->nombresCompletos ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <tr>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <th><?php echo $total ?></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
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