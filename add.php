<!--Con el PHP diferenciamos cuando nos están pidiendo el formulario y cuando nos están mandando datos-->

<?php
  require "database.php"; //Llamamos a la base de datos. Con ello tenemos disponible la variable conn, que permite connectarnos a la base de datos

  session_start(); //Si estamos loggeados, existe la sesion (revisar fichero login.php)

  if (!isset($_SESSION["user"])) { //Si no estamos autentificados por el navegador, entonces redirigimos al php de login para que el usuario inicie la sesión
    header("LOCATION: login.php");
    return; //Si no estas autenticado no ejecutamos el resto de este código
  } 

/*En PHP existen las variables super globales, que significa que están disponibles en cualquier archivo de nuestro PHP
* Por ejemplo, la supervariable _SERVER que contiene info sobre la petición HTTP que nos han mandado, además de más cosas*/

$error = null; // POr defecto asumimos que no hay errores

  if($_SERVER["REQUEST_METHOD"] == "POST") { //Aquí es donde me estan enviando a mí datos
    if (empty($_POST["name"]) or empty($_POST["phone_number"])) {
      $error = "Please fill all the fields. No empty spaces are allowed.";
    } else if (!is_numeric($_POST["phone_number"]) or strlen($_POST["phone_number"]) < 9) { //Si se envia algo que no sea un número o tenga menos de 9 cifras no es válido
      $error = "Phone number must be numeric and have at least 9 characters.";
    } else { //Si se envia el formulario con el nombre o el número vacío, devolvemos un error
      $name = $_POST["name"];
      $phoneNumber = $_POST["phone_number"]; //En las variables siempre usamos Camelcase (como si fuese Java) pensando en el laravel

      //$statement = $conn->prepare("INSERT INTO contacts (name, phone_number) VALUES ('$name', '$phoneNumber')"); //Prepara la sentencia SQL.
      //$statement->execute(); //Ejecutamos la sentencia y MySql lo entiende y lo ejecuta
      // Esto que acabamos de hacer tiene muchos problemas de seguridad porque nos pueden hacer una inyección SQL y fastidiar nuestra base de datos

      // Para evitar los problemas de inyección de SQL del código anterior usamos :nombre_parámetro para preparar la sentencia
      // En PHP, el operador -> se utiliza para acceder a métodos y propiedades de un objeto
      $statement = $conn->prepare("INSERT INTO contacts (user_id, name, phone_number) VALUES ({$_SESSION["user"]["id"]},:name, :phone_number)"); 
      $statement->bindParam(":name", $_POST["name"]); //bindParam analiza y elimina directamente las inyecciones SQl $_POST["name"] es lo que viene del cliente que rellena el formulario
      $statement->bindParam(":phone_number", $_POST["phone_number"]);
      $statement->execute();
      
      $_SESSION["flash"] = ["message" => "Contact {$_POST["name"]} added."]; //Mensaje tipo flash cuando se añada un nuevo contacto

      /*A continuación, intentamos almacenar esto en un archivo. Lo dejamos comentado porque vamos a configuaralo para que se conecte con la base de datos*/
      //if (file_exists("contacts.json")) {
      //  $contacts = json_decode(file_get_contents("contacts.json"), true); /*Con json_decode convertimos un json en un string (array asociativo con el parámetro assoc en true)*/
      //} else{
      //  $contacts = [];
      //} /*Generamos una lista con los contactos existentes, en caso de que no haya ninguno, generamos una lista vacía*/
      //$contacts[] = $contact; /*$contacts[] = $contact; Es el método que se utiliza para añadir contenido a una lista. Es como el .append en pyhon*/
      /*Guardamos la lista generada en un fichero json., usamos la función json_encode para generar el archivo. Se le pasa un array asociativo (un diccionario, lista...)
      * Usamos la función file_put_contents para poner el contenido en un archivo y gener el archivo*/
      //file_put_contents("contacts.json", json_encode($contacts));

      /*Ahora vamos a ver como redirigimos al navegador para que nos devuelva a la página de index*/
      header("Location: home.php"); /*Definimos una cabecera y le indicamos que vuelva a nuestro index*/
      return; //Lo ponemos porque la lógica lo exige para que se pueda mostrar el mensaje de contacto añadido
    }
  } 
?>

<?php require "partials/header.php" ?> <!--Reutilizamos el HTML con una ruta PHP para no tener que escribirlo cada vez-->

<div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Add New Contact</div>
          <div class="card-body">
            <?php if ($error != null):?>
              <p class="text-danger">
                <?= $error ?> <!--Si se produce un error, devolvemos el valor de la cadena error resaltado en rojo-->
              </p>
            <?php endif ?>
            <form method="POST" action="add.php"> <!--El metodo POST indica que las peticiones HTTP tipo POST. 
            Action para que mande la respuesta, y definimos el archivo, en este caso, será este mismo archivo-->
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
  
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                </div>
              </div>
  
              <div class="mb-3 row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
  
                <div class="col-md-6">
                  <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
                </div>
              </div>
  
              <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>

<?php require "partials/footer.php" ?>
