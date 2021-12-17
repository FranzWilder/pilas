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
    border: 4px solid black;
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



<div class="bg-white">


    <div class="row">
        <div class="col-md-12 fondoAzul1 p-2">

            <span class="text-white fw-bold"><?php echo $proyecto->nombre ?> </span>
            <div class="btn-group dropstart float-end">
                <a type="button" class="text-white" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a style="cursor:pointer" id="btnModalAsignar" class="dropdown-item"><i
                                class="fas fa-plus-circle"></i> Asignar/ver usuarios</a></li>
                    <li><a style="cursor:pointer" id="btnGuardarReporte" class="dropdown-item"><i
                                class="far fa-file-alt"></i> Generar Reporte</a></li>
                    <li><a style="cursor:pointer" id="btnEliminarProyecto" class="dropdown-item"><i
                                class="far fa-trash-alt"></i> Eliminar Proyecto</a></li>


                </ul>
            </div>
        </div>
    </div>

    <div>
        <!-- <canvas></canvas> -->
    </div>
    <div class="row  position-relative">
        <div class="col-md-12 position-relative" style="height: 500px;overflow: scroll;">
            <span class="badge bg-danger" id="msg"></span>
            <div id="miMapa"></div>
        </div>


        <!-- <button style="background:#8AA9E2;border:0;border-radius:150px;width:40px;height:40px;position:absolute;right:10px;top:100px" class=" text-white zoomUp"><i class="fas fa-plus"></i></button>

        <button style="background:#8AA9E2;border:0;border-radius:150px;width:40px;height:40px;position:absolute;right:10px;top:150px" class=" text-white zoomDown"><i class="fas fa-minus"></i></button> -->

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="fondoAzul1 text-white f12" style="padding: 26px;">
                <div class="row">

                    <div class="col" style="border-right:1px solid white">
                        <div>
                            <img class="float-start" src="static/images/pilaslogo.svg"
                                style="height: 34px; padding-left: 8px;">
                            <span class="float-start" id="pilasInstaladas" style="padding-left: 8px;">125</span>
                            <div class="float-start" style="padding-left: 8px;">
                                <div>Pilas instaladas</div>
                                <span> <span id="instaladas">85</span>% de avance</span>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <img class="float-start" src="static/images/pilaslogo.svg"
                            style="height: 34px; padding-left: 8px;">
                        <span class="float-start" id="pilasNoInstaladas" style="padding-left: 8px;">15</span>
                        <div class="float-start" style="padding-left: 8px;">
                            <div>Pilas no instaladas</div>
                            <span><span id="noinstaladas">15</span>% de saldo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<div class="modal" tabindex="-1" id="miModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edición de pilas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="height: 500px;overflow:auto">
                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Ing. Residente</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a1">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Ing. Seguridad</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a2">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Asistente de Calidad</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a3">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Fecha</label>
                    <div class="col-sm-7">
                        <input type="date" class="form-control" name="a4">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Clima</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a5">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Turno</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a6">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Sistema Geopier</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a7">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Inicio de Jornada</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a8">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Fin de Jornada</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a9">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro inicial Exc. Apisonador 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a10">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro final Exc. Apisonador 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a11">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro inicial Exc. Apisonador 2</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a12">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro final Exc. Apisonador 2</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a13">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro inicial Exc. Barrena 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a14">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro final Exc. Barrena 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a15">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro inicial Abastecedor 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a16">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro final Abastecedor 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a17">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro inicial limpieza 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a18">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro final limpieza 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a19">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro inicial limpieza 2</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a20">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Horómetro final limpieza 2</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a21">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Sector</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a22">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Tipo de Cimentación</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a23">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Cota de superficie (msnm)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a24">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Profundidad de diseño (m)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a25">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Profundidad de Barrenado (m)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a26">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Cota de inicio Mandril (ft)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a27">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Cota de Término Mandril (ft)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a28">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Profundidad instalada (m)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a29">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Volumen de grava (m3)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a30">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Volumen de lechada (m3)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a31">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Tiempo barrenado (min)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a32">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Tiempo de instalación (min)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a33">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Volumen sobrante h (m)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a34">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Volumen sobrante o1 (m)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a35">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Volumen sobrante o2 (m)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a36">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Prof. CST - BST 1 (ft)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a37">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Prof. CST - BST 2 (ft)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a38">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Prof. CST - BST 3 (ft)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a39">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Def. CST - BST 1 (cm)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a40">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Def. CST - BST 2 (cm)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a41">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Def. CST - BST 3 (cm)</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a42">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Martillo</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a43">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Rotaria</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a44">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Op. Exc. Apisonador 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a45">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Op. Exc. Apisonador 2</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a46">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Op. Exc. Barrena 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a47">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Op. Abastecedor 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a48">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Op. Limpieza 1</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a49">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Op. Limpieza 2</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a50">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-5 col-form-label">Observaciones</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="a51">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="guardarCirculo">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" id="modalReporte">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <i style="font-size:100px" class="colorAzul2 far fa-file-alt"></i>
                </p>
                <p>
                    ¿Deseas generar el reporte?
                </p>

                <div class="text-center">
                    <button id="guardarReporte" class="boton fondoAzul1 text-white">Aceptar</button>
                    <button class="boton fondoAzul3 text-white" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalEliminarProyecto" elId="<?php echo $proyecto->id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <i style="font-size:100px" class="colorAzul2 far fa-file-alt"></i>
                </p>
                <p>
                    ¿Deseas eliminar el proyecto?
                </p>

                <div class="text-center">
                    <button id="eliminarProyecto" class="boton fondoAzul1 text-white">Aceptar</button>
                    <button class="boton fondoAzul3 text-white" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="modalAsignar">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="api/asignarUsuarios/<?php echo $idProyecto ?>" method="post">
                <div class="modal-header text-center">
                    <span class="f19 fw-bold colorAzul4">Asignar nuevo usuario</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 330px;    overflow: auto;">
                    <div class="mb-3 position-relative">
                        <i class="fas fa-search position-absolute colorAzul4" style="right:11px;top:11px"></i>
                        <input class="form-control" type="text" placeholder="Buscar" id="buscarAsignado">
                    </div>


                    <table class="table table-borderless f14">
                        <thead class="colorAzul4">
                            <tr>

                                <th colspan="2">Nombre y Apellido</th>
                                <th>Email</th>
                                <th>Seleccionar</th>
                            </tr>
                        </thead>

                        <tbody class="colorAzul4">
                            <?php foreach ($usuarios as $key => $value) : ?>

                            <tr class="filaAsignado">
                                <td style="background:#F7F7F7;"><img style="max-height:50px" class="img-fluid"
                                        onerror="if (this.src != '') this.src = 'static/images/perfil.png';"
                                        src="static/images/usuarios/<?php echo $value->id ?>/<?php echo $value->imagen ?>"
                                        alt=""></td>
                                <td style="background:#F7F7F7;" class="nombreAsignado">
                                    <?php echo $value->nombres . " " . $value->apellidos ?></td>
                                <td style="background:#F7F7F7;"><?php echo $value->email ?></td>
                                <td style="background:#F7F7F7;" class="text-center">
                                    <input class="form-check-input" type="checkbox" name="asignados[]"
                                        value="<?php echo $value->id ?>"
                                        <?php if (array_search($value->id, $asignados) !== false) {
                                                                                                                                                echo "checked";
                                                                                                                                            }  ?>>
                                </td>
                            </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>


                </div>
                <div class="text-center mt-4 mb-4">
                    <button type="submit" class="boton fondoAzul1 text-white"><i class="fas fa-link"></i>
                        Asignar</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="static/main/js/pinch-zoom.js"> </script>
<script type="text/javascript" src="https://unpkg.com/panzoom@7.0.2/dist/panzoom.min.js"> </script>

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
    let text_num = "";

    if (circulo.num == "0") {
        text_num = "";
    } else {
        text_num = circulo.num;
    }

    let miCirculo = $("<div id='" + circulo.id + "' xi='" + circulo.xi + "' yi='" + circulo.yi +
        "'  class='miCirculo miPilaComun' style='top:" + circulo.y + "px;left:" + circulo.x + "px;' x='" + circulo
        .x + "' y='" + circulo.y + "' pilasavanzado='" + circulo.pilasavanzado + "'>" + text_num + "</div>");


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
        $("#" + circulo.id).html("<img src='static/images/circulo.png' style='width:100%'><span class='textCir'>" +
            text_num + "</span>");
    } else if (full) {
        $("#" + circulo.id).html("<img src='static/images/rectangulo.png' style='width:100%'><span class='textCir'>" +
            text_num + "</span>");
    } else {
        $("#" + circulo.id).html("<img src='static/images/triangulo.png' style='width:100%'><span class='textCir'>" +
            text_num + "</span>");
    }

    /*     $("#miMapa").append(miCirculo);
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
        } */
}




let altoy = 0;
let altox = 0;
let minx = 1000000;
let miny = 1000000;
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
    array_coordenadas[i].ide = array_coordenadas[i].x + "-" + array_coordenadas[i].y;
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

countPil();

$("#miMapa").css("height", (parseInt(altoy) + 100) + "px");
$("#miMapa").css("width", (parseInt(altox) + 100) + "px");

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

$(function() {


    var modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminarProyecto'), "");

    $("#btnEliminarProyecto").click(function() {
        modalEliminar.show();
    });

    $("#eliminarProyecto").click(function() {

        $.ajax({
            url: "api/eliminar/" + $("#modalEliminarProyecto").attr("elId"),
            dataType: "json",
            success: function(response) {
                if (response.respuesta == 1) {
                    modalEliminar.hide();
                    $("#msg").text("Proyecto eliminado");
                    $("#miMapa").html("")
                }
            }
        });
    });


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
            url: "api/getParametros",
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
            url: "api/ajaxGuardarPilas",
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
                    let textNum = $("#" + id).find("span").text();
                    if (empty) {
                        $("#" + id).html(
                            "<img src='static/images/circulo.png' style='width:100%'><span class='textCir'>" +
                            textNum + "</span>");

                    } else if (full) {
                        $("#" + id).html(
                            "<img src='static/images/rectangulo.png' style='width:100%'><span class='textCir'>" +
                            textNum + "</span>");

                    } else {
                        $("#" + id).html(
                            "<img src='static/images/triangulo.png' style='width:100%'><span class='textCir'>" +
                            textNum + "</span>");

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
            url: "api/ajaxGuardarReporte",
            type: "post",
            data: {
                idUsuario: idUsuario,
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
    var el = document.getElementById('miMapa');
    /*let pz = new PinchZoom.default(el, {

        onZoomUpdate: function(object, event) {
            console.log(event);
            console.log(object);
        },
        onZoomEnd: function(object, event){
            console.log('df');
        }
    });*/
    var instance = panzoom(el);
  
});
</script>