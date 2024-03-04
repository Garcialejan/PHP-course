<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand font-weight-bold" href="index.php">
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
      <div clas="d-flex justify-content-between w-100"> <!--Creamos una caja de tipo flex, con el contenido justificado y de ancho 100-->
        <ul class="navbar-nav">
          <?php if (isset($_SESSION["user"])): ?> <!--Si existe el usuario te pongo las rutas para que añada contactos a la fuente de datos-->
            <li class="nav-item">
              <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="add.php">Add Contact</a> <!--Linkeamos para que cuando se aprete add contact vaya al add.php para añadir un nuevo contacto-->
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a> <!--Linkeamos para que cuando se aprete Logout vaya al logaout.php y se elimine la sesión-->
            </li>
          <?php else: ?> <!--Si NO existe el usuario te pongo las rutas para que se registre-->
            <li class="nav-item">
              <a class="nav-link" href="register.php">Register</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a> <!--Linkeamos para que cuando se aprete loging se vaya al loging.php para logear el usuario-->
            </li>
          <?php endif ?>
        </ul>
        <?php if (isset($_SESSION["user"])): ?> <!--Finalmente, si existe la sesión, cogemos el email del usuario registrado y lo mostramos en el navbar-->
          <div class="p-2">
          <?= $_SESSION["user"]["email"]?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</nav>
