<?php // Copiamos el contenido de add-php porque el formulario es el mismo y lo moedificamos para generar la edición
  require "database.php";

  if (!isset($_SESSIOn["user"])) { //Si no estamos autentificados por el navegador, entonces redirigimos al php de login para que el usuario inicie la sesión
    header("LOCATION: login.php");
    return; //Si no estas autenticado no ejecutamos el resto de este código
  }

  $id = $_GET["id"]; // Usamos la misma lógica que en el delete.php para comprobar si existe un contacto
  
  $statement = $conn->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
  $statement->bindParam(":id", $id);
  $statement->execute();
  
  if ($statement->rowCount() == 0) {
    http_response_code(404);
    echo("HTTP 404 NOT FOUND"); //Echo es como un print en python
    return;
  }
  // En caso de que sí exista el contacto, nosotros queremos que nos lo proporcione para poder modificarlo

  $contact = $statement->fetch(PDO::FETCH_ASSOC); // De esta forma conseguimos que nos develva directamente un array asociativo ["name" => "Pepe"]


  $error = null; 

    if($_SERVER["REQUEST_METHOD"] == "POST") { 
      if (empty($_POST["name"]) or empty($_POST["phone_number"])) {
        $error = "Please fill all the fields. No empty spaces are allowed.";
      } else if (!is_numeric($_POST["phone_number"]) or strlen($_POST["phone_number"]) < 9) { 
        $error = "Phone number must be numeric and have at least 9 characters.";
      } else { 
        $name = $_POST["name"];
        $phoneNumber = $_POST["phone_number"]; 

        $statement = $conn->prepare("UPDATE contacts SET name = :name, phone_number = :phone_number WHERE id = :id"); //Actualizamos con SQL la tabla de contactos
        //El contacto que queremos actualizar es aquel que nos hayan pasado por eso usamos el WHERE id = :id
        $statement->execute([
          ":id" => $id, //Variable generada que la hemos enlazado con el query string anteriormente
          ":name" => $_POST["name"], //Con el POST cogemos lo que nos manda el usuario desde el formulario
          ":phone_number" => $_POST["phone_number"]
        ]);
      
        header("Location: home.php"); //Definimos una cabecera y le indicamos que vuelva a nuestro index
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
                <?= $error ?>
              </p>
            <?php endif ?>
            <form method="POST" action="edit.php?id=<?= $contact["id"]?>"> <!--Especificamos el ID para saber cual es el contcato que tiene que modificar
              Existen dos formas para hacerlo: como query string que es lo más sencillo, o enviando valores del tipo hidden para el usuario (complicarlo sin necesidad)-->
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
  
                <div class="col-md-6">
                  <input value="<?= $contact["name"]?>" id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                </div> <!--Introducimos como value el valor de name del contact que ya tenemos en la base de datos-->
              </div>
  
              <div class="mb-3 row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
  
                <div class="col-md-6">
                  <input value="<?= $contact["phone_number"]?>" id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
                </div> <!--Introducimos como value el valor del phone_number del contact que ya tenemos en la base de datos-->
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
