<?php
include 'cnx.php';
function espera($zona){
	global $conectar;
	$res=mysqli_query($conectar,"BEGIN WORK");
	$res=mysqli_query($conectar,"use dapp");
	$sql="select count(expediente) as n from usuarios where zona_siguiente=".$zona;
	$res=mysqli_query($conectar,$sql);
	$row=mysqli_fetch_array($res);
	$n=$row['n'];
	$res=mysqli_query($conectar,"COMMIT");
	echo $n;
}
function actual($zona){
	global $conectar;
	$res=mysqli_query($conectar,"BEGIN WORK");
	$res=mysqli_query($conectar,"use dapp");
	$sql="select count(expediente) as n from usuarios where zona_actual=".$zona;
	$res=mysqli_query($conectar,$sql);
	$row=mysqli_fetch_array($res);
	$n=$row['n'];
	$res=mysqli_query($conectar,"COMMIT");
	echo $n;
}
?>
<DOCTYPE! html>
<html>
	<head>
	</head>
	<body>
		<?php
			$res=mysqli_query($conectar,"BEGIN WORK");
			$res=mysqli_query($conectar,"use dapp");
			$sql="select count(expediente) from usuarios where zona_actual!=5";
			$res=mysqli_query($conectar,$sql);
			$row=mysqli_fetch_array($res);
			$r=$row['count(expediente)'];
			$res=mysqli_query($conectar,"COMMIT");
			echo "pacientes en coi: ".$r;
		?>
		</br>
		<table>
			<tr>
				<td>zona</td><td>actualmente</td><td>en espera</td>
			</tr>
			<tr>
				<td>recepcion</td><td><?php actual(1)?></td><td></td>
			</tr>
			<tr>
				<td>toma de signos</td><td><?php actual(2);?></td><td><?php espera(2);?></td>
			</tr>
			<tr>
				<td>consulta</td><td><?php actual(3)?></td><td><?php espera(3);?></td>
			</tr>
			<tr>
				<td>informes</td><td><?php actual(6);?></td><td><?php espera(6)?></td>
			</tr>
			<tr>
				<td>sala</td><td><?php actual(4)?></td><td></td>
			</tr>
		</table>
		<br>
		<a href="./NuevoExpediente.php">Nuevo Expediente</a>
		</br>
		<a href="./Recepcion.php">Recepcion</a>
		</br>
		<a href="./Signos.php">Toma de Signos</a>
		</br>
		<a href="./Consulta.php">Consulta</a>
		<br>
		<a href="./Informes.php">Informes</a>
	</body>
</html>