<?php

require "database.php"; //No es un import como tal, con "require" es como si introducimos el code de database.php en este archivo

//Usamos la variable super global (significa que están disponibles en cualquier archivo de nuestro PHP) $GET para ver la query string
$id = $_GET["id"];

//Podrían hacernos inyecciones de SQL, por ello utilizamos el statment y el bindParam
//A continuación, para evitar falloos en la base de datos vamos a comprobar si el id seleccionado existe, y si no existe mostraremos un error 404notfound

$statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id");
$statement->bindParam(":id", $id);
$statement->execute();

if ($statement->rowCount() == 0) {
  http_response_code(404);
  echo("HTTP 404 NOT FOUND"); //Echo es como un print en python
  return;
}

// Shortcut para no tener que hacer el bind usando un array asociativo $statement->execute([":id" => $id]);
$conn->prepare("DELETE FROM contacts WHERE id = :id")->execute([":id" => $id]);

header("LOCATION: index.php");
