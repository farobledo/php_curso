<?php include('../template/cabecera.php') ?>

<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('../config/db.php');

switch ($accion) {
    case "Agregar":


        $setenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen) VALUES (:nombre,:imagen);");
        $setenciaSQL->bindParam(':nombre', $txtNombre);

        $fecha = new DateTime();
        $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";

        $tmpImagen = $_FILES['txtImagen']['tmp_name'];

        if ($tmpImagen != "") {
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);
        }


        $setenciaSQL->bindParam(':imagen', $nombreArchivo);
        $setenciaSQL->execute();

        header("location:productos.php");
        break;

    case "Modificar":

        $setenciaSQL = $conexion->prepare("UPDATE libros SET nombre=nombre WHERE id=:id");
        $setenciaSQL->bindParam(':nombre', $txtNombre);
        $setenciaSQL->bindParam(':id', $txtID);
        $setenciaSQL->execute();

        if ($txtImagen != "") {

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen != "") ? $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $setenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $setenciaSQL->bindParam(':id', $txtID);
            $setenciaSQL->execute();
            $libro = $setenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img" . $libro["imagen"])) {
                    unlink("../../img" . $libro["imagen"]);
                }
            }

            $setenciaSQL = $conexion->prepare("UPDATE libros SET Imagen=:imagen WHERE id=:id");
            $setenciaSQL->bindParam(':imagen', $txtArchivo);
            $setenciaSQL->bindParam(':id', $txtID);
            $setenciaSQL->execute();
        }

             header("location:productos.php");
        break;


    case "Cancelar":
        header("location:productos.php");
        break;

    case "seleccionar":

        $setenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $setenciaSQL->bindParam(':id', $txtID);
        $setenciaSQL->execute();
        $libro = $setenciaSQL->fetch(PDO::FETCH_LAZY);
        $txtNombre = $libro['nombre'];
        $txtImagen = $libro['imagen'];
        break;

    case "Borrar":
        $setenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $setenciaSQL->bindParam(':id', $txtID);
        $setenciaSQL->execute();
        $libro = $setenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $libro["imagen"])) {
                unlink("../../img/" . $libro["imagen"]);
            }
        }
        $setenciaSQL = $conexion->prepare("DELETE  FROM libros WHERE id=:id");
        $setenciaSQL->bindParam(':id', $txtID);
        $setenciaSQL->execute();

        header("location:productos.php");
        break;
}

$setenciaSQL = $conexion->prepare("SELECT * FROM libros");
$setenciaSQL->execute();
$listaLibros = $setenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header text-center text-primary">
            <h2>Datos de Productos</h2>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">

                <div class="for-group">
                    <label class="text-danger">ID:</label>
                    <input type="text" require readonly class="form-control" value="<?php echo $txtID ?>" name="txtID" placeholder="ID">
                </div>

                <div class="for-group">
                    <label form="txtNombre" class="text-danger">Nombre:</label>
                    <input type="text" require class="form-control" value="<?php echo $txtNombre ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Producto"">
                </div>          

                    <div class=" for-group">
                    <label form="txtNombre" class="text-danger">Imagen:</label>

                   
                    <br />
                    <?php if ($txtImagen != "") { ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="" srcset="">
                    <?php } ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen del Producto"">
                </div>


                    <br>
                    <div class=" btn-group" role="group" aria-label="">
                    <button type="submit" name="accion"<?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion"<?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion"<?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-danger">Cancelar</button>
                </div>

            </form>

        </div>

    </div>




</div>
<div class="col-md-7">

    <table class="table table-bordered border-primary"">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

<?php foreach ($listaLibros as $libro) { ?>

         <tr>
        <td class=" table-primary"><?php echo $libro['id']; ?></td>
        <td class=" table-info"><?php echo $libro['nombre']; ?></td>


        <td class=" table-success">
            <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="" srcset="">
        </td>


        <td class="table-primary">

            <form method="post">

                <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

            </form>


        </td>



        </tr>
    <?php } ?>
    </tbody>
    </table>

</div>




<?php include('../template/pie.php') ?>