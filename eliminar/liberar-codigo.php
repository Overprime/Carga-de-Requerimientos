<?php 

include("../bd/conexion.php"); 
$link=Conectarse(); 
$CODIGO=$_REQUEST['codigo'];
$USUARIO=$_REQUEST['usuario'];


$Sql="DELETE FROM [020BDCOMUN].DBO.DATOS_RQ WHERE USUARIO='$USUARIO' AND 
	CODIGODATOS_RQ='$CODIGO'";

$result         =mssql_query($Sql);

if (!$result){echo "Error al guardar";}
else{



?>

	<script>
	
	window.location = "/overprime/compras/carga-de-datos/archivo/pages/consulta";
	</script>

<?php

}





?> 