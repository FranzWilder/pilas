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

    var modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'), {
        keyboard: false
    });

    $("body").on("click", "#btnModalSubir", function() {
        myModal.show();
    });

    $("body").on("click", ".btnEliminar", function() {
        $("#modalEliminar").attr("elId", $(this).attr("id"));
        modalEliminar.show();
    });

    $("#btnAceptar").click(function() {
        let idReportes = $("#modalEliminar").attr("elId");

        window.location.href = "admin/reportes/eliminar/" + idReportes;
    });


});
</script>

<br>

<div class="bg-white p-5">

    <div class="row">
        <div class="col-md-12">

            <table class="table">
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
                                <a elId="<?php echo $value->id ?>" class="btnMirar colorAzul2"><i
                                        class="fas fa-eye"></i></a>

                                <a id="<?php echo $value->id ?>" class="btnEliminar colorAzul2"><i
                                        class="far fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <div style="display:none">
        <div id="divPdf">
            <div class="text-end">
                <img src="static/images/logo.svg" alt="" style="height:60px">
            </div>
            <div>
                Solicitado : <?php $this->session->userdata("nombres") . " " . $this->session->userdata("apellidos"); ?>
            </div>
            <div id="mapaOculto">

            </div>
        </div>

    </div>


</div>



<div elId="" class="modal" tabindex="-1" role="dialog" id="modalEliminar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="text-center">

                    <img class="mt-4 mb-4" src="static/images/equis.svg" alt="">

                    <p>¿Esta seguro de eliminar el usuario?</p>
                    <button type="button" class="boton fondoAzul1 text-white" id="btnAceptar">Aceptar</button>
                    <button type="button" data-bs-dismiss="modal" class="boton fondoAzul2 text-white">Cancelar</button>
                </div>

            </div>

        </div>
    </div>
</div>


<div elId="" class="modal" tabindex="-1" role="dialog" id="modalMirar">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body">
                <div class="row  position-relative">
                    <div id="pdf">

                        <div class="col-md-12 position-relative divTotal" style="height: 500px;overflow: scroll;">

                            <div id="" style="border:1px solid white">
                                <div class="text-end">
                                    <img src="static/images/logo.svg" alt="" style="height:60px">
                                </div>

                                <div class="text-center fw-bold f23">
                                    Reporte de : <span id="pdfNombreProyecto"></span>
                                </div>
                                <br>
                                <div class="fw-bold f20">
                                    Solicitado :
                                    <?php echo $this->session->userdata("nombres") . " " . $this->session->userdata("apellidos"); ?>
                                </div>
                                <div class="fw-bold f20">Fecha : <span id="fechaHora"></span> </div>
                                <br>
                                <div id="miMapa" style="border:1px solid black" class="position-relative">

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

                    <button style="width:60px;position:absolute;right:10px;top:100px"
                        class="fondoAzul1 text-white zoomUp"><i class="fas fa-plus"></i></button>

                    <button style="width:60px;position:absolute;right:10px;top:150px"
                        class="fondoAzul1 text-white zoomDown"><i class="fas fa-minus"></i></button>

                    <br>
                    <br>
                    <br>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
$(function() {


    $("#descargar").click(function() {
        var element = document.getElementById('miMapa');

        location.href = $(this).attr("link");
        /* var opt = {
            margin: 1,
            filename: 'proyecto.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 1
            },
            jsPDF: {
                unit: 'in',
                format: 'a1',
                orientation: 'portrait'
            }
        };

        var worker = html2pdf().set(opt).from(element).save(); */
    });


    let scale = 1;


    let altoy = 0;
    let altox = 0;
    let minx = 1000000;
    let miny = 1000000;
    $(".zoomUp").click(function() {
        if (scale < 1) {
            scale += 0.1;
            $("#miMapa").css("transform", "scale(" + scale + ")");
            $("#miMapa").css("border", (5 / scale) + "px solid black");
            $(".miCirculo").css("width", 30 * (1 / scale) + "px");
            $(".miCirculo").css("height", 30 * (1 / scale) + "px");
            $(".miCirculo").css("border-radius", 30 * (1 / scale) + "px");
            $(".miCirculo").css("font-size", 13 * (1 / scale) + "px");
        }
    });

    $(".zoomDown").click(function() {
        if (parseInt($("#miMapa").css("width")) < 1500 && scale < 0.7) {

            return false;
        }

        if (scale > 0.12) {
            scale -= 0.1;
            $("#miMapa").css("transform", "scale(" + scale + ")");
            $("#miMapa").css("border", (5 / scale) + "px solid black");
            $(".miCirculo").css("width", 30 * (1 / scale) + "px");
            $(".miCirculo").css("height", 30 * (1 / scale) + "px");
            $(".miCirculo").css("border-radius", 30 * (1 / scale) + "px");
            $(".miCirculo").css("font-size", 13 * (1 / scale) + "px");
        }
    });

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


        $("#miMapa").append(miCirculo);

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



    $("body").on("click", ".btnMirar", function() {
        let idReportes = $(this).attr("elId");

        let fecha = $(this).parents("tr").find(".fechaTabla").text();
        let nombre = $(this).parents("tr").find(".nombreTabla").text();
        $("#descargar").attr("link", "admin/reportes/pdf/" + idReportes);
        $("#fechaHora").text(fecha);
        $("#pdfNombreProyecto").text(nombre);


        let f = $.ajax({
            url: "admin/reportes/ajaxTraeReporte",
            type: "post",
            data: {
                idReportes: idReportes
            },
            dataType: "json",
            success: function(response) {
                $("#miMapa").html("");
                altoy = 0;
                altox = 0;
                minx = 1000000;
                miny = 1000000;
                $("#miMapa").css("height", "0");
                $("#miMapa").css("width", "0");

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


                $("#miMapa").css("height", (parseInt(altoy) + 100) + "px");
                $("#miMapa").css("width", (parseInt(altox) + 100) + "px");

                var modalEliminar = new bootstrap.Modal(document.getElementById(
                    'modalMirar'), {
                    keyboard: false
                });
                modalEliminar.show();

                /////

                let totInst = $(".miPilaComun").length;
                let inst = $(".miCuadrado").length;


                let percentInst = (inst * 100 / totInst).toFixed(2);

                $("#pilasInstaladas").text(inst + " (" + percentInst + "% de avance)");
                $("#pilasNoInstaladas").text((totInst - inst) + " (" + (100 - percentInst) +
                    "% de avance)");

                $("#miMapa").css("transform", "scale(1)");
                scale = 1;
            }
        })

    });




});
</script>