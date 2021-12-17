<style>
    .miCirculo {
        width: 30px;
        height: 30px;

        text-align: center;
        border-radius: 100px;
        border: 1px solid red;
        position: absolute;
        cursor: pointer;
    }

    #miMapa {
        border: 1px solid black;
        transform-origin: left top;
    }
</style>


<div class="bg-white m-4 ms-1">


    <div class="row">
        <div class="col-md-12 fondoAzul1 p-2">

            <span class="text-white fw-bold"><?php echo $proyecto->nombre ?> </span>
            <div class="btn-group dropstart float-end">
                <a type="button" class="text-white" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>

            </div>
        </div>
    </div>

    <div>
        <!-- <canvas></canvas> -->
    </div>
    
    <div class="row  position-relative">
        <div class="col-md-12 position-relative" style="height: 500px;overflow: scroll;">
            <div>
                <div class="text-end">
                    <img src="static/images/logo.svg" alt="" style="height:60px">
                </div>
                <div class="fw-bold">
                    Solicitado : <?php $this->session->userdata("nombres") . " " . $this->session->userdata("apellidos");?>
                </div>
                <div id="miMapa"></div>
            </div>
        </div>

        <button style="width:60px;position:absolute;right:10px;top:100px" class="fondoAzul1 text-white zoomUp"><i class="fas fa-plus"></i></button>

        <button style="width:60px;position:absolute;right:10px;top:150px" class="fondoAzul1 text-white zoomDown"><i class="fas fa-minus"></i></button>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>



</div>




<script>
    let modalReporte = new bootstrap.Modal(document.getElementById('modalReporte'), {});

    let scale = 1;
    let idProyecto = "<?php echo $idProyecto ?>";
    let idUsuario = "<?php echo $idUsuario ?>";
    let array_coordenadas = JSON.parse('<?php echo json_encode($array_coordenadas) ?>');

    function countPil() {
        let totInst = $(".miPilaComun").length;
        let inst = $(".miCuadrado").length;


        let percentInst = (inst * 100 / totInst).toFixed(2);

        $("#pilasInstaladas").text(inst);
        $("#pilasNoInstaladas").text(totInst - inst);
        $("#instaladas").text(percentInst);
        $("#noinstaladas").text(100 - percentInst);

    }

    function crearCirculo(circulo) {
        let miCirculo = $("<div id='" + circulo.id + "' xi='" + circulo.xi + "' yi='" + circulo.yi + "'  class='miCirculo miPilaComun' style='top:" + circulo.y + "px;left:" + circulo.x + "px;' x='" + circulo.x + "' y='" + circulo.y + "' pilasavanzado='" + circulo.pilasavanzado + "'></div>");


        let empty = true;
        let full = true;
        for (let i = 1; i < 52; i++) {
            let at = circulo["a" + i];

            if (at != "") {
                empty = false;
            }
            if (at == "") {
                full = false;
            }
        }



        $("#miMapa").append(miCirculo);
        if (empty) {
            console.log("#" + circulo.id);
            $("#" + circulo.id).addClass("miCirculo");
            $("#" + circulo.id).removeClass("miCuadrado");
            $("#" + circulo.id).removeClass("miTriangulo");
        } else if (full) {
            console.log(circulo.id + ' lleno');
            $("#" + circulo.id).removeClass("miCirculo");
            $("#" + circulo.id).addClass("miCuadrado");
            $("#" + circulo.id).removeClass("miTriangulo");
        } else {
            console.log(circulo.id + ' inter');
            $("#" + circulo.id).removeClass("miCirculo");
            $("#" + circulo.id).removeClass("miCuadrado");
            $("#" + circulo.id).addClass("miTriangulo");
        }
    }




    let altoy = 0;
    let altox = 0;
    let minx = 1000000;
    let miny = 1000000;
    let factor = 15 / array_coordenadas[0].radio;

    for (let i = 0; i < array_coordenadas.length; i++) {
        array_coordenadas[i].xi = array_coordenadas[i].x;
        array_coordenadas[i].yi = array_coordenadas[i].y;

        if (minx > array_coordenadas[i].x) {
            minx = array_coordenadas[i].x;
        }
        if (miny > array_coordenadas[i].y) {
            miny = array_coordenadas[i].y;
        }
        array_coordenadas[i].ide = array_coordenadas[i].x + "-" + array_coordenadas[i].y;
    }

    for (let i = 0; i < array_coordenadas.length; i++) {
        array_coordenadas[i].y = array_coordenadas[i].y - miny;
        array_coordenadas[i].y = array_coordenadas[i].y * factor;

        array_coordenadas[i].x = array_coordenadas[i].x - minx;
        array_coordenadas[i].x = array_coordenadas[i].x * factor;
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

    countPil();

    $("#miMapa").css("height", (parseInt(altoy) + 100) + "px");
    $("#miMapa").css("width", (parseInt(altox) + 100) + "px");

    $(".zoomUp").click(function() {
        if (scale < 1) {
            scale += 0.1;
            $("#miMapa").css("transform", "scale(" + scale + ")");
        }
    });

    $(".zoomDown").click(function() {
        if (scale > 0.3) {
            scale -= 0.1;
            $("#miMapa").css("transform", "scale(" + scale + ")");
        }
    });

    $(function() {
        var myModal = new bootstrap.Modal(document.getElementById('miModal'), "");
        var modalAsignar = new bootstrap.Modal(document.getElementById('modalAsignar'), "");

        $("#buscarAsignado").keyup(function() {
            let val = $(this).val();
            if (val != "") {
                $(".filaAsignado").each(function() {

                    if (($(this).find(".nombreAsignado").text()).indexOf(val) == -1) {
                        $(this).css("display", "none");
                    } else {
                        $(this).css("display", "table-row");

                    }
                });
            } else {
                $(".filaAsignado").css("display", "table-row");
            }
        });

        $("#btnModalAsignar").click(function() {
            modalAsignar.show();
        });


        $("body").on("click", ".miCirculo,.miTriangulo,.miCuadrado", function() {
            let id = $(this).attr("id");
            let $this = $(this);
            let usuario = $("#usuario").val();
            $("#miModal").attr("elId", id);
            $("#miModal").attr("usuario", usuario);

            $.ajax({
                url: "admin/proyectos/getParametros",
                type: "post",
                dataType: "json",
                data: {
                    id: id
                },
                error: function(ee) {
                    console.log(ee);
                },
                success: function(response) {
                    myModal.show()
                    let parametros = response.parametros;


                    for (let i = 1; i < 52; i++) {

                        $("[name='a" + i + "']").val(parametros["a" + i]);
                    }
                }
            });







        });

        $("#guardarCirculo").click(function() {
            let id = $("#miModal").attr("elId");
            let usuario = $("#miModal").attr("usuario");
            let pilas = $("#pilas").val();

            let a1 = $("[name='a1']").val();
            let a2 = $("[name='a2']").val();
            let a3 = $("[name='a3']").val();
            let a4 = $("[name='a4']").val();
            let a5 = $("[name='a5']").val();
            let a6 = $("[name='a6']").val();
            let a7 = $("[name='a7']").val();
            let a8 = $("[name='a8']").val();
            let a9 = $("[name='a9']").val();
            let a10 = $("[name='a10']").val();
            let a11 = $("[name='a11']").val();
            let a12 = $("[name='a12']").val();
            let a13 = $("[name='a13']").val();
            let a14 = $("[name='a14']").val();
            let a15 = $("[name='a15']").val();
            let a16 = $("[name='a16']").val();
            let a17 = $("[name='a17']").val();
            let a18 = $("[name='a18']").val();
            let a19 = $("[name='a19']").val();
            let a20 = $("[name='a20']").val();
            let a21 = $("[name='a21']").val();
            let a22 = $("[name='a22']").val();
            let a23 = $("[name='a23']").val();
            let a24 = $("[name='a24']").val();
            let a25 = $("[name='a25']").val();
            let a26 = $("[name='a26']").val();
            let a27 = $("[name='a27']").val();
            let a28 = $("[name='a28']").val();
            let a29 = $("[name='a29']").val();
            let a30 = $("[name='a30']").val();
            let a31 = $("[name='a31']").val();
            let a32 = $("[name='a32']").val();
            let a33 = $("[name='a33']").val();
            let a34 = $("[name='a34']").val();
            let a35 = $("[name='a35']").val();
            let a36 = $("[name='a36']").val();
            let a37 = $("[name='a37']").val();
            let a38 = $("[name='a38']").val();
            let a39 = $("[name='a39']").val();
            let a40 = $("[name='a40']").val();
            let a41 = $("[name='a41']").val();
            let a42 = $("[name='a42']").val();
            let a43 = $("[name='a43']").val();
            let a44 = $("[name='a44']").val();
            let a45 = $("[name='a45']").val();
            let a46 = $("[name='a46']").val();
            let a47 = $("[name='a47']").val();
            let a48 = $("[name='a48']").val();
            let a49 = $("[name='a49']").val();
            let a50 = $("[name='a50']").val();
            let a51 = $("[name='a51']").val();


            $.ajax({
                url: "admin/proyectos/ajaxGuardarPilas",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                    usuario: usuario,
                    pilas: pilas,
                    a1: a1,
                    a2: a2,
                    a3: a3,
                    a4: a4,
                    a5: a5,
                    a6: a6,
                    a7: a7,
                    a8: a8,
                    a9: a9,
                    a10: a10,
                    a11: a11,
                    a12: a12,
                    a13: a13,
                    a14: a14,
                    a15: a15,
                    a16: a16,
                    a17: a17,
                    a18: a18,
                    a19: a19,
                    a20: a20,
                    a21: a21,
                    a22: a22,
                    a23: a23,
                    a24: a24,
                    a25: a25,
                    a26: a26,
                    a27: a27,
                    a28: a28,
                    a29: a29,
                    a30: a30,
                    a31: a31,
                    a32: a32,
                    a33: a33,
                    a34: a34,
                    a35: a35,
                    a36: a36,
                    a37: a37,
                    a38: a38,
                    a39: a39,
                    a40: a40,
                    a41: a41,
                    a42: a42,
                    a43: a43,
                    a44: a44,
                    a45: a45,
                    a46: a46,
                    a47: a47,
                    a48: a48,
                    a49: a49,
                    a50: a50,
                    a51: a51
                },
                success: function(response) {
                    if (response.respuesta == 1) {
                        myModal.hide();
                        $("#" + id).text(response.pilas);
                        $("#pilas").val("");
                        let empty = true;
                        let full = true;
                        for (let i = 1; i < 52; i++) {

                            let at = $("[name='a" + i + "']").val();
                            console.log(at);
                            if (at != "") {
                                empty = false;
                            }
                            if (at == "") {
                                full = false;
                            }
                        }
                        if (empty) {
                            $("#" + id).addClass("miCirculo");
                            $("#" + id).removeClass("miCuadrado");
                            $("#" + id).removeClass("miTriangulo");
                            console.log('vacio');
                        } else if (full) {
                            $("#" + id).removeClass("miCirculo");
                            $("#" + id).addClass("miCuadrado");
                            $("#" + id).removeClass("miTriangulo");
                            console.log('lleno');
                        } else {
                            $("#" + id).removeClass("miCirculo");
                            $("#" + id).removeClass("miCuadrado");
                            $("#" + id).addClass("miTriangulo");
                            console.log('mitad');
                        }
                        countPil();


                    }
                }
            });
        });

        $("#btnGuardarReporte").click(function() {
            modalReporte.show();
        });

        $("#guardarReporte").click(function() {

            $.ajax({
                url: "admin/reportes/ajaxGuardarReporte",
                type: "post",
                data: {
                    idProyecto: idProyecto
                },
                dataType: "json",
                success: function(response) {
                    if (response.respuesta > 0) {
                        modalReporte.hide();
                    }
                }
            });
        });
    });
</script>