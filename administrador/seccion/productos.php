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

        $fecha=new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

        $tmpImagen=$_FILES['txtImagen']['tmp_name'];

        $setenciaSQL->bindParam(':imagen', $txtImagen);
        $setenciaSQL->execute();
        break;

    case "Modificar":
        $setenciaSQL = $conexion->prepare("UPDATE libros SET nombre=nombre WHERE id=:id");
        $setenciaSQL->bindParam(':nombre', $txtNombre);
        $setenciaSQL->bindParam(':id', $txtID);
        $setenciaSQL->execute();

        if ($txtImagen != "") {
            $setenciaSQL = $conexion->prepare("UPDATE libros SET imagen=imagen WHERE id=:id");
            $setenciaSQL->bindParam(':nombre', $txtImagen);
            $setenciaSQL->bindParam(':id', $txtID);
            $setenciaSQL->execute();
        }
        break;


    case "Cancelar":
        echo "Presionar boton Cancelar";
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
        $setenciaSQL = $conexion->prepare("DELETE  FROM libros WHERE id=:id");
        $setenciaSQL->bindParam(':id', $txtID);
        $setenciaSQL->execute();
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
                    <input type="text" class="form-control" value="<?php echo $txtID ?>" name="txtID" placeholder="ID">
                </div>

                <div class="for-group">
                    <label form="txtNombre" class="text-danger">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $txtNombre ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Producto"">
                </div>          

                    <div class=" for-group">
                    <label form="txtImagen" class="text-danger">Imagen:</label>
                    <?php echo $txtImagen ?>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen del Producto"">
                </div>


                    <br>
                    <div class=" btn-group" role="group" aria-label="">
                    <button type="button" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="button" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="button" name="accion" value="Cancelar" class="btn btn-danger">Cancelar</button>
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

<?php
foreach ($listaLibros as $libro) { ?>

         <tr>
        <td class=" table-primary"><?php echo $libro['id']; ?></td>
        <td class=" table-info"><?php echo $libro['nombre']; ?></td>
        <td class=" table-success"><?php echo $libro['imagen']; ?></td>


        <td class="table-danger">

            <form method="post">

                <input type="text" name="txt" id="txtID" value="<?php echo $libro['id']; ?>">
                <input type="submit" name="accion" value="Selecionar" class="btn btn-primary">
                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">

            </form>


        </td>



        </tr>
    <?php } ?>
    </tbody>
    </table>

</div>




<?php include('../template/pie.php') ?>