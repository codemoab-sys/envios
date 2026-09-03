<?php 



$item = null;
$valor = null;
$orden = "id";


$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);








?>


<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">productos agregados recientemente</h3>

    </div>





    <div class="box-footer no-padding">
        <ul class="nav nav-pills nav-stacked">


            <?php 

         for($i =  0; $i < 10 ; $i++){


            echo '<li>
            
           <a href="productos"> 

                    <img src="'.$productos[$i]["imagen"].'" width="60px" style="margin-right:10px">
                    '.$productos[$i]["descripcion"].'


                    

                    <span class="label label-success pull-right"> 

                   $ '.$productos[$i]["precio_venta"]. ' 
                    
                    </span>
                    
                    </a>
                    
                    
                    </li>';

         }
        
        
        
        ?>


















        </ul>
    </div>

</div>