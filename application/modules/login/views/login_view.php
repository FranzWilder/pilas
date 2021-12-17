<!DOCTYPE HTML>
<html>

<head><meta charset="euc-jp">
    <base href="<?php echo base_url(); ?>">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="static/main/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="static/modules/login/css/estilo.css">
    <!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    <script src="static/main/jquery.js"></script>

    <style>
        .fondoAzul{background: #00326c;}
        .fondoCeleste{background: #8aa9e2;}
        .colorAzul{color: #00326c;}
        .inputLinea{border-width: 0 0 2px 0;border-radius:0;    padding-left: 40px;background: none;}
        
        textarea:focus, input:focus{
            box-shadow: none !important;
            background-color: inherit !important;
        }
        
        @font-face {
          font-family: Roboto;
          src: url(static/main/fonts/Roboto-Regular.ttf);
        }
        body{
            font-family: Roboto;
            background:#0000000D;
        }
        
        @media (min-width: 600px) {
          #caraAzul:after {
            content: '';
            width: 182px;
            height: 100%;
            position: absolute;
            transform: skewX(-7deg);
            border: 1px solid #00397c;
            border-left: 1px solid transparent;
            top: 0px;
            right: -113px;
            /* border-top-right-radius: 6px; */
            background: #00397c;
        }
        }
        
        
    </style>
    
    <script>
        $(function(){
            $("#caraAzul").css("height",$(window).height());
        });
    </script>
</head>



<body>
    <div class="container-fluid">

        <div class="row">
            
            <div class="col-md-6 position-relative" id="caraAzul"  style="background: #00397C;">
                <div class="row" style="margin: auto;margin-top: 48%;">
                    <div class="col-md-6" style="text-align: right;">
                    <img src="static/images/pilaslogo.svg">
                    </div>
                    <div class="col-md-6 text-white">
                        <div style="font-size: 24px;">Sistema de </div>
                        <div style="line-height: 27px;font-size: 35px;">Gestión de pilas</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div>
                            <form method="post" style="margin-top: 48%;"> 
                                <br>
                                <br>
                                <br>
                                <br>
                                <div class="row text-center">
                                    <img src="static/images/logo.svg" style="width:114px;margin:0 auto">
                                </div>
        
                                <br>
        
                                <div class="mb-3 position-relative">
                                    <img src="static/images/persona.svg" class="position-absolute" style="top:2px">
                                    <input class="form-control inputLinea mb-4"  name="email" type="email" placeholder="    Correo">
                                </div>
        
                                <div class="mb-3 position-relative">
                                    <img src="static/images/llave.svg" class="position-absolute" style="top:7px">
                                    <input class="form-control inputLinea mb-4"  name="contrasena" type="password" placeholder="    Contraseña">
                                </div>
        
                                
        
        
        
                               <div class="form-group row mt-5">
                                    <div class="col-md-12" style="    text-align: center;">
                                        <button type="submit" class="" style="    background: #00326C;color: white;border: 0;border-radius: 10px;padding: 15px 136px;font-size: 14px;">Iniciar sesión</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
           
                    
        </div>
    </div>
</body>

</html>