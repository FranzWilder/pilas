<script>
$(function(){let e=JSON.parse('<?php echo json_encode($model) ?>'),a=[];for(let o in e)a[e[o].id]=e[o];var o=new bootstrap.Modal(document.getElementById("modalUsuario"),{keyboard:!1}),n=new bootstrap.Modal(document.getElementById("modalExito"),{keyboard:!1}),t=new bootstrap.Modal(document.getElementById("modalEliminar"),{keyboard:!1}),l=new bootstrap.Modal(document.getElementById("modalEditar"),{keyboard:!1});$("body").on("click","#btnModalSubir",function(){o.show()}),$("body").on("click",".btnEliminar",function(){$("#modalEliminar").attr("elId",$(this).attr("id")),t.show()}),$("body").on("click",".btnEditar",function(){let e=$(this).attr("elId");console.log(e),console.log(a),$("#eidUsuario").val(e),$("#enombres").val(a[e].nombres),$("#eapellidos").val(a[e].apellidos),$("#ecargo").val(a[e].cargo),$("#eemail").val(a[e].email),$("#econtrasena").val(a[e].contrasena),$("#imagenPersona").attr("src","static/images/usuarios/"+a[e].id+"/"+a[e].imagen),$("#modalEditar").attr("elId",e),l.show()}),$("#formUsuarioEditar").submit(function(e){e.preventDefault();var a=new FormData;if(a.append("elid",$("#modalEditar").attr("elId")),a.append("nombres",$("#enombres").val()),a.append("apellidos",$("#eapellidos").val()),a.append("cargo",$("#ecargo").val()),a.append("email",$("#eemail").val()),a.append("contrasena",$("#econtrasena").val()),null==$("#eimagenPerfi")[0].files[0]);else{let e=$("#eimagenPerfi")[0].files[0].name,n=$("#eimagenPerfi")[0].files[0].size,t=new Array(".jpg",".png"),l=e.substring(e.lastIndexOf(".")).toLowerCase(),i=!1;for(var o=0;o<t.length;o++)if(t[o]==l){i=!0;break}if(!i)return void alert("LA foto debe ser de formato jpg o png");if(n>1024e3)return void alert("El tamaño de la foto debe ser menor a 1MB");a.append("imagen",$("#eimagenPerfi")[0].files[0])}$.ajax({url:"admin/usuarios/editar",type:"POST",dataType:"json",data:a,processData:!1,contentType:!1,error:function(e){alert("No se pudo actualizar todos los datos")},success:function(e){console.log(e),"1"==e.resultado?(console.log("22"),location.reload()):alert("No se pudo actualizar todos los datos")}})}),$("#btnFile").click(function(){$("#imagenPerfi").click()}),$("#ebtnFile").click(function(){$("#eimagenPerfi").click()}),$("#btnAceptar").click(function(){let e=$("#modalEliminar").attr("elId");window.location.href="admin/usuarios/eliminar/"+e}),$("#formUsuario").submit(function(e){e.preventDefault();var a=new FormData;if(a.append("nombres",$("#nombres").val()),a.append("apellidos",$("#apellidos").val()),a.append("cargo",$("#cargo").val()),a.append("email",$("#email").val()),a.append("contrasena",$("#contrasena").val()),null==$("#imagenPerfi")[0].files[0]);else{a.append("imagen",$("#imagenPerfi")[0].files[0]);let e=$("#imagenPerfi")[0].files[0].name,n=$("#imagenPerfi")[0].files[0].size,t=new Array(".jpg",".png"),l=e.substring(e.lastIndexOf(".")).toLowerCase(),i=!1;for(var o=0;o<t.length;o++)if(t[o]==l){i=!0;break}if(!i)return void alert("LA foto debe ser de formato jpg o png");if(n>1024e3)return void alert("El tamaño de la foto debe ser menor a 1MB")}$.ajax({url:"admin/usuarios/subir",type:"POST",dataType:"json",data:a,processData:!1,contentType:!1,success:function(e){console.log(e),"1"==e.resultado&&(n.show(),location.reload())}})})});
</script>

<br>

<div class="bg-white p-5">
    <div class="row">
        <div class="col-md-4">

            <a id="btnModalSubir" style="cursor:pointer;border-radius: 0px;display: inline-block;padding-top: 10px;text-decoration: none;padding: 14px;" class="text-white text-center fondoAzul1">
                <span>
                    <i class="fas fa-plus-circle"></i> Crear un nuevo usuario
                </span>
            </a>

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">

            <table class="table">
                <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <!-- <th>Contraseña</th>
                    <th>Rol</th> -->
                    <th>Acciones</th>
                </tr>

                <?php foreach ($model as $key => $value) : ?>
                    <tr>
                        <td><img style="height:50px" src="static/images/usuarios/<?php echo $value->id ?>/<?php echo $value->imagen ?>" onerror="if (this.src != '') this.src = 'static/images/perfil.png';" class="img-fluid"></td>
                        <td><?php echo $value->nombres ?></td>
                        <td><?php echo $value->apellidos ?></td>
                        <td><?php echo $value->email ?></td>
                        <td><?php echo $value->cargo ?></td>
                        <!-- <td>********</td> -->
                        <!-- <td><?php echo $value->contrasena ?></td> -->
                        <!-- <td><?php echo $value->rol ?></td> -->

                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend" id="button-addon3">
                                    <a elId="<?php echo $value->id ?>" class="btnEditar colorAzul2" data-toggle="tooltip" data-placement="top" title="Editar"><i class="far fa-edit"></i></a>
                                  
                                    <a id="<?php echo $value->id ?>" class="btnEliminar colorAzul2" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="far fa-trash-alt"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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

<div class="modal" tabindex="-1" id="modalUsuario">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-body">
                <h5 class="p-4 pb-0">Crear nuevo usuario</h5>
                <div class="row">
                    <div class="col-md-4 mt-5 text-center">
                        <div id="btnFile" style="margin: 18px 50px;background: #eee;padding: 64px;border-radius: 222px;">
                            <i style="font-size:128px" class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form id="formUsuario" method="post" enctype="multipart/form-data">
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cargo" class="form-label">Cargo</label>
                                        <select class="form-select" id="cargo" required>
                                            <option value="">Elegir</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Operario">Operario</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="contrasena" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="contrasena" required>
                                    </div>
                                </div>

                            </div>
                            <input type="file" id="imagenPerfi" name="imagenPerfi" style="display:none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <button type="submit" id="btnAgregarUsuario" class="text-white text-center fondoAzul1 pe-4 ps-4" style="border:0px;border-radius:0px;display:block;height:45px;text-decoration: none;">Crear</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal" tabindex="-1" id="modalEditar">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-body">
                <h5 class="p-4 pb-0">Editar usuario</h5>
                <div class="row">
                    <div class="col-md-4 mt-5 text-center">
                        <div id="ebtnFile" style="margin: 18px 50px;background: #eee;padding: 64px;border-radius: 222px;">
                            <img id="imagenPersona" class="img-fluid" src="" alt="" onerror="if (this.src != '') this.src = 'static/images/perfil.png';">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form id="formUsuarioEditar" action="admin/usuarios/editar" method="post" enctype="multipart/form-data">
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="enombres" name="enombres" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="eapellidos" name="eapellidos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cargo" class="form-label">Cargo</label>
                           
                                        <select class="form-select" id="ecargo" required>
                                            <option value="">Elegir</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Operario">Operario</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="eemail" name="eemail" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="contrasena" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="econtrasena" name="econtrasena"  required>
                                    </div>
                                </div>

                            </div>
                          
                            <input type="file" id="eimagenPerfi" name="eimagenPerfi" style="display:none">
                            <input type="hidden" id="eidUsuario" name="eidUsuario" style="display:none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <button type="submit" id="btnEditarUsuario" class="text-white text-center fondoAzul1 pe-4 ps-4" style="border:0px;border-radius:0px;display:block;height:45px;text-decoration: none;">Editar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div elId="" class="modal" tabindex="-1" role="dialog" id="modalExito">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="static/images/check.svg" alt="">
                <div>
                    Usuario se creo con éxito
                </div>
                <div class="text-center mt-4 mb-4">
                    <button type="button" data-bs-dismiss="modal" class="boton fondoAzul1 text-white" id="btnAceptar">Aceptar</button>
                </div>
            </div>
            
        </div>
    </div>
</div>