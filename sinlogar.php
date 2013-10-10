<?

if ($login->errores) {
    foreach ($login->errores as $error) {
        echo $error;
    }
}

if ($login->mensajes) {
	foreach ($login->mensajes as $mensaje) {
		echo $mensaje;
	}
}
?>

<form method="post" action="index.php" name="loginform">
    <label for="login_input_username">Usuario</label>
    <input id="login_input_username" type="text" name="nombre" required />

    <label for="login_input_password">Clave</label>
    <input id="login_input_password" class="login_input" type="password" name="pass" autocomplete="off" required />

    <input type="submit"  name="login" value="Entrar" />
</form>

<a href="register.php">Registrar</a>
