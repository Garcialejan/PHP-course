<!--Con el PHP diferenciamos cuando nos están pidiendo el formulario y cuando nos están mandando datos-->

<?php
  require "database.php"; //Llamamos a la base de datos. Con ello tenemos disponible la variable conn, que permite connectarnos a la base de datos

/*En PHP existen las variables super globales, que significa que están disponibles en cualquier archivo de nuestro PHP
* Por ejemplo, la supervariable _SERVER que contiene info sobre la petición HTTP que nos han mandado, además de más cosas*/

$error = null; // POr defecto asumimos que no hay errores

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
      $error = "Please fill all the fields";
    } else if (!str_contains($_POST["email"], "@")) { //Si el email no contiene una arroba enviamos un mensaje de que no es válido
      $error = "Email format incorret."; //Podríamos usar librerías para validar email pero hemos hecho una validación muy simple para probar
    } else {
      $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
      $statement->bindParam(":email", $_POST["email"]); //Le pasamos como email lo que nos llega por el POST y evitamos inyecciones de SQL
      $statement->execute();

      if ($statement->rowCount() == 0) { //Si el usuario no existe y por tanto rowcount=0, se ha fallado en el correo o en la contraseña.
        $error = "Invalid credentials.";
      } else {
        $user = $statement->fetch(PDO::FETCH_ASSOC); //Si no da cero, generamos el usuario como un array asociativo.
        //Podemos acceder a su email, nombre y contraseña en forma de arrays y así podemos enlazar al usuario con sus contactos
        if (!password_verify($_POST["password"], $user["password"])) { //Si la contraseña no coincide con lo que tenemos en la base de datos le damos un error
          $error = "Incorrect credential.";
        } else {//Si el usuario existe y la contraseña es correcta, ya podemos logear al usuario (sesiones y cookies)
          session_start(); //Esto lo que hace es que el navegador te asigna una sesión en el servidor, si no tienes ninguna creada todavía
          //En caso de que tengas una sesión ya creada el navegador ya sabe que sesión tienes porque te manda la cookie
          //Tenemos una también una variable superglobal $_SESSION, al igual que con $_GET y $_POST
          unset($user["password"]); //Eliminamos la info de la password en la sesion. Se hace por seguridad (¿un poco paranoico no?)
          $_SESSION["user"] = $user; 


          header("LOCATION: home.php");
        }
      }
    }
  } 
?>

<?php require "partials/header.php" ?> <!--Reutilizamos el HTML con una ruta PHP para no tener que escribirlo cada vez-->

<div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <?php if ($error != null):?>
              <p class="text-danger">
                <?= $error ?> <!--Si se produce un error, devolvemos el valor de la cadena error resaltado en rojo-->
              </p>
            <?php endif ?>
            <form method="POST" action="login.php"> <!--El metodo POST indica que las peticiones HTTP tipo POST. 
            Action para que mande la respuesta, y definimos el archivo, en este caso, será este mismo archivo-->
              <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
  
                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
  
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
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
