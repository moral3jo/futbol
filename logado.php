<?
require_once 'config/Partido.php';
require_once 'config/Colores.php';
$colores  = new Colores($db);
$partidos = new Partido($db);

$partidos->cargarPartido();
$partidos->jugadoresDePartido();

?>
<?
if ($login->errores) {
    foreach ($login->errores as $error) {
        echo $error;    
    }
}
?>
<div><?php echo $_SESSION['nombre']; ?> (<a href="index.php?logout">X</a>)</div>


<?
//echo $_SESSION['partido']->id;
?>
<?
//sino está invitado
?>
PARTIDO
<table border="1px">
<?
$partido = $partidos->partido;
echo '<tr>';
echo '<td>Viernes: '.date("d", strtotime($partido->dia)).'</td>';
echo '<td>'.$partido->lugar.'</td>';
echo '</tr>';
?>
</table>
<hr>

CONVOCADOS
<table>
<?

foreach ($partidos->jugadores as $jugador) {
	echo '<tr class="'.$jugador->color.'"><td>'.$jugador->nombre.'</td><td>'.$jugador->color.'</td>';
	if (($_SESSION['nombre']==$jugador->nombre)&&($jugador->color=="")){
		echo '<td>';
			echo '<a href="index.php?color=azul">AZUL</a>';
			echo '--<a href="index.php?color=rojo">ROJO</a>';
			echo '--<a href="index.php?color=zz">NO PUEDO</a>';
		echo '</td>';
	}else{
		echo "<td></td>";
	}
	echo "</tr>";
	
}
?>
</table>
<hr>
<table>
<?
if($_SESSION['nombre']=='roberto'){
$partidos->cargarInvitados();
if(count($partidos->invitados)>0){
	foreach ($partidos->invitados as $invitado) {
		echo '<tr><td>'.$invitado->nombre.'</td><td><a href="index.php?invitar='.$invitado->id.'">INVITAR</a></td></tr>';
	}
}else{echo 'No quedan invitados.';}
}
?>
</table>