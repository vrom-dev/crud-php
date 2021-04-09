<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a href="listaUsuario.php">Volver a la lista de usuarios</a>
        <h1>Modificar usuarios</h1>
        <?php 
            include('baseDatos.php');

            if(!isset($_POST["action"])) {
                die("Error: acción no definida.");
            }

            if(!isset($_POST["id"])) {
               die("Error: ID de artículo no específicado.");
            }

            switch($_POST["action"]) {
                case "modify":
                    modifyUser();
                    break;
                case "modifyFromBD":
                    modifyUserDB($_POST["name"],  $_POST["email"], $_POST["id"]);
                    break;
                case "delete":
                    deleteUser();
                    break;
                case "deleteFromDB":
                    deleteUserDB();
                    break;
            }

            function modifyUser(){
                    $user = getUser($_POST["id"]);
                ?>
                    <div class="form-box">
                        <form action="formUsuario.php" method="post">
                            <input type="hidden" name="action" value="modifyFromBD" >
                            <input type="hidden" name="id" value="<?php echo $user["UserID"]?>">
                            <div>
                                <label for="nombre">Nombre</label>
                                <input type="text" name="name" value="<?php echo $user["FullName"]?>" >
                            </div>
                            <div>
                                <label for="apellido">Email</label>
                                <input type="text" name="email" value="<?php echo $user["Email"]?>" >
                            </div>
                            <div>
                                <input type="submit" value="Aceptar">
                            </div>
                        </form>
                    </div>
                <?php
            }

            function deleteUser(){
                ?>
                <p>Quieres eliminar al usuario?</p>
                <div class="form-box">
                    <form action="formUsuario.php" method="post">
                        <input type="hidden" name="action" value="deleteFromDB" >
                        <input type="hidden" name="id" value="<?php echo $_POST['id']?>">
                        <input type="submit" value = "Si">
                    </form>
                    <form action="listaUsuario.php" method="post">
                        <input type="submit" value = "No">
                    </form>
                </div>
                <?php
            }
        ?>
    </div>

</body>
</html>