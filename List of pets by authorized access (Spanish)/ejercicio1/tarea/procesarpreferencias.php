<?php

if (isset($_POST['restablecer'])) { // Si se recibe el dato POST de restablecer preferencias, borramos las cookies y retornamos todos los tipos de mascotas
  $mascotasCookies = TIPOS_DE_MASCOTAS;
  setcookie('tipos_mascotas_LCU', '', time() - 600);
  setcookie('hash_tipos_mascotas_LCU', '', time() - 600);
  $notifs[] = "Se han restablecido las preferencias.";
} else { // Si los datos POST recibidos nos son el de restablecer preferencias, comprobamos si son los datos POST tipos [] y si estos son correctos

  if (isset($_POST['tipos']) && is_array($_POST['tipos'])) { // Comprobamos si se han introducido datos POST

    if (empty(array_diff($_POST['tipos'], TIPOS_DE_MASCOTAS))) { // Comprobamos si son tipos válidos de mascotas
      $mascotasElegidas = $_POST['tipos']; // Almacenamos los tipos de mascotas que hemos escogido mediante POST
      setcookie('tipos_mascotas_LCU', serialize($mascotasElegidas), time() + 600); // Almacenamos los tipos de mascotas en una cookie durante diez minutos
      setcookie('hash_tipos_mascotas_LCU', hash('sha256', serialize($_POST['tipos']) . SALTEADO), time() + 600); // Creamos una cookie de verificación con un hash de la cookie anterior
      $notifs[] = 'Preferencias guardadas, se mostrarán las mascotas seleccionadas en tu próxima visita';
    } else { // Si no se han introducido tipos de mascotas válidos, lo indicamos, no se guardan preferencias y mostramos todos los tipos de mascotas
      $errors[] = 'Los tipos seleccionadas no son válidas';
      $mascotasCookies = TIPOS_DE_MASCOTAS;
    }

    $mascotasCookies = $mascotasElegidas; // Si se han introducido datos POST, mostramos los tipos de mascotas seleccionados
    
  } else { // Si no se han introducido datos POST (cuando se accede a la página por primera vez) comprobamos si se han enviado cookies para que aparezcan los datos de la última visita

    if (isset($_COOKIE['tipos_mascotas_LCU']) || isset($_COOKIE['hash_tipos_mascotas_LCU'])) { // Comprobamos si existe una cookie en caso de que no se hayan mostrado datos POST

      if (hash('sha256', $_COOKIE['tipos_mascotas_LCU'] . SALTEADO) === $_COOKIE['hash_tipos_mascotas_LCU']) { // Comprobamos si la cookie es válida comparándola con el hash de la misma
        $datos = @unserialize($_COOKIE['tipos_mascotas_LCU']); // Si es válida, obtenemos el array de tipos de mascotas almacenado en la cookie
        $mascotasCookies = $datos; // Mostramos los tipos de mascotas almacenados en la cookie
        $notifs[] = "Cookie verificada"; // Informamos al usuario de que se ha verificado la cookie
      } else { // Si la cookie no es válida, borramos las cookies y mostramos todos los tipos de mascotas
        $mascotasCookies = TIPOS_DE_MASCOTAS;
        setcookie('tipos_mascotas_LCU', '', time() - 600);
        setcookie('hash_tipos_mascotas_LCU', '', time() - 600);
        $errors[] = 'Cookies no válidas';
      }
    } else { // Si no existen cookies, mostramos todos los tipos de mascotas e informamos al usuario de que no se han guardado preferencias

      $mascotasCookies = TIPOS_DE_MASCOTAS;
      $errors[] = 'No hay cookies';
    }
  }
}

return $mascotasCookies; // Devolvemos los tipos de mascotas seleccionados, almacenados en la variable $mascotasCookies según el caso
