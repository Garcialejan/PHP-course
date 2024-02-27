<?php

// Definir los parámetros de conexión a la base de datos
$host = "localhost"; // Nombre del host, que en este caso seremos nosotros mismos. Tmb podemos usar el ID 127.0.0.1
$database = "contacts_app"; // Nombre de la base de datos donde queremos trabajar
$user = "root"; // Nombre de usuario de la base de datos con el que nos vamos a conectar
$password = ""; // Contraseña de la base de datos (en este caso, vacía)

// Intentar establecer la conexión a la base de datos. Un try catch es como un try except en Python. Lo usamos para el manejo de excepciones
try {
    // Crear una nueva instancia de PDO para la conexión a nuestra base de datos
    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

    // Ejecutar una consulta SQL para mostrar las bases de datos disponibles. El método query del objeto PDO ejecuta una consulta SQL y devuelve un conjunto de resultados
    //foreach ($conn->query("SHOW DATABASES") as $row) {
        // Imprimir cada fila de resultados obtenida de la consulta "SHOW DATABASES"
    //    print_r($row);
    //}

    // Finalizar la ejecución del script
    //die();
} catch (PDOException $e) {
    // Capturar cualquier excepción que ocurra durante la conexión a la base de datos
    // Imprimir un mensaje de error indicando el motivo del fallo en la conexión
    die("PDO Connection Error: " . $e->getMessage());
}

// En PHP, el operador -> se utiliza para acceder a métodos y propiedades de un objeto
?>
