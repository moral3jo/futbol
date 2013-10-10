<?php
class Partido {
	
	private $db_connection = null;	
	public $partido = null;
	public $jugadores = array();
	public $invitados = array();
	public $estado = "";
	
	function __construct($db) {
		$this->db_connection = $db;
		$this->validarDatos();
	}
	
	public function cargarPartido(){
		$sql = "SELECT id, estado, dia, lugar FROM partidos WHERE estado = 'OK' ORDER BY partidos.dia DESC";
		$listaPartidos = $this->lanzarSelect($sql);
		if ($listaPartidos->num_rows == 1) {
			$this->partido = $listaPartidos->fetch_object();
			$_SESSION['idpartido'] = $this->partido->id;
			$_SESSION['partido'] = $this->partido;
			$listaPartidos->close();
		}else{
			die("Todavía no hay partido para esta semana.");
		}
	}
	
	//ojo requiere llamar antes a cargarPartido
	public function jugadoresDePartido(){
		//recuperar jugadores
		$sql = 	"SELECT u.nombre, j.color ".
				"FROM usuarios u, jugadores j, partidos p ".
				"WHERE u.id  = j.idusuario AND p.id = j.idpartido ".
				"AND p.id = ".$_SESSION['idpartido'].
				" ORDER BY j.color ASC";
		$jugadores = $this->lanzarSelect($sql);
		if ($jugadores->num_rows > 0) {
			while ($jugador = $jugadores->fetch_object()) {
				$this->jugadores[] = $jugador;
				if(($_SESSION['nombre']==$jugador->nombre) && ($jugador->color!="")){
					$this->estado="bloqueado";
				}
			}
		}
	}
	
	public function cargarInvitados(){
		$sql = "SELECT id, nombre FROM usuarios ";
		$invitados = $this->lanzarSelect($sql);
		if ($invitados->num_rows > 0) {
			while ($invitado = $invitados->fetch_object()) {
				$enc = false;
				foreach ($this->jugadores as $jugador) {
					if($jugador->nombre==$invitado->nombre){
						$enc = true;
						break;
					}
				}
				if($enc==false)
					$this->invitados[] = $invitado;
			}
		}
    }
    
    private function validarDatos(){
		//TODO: validar todo
		//si partido actual >= hoy cerrar y crear otro ->nuevoPartido
		//sino
			//si 10 colores -> mostrar boton envio confirmación -> cerrarPartido
			//sino
				//si hace X tiempo que se aviso - reavisar
	}
	
	
	private function nuevoPartido(){
		//TODO: Crear nuevo partido para proximo viernes
		//INSERT INTO `login`.`partido` (`idpartido`, `estado`, `dia`, `lugar`) VALUES (NULL, 'OK', '2013-10-04', 'LA SALUD'), (NULL, 'KO', '2013-09-27', 'LA SINDICAL');
	}
	
	private function cerrarPartido(){
		//TODO: Partido cerrado. bloquear y enviar aviso
	}
	
	private function enviarRecordatorio($idusuario){
		//TODO: envia correo a usuario
	}
	
	
	
	private function lanzarSelect($sql){
		if (!$this->db_connection->connect_errno) {
			return $this->db_connection->query($sql);
		} else {$this->errors[] = "No hay conexion con la bbdd.";}
	}
}

?>