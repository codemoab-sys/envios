<?php 

require_once "conexion.php";

class ModeloProductos{



	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/

	    static public function mdlMostrarProductos($tabla, $item,$valor,$orden){

		$tenantId = Conexion::tenantId();
		if($tenantId <= 0) return $item != null ? false : array();


        if($item !=null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND tenant_id=:tenant_id ORDER BY id DESC");

            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();

        }else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE tenant_id=:tenant_id ORDER BY $orden DESC");
			$stmt->bindValue(":tenant_id", $tenantId, PDO::PARAM_INT);

            $stmt -> execute();

			return $stmt -> fetchAll();

        }

        $stmt -> close();

		$stmt = null;



    }



	static public function mdlMostrarSumaVentas($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(ventas) as total FROM $tabla WHERE tenant_id=:tenant_id");
		$stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;








	}


    static public function mdlEliminarProducto($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id AND tenant_id=:tenant_id");

        $stmt -> bindParam(":id", $datos, PDO::PARAM_INT);
		$stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);

        if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;



    }







    static public function mdlIngresarProducto($tabla,$datos){


		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tenant_id,id_categoria,codigo,descripcion,imagen,stock,precio_compra,precio_venta)VALUES(:tenant_id,:id_categoria,:codigo,:descripcion,:imagen,:stock,:precio_compra,:precio_venta)");
		 $stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);


         $stmt -> bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
         $stmt -> bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
         $stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
         $stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
         $stmt -> bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
         $stmt -> bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);
         $stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);

         if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

    }



    static public function mdlEditarProducto($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria=:id_categoria,descripcion=:descripcion,imagen=:imagen,stock=:stock,precio_compra=:precio_compra,precio_venta=:precio_venta WHERE codigo=:codigo AND tenant_id=:tenant_id");
		$stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);

        $stmt->bindParam(":id_categoria", $datos["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra", $datos["precio_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_venta", $datos["precio_venta"], PDO::PARAM_STR);

        if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;


    }



    /*=============================================
	ACTUALIZAR PRODUCTO
	=============================================*/
    static public function mdlActualizarProducto($tabla, $item1, $valor1, $valor){

        $columnasPermitidas = ["estado", "stock"];
        if(!in_array($item1, $columnasPermitidas)){
            return "error";
        }

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :valor WHERE id = :id AND tenant_id=:tenant_id");
		$stmt->bindValue(":tenant_id", Conexion::tenantId(), PDO::PARAM_INT);

        $stmt -> bindParam(":valor", $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

        	if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;







    }




}



?>