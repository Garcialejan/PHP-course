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
    <?php $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?> 
    <!--Utilizamos SERVER para asignar la ruta en la que estoy. Esto lo hacemos porque solo queremos cargar el js para formatear la imagen cuando estoy en index
        Con el parse_url evitamos los querystrings y dejamos solo el PATH que nos interesa
        La diferencia entre URL y URI es que la URL incorpora el protocolo HTTP y la URI es un identificador global. Todas las URL son URI pero no todas las URI son URL-->
    <?php if ($uri == "/contacts-app/" || $uri == "/contacts-app/index.php"): ?> 
        <script defer src="./static/js/welcome.js"></script>
    <?php endif ?> 

    <title>Contacts App</title>
</head>
<body>
  <?php require "navbar.php" ?> <!--Hacemos que la barra del navegador sea otra parte diferenciada, por si queremos modificarla-->

    <?php if (isset($_SESSION["flash"])): ?>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
        </svg>

        <div class="container mt-4">
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div class="ml-2">
                <?= $_SESSION["flash"]["message"] ?>
                </div>
            </div>
        </div>
        <?php unset($_SESSION["flash"]) ?>
    <?php endif ?>
  <main>
<!-- Content here -->
