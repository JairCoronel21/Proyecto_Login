<?php
       // recuperar contraseña

	   require 'database/config.php';
	   require 'config/funciones_email.php';
        

	   $errors = array();

	   if(!empty($_POST)){

		   $email = $mysqli->real_escape_string($_POST['email']);


		   if(!isEmail($email)) {
			   $errors[] = "Debe ingresar un correo electronico valido";

                if(emailExiste($email)) {

					$user_id = getValor('id', 'correo', $email);
					$user_id = getValor('nombre', 'correo', $email);

					$token

				}
			   
		   }
	   }



?>


<!DOCTYPE html>
<html>


