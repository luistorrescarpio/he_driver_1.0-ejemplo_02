<?php 
require_once("../he_driver/start.php");

switch ($obj->action) {

	case 'cerrar_session':
		session_destroy();
		header("Location: {$base_url}/index.php");
		break;

	case 'validar_acceso':
		$r = query("SELECT * FROM usuario 
					WHERE us_login='$obj->us_login'
					AND us_password='$obj->us_password' ");

		if( count($r)>0 ){
			$_SESSION["user"] = $r[0];
			$_SESSION["privilegio"] = $r[0]->us_privilegio;

			switch ($r[0]->us_privilegio) {
				case 'estudiante':
					$dir = "{$view}/estudiante/index.php";
					break;
				case 'docente':
					$dir = "{$view}/docente/index.php";
					break;
				case 'admin':
					$dir = "{$view}/admin/index.php";
					break;
			}
			res([
				"success"=>true
				,"message"=>"Validación exitosa"
				,"dir"=>$dir
			]);
		}else{
			res([
				"success"=>false
				,"message"=>"Usuario o Contraseña Incorrecta"
			]);
		}
		break;

}