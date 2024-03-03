<?php

/*Definimos una variable que cuando se ejecute este programa, es una variable que estará disponible y que 
podremos usar en cualquier punto de nuestro HTML
* Definimos un bucle if, en el que si existe en fichero contacts.json generado en el add.php, nos generere los contactos en el index*/
/*if (file_exists("contacts.json")) {
  $contacts = json_decode(file_get_contents("contacts.json"), true); /*Con json_decode convertimos un json en un string (array asociativo con el parámetro assoc en true)*/
/*} else{
  $contacts = []; /*Generamos una lista vacía ya que no tenemos ningún contacto en nuestra base de datos
}*/ 
// Dejamos todo lo anterior comentado porque lo implementamos antes de genera la base de datos con Mysql.
// A continuación establecemos la conexión con la base de datos
// En PHP, el operador -> se utiliza para acceder a métodos y propiedades de un objeto

require "database.php";

$contacts = $conn->query("SELECT * FROM contacts"); //El método query ejecuta una consulta SQL con la que pedimos los datos a la base de datos

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.3.2/darkly/bootstrap.min.css"
        integrity="sha512-JjQ+gz9+fc47OLooLs9SDfSSVrHu7ypfFM7Bd+r4dCePQnD/veA7P590ovnFPzldWsPwYRpOK1FnePimGNpdrA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <script
        defer 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"
    ></script> <!-- Colocamos el defer para que no cargue el javascript antes que el HTML-->

    <!-- Static Content -->
    <link rel="stylesheet" href="./static/css/index.css">
    <title>Contacts App</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand font-weight-bold" href="#">
        <img class="mr-2" src="./static/img/logo.png" />
        ContactsApp
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php">Add Contact</a> <!--Linkeamos para que cuando se aprete add contact vaya al add.php-->
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <main>
        <div class="container pt-4 p-3">
          <div class="row">

          <?php if ($contacts->rowCount() == 0): ?> <!--El count() en PHP es como el len() de Python. Usamos rowCount(), porque si las filas son cero no hay datos
            * Con el siguiente, cuando no hay contactos, el usario lo que verá será un mensaje de que no tiene contcatos actualmente-->
            <div class="col-md-4 mx-auto">
              <div class="card card-body text-center">
                <p>No contacts saved yet</p>
                <a href="add.php">Add One!</a>
              </div>
            </div>
          <?php endif ?>
            <?php foreach ($contacts as $contact): ?> <!--Generamos un bucle con el PHP para establecer los contactos de manera DINÁMICA-->
              <div class="col-md-4 mb-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3> <!--Buscamos el valor del nombre del contacto-->
                    <p class="m-2"><?= $contact["phone_number"] ?></p> <!--Buscamos el valor del número del contacto-->
                    <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
                    <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
                    <!--Con el "?" (query string) metemos el contenido directamente en la URL y extraemos la id que quereos que borre-->
                  </div>
                </div>
              </div>
          <?php endforeach ?>
        </div>
      </main>
  </main>
</body>
</html>
