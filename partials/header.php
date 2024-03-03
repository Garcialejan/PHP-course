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
    <?php $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)?> 
    <!--Utilizamos SERVER para asignar la ruta en la que estoy. Esto lo hacemos porque solo queremos cargar el js para formatear la imagen cuando estoy en index
        Con el parse_url evitamos los querystrings y dejamos solo el PATH que nos interesa
        La diferencia entre URL y URI es que la URL incorpora el protocolo HTTP y la URI es un identificador global. Todas las URL son URI pero no todas las URI son URL-->
    <?php if ($uri == "/contacts-app/" or $uri == "/contacts-app/index.php"): ?> 
        <script defer src="./static/js/welcome.js"></script>
    <?php endif ?> 

    <title>Contacts App</title>
</head>
<body>
  <?php require "navbar.php" ?> <!--Hacemos que la barra del navegador sea otra parte diferenciada, por si queremos modificarla-->

  <main>
<!-- Content here -->
