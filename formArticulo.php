<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Modificar artículo</title>
</head>
<body>
<div class="container">
        <a href="listaArticulo.php">Volver a la lista de artículos</a>
        <h1>Modificar artículos</h1>
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
                    modifyProduct();
                    break;
                case "modifyFromBD":
                    modifyProductDB($_POST["id"], $_POST["name"], $_POST["cost"], $_POST["price"], $_POST["category"]);
                    break;
                case "delete":
                    deleteProduct();
                    break;
                case "deleteFromDB":
                    deleteProductDB();
                    break;
            }

            function modifyProduct(){
                    $product = getProduct($_POST["id"]);
                ?>
                    <div class="form-box">
                        <form action="formArticulo.php" method="post">
                            <input type="hidden" name="action" value="modifyFromBD" >
                            <input type="hidden" name="id" value="<?php echo $product["ProductID"]?>">
                            <div>
                                <label for="nombre">Nombre</label>
                                <input type="text" name="name" value="<?php echo $product["Name"]?>" >
                            </div>
                            <div>
                                <label for="apellido">Coste</label>
                                <input type="text" name="cost" value="<?php echo $product["Cost"]?>" >
                            </div>
                            <div>
                                <label for="apellido">Precio</label>
                                <input type="text" name="price" value="<?php echo $product["Price"]?>" >
                            </div>
                            <div>
                                <label for="apellido">Categoria</label>
                                <select name="category">
                                    <option value="1" <?php if($product["CategoryID"] == 1) echo "selected"; ?>>Pantalón</option>
                                    <option value="2" <?php if($product["CategoryID"] == 2) echo "selected"; ?>>Camisa</option>
                                    <option value="3" <?php if($product["CategoryID"] == 3) echo "selected"; ?>>Jersey</option>
                                    <option value="4"<?php if($product["CategoryID"] == 4) echo "selected"; ?>>Chaqueta</option>
                                </select>

                            </div>
                            <div>
                                <input type="submit" value="Aceptar">
                            </div>
                        </form>
                    </div>
                <?php
            }

            function deleteProduct(){
                ?>
                <p>Quieres eliminar el producto?</p>
                <div class="form-box">
                    <form action="formArticulo.php" method="post">
                        <input type="hidden" name="action" value="deleteFromDB" >
                        <input type="hidden" name="id" value="<?php echo $_POST['id']?>">
                        <input type="submit" value = "Si">
                    </form>
                    <form action="listaArticulo.php" method="post">
                        <input type="submit" value = "No">
                    </form>
                </div>
                <?php
            }
        ?>
    </div>
</body>
</html>