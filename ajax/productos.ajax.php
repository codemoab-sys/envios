<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelo/productos.modelo.php";






class AjaxProductos{


    public $idCategoria;

    public function ajaxCrearCodigoProducto(){

        $item="id_categoria";
        $valor=$this->idCategoria;
        $orden="id";

        $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor,$orden);

        echo json_encode($respuesta);


    }





/*=============================================
  EDITAR PRODUCTO
  =============================================*/ 
  public $idProducto;
  public $traerProducto;
  public $nombreProducto;

    public function ajaxEditarProducto(){


    if($this->traerProducto == "ok"){

            $item=null;
            $valor=null;
            $orden="id";

            $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor,$orden);

            echo json_encode($respuesta);



    }else if($this->nombreProducto != ""){

            $item="descripcion";
            $valor=$this->nombreProducto;
            $orden="id";

            $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor,$orden);

            echo json_encode($respuesta);


        
    }else{


    $item="id";
            $valor=$this->idProducto;
            $orden="id";

            $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor,$orden);

            echo json_encode($respuesta);


    }


}




}

/*=============================================
EDITAR PRODUCTO
=============================================*/	

if(isset($_POST["idProducto"])){

    $editarProduto=new AjaxProductos();
    $editarProduto->idProducto=$_POST["idProducto"];
    $editarProduto->ajaxEditarProducto();



}



/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/	

if(isset($_POST["idCategoria"])){

$codigoProducto=new AjaxProductos();
$codigoProducto->idCategoria =$_POST["idCategoria"];
$codigoProducto->ajaxCrearCodigoProducto();

}

/*=============================================
GENERAR CÓDIGO A PARTIR DE ID CATEGORIA
=============================================*/	

if(isset($_POST["traerProductos"])){

$traerProductos=new AjaxProductos();
$traerProductos->traerProducto =$_POST["traerProductos"];
$traerProductos->ajaxEditarProducto();

}


/*=============================================
TRAER PRODUCTO
=============================================*/	

if(isset($_POST["nombreProducto"])){

$traerProductos=new AjaxProductos();
$traerProductos->nombreProducto =$_POST["nombreProducto"];
$traerProductos->ajaxEditarProducto();

}




?>