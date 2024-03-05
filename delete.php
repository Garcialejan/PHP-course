<?php

require "database.php"; //No es un import como tal, con "require" es como si introducimos el code de database.php en este archivo

session_start(); //Si estamos loggeados, existe la sesion (revisar fichero login.php)

if (!isset($_SESSION["user"])) { //Si no estamos autentificados por el navegador, entonces redirigimos al php de login para que el usuario inicie la sesión
  header("LOCATION: login.php");
  return; //Si no estas autenticado no ejecutamos el resto de este código
}

//Usamos la variable super global (significa que están disponibles en cualquier archivo de nuestro PHP) $GET para ver la query string
$id = $_GET["id"];

//Podrían hacernos inyecciones de SQL, por ello utilizamos el statment y el bindParam
//A continuación, para evitar falloos en la base de datos vamos a comprobar si el id seleccionado existe, y si no existe mostraremos un error 404notfound

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$statement->bindParam(":id", $id);
$statement->execute();

if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND"); //Echo es como un print en python
  return;
}

$contact = $statement->fetch(PDO::FETCH_ASSOC); //Una vez comprobado que existe el usuario, sacamos la info del usuario (sacamos un diccinario con su info con el FETCH_ASSOC)
if ($contact["user_id"] !== $_SESSION["user"]["id"]) { //Si el contacto anterior es distinto al de la sesion, sacamos un error 403 (no autorizado)
  http_response_code(403);
  echo("HTTP 403 UNAUTHORIZED");
  return;
}

// Shortcut para no tener que hacer el bind usando un array asociativo $statement->execute([":id" => $id]);
$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

$_SESSION["flash"] = ["message" => "Contact {$contact["name"]} deleted."]; //Mensaje tipo flash cuando se elimina un contacto ya existente

header("LOCATION: home.php");
