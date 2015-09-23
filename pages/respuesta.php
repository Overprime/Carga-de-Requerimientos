<!DOCTYPE html>
<html lang="es">
<head>
<?php 
$Requerimiento=$_REQUEST['rq'];

include('../header.php');?>
</head>
<body>



<div class="container">

<div class="row clearfix">
<div class="col-md-4 column">
</div>
<div class="col-md-4 column">
<img src="../img/aprobado.png" alt="" class="img-responsive">
<h3 class="text-primary">El requerimiento 
<?php echo $Requerimiento; ?> fue insertado exitosamente.</h3>

<a href="/overprime/compras/carga-de-datos/home" 
class="btn btn-success">VOLVER AL INICIO</a>
</div>

</div>

</div>
</body>
</html>