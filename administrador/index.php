<?php
session_start();
if($_POST){
  if(($_POST['usuario']=="login")&&($_POST['contraseña']=="123")){

    $_SESSION['usuario']="ok";
    $_SESSION['nombreUsuario']="php_curso";
    header('location:inicio.php');

  }else{
     $mensage="Error: El usuario o contraseña son incorrectos";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Administrador</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.0.2 -->
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/cabecera.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   

</head>

<body>
  <br>

  <div class="container">
    <div class="row">

      <div class="col-md-4">

      </div>


      <div class="col-md-4">
        <br/><br/><br/>
        <div class="card">
          <div class="card-header">
            Login
          </div>
          <div class="card-body">

           <?php if(isset($mensage)) {?>
          <div class="alert alert-danger" role="alert">
              <?php echo $mensage; ?>
          </div>
          <?php }?>

            <form method="POST">

              <div class="for-group">
                <label>Usuario:</label>
                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
              </div>

              <div class="for-group">
                <label>Contraseña:</label>
                <input type="password" class="form-control" name="contraseña" placeholder="Escribe tu contraseña"">
             
            </div>
             <br>
            <button type=" submit" class="btn btn-primary">Entrar al Administrador</button>

            </form>


          </div>

        </div>

      </div>

    </div>
  </div>




</body>

</html>