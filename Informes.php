<?php
session_start();
include 'cnx.php';
function muestraEsperaInformes(){
	global $conectar;
	$sql="select count(expediente) as n from usuarios where zona_siguiente=6";
	$res=mysqli_query($conectar,"BEGIN WORK");
	$res=mysqli_query($conectar,"use dapp");
	$res=mysqli_query($conectar,$sql);
	$row=mysqli_fetch_array($res);
	$n=$row['n'];
	$res=mysqli_query($conectar,"COMMIT");
	echo "Pacientes esperando para informes: ".$n."<br>";	
	}
function muestraSelect($zona){
	global $conectar;
	$sql="select * from usuarios where zona_siguiente=".$zona;
	$res=mysqli_query($conectar,"BEGIN WORK");
	$res=mysqli_query($conectar,$sql);
	$row=1;
	$select=NULL;
	echo "<select name=expediente>";
	while ($row) {
		$row=mysqli_fetch_array($res);
		$select.="<option value=".$row['expediente']." name='expediente'>".$row['expediente']."</option>";
	}
	echo $select;
	echo "</select>";
	$res=mysqli_query($conectar,"COMMIT");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<form>
		<?php
			if (isset($_GET['inicio'])) {
				$_SESSION['expediente']=$_GET['expediente'];
				$res=mysqli_query($conectar,"BEGIN WORK");
				$res=mysqli_query($conectar,"use dapp");
				$sql="select max(ID) as M from tiempos";
				$res=mysqli_query($conectar,$sql);
				$row=mysqli_fetch_array($res);
				$M=$row['M'];
				if ($M>0) {
					$max=$M+1;
				}
				else {
					$max=1;
				}
				$sql="insert into tiempos values(";
				$sql.=$max.",";
				$sql.=$_GET['expediente'].",";
				$sql.="'".date('Y-m-d')."',";
				$sql.="'".date('H:i:s')."',NULL,";
				$sql.="6)";
				$res=mysqli_query($conectar,$sql);
				$sql="update usuarios set zona_actual=6, zona_siguiente=5 where expediente=".$_SESSION['expediente'];
				$res=mysqli_query($conectar,$sql);
				$res=mysqli_query($conectar,"COMMIT");
				$_SESSION['ID']=$max;
				muestraEsperaInformes();
				echo "expediente: ".$_SESSION['expediente']."<br>";
				echo '<form method=POST>';
				echo 'zona siguiente: <select name=zonaSig>';
				$sql="select * from zonas";
				$res=mysqli_query($conectar,$sql);
				$row=1;
				$select=NULL;
				while ($row) {
					$row=mysqli_fetch_array($res);
					$select.="<option value=".$row['ID'].">".$row['zona']."</option>";
				}
				echo $select;
				echo "</select><br>";
				echo '<input type="submit" name="fin" value="fin"></input>';
				echo '</form>';
			}
			elseif (isset($_GET['fin'])) {
				$res=mysqli_query($conectar,"BEGIN WORK");
				$res=mysqli_query($conectar,"use dapp");
				$sql="update tiempos set fin=";
				$sql.="'".date('H:i:s')."' ";
				$sql.="where ID=".$_SESSION['ID'];
				$res=mysqli_query($conectar,$sql);
				$sql="update usuarios set zona_siguiente=".$_GET['zonaSig']." where expediente=".$_SESSION['expediente'];
				$res=mysqli_query($conectar,$sql);
				$sql="update usuarios set zona_actual=4 where expediente=".$_SESSION['expediente'];
				$res=mysqli_query($conectar,$sql);
				$res=mysqli_query($conectar,"COMMIT");
				muestraEsperaInformes();
				echo '<form method=POST>';
				echo 'expediente: ';
				muestraSelect(6);
				echo "<br>";
				echo '<input type="submit" name="inicio" value="inicio">';
				echo '</form>';
			}
			else {
				muestraEsperaInformes();
				echo '<form method=POST>';
				echo 'expediente: ';
				muestraSelect(6);
				echo "<br>";
				echo '<input type="submit" name="inicio" value="inicio">';
				echo '</form>';	
			}
		?>
	</form>
</body>
</html>