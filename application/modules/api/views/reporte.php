<style>
.miCirculo {
    width: 30px;
    height: 30px;

    text-align: center;


    position: absolute;
    cursor: pointer;

    font-size: 13px;
    padding-top: 5px;
}

.miCuadrado {
    width: 30px;
    height: 30px;
    background: #4472c4;
    position: absolute;
    cursor: pointer;
    padding-left: 10px;
    padding-top: 1px;
}

.miTriangulo {
    position: absolute;
    padding-left: 6px;
    padding-top: 4px;
}

.miTriangulo::after {
    content: "";
    position: absolute;
    cursor: pointer;
    top: 0;
    border-left: 20px solid transparent;
    border-right: 20px solid transparent;
    border-top: 0px solid transparent;
    border-bottom: 30px solid #ffc000;
    left: -8px;
    z-index: -1;
}

#miMapa {
    border: 2px solid black;
    transform: scale(1);
    transform-origin: left top;
    position: relative;
    margin: 20px;
}

.table td,
.table th {
    border-top: 0px;
}

.textCir {
    position: absolute;
    left: 0.5em;
    top: 0.5em;
}
</style>
<script src="static/main/html2pdf.bundle.min.js"></script>
<script>
$(function() {
    let controller = "<?php echo $controller ?>";

    // var modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'), {
    //     keyboard: false
    // });

    // $("body").on("click", "#btnModalSubir", function() {
    //     myModal.show();
    // });

    // $("body").on("click", ".btnEliminar", function() {
    //     $("#modalEliminar").attr("elId", $(this).attr("id"));
    //     modalEliminar.show();
    // });

    $("#btnAceptar").click(function() {
        let idReportes = $("#modalEliminar").attr("elId");

        window.location.href = "admin/reportes/eliminar/" + idReportes;
    });


});
</script>

<br>

<div class="bg-white">

    <div class="row">
        <div class="col-md-12">

            <!-- <table class="table">
                <tr>
                    <th>Nombre de Proyecto</th>
                    <th>Código</th>
                    <th>Supervisor del proyecto</th>
                    <th>Fecha de reporte</th>

                    <th>--</th>
                </tr>

                <?php foreach ($model as $key => $value) : ?>
                    <tr>

                        <td class="nombreTabla"><?php echo $value->nombreProyecto ?></td>
                        <td><?php echo $value->codigoReporte ?></td>
                        <td><?php echo $value->nombreUsuario ?></td>
                        <td class="fechaTabla"><?php echo $value->fechaReporte ?></td>


                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend" id="button-addon3">
                                    <a elId="<?php echo $value->id ?>" class="btnMirar colorAzul2" ><i class="fas fa-eye"></i></a>

                                    <a id="<?php echo $value->id ?>" class="btnEliminar colorAzul2"><i class="far fa-trash-alt"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table> -->
        </div>
    </div>

    <div>
        <div class="row  position-relative">
            <div id="pdf">

                <div class="col-md-12 position-relative divTotal" style="height: 500px;overflow: scroll;">

                    <div id="miMapa" style="border:1px solid white">
                        <div class="text-end">
                            <img src="static/images/logo.svg" alt="" style="height:60px">
                        </div>

                        <div class="text-center fw-bold f23">
                            Reporte de : <?php echo $proyecto->nombre ?>
                        </div>
                        <br>
                        <div class="fw-bold f20">
                            Solicitado : <?php echo $usuario->nombres . " " . $usuario->apellidos; ?>
                        </div>
                        <div class="fw-bold f20">Fecha : <?php echo $reporte->fechaRegistro ?> </div>
                        <br>
                        <div id="miMapapdf" style="border:1px solid black" class="position-relative">

                        </div>
                        <br>
                        <div class="fw-bold f20">Pilas instaladas <span id="pilasInstaladas"></span></div>
                        <div class="fw-bold f20">Pilas no instaladas <span id="pilasNoInstaladas"></span> </div>
                    </div>
                </div>


            </div>
            <br>
            <br>
            <br>
            <div class="text-center">
              <button id="descargar" class="mt-4 boton fondoAzul1 text-white">Descargar</button>
            </div>

            <!-- <button style="width:60px;position:absolute;right:10px;top:100px" class="fondoAzul1 text-white zoomUp"><i class="fas fa-plus"></i></button>

                    <button style="width:60px;position:absolute;right:10px;top:150px" class="fondoAzul1 text-white zoomDown"><i class="fas fa-minus"></i></button> -->

            <br>
            <br>
            <br>
        </div>

    </div>


</div>


<script>
$(function() {


    $("#descargar").click(function() {
        location.href = "api/pdf/"+"<?php echo $reporte->id ?>";
        //$("#miMapa").css("transform", "scale(0.3)");
        /*var element = document.getElementById('miMapa');

        var opt = {
            margin: 1,
            filename: 'proyecto.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 3
            },
            jsPDF: {
                unit: 'in',
                format: 'a1',
                orientation: 'portrait'
            }
        };

        var worker = html2pdf().set(opt).from(element).save();*/

    });


    let scale = 1;


    let altoy = 0;
    let altox = 0;
    let minx = 1000000;
    let miny = 1000000;

    function crearCirculo(circulo) {

        let text_num = "";

        if (circulo.num == "0") {
            text_num = "";
        } else {
            text_num = circulo.num;
        }


        let miCirculo = $("<div num='" + circulo.num + "' id='" + circulo.id + "' xi='" + circulo.xi +
            "' yi='" + circulo.yi + "'  class='miCirculo miPilaComun' style='top:" + circulo.y +
            "px;left:" + circulo.x + "px;' x='" + circulo.x + "' y='" + circulo.y + "' pilasavanzado='" +
            circulo.pilasavanzado + "'>" + text_num + "</div>");


        $("#miMapapdf").append(miCirculo);


        if (circulo.estadoPila == "1") {

            $("#" + circulo.id).html(
                "<img src='static/images/circulo.png' style='width:100%'><span class='textCir'>" +
                text_num + "</span>");

        } else if (circulo.estadoPila == "3") {
            $("#" + circulo.id).html(
                "<img src='static/images/rectangulo.png' style='width:100%'><span class='textCir'>" +
                text_num + "</span>");

        } else {
            $("#" + circulo.id).html(
                "<img src='static/images/triangulo.png' style='width:100%'><span class='textCir'>" +
                text_num + "</span>");
        }
    }




    let idReportes = '<?php echo $reporte->id ?>';

    // let fecha = $(this).parents("tr").find(".fechaTabla").text();
    // let nombre = $(this).parents("tr").find(".nombreTabla").text();

    // $("#fechaHora").text(fecha);
    // $("#pdfNombreProyecto").text(nombre);


    let f = $.ajax({
        url: "api/ajaxTraeReporte",
        type: "post",
        data: {
            idReportes: idReportes
        },
        dataType: "json",
        success: function(response) {
            $("#miMapapdf").html("");
            altoy = 0;
            altox = 0;
            minx = 1000000;
            miny = 1000000;
            $("#miMapapdf").css("height", "0");
            $("#miMapapdf").css("width", "0");

            let array_coordenadas = response.respuesta;
            // console.log(array_coordenadas);
            // console.log(array_coordenadas.length);


            let factor = 15 / array_coordenadas[0].radio;


                for (let i = 0; i < array_coordenadas.length; i++) {
                    array_coordenadas[i].xi = array_coordenadas[i].x;
                    array_coordenadas[i].yi = array_coordenadas[i].y;

                    if (minx >= parseInt(array_coordenadas[i].x)) {
                        minx = parseInt(array_coordenadas[i].x);
                    }
                    if (miny >= parseInt(array_coordenadas[i].y)) {
                        miny = parseInt(array_coordenadas[i].y);
                    }
                    array_coordenadas[i].ide = array_coordenadas[i].x + "-" +
                        array_coordenadas[i].y;
                }



                for (let i = 0; i < array_coordenadas.length; i++) {
                    array_coordenadas[i].y = array_coordenadas[i].y - miny;
                    array_coordenadas[i].y = array_coordenadas[i].y * factor;

                    // array_coordenadas[i].y = array_coordenadas[i].y ;

                    array_coordenadas[i].x = array_coordenadas[i].x - minx;
                    array_coordenadas[i].x = array_coordenadas[i].x * factor;
                    // array_coordenadas[i].x = array_coordenadas[i].x ;
                }

                for (let i = 0; i < array_coordenadas.length; i++) {

                    if (array_coordenadas[i].y > altoy) {
                        altoy = array_coordenadas[i].y;
                    }
                    if (array_coordenadas[i].x > altox) {
                        altox = array_coordenadas[i].x;
                    }
                }

                for (let i = 0; i < array_coordenadas.length; i++) {
                    array_coordenadas[i].y = altoy - array_coordenadas[i].y
                    crearCirculo(array_coordenadas[i]);
                }

            console.log((parseInt(altoy) + 100) + "px");
            console.log((parseInt(altox) + 100) + "px");

            $("#miMapapdf").css("height", (parseInt(altoy) + 100) + "px");
            $("#miMapapdf").css("width", (parseInt(altox) + 100) + "px");



            /////

            let totInst = $(".miPilaComun").length;
            let inst = $(".miCuadrado").length;


            let percentInst = (inst * 100 / totInst).toFixed(2);

            $("#pilasInstaladas").text(inst + " (" + percentInst + "% de avance)");
            $("#pilasNoInstaladas").text((totInst - inst) + " (" + (100 - percentInst) +
                "% de avance)");

            $(".divTotal").scrollTop($("#miMapa").height() / 2)
            // $("#miMapa").css("transform", "scale(0.3)");
            scale = 1;
        }
    })






});
</script>