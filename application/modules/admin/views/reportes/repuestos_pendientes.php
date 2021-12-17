<script>
$(function() {
    $(".btnFacturar").click(function() {
        $("#modalFactura").modal();
        $("#modalFactura").attr("elId",$(this).attr("miId"));
    });

    $("#btnGrabar").click(function(){
        var fechaFacturacion = $("#fechaFacturacion").val();
       // $("#btnGrabar").attr("disabled","disabled");
        $.ajax({
            url : "admin/reportes/ajaxSaveFacturacion",
            type : "post",
            dataType : "json",
            data : {
                id : $("#modalFactura").attr("elId"),
                fechaFacturacion:fechaFacturacion
            },
            error : function(e){
                //alert("Se produjo un error");
                //location.reload();
            },
            success : function(response){
                console.log(response);
                //x$("#btnGrabar").attr("disabled","false");
                $("#modalFactura").modal("hide");
                location.reload();
            }
        });
    });


});
</script>

<br>

<div class="card">
    <h5 class="card-header">Repuestos Pendientes</h5>
    <div class="card-body">
        <!-- <h5 class="card-title">Special title treatment</h5> -->

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
                        <th>Acciones</th>
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
                        <td>
                            <button class="btn btn-outline-info btnFacturar" miId="<?php echo $value->id ?>">Facturar</button>
                        </td>
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


<div elId="" class="modal" tabindex="-1" role="dialog" id="modalFactura">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facturación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-inline">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Fecha</span>
                        </div>

                        <input id="fechaFacturacion" type="date" class="form-control" value="<?php echo date("Y-m-d") ?>">

                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="button" id="btnGrabar">Grabar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>