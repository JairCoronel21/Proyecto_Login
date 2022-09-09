
<?php

function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
}

function emailExiste($email){
    global $conexion;
    if ($conexion) 
    {
        $stmt= $conexion->prepare("SELECT user FROM id WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $email);
        if ( $stmt->execute() ) 
        {
            $stmt->store_result();
            $num= $stmt->num_rows;
            $stmt->close();
            if ($num > 0) 
            {
                return ["done"=>"Filas encontradas: $num"];
            } else {
                return ["error" => "No se encontraron filas"];
            }
        }else{
            return ["error"=>"Falló la ejecución de la consulta: {$stmt->error}"];
        }   
    }else{
            return ["error"=>"La conexión es nula. Revise su conexión"];
    }
}

function getValor($campo, $campoWhere, $valor)
	{
		global $link;
		
		$stmt = $link->prepare("SELECT $campo FROM user WHERE $campoWhere = ? LIMIT 1");
		$stmt->bind_param('s', $valor);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($_campo);
			$stmt->fetch();
			return $_campo;
		}
		else
		{
			return null;	
		}
	}

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	function enviarEmail($email, $nombre, $asunto, $cuerpo){

	  
		require 'vendor/autoload.php';

		try {
		    $mail = new PHPMailer(true);
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'jilmercoronel7@gmail.com';
			$mail->Password = 'wtdgjoywvhclpzsd';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
		
		
		$mail->setFrom('jilmercoronel7@gmail.com', 'SOFTGOLD');
		$mail->addAddress($email, $nombre);

		$mail->isHTML(true);
		
		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
		
		
		if($mail->send()) {
		     return true;
			}else
			return false;
		}catch (Exception $e) {
			echo 'Mensaje' . $email->ErrorInfo;
		}
	}


    function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">[X]</a>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}