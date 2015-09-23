<!DOCTYPE html>
<html lang                 ="es">
<head>
<?php include('../../header.php'); ?>
<?php //include('../../bd/conexion.php'); ?>
<meta charset              ="UTF-8">
</head>
<body>

<div class                 ="container">
<div class                 ="row clearfix">
<div class                 ="col-md-4 column">
<form 
action                     ="/overprime/compras/carga-de-datos/registrar/grabar-requerimiento-orden.php"
method="POST" autocomplete="Off">
<label for                 ="">Requerimiento:</label>
<?php $Starsoft=$_SESSION['starsoft'];
//echo "$Starsoft"; ?>
<select name               ="requerimiento" class="form-control" required>
<option value              ="">Selecciona el requerimiento...</option>
<?php
$link                      =Conectarse();
$Sql                       ="SELECT C.NROREQUI,C.CODSOLIC FROM [011BDCOMUN].DBO.REQUISC 
AS C INNER JOIN [011BDCOMUN].DBO.REQUISD AS D 
ON  C.NROREQUI=D.NROREQUI WHERE DESCPRO='RQEXCEL' AND codpro='TEXTO' 
AND CODSOLIC='$Starsoft'
order by NROREQUI";
$result                    =mssql_query($Sql) or die(mssql_error());
while ($row                =mssql_fetch_array($result)) {
?>
<option value              ="<?php echo $row['NROREQUI']?>">
<?php echo $row['NROREQUI'];?></option>
<?php }?>
</select>
<label for                 ="">Nro. de Máquina:</label>
<input type                ="text" name="maquina"  class="form-control" 
onchange                   ="conMayusculas(this)">
</div>
<div class                 ="col-md-4 column">
<label for                 ="">Orden de fabricación:</label>
<select name               ="orden" class="form-control" >
<option value              ="">Seleccione la o/t...</option>
<?php
$link                      =Conectarse();
$Sql                       ="SELECT OF_COD,OF_ARTNOM,OF_ESTADO FROM [011BDCOMUN].dbo.ORD_FAB
WHERE OF_ESTADO            ='ACTIVO' ORDER BY OF_COD";
$result                    =mssql_query($Sql) or die(mssql_error());
while ($row                =mssql_fetch_array($result)) {
?>
<option value              ="<?php echo $row['OF_COD']?>">
<?php echo $row['OF_COD'];?></option>
<?php }?>
</select>
<label for                 ="">Centro de Costo:</label>
<select name               ="centro" class="form-control" required>
<option value              ="">Seleccione el centro de costo...</option>
<?php
$link                      =Conectarse();
$Sql                       ="SELECT  CENCOST_CODIGO,CENCOST_DESCRIPCION,
(CENCOST_DESCRIPCION+' - '+CENCOST_CODIGO)as fullname
from [011BDCONTABILIDAD].DBO.CENTRO_COSTOS

order by  CENCOST_CODIGO";
$result                    =mssql_query($Sql) or die(mssql_error());
while ($row                =mssql_fetch_array($result)) {
?>
<option value              ="<?php echo $row['CENCOST_CODIGO']?>">
<?php echo $row['fullname'];?></option>
<?php }?>
</select>

<!-- incio modal grabar	 -->
<div class                 ="modal fade" id="modal-container-160169" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class                 ="modal-dialog">
<div class                 ="modal-content">
<div class                 ="modal-header">
<button type               ="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class                  ="modal-title" id="myModalLabel">
Confirmación...
</h4>
</div>
<div class                 ="modal-body">
Tenga en cuenta que solo se grabaran  los registros que tengan el simbolo
<i class                   ="glyphicon glyphicon-ok-circle text-primary"></i>.</br>
¿Esta seguro de proceder con la carga de datos?
</div>
<div class                 ="modal-footer">

<button type               ="submit" class="btn btn-primary">SI</button>
<button type               ="button" class="btn btn-default" data-dismiss="modal">NO</button> 
</form>
</div>
</div>

</div>

</div>
<!-- 	fin modal grabar -->
</div>
<div class                 ="col-md-2 column">
<br>	
<a id                      ="modal-160169" href="#modal-container-160169" 
role                       ="button" class="btn btn-success" data-toggle="modal">Grabar</a>

</div>
<div class                 ="col-md-2 column">
<ul class                  ="nav navbar-nav navbar-right">
<li>
<a href                    ="#"><i class="glyphicon glyphicon-cog">
</i></a>
</li>
<li class                  ="dropdown">
<a href                    ="#" class="dropdown-toggle" data-toggle="dropdown"><strong class="caret">
</strong></a>
<ul class                  ="dropdown-menu">
<li>
<a id                      ="modal-681841" href="#modal-container-681841" 
role                       ="button" class="btn btn-danger" 
data-toggle                ="modal">Liberar</a>
</li>

</ul>
</li>
</ul>
</div>
</div>


<div class                 ="row clearfix">
<div class                 ="col-md-12 column">
<p></p>
<div class                 ="table-responsive">

<table class               ="table table-bordered table-condensed">
<thead>
<tr class                  ="success">
<th class="text-primary">ITEM</th>
<th class="text-primary">CÓDIGO</th>
<th class="text-primary">DESCRIPCIÓN</th>
<th class="text-primary">UNIDAD</th>
<th class="text-primary">CANT.</th>
<th class="text-primary">STOCK</th>
<!--  
<th>&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-trash text-danger"></i></th>
<th>&nbsp;&nbsp;&nbsp;<i class="glyphicon glyphicon-edit text-success"></i></th>
<th><span class            ="glyphicon glyphicon-refresh text-priamary"></span></th> 
-->
<th><i class="glyphicon glyphicon-eye-open text-primary" ></i></th>



</tr>
</thead>
<!-- Vatiable de sesion -->
<?php 
$usuario                   =$_SESSION['id_usuario'];
?>
<?php 
$link                      =Conectarse();

$sql="SELECT IDDATOS_RQ,CASE WHEN RTRIM(ACODIGO)   = '' THEN 'NO'
ELSE ISNULL(ACODIGO, 'NO') END EXISTE
,CODIGODATOS_RQ,CANTDATOS_RQ,AUNIDAD,ADESCRI,
STSKDIS AS STOCK FROM [020BDCOMUN].DBO.DATOS_RQ AS D
LEFT JOIN [011BDCOMUN].DBO.MAEART AS M ON
D.CODIGODATOS_RQ=M.ACODIGO LEFT JOIN [011BDCOMUN].DBO.STKART AS S 
ON D.CODIGODATOS_RQ=S.STCODIGO  WHERE D.USUARIO='$usuario' AND  M.AESTADO='V'
ORDER BY IDDATOS_RQ
";  
$result                    = mssql_query($sql) or die(mssql_error());
if(mssql_num_rows($result) ==0) die("NO TENEMOS DATOS PARA MOSTRAR");

while($row                 =mssql_fetch_array($result))
{

?>
<tbody>
<tr class                  ="active">
<?php 	
$txta                      ='modal-containera-';
$txtxa                     ='#modal-containera-';
$txta                      .=$j;
$txtxa                     =$txtxa.=$j;

$txt                       ='modal-container-';
$txtx                      ='#modal-container-';
$txt                       .=$i;
$txtx                      =$txtx.=$i;
?>
<td><b><?php echo utf8_encode($row[IDDATOS_RQ]); ?></b>  </td>
<td><?php echo utf8_encode($row[CODIGODATOS_RQ]); ?>  </td>
<td><?php 	
if ($row[ADESCRI]=='') {
echo "<label class='text-danger'>EL CÓDIGO NO EXISTE O ESTA MAL ESCRITO.......VERIFICAR POR FAVOR :( !!!!!!</label>";
}
else {
echo utf8_encode($row[ADESCRI]);
}
?>	
</td>
<td><?php echo utf8_encode($row[AUNIDAD]); ?>  </td>
<td><?php echo utf8_encode($row[CANTDATOS_RQ]); ?>  </td>


<td><?php 
if ($row[STOCK]==0) {
?>
<label class="text-danger">0</label>
<?php
}
else
{
echo $row[STOCK]; 
}
?>
</td>
<!--  
<td>	<a id              ="modal-11978" href='<?php echo $txtxa;?>' role="button" 
class                      ="btn" data-toggle="modal">
<span class                ="glyphicon glyphicon-trash text-danger"></span></a></td> 

<td>	<a id              ="modal-11978" href='<?php echo $txtx;?>' role="button" 
class                      ="btn" data-toggle="modal">
<span class                ="glyphicon glyphicon-edit text-success"></span></a></td> 
-->
<td>
<?php 	
if ($row[EXISTE]           =='NO') {
?>
<i class                   ="glyphicon glyphicon-remove-circle text-danger"></i>
<?php
}

ELSE	{
?>
<i class                   ="glyphicon glyphicon-ok-circle text-primary"></i>
<?php
}

?>  
</td>


<!-- INICIO MODAL ELIMINAR	 -->
<div class="modal fade" id="<?php echo $txta;?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class="modal-title text-danger" id="myModalLabel">
CONFIRMACIÓN
</h4>
</div>
<div class="modal-body">
¿ESTA SEGURO DE ELIMINAR EL ÁRTICULO 
<label class="text-danger">	<?php echo $row[CODIGODATOS_RQ]; ?></label>	?
</div>
<div class="modal-footer">
<a href="../../eliminar/liberar-codigo.php?codigo=<?php echo $row[CODIGODATOS_RQ];?>&
usuario=<?php echo $usuario;?>" class="btn btn btn-primary">SI ESTOY SEGURO</a>
<button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>

</div>
</div>

</div>

</div>

<!--FIN MODAL ELIMINAR 	 -->

<!-- INICIO MODAL ACTUALIZAR -->
<div class="modal fade" id="<?php echo $txt;?>" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class="modal-title text-primary" id="myModalLabel">
ACTUALIZAR
</h4>
</div>
<div class="modal-body">

<form action="../../actualizar/codigo.php" method="POST" autocomplete="Off">
<input type="hidden" name="usuario"value="<?php echo $usuario; ?>">
	<label for="">CÓDIGO ACTUAL:</label>
	<input type="text" name="codigoactual" class="form-control"  value="<?php echo  $row[CODIGODATOS_RQ]; ?>" readonly>
    <label class="text-primary">CÓDIGO NUEVO:</label>
	<input type="text" name="codigonuevo" class="form-control" value="<?php echo  $row[CODIGODATOS_RQ]; ?>" >
	<label for="">DESCRIPCIÓN:</label>
	<input type="text" name="descripcion" class="form-control"
	 readonly="" value='<?php if ($row[ADESCRI]=='') {
echo "EL CÓDIGO NO EXISTE O ESTA MAL ESCRITO.......VERIFICAR POR FAVOR :( !!!!!!";
}
else {
echo utf8_encode($row[ADESCRI]);
}  ?>'  maxlength="200">
	<label for="">CANTIDAD ACTUAL:</label>
	<input type="text" name="cantidadactual" class="form-control" readonly="" value="<?php echo $row[CANTDATOS_RQ]?>">
	<label class="text-primary">CANTIDAD NUEVA:</label>
	<input type="number" name="cantidadnueva" class="form-control" value="<?php echo $row[CANTDATOS_RQ]?>" required min="1" >


</div>
<div class="modal-footer">
<button type="submit" class="btn btn-primary">ACTUALIZAR</button>
<button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
</form>
</div>
</div>

</div>

</div>

<!--FIN MODAL ACTUALIZAR 	 -->

</tr>

<?php 
$i                         =$i+1;
$j                         =$j+1; 

}?>
</tbody>
</table>
</div>
</div>
</div>
</div>





<div class                 ="modal fade" id="modal-container-681841" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class                 ="modal-dialog">
<div class                 ="modal-content">
<div class                 ="modal-header">
<button type               ="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
<h4 class                  ="modal-title" id="myModalLabel">
Confirmación...
</h4>
</div>
<div class                 ="modal-body">
<p>Este proceso eliminara toda la data cargada.</p>
<p>¿Desea continuar...?</p>
</div>
<div class                 ="modal-footer">
<a href                    ="/overprime/compras/carga-de-datos/eliminar/liberar-data-excel.php" class="btn btn-primary">SI</a>
<button type               ="button" class="btn btn-default" data-dismiss="modal">NO</button>

</div>
</div>

</div>

</div>
</body>
</html>