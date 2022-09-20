<?php
session_start();
include 'cnx.php';
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
			echo $_POST['inicio'];
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
				$sql.="1)";
				$res=mysqli_query($conectar,$sql);
				$res=mysqli_query($conectar,"COMMIT");
				$_SESSION['ID']=$max;
				echo "<br>".$sql;
				echo "expediente: ".$_SESSION['expediente']."<br>";
				echo '<form method=POST>';
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
				$res=mysqli_query($conectar,"COMMIT");
				echo '<form method=POST>';
				echo 'expediente: <input type="text" name="expediente"></input><br>';
				echo '<input type="submit" name="inicio" value="inicio">';
				echo '</form>';
			}
			else {
				echo '<form method=POST>';
				echo 'expediente: <input type="text" name="expediente"></input><br>';
				echo '<input type="submit" name="inicio" value="inicio">';
				echo '</form>';	
			}
		?>
	</form>
</body>
</html>