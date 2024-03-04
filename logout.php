<?php

session_start(); //Cogemos la sesion que nos envía el navegador con la cookie
session_destroy(); //Destruimos la sesión
header("LOCATION: index.php"); //redirigimos al usuario para que se logee de nuevo

//Necesario introducir una ruta a este fichero dentro del navbar para poder cerrar la sesión

?>
