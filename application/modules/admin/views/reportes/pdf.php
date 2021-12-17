
<?php
    $altoy = 0;
    $altox = 0;
    $minx = 1000000;
    $miny = 1000000;
    $maxx = 0;
    $maxy = 0;
    $factor = 15 / $array_coordenadas[0]->radio;

    $totalPilas = 0;
    $pilasInstaladas = 0;//pila totalmente instalada con todos los campos

    
    for ($i = 0; $i < count($array_coordenadas); $i++) {
        switch ($array_coordenadas[$i]->estadoPila) {
            case '1':
                $totalPilas++;
                break;
            case '3':
                $totalPilas++;$pilasInstaladas++;
                break;
            default:
                $totalPilas++;
                break;
        }

        $array_coordenadas[$i]->xi = $array_coordenadas[$i]->x;
        $array_coordenadas[$i]->yi = $array_coordenadas[$i]->y;

        if ($minx > $array_coordenadas[$i]->x) {
            $minx = $array_coordenadas[$i]->x;
        }
        if ($miny > $array_coordenadas[$i]->y) {
            $miny = $array_coordenadas[$i]->y;
        }
        $array_coordenadas[$i]->ide = $array_coordenadas[$i]->x . "-" . $array_coordenadas[$i]->y;
    }

    for ($i = 0; $i < count($array_coordenadas); $i++) {
        $array_coordenadas[$i]->y = $array_coordenadas[$i]->y - $miny;
        $array_coordenadas[$i]->y = $array_coordenadas[$i]->y * $factor;

        $array_coordenadas[$i]->x = $array_coordenadas[$i]->x - $minx;
        $array_coordenadas[$i]->x = $array_coordenadas[$i]->x * $factor;
    }

    for ($i = 0; $i < count($array_coordenadas); $i++) {

        if ($array_coordenadas[$i]->y > $altoy) {
            $altoy = $array_coordenadas[$i]->y;
        }
        if ($array_coordenadas[$i]->x > $altox) {
            $altox = $array_coordenadas[$i]->x;

        }
    }
  

    for ($i = 0; $i < count($array_coordenadas); $i++) {
        $array_coordenadas[$i]->y = $altoy - $array_coordenadas[$i]->y;
    }


    $transfor = 2000/$altox;
    $miC = 30;
    if($transfor>=1){
        $transfor=1;
    }
    if(30*$transfor<1){
        $miC = 5/($transfor);
    }
    $bd = $miC/2;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .circulo{
     
            width: <?php echo $miC ?>px;
            height: <?php echo $miC ?>px;
            background: #ff0000;
            text-align: center;
            border-radius: <?php echo ($miC/2) ?>px <?php echo ($miC/2) ?>px <?php echo ($miC/2) ?>px <?php echo ($miC/2) ?>px;
            border: 1px solid red;
            position: absolute;
            cursor: pointer;
        }
         .miCirculo {
            
            width: <?php echo $miC ?>px;
            height: <?php echo $miC ?>px;
            text-align: center;
            position: absolute;
            cursor: pointer;
        }
        .miCuadrado {
            
            width: <?php echo $miC ?>px;
            height: <?php echo $miC ?>px;
            text-align: center;
            position: absolute;
            cursor: pointer;
        }

        .miTriangulo {
            
            width: <?php echo $miC ?>px;
            height: <?php echo $miC ?>px;
            text-align: center;
            position: absolute;
            cursor: pointer;
        }

        
    </style>
</head>
<body>

<div>
    <div style="text-align:right;">
        <img src="http://localhost/pilas/static/images/logo.png" alt="">
    </div> <br>
    <div style="text-align:center;">
        Reporte de : <?php echo  $proyecto->nombre?>
    </div>
    <div> <br>
        <div>
            Solicitado por : <?php echo $usuario->nombres. " " . $usuario->apellidos ?>
        </div>
        <div>
            Fecha :  <?php echo $reporte->fechaRegistro ?>
        </div>
    </div>
</div>

<div>
    Pilas instaladas : <?php echo $pilasInstaladas ?> (<?php echo round($pilasInstaladas*100/$totalPilas,2) ?> % de avance)
</div>
<div>
    Pilas No instaladas : <?php echo $totalPilas - $pilasInstaladas ?> (<?php echo round(($totalPilas - $pilasInstaladas)*100/$totalPilas,2) ?> % de avance)
</div>

<br>
<br>

<div style="margin: 0 auto">

    <div id="hola" style=";position:relative;transform: scale(<?php echo $transfor  ?>);">
        
        <?php foreach($array_coordenadas as $key=>$value): ?>
            <?php
                $figura = "miCirculo";
                if($value->estadoPila==2){
                    $figura = "miCuadrado";
                }else if($value->estadoPila==3){
                    $figura = "miTriangulo";
                }
            ?>
    
            <div class="<?php echo $figura ?>" style="top:<?php echo $value->y."px" ?>;left:<?php echo $value->x."px" ?>">
                <?php 
                    switch ($value->estadoPila) {
                        case '1':
                            $totalPilas++;
                            echo "<div class='circulo' style='z-index:-1'></div>";
                            break;
                        case '3':
                            $totalPilas++;$pilasInstaladas++;
                            echo "<img src='http://localhost/pilas/static/images/rectangulo.png' style='width:".$miC."px;position: absolute;left: 0;z-index: -1;'>";
                            break;
                        default:
                            $totalPilas++;
                            echo "<img src='http://localhost/pilas/static/images/triangulo.png' style='width:".$miC."px;position: absolute;left: 0;z-index: -1;'>";
                            break;
                    }
                ?>
                <span><?php echo $value->num ?></span>
            </div>
        <?php endforeach; ?>
    
    
    </div>
</div>

<br>

</body>
</html>



