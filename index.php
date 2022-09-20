<?php
include 'cnx.php';
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
		<a href="./NuevoExpediente.php">Nuevo Expediente</a>
		</br>
		<a href="./Recepcion.php">Recepcion</a>
		</br>
		<a href="./Signos.php">Toma de Signos</a>
		</br>
		<a href="./Consulta.php">Consulta</a>
	</body>
</html>