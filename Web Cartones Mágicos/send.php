<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambia esto si tienes otro usuario
$password = ""; // Cambia esto si tienes contraseña en tu MySQL
$dbname = "registro"; // Nombre de tu base de datos

// Crear conexión
$conex = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conex->connect_error) {
    die("Error de conexión: " . $conex->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $contraseña = trim($_POST['contraseña']);
    $nombre = trim($_POST['nombre']);
    $direccion = trim($_POST['direccion']);
    $tlf = trim($_POST['tlf']);

    if (!empty($email) && !empty($usuario) && !empty($contraseña) && !empty($nombre) && !empty($direccion) && !empty($tlf)) {
        // Guardar en archivo TXT
        $contenido = "Correo: $email\nUsuario: $usuario\nContraseña: $contraseña\nNombre: $nombre\nDirección: $direccion\nTeléfono: $tlf\n------------------------\n";
        $ruta = "datos.txt";
        file_put_contents($ruta, $contenido, FILE_APPEND | LOCK_EX);

        // Insertar en la base de datos
        $sql = "INSERT INTO usuarios (correo, usuario, contraseña, nombre, direccion, telefono)
                VALUES ('$email', '$usuario', '$contraseña', '$nombre', '$direccion', '$tlf')";

        if ($conex->query($sql) === TRUE) {
            echo"<h3 class='success'></h3>";
        } else {
            echo "<h3 class='error'>Error al guardar en la base de datos: " . $conex->error . "</h3>";
        }
    } else {
        echo "<h3 class='error'>Por favor, completa todos los campos.</h3>";
    }
    
}
// Cerrar conexión
$conex->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Compra, vende e intercambia cartas de Magic: The Gathering con facilidad en Cartones Mágicos." />
  <meta name="keywords" content="Magic The Gathering, cartas, comprar, vender, intercambiar" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/style.css" />
  <title>Cartones Mágicos</title>
  <link rel="icon" href="Image/icono.png" type="image/png"/>
</head>

<!--Aqui comienza el body -->

<body>

  <!--cabezera-->
  <header class="py-3 text-center bg-dark text-white ">
    <h1>Cartones Mágicos</h1>
  </header>

  <!--menu nav donde inicio y lo otro esta separado-->
  <nav class="navbar navbar-expand-lg sticky-top bg-success">
    <div class="container-fluid">
      
      <a class="navbar-brand text-white" href="Index.html"><img src="Image/Iconoempresa.png" class="btn p-0" alt="empresa" width="60" height="54"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link text-white" href="Productos.html">Productos</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="Carro.html">Comprar</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="Registro.html">Perfil</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="comunidad.html">Comunidad</a></li>
        </ul>

        <!--Buscador-->
        <p></p>
        <form class="d-flex ms-3" role="search">
          <input id="filtro-cartas" class="form-control me-2" type="search" placeholder="Buscar cartas..." aria-label="Buscar">
          <button class="btn btn-custom" type="submit">Buscar</button>
        </form>

      </div>
    </div>
  </nav>

  
  <!--Bienvenido-->
  <main class="container-fluid py-5">
    <section id="inicio" class="text-center mb-5">
      <h2>¡Datos guardados correctamente en la base de datos!</h2>
      <!--Buscador que ya no-->
    </section>
    <img src="Image/Cartonmagico.png" class="card-img-top" alt="logo" />

  </main>

  <!--pie de pagina-->
  <footer class="text-white text-center bg-dark py-3">
    <p>&copy; 2025 Magic Market - Todos los derechos reservados</p>
  </footer>


  <!--Enlace de javascript-->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="javascrip/javas.js"></script>

</body>

</html>
