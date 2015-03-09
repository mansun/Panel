<?php
include 'header.php';
include 'lib/conexion.php';
include 'lib/autenticacion.php';
?>
    <div class='container'>
      <div class='page-header'>
        <h3>Login</h3>
      </div>
      <form class="formulario-login" method="post">
  <div class="form-group">
    <label for="usuAlias">Alias</label>
    <input type="text" class="form-control" name="usuAlias" id="usuAlias" value="">
  </div>
  <div class="form-group">
    <label for="usuPw">Contraseña</label>
    <input type="password" class="form-control" name="usuPw" id="usuPw" value="">
  </div>
  <button type="submit" name="enviar" value="enviar" class="btn btn-default">Enviar</button>
  </form>

     </div>
<?php
include 'footer.php';
?>