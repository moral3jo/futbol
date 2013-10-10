<?
class Login {
	
	private $db = null;
    private $nombre = "";
    private $correo = "";
    private $pass = "";
    private $usuario_logado = false;
    public  $errores  = array();
    public  $mensajes = array();
	
	function __construct($db) {
		$this->db = $db;
		session_start();
		if(isset($_GET["logout"])){ //salir
			$this->logout();
		}elseif (isset($_GET["code"])) { //login URL
			$this->loginUrl($_GET["code"]);
		}elseif(!empty($_SESSION['nombre']) && ($_SESSION['usuario_logado'] == 1)) { //mantenerse
			$this->loginWithSessionData();
		}elseif (isset($_POST["login"])) { //login
			$this->loginWithPostData();
		}
	}
	private function loginUrl($code){
		//TODO: validar codigo longitud y forma antes de ir a bbdd
		$code = $this->db->real_escape_string($code);
		if (!$this->db->connect_errno) {
			// 
			$sql = "SELECT nombre, correo, pass, id FROM usuarios WHERE codigo =  '" . $code . "';"; 
			$checklogin = $this->db->query($sql);
			if ($checklogin->num_rows == 1) {
				$result_row = $checklogin->fetch_object();
				$_SESSION['id'] = $result_row->id;
				$_SESSION['nombre'] = $result_row->nombre;
				$_SESSION['correo'] = $result_row->correo;
				$_SESSION['usuario_logado'] = 1;
				$this->usuario_logado = true;
			}else{$this->errores[] = "Codigo no valido.";$this->logout();}
		}else{$this->errores[] = "Error conexion bbdd.";$this->logout();}
	}
	
	public function logout(){
		$_SESSION = array();
		session_destroy();
		$this->usuario_logado = false;
		$this->messages[] = "Desconectado.";
	}
	
	private function loginWithSessionData(){ //mantenerse conectado
		$this->usuario_logado=true;
	}
	
	private function loginWithPostData(){ //login
        if (!empty($_POST['nombre']) && !empty($_POST['pass'])) {
            if (!$this->db->connect_errno) {
                $this->nombre = $this->db->real_escape_string($_POST['nombre']);
                $checklogin = $this->db->query("SELECT id, nombre, correo, pass FROM usuarios WHERE estado in('si','fi') AND nombre = '" . $this->nombre . "';");
                if ($checklogin->num_rows == 1) {
                    $result_row = $checklogin->fetch_object();
                    if (password_verify($_POST['pass'], $result_row->pass)) {
                    	$_SESSION['id'] = $result_row->id;
                        $_SESSION['nombre'] = $result_row->nombre;
                        $_SESSION['correo'] = $result_row->correo;
                        $_SESSION['usuario_logado'] = 1;
                        $this->usuario_logado = true;
                    } else {$this->errores[] = "Error clave.";}
                } else {$this->errores[] = "El usuario no existe.";}
            } else {$this->errores[] = "No hay conexion con la bbdd.";}
        } elseif (empty($_POST['user_name'])) {$this->errores[] = "Falta usuario.";
		} elseif (empty($_POST['user_password'])) {$this->errores[] = "Falta clave.";}
	}

	public function isUsuarioLogado(){
        return $this->usuario_logado;
    }
}
