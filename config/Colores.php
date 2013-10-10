<?php
class Colores {
	private $db_connection = null;	
	
	function __construct($db) {
		$this->db_connection = $db;
		if(isset($_GET["color"])){
			$this->elegirColor($_GET["color"]);
		}elseif(isset($_GET["invitar"])){
			$this->invitar($_GET["invitar"]);
		}
	}
	
	private function elegirColor($color){ //azul rojo no_puedo
		//TODO: revisar si se llega aqui con todo valido
		$color = $this->db_connection->real_escape_string($color);
		if($color=='azul' || $color=='rojo' || $color=="zz"){ //color es valido
			// mirar ya tiene color elegido
			$sql = 	"SELECT j.idusuario ".
					"FROM jugadores j ".
					"WHERE j.idusuario = '".$_SESSION['id']."' AND j.color != ''";
			$tieneColor = $this->lanzarSelect($sql);
			if ($tieneColor->num_rows > 0) {
				echo "Ya tiene color asignado.";
			}else{
				//TODO: mirar si hay 5 personas en ese color ya
				$sql = "UPDATE jugadores SET color = '".$color."' WHERE idpartido = ".$_SESSION['idpartido']." AND idusuario = ".$_SESSION['id']." ";
				mysqli_query($this->db_connection, $sql);
			}
		}else{
			echo "Color no valido.";
		}
	}
	
	private function invitar($idinvitar){
		$idinvitar = $this->db_connection->real_escape_string($idinvitar);
		if($_SESSION['nombre']=='roberto'){
			if($idinvitar!=""){
				$sql = 	"SELECT j.idusuario ".
					"FROM jugadores j ".
					"WHERE j.idusuario = '".$idinvitar."'";
				$yaInvitado = $this->lanzarSelect($sql);
				if ($yaInvitado->num_rows == 0) {
					$sql = "INSERT INTO  jugadores (`idusuario` ,`idpartido` ,`color`) VALUES ('".$idinvitar."',  '".$_SESSION['idpartido']."', '')";
					mysqli_query($this->db_connection, $sql);
				}else{
					echo "ya invitado";
				}
			}else{
				echo "falta id de invitado";
			}
		}else{
			echo "Invitando pero a una copa";
		}
	}
	
	private function lanzarSelect($sql){
		if (!$this->db_connection->connect_errno) {
			return $this->db_connection->query($sql);
		} else {$this->errors[] = "No hay conexion con la bbdd.";}
	}
}

?>