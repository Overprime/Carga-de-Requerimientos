<?php 

include("../bd/conexion.php"); 
$link=Conectarse(); 
$CODIGOACTUAL=$_REQUEST['codigoactual'];
$CODIGONUEVO=$_REQUEST['codigonuevo'];
$USUARIO=$_REQUEST['usuario'];
$CANTIDAD=$_REQUEST['cantidadnueva'];



$Sql="UPDATE  [020BDCOMUN].DBO.DATOS_RQ SET CANTDATOS_RQ='$CANTIDAD',CODIGODATOS_RQ='$CODIGONUEVO'
WHERE USUARIO='$USUARIO' AND CODIGODATOS_RQ='$CODIGOACTUAL'";

$result         =mssql_query($Sql);

if (!$result){echo "Error al guardar";}
else{



?>
<script type="text/javascript">alert('ACTUALIZACION EXITOSA')</script>
	<script>
	
	window.location = "/overprime/compras/carga-de-datos/archivo/pages/consulta";
	</script>

<?php

}





?> 