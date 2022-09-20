<?php
include 'cnx.php';

if (isset($_POST['registro'])) {
	$res=mysqli_query($conectar,"BEGIN WORK");
	$res=mysqli_query($conectar,"use dapp");
	$sql="select max(expediente) as M from usuarios";
	$res=mysqli_query($conectar,$sql);
	$row=mysqli_fetch_array($res);
	$M=$row['M'];
	if ($M>0) {
		$max=$M+1;
	}
	else {
		$max=1;
	}
	$sql="insert into usuarios values(";
	$sql.=$max.",";
	$sql.="'".$_POST['apellidos']."',";
	$sql.="'".$_POST['nombre']."',";
	$sql.="'".$_POST['nacimiento']."',";
	$sql.="'".$_POST['primeraCons']."',";
	$sql.="'".$_POST['diagnostico']."',";
	$sql.="'".$_POST['especialidad']."',";
	$sql.="'".$_POST['estatus']."',";
	$sql.="'".$_POST['comentarios']."',";
	$sql.="'".$_POST['histologia']."',";
	$sql.="'".$_POST['estadoClin']."',";
	$sql.="5".",";
	$sql.="5".")";
	$res=mysqli_query($conectar,$sql);
	$res=mysqli_query($conectar,"COMMIT");
}
?>
<DOCTYPE! html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<form method=POST>
		apellidos: 
		<input type="text" name="apellidos">
		<br>
		nombre: 
		<input type="text" name="nombre">
		<br>
		fecha de nacimiento: 
		<input type="date" name="nacimiento">
		<br>
		fecha de primera consulta: 
		<input type="date" name="primeraCons">
		<br>
		diagnostico: 
		<input type="text" name="diagnostico">
		<br>
		especialidad: 
		<input type="text" name="especialidad">
		<br>
		estatus: 
		<input type="text" name="estatus">
		<br>
		comentarios: 
		<input type="text" name="comentarios">
		<br>
		hitologia: 
		<input type="text" name="histologia">
		<br>
		estado clinico: 
		<input type="text" name="estadoClin">
		<br>
		<input type="submit" name="registro" value="registrar">
	</form>
</body>
</html>