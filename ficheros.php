<!DOCTYPE html>
<html>

<head>
    <title>Carga de archivos</title>
</head>

<body>
    <form action="ficheros.php" method="post" enctype="multipart/form-data">
        Subir ficheros <br>
        <input type="file" name="files" multiple accept=".jpg, .png"><br><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>
<?php
$errors = [];
$error = false;
$uploadDirectory = 'imgusers/';
$individualSizeLimit = 200 * 1024;
$totalSizeLimit = 300 * 1024;
$totalSize;

if (isset($_FILES['files'])) {
    foreach ($_FILES['files']['name'] as $k => $fileName) {
        $fileSize = $_FILES['files']['size'][$key];
        $extension = pathinfo($fileName);

        if ($extension['extension'] !== "jpg" && $extension['extension'] !== "png") {
            array_push($errors, "El archivo $fileName no es ni .jpg ni .png");
            $error = true;
        }

        if ($fileSize > 200 * 1024) {
            array_push($errors, "El archivo $ supera los 200kb");
            $error = true;
        } else {
            $totalSize += $fileSize;
        }

        if ($totalSize > 400 * 1024) {
            array_push($errors, "Los archivos superan los 400kb");
            $error = true;
        }

        if (file_exists($uploadDirectory . $fileName)) {
            array_push($errors, "El archivo $fileName ya existe en el directorio de imágenes.");
            $error = true;
        }
    }

    if ($error == true) {
        implode("\n", $errors);
    } else {
        $fileName = $_FILES['files']['name'];
        move_uploaded_file($fileName, "$uploadDirectory/$fileName");;
    }
} else {
    echo 'No se ha seleccionado ningun archivo';
}
?>
