
<?php 
include("../bd/conexion.php");

$link=Conectarse();

//Iniciar SesiÃ³n
session_start();

//Validar si se estÃ¡ ingresand con sesiÃ³n correctamente
if (!$_SESSION){
echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "/overprime/compras/carga-de-datos/acceso"
</script>';
}

$id_usuario = $_SESSION['id_usuario'];

$consulta= "SELECT apellidos,dni FROM [020BDCOMUN].DBO.USUARIOS
WHERE id_usuario='".$id_usuario."'"; 
$resultado= mssql_query($consulta,$link) or die (mssql_error());
$fila=mssql_fetch_array($resultado);
$apellidos = $fila['apellidos'];
$edad = $fila['edad'];


//Variable de sesion 

$usuario=$_SESSION['id_usuario'];
$solicitante=$_SESSION['starsoft'];


$Requerimiento=$_REQUEST['requerimiento'];
$Centro=$_REQUEST['centro'];
$Orden=$_REQUEST['orden'];
$Maquina=$_REQUEST['maquina'];
$Fecha=date('Y-m-d');


/*Insertamos los nuevos Datos*/


$Sql="INSERT INTO [011BDCOMUN].DBO.REQUISD(NROREQUI,codpro,DESCPRO,UNIPRO,CANTID,ESTREQUI,FECREQUE,REQITEM,
SALDO,CENCOST,REMAQ,TIPOREQUI,ORDFAB_REQUI)
SELECT '$Requerimiento',CODIGODATOS_RQ,M.ADESCRI,M.AUNIDAD,D.CANTDATOS_RQ,'P','$Fecha',
(ROW_NUMBER() OVER(ORDER BY  D.CODIGODATOS_RQ))AS ITEM,D.CANTDATOS_RQ,'$Centro',
'$Maquina','RQ','$Orden' 
FROM [020BDCOMUN].DBO.DATOS_RQ AS D INNER JOIN [011BDCOMUN].DBO.MAEART AS M ON 
D.CODIGODATOS_RQ=M.ACODIGO  WHERE D.USUARIO='$usuario' AND  M.AESTADO='V'/*
ORDER BY (ROW_NUMBER() OVER(ORDER BY  D.CODIGODATOS_RQ))*/";


$Sql1="INSERT INTO [020BDCOMUN].DBO.AUD_RQ 
VALUES('$Requerimiento','$solicitante','RQ','$usuario',
GETDATE(),'P','','$Orden','$Centro')";

$Sql2="DELETE FROM [011BDCOMUN].DBO.REQUISD
WHERE NROREQUI='$Requerimiento' AND codpro='TEXTO' AND DESCPRO='RQEXCEL'";


$Sql3="DELETE FROM [020BDCOMUN].DBO.DATOS_RQ WHERE USUARIO='$usuario'";

$result=mssql_query($Sql);
if (!$result){echo "Error al guardar";}

else {

$result1=mssql_query($Sql1);
$result2=mssql_query($Sql2);
$result3=mssql_query($Sql3);


header('Location: /overprime/compras/carga-de-datos/pages/respuesta?rq='.urlencode($Requerimiento));

}

?>