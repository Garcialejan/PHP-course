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

<?php require "partials/header.php" ?>

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

<?php require "partials/footer.php" ?>
