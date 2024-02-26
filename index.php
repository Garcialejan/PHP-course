<?php

$contacts = [
  ["name" => "Pepe", "phone_number" => "2132139"], /*Generamos un diccionario, pero usando => en vez de {:}*/
  ["name" => "Antonio", "phone_number" => "982392"],
  ["name" => "Nate", "phone_number" => "329847"],
  ["name" => "Rodrigo", "phone_number" => "4353234"],
  ["name" => "Marcos", "phone_number" => "12312432"],
];
/*Definimos una variable que cuando se ejecute este programa, es una variable que estará disponible y que 
podremos usar en cualquier punto de nuestro HTML*/
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
            <a class="nav-link" href="./add.html">Add Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
    <main>
        <div class="container pt-4 p-3">
          <div class="row">
            <?php foreach ($contacts as $contact): ?> <!--Generamos un bucle con el PHP para establecer los contactos de manera DINÁMICA-->
              <div class="col-md-4 mb-3">
                <div class="card text-center">
                  <div class="card-body">
                    <h3 class="card-title text-capitalize"><?= $contact["name"] ?></h3> <!--Buscamos el valor del nombre del contacto-->
                    <p class="m-2"><?= $contact["phone_number"] ?></p> <!--Buscamos el valor del número del contacto-->
                    <a href="#" class="btn btn-secondary mb-2">Edit Contact</a>
                    <a href="#" class="btn btn-danger mb-2">Delete Contact</a>
                  </div>
                </div>
              </div>
          <?php endforeach ?>
        </div>
      </main>
  </main>
</body>
</html>
