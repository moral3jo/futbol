<?
require_once 'config/db.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

require_once 'config/Login.php';
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("config/password_compatibility_library.php");
}
$login = new Login($db);
?>
<?
if($login->isUsuarioLogado() == true){
?>

<?php
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("config/password_compatibility_library.php");
}

require_once("config/db.php");
require_once("config/Registration.php");

$registration = new Registration();

if ($registration->errors) {
    foreach ($registration->errors as $error) {
        echo $error;    
    }
}

if ($registration->messages) {
    foreach ($registration->messages as $message) {
        echo $message;
    }
}

?>
<form method="post" action="register.php" name="registerform">   
    
    <label for="login_input_username">Usuario</label>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
    <br>
    <label for="login_input_email">Correo</label>    
    <input id="login_input_email" class="login_input" type="email" name="user_email" required />        
    <br>
    <label for="login_input_password_new">Password</label>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />  
    <br>
    <label for="login_input_password_repeat">Repetir password</label>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
    <br>
    <label for="estado">Estado</label>    
    <input id="esado" class="login_input" type="text" name="estado" required />fi|no|si
    <br>
    <label for="codigo">Codigo</label>
    <input id="codigo" class="login_input" type="text" name="codigo" required />
    <br>
    <input type="submit"  name="register" value="Registrar" />
    
</form>

<a href="index.php">volver</a>

<?
}else{
	?>
no logado
<?
}
?>
