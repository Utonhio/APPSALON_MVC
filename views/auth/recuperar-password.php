<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php
include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if ($error) return; ?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu nuevo password">
    </div>
    <input type="submit" class="boton" value="Guarda nuevo password">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Obtener una</a>
</div>