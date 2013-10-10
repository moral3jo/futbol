<?
require_once 'config/db.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

require_once 'config/Login.php';
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("config/password_compatibility_library.php");
}
$login = new Login($db);
?>
<html>
<head>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?
if($login->isUsuarioLogado() == true){
	include 'logado.php';
}else{
	include 'sinlogar.php';
}
?>
</body>
</html>