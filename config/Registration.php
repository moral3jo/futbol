<?php
class Registration
{
    private $db_connection = null;
    private $user_name = "";
    private $user_email = "";
    private $user_password = "";
    private $user_password_hash = "";
	private $estado = "";
	private $codigo = "";
    public $registration_successful = false;
    public $errors = array();
    public $messages = array();

    public function __construct(){
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    private function registerNewUser(){
        if (empty($_POST['user_name'])) {$this->errors[] = "Usuario vacio";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {$this->errors[] = "Clave vacia.";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {$this->errors[] = "No coinciden las claves.";
        } elseif (strlen($_POST['user_password_new']) < 6) {$this->errors[] = "Password minimo de 6.";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {$this->errors[] = "nombre de usuario menor de 2 y mayor de 64";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {$this->errors[] = "Usuario no valido, solo letras y numeros.";
        } elseif (empty($_POST['user_email'])) {$this->errors[] = "Email obligatorio";
        } elseif (strlen($_POST['user_email']) > 64) {$this->errors[] = "Email no mayor de 64 caracteres.";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {$this->errors[] = "Correo no valido.";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if (!$this->db_connection->connect_errno) {
                $this->user_name = $this->db_connection->real_escape_string(htmlentities($_POST['user_name'], ENT_QUOTES));
                $this->user_email = $this->db_connection->real_escape_string(htmlentities($_POST['user_email'], ENT_QUOTES));
                $this->user_password = $_POST['user_password_new'];
                $this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT);
				$this->estado = $_POST['estado'];
				$this->codigo = $_POST['codigo'];
                $query_check_user_name = $this->db_connection->query("SELECT * FROM usuarios WHERE nombre = '" . $this->user_name . "';");
                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Usuario ya existe";
                } else {
                    $query_new_user_insert = $this->db_connection->query("INSERT INTO usuarios (nombre, pass, correo, estado, codigo) VALUES('" . $this->user_name . "', '" . $this->user_password_hash . "', '" . $this->user_email . "', '" . $this->estado ."', '" . $this->codigo . "');");
                    if ($query_new_user_insert) {
                        $this->messages[] = "Cuenta creada.";
                        $this->registration_successful = true;
                    } else {
                        $this->errors[] = "Error al dar de alta usuario.";
                    }
                }
            } else {$this->errors[] = "Error con la conexion a bbdd.";}
        } else {$this->errors[] = "Error desconocido.";}
    }
}
