
<?php 

$errores = [];
$nombre = "";
$correo = "";
$mensaje = "";
$enviado = false;

// Verificar si el mensaje se ha mandado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $nombre = trim($_POST["nombre"] ?? "");
  $correo = trim($_POST["correo"] ?? "");
  $mensaje = trim($_POST["mensaje"] ?? "");

  if (empty($nombre)) {
    $errores[] = "Por favor ingrese su nombre.";
  }

  if (empty($correo)) {
    $errores[] = "Por favor ingrese su correo.";
  } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "Por favor ingrese un correo válido.";
  }

  if (empty($mensaje)) {
    $errores[] = "Por favor detalle su mensaje.";
  }

  if (empty($errores)) {
    
    $enviado = true;
    $nombre = "";
    $correo = "";
    $mensaje = "";
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css"
    />
    <link rel="stylesheet" href="./css/style.css">
    <title>Formulario</title>
</head>
<body>
  <main class="contenedor">
    <section class="formulario">
      <div class="formulario__encabezado">
        <span class="formulario__icono"><i class="bi bi-envelope-at-fill"></i></span>
        <h1>Contáctate con nosotros</h1>
        <p>
          ¿Tienes alguna consulta?
          Escríbenos y nos pondremos en contacto contigo.
        </p>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "UTF-8") ?>" method="post" novalidate>

        <div class="campo">
          <label for="nombre">Nombre</label>
          <input 
            id="nombre" type="text" name="nombre" placeholder="Ingrese su nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, "UTF-8"); ?>" class="<?php echo !empty($errores) && empty($nombre) ? 'campo__input--error' : ''; ?>">
        </div>

        <div class="campo">
          <label for="correo">Correo electrónico</label>
          <input 
            id="correo" type="text" name="correo" placeholder="ejemplo@correo.com" value="<?php echo htmlspecialchars($correo, ENT_QUOTES, "UTF-8"); ?>" class="<?php echo !empty($errores) && (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) ? 'campo__input--error' : ''; ?>">
        </div>

        <div class="campo">
          <label for="mensaje">Mensaje</label>
          <textarea id="mensaje" name="mensaje" placeholder="Escriba su mensaje aquí..." class="<?php echo !empty($errores) && empty($mensaje) ? 'campo__input--error' : ''; ?>"><?php echo htmlspecialchars($mensaje, ENT_QUOTES, "UTF-8"); ?></textarea>
        </div>

        <!-- errores -->
        <?php 
        if (!empty($errores)) { ?>
          <div class="alerta alerta--error" role="alert">
            <span class="alerta__icono"><i class="bi bi-exclamation-circle-fill"></i></span>
            <div>
              <?php foreach($errores as $error){ ?>
              <p><?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?></p>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        
        <!-- mensaje enviado -->
        <?php 
        if ($enviado) { ?>
          <div class="alerta alerta--exito" role="status">
            <span class="alerta__icono"><i class="bi bi-send-check-fill"></i></span>
            <p>Enviado correctamente.</p>
          </div>
        <?php } ?> 

        <!-- botón -->
        <div class="formulario__boton">
          <button type="submit" name="submit">
            Enviar Correo
            <span><i class="bi bi-box-arrow-in-right"></i></span>
          </button>
        </div>
        
      </form>
    </section>
  </main>
</body>
</html>