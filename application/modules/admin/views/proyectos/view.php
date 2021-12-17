<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">


<script>
    $(function() {
        new Splide('.splide').mount();


        let controller = "<?php echo $controller ?>";
        $(".btnEliminar").click(function() {
            let id = $(this).attr("id");
            $("#modalEliminar").attr("elId", id);
            $("#modalEliminar").modal();
        });

        $("#btnAceptar").click(function() {
            window.location = "admin/" + controller + "/eliminar/" + $("#modalEliminar").attr("elId");
        });

        $('[data-toggle="tooltip"]').tooltip()

        $("#buscar").keyup(function() {
            let textoBuscar = $(this).val();

            $(".divProyecto").each(function() {
                let nombre = $(this).find(".nombreProyecto").text();
                if (nombre.search(textoBuscar) != -1) {
                    $(this).css("display","block");
                } else {
                    $(this).css("display","none");
                }
            });
        });

        $("#buscarFecha").change(function() {
          
            let textoBuscar = $(this).val();

            $(".divProyecto").each(function() {
                let miFecha = $(this).find(".miFecha").text();
                if (miFecha.search(textoBuscar) != -1) {
                    $(this).css("display","block");
                } else {
                    $(this).css("display","none");
                }
            });
        });
    });
</script>

<br>


<div class="bg-white p-5">

    <div class="row">
        <div class="col-md-12">
            <br>
            <h5 class="colorAzul2 fw-bold">Mis Proyectos</h5>
        </div>
    </div>


    <div class="row">
        <div class="col-md-2">
            <input class="form-control" type="search" placeholder="Buscar" id="buscar">
        </div>
        <div class="col-md-8"></div>
        <div class="col-md-2">
            <input class="form-control" type="date" placeholder="Buscar" id="buscarFecha">
        </div>
    </div>


    <div class="splide">
        <div class="splide__track">
            <ul class="splide__list">
                <?php foreach ($array_proyectos as $key2 => $value2) : ?>
                    <li class="splide__slide">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">

                                <div class="row">
                                    <?php foreach ($array_proyectos[$key2] as $key => $value) : ?>

                                        <div class="col-md-4 mt-4 divProyecto">
                                            <div style="background:#f0f0f0;border-radius:6px">
                                                <div class="p-4">

                                                    <h6 class="fw-bold nombreProyecto"><?php echo $value->nombre ?></h6>
                                                    <span class="miFecha" style="display:none"><?php echo $value->fechaRegistro ?></span>
                                                    <div class="colorAzul3" style="font-size:12px">Cod: <?php echo $value->codigo ?></div>

                                                    <br>

                                                    <div class="colorAzul3 mb-2" style="font-size:12px">Supervisor</div>

                                                    <div>
                                                        <img src="static/images/usuarios/1/1.png" style="height: 30px;    width: 30px;" alt=""> <span class="fw-bold"><?php echo $value->nombresSupervisor . " " . $value->apellidosSupervisor ?></span>
                                                    </div>
                                                </div>

                                                <a href="admin/proyectos/mapa/<?php echo $value->id ?>">
                                                    <div class="fondoAzul1 text-white pt-4 p-3" style="border-radius:0 0 6px 6px">
                                                        <div class="row">
                                                            <?php if ($value->curso == 3) : ?>
                                                                <div class="col-md-10" style="font-size:12px"><i style="color:#b1ff00" class="fas fa-circle"></i> Terminado</div>
                                                            <?php else : ?>
                                                                <div class="col-md-10" style="font-size:12px"><i style="color:yellow" class="fas fa-circle"></i> En curso</div>
                                                            <?php endif; ?>

                                                            <div class="col-md-2"> <i style="font-size:26px" class="fas fa-angle-right"></i> </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </li>
                <?php endforeach; ?>

            </ul>
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