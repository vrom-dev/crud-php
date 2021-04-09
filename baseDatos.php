<?php 
    //Elimina que los mensajes de error de PHP/mysql se muestren automáticamente en el HTML
    ini_set("display_errors", 1); //0
    ini_set("display_startup_errors", 1); //0

    //Datos de conexión con el servidor
    CONST HOST = "localhost";
    CONST USER = "root";
    CONST PASSWORD = "";
    CONST DB = "pac3_daw";


    //Función que nos crea un objeto mysqli con la conexión a la base de datos
    function connectDB($host, $user, $password, $db) {
        $connection = new mysqli($host, $user, $password);

        //Comprobamos si la conexión con el servidor ha fallado
        if($connection -> connect_error) {
            die("Conexión fallida. Código de error: " . $connection -> connect_errno . "<br>" . $connection->connect_error);
        }

        //Seleccionamos la base de datos con la que trabajar
        if(!$connection->select_db($db)) {
            die("No se ha encontrado la base de datos especificada.");
        }

        return $connection;
    }

    //Utilizamos un LEFT JOIN para que también coja los usuarios que NO son SuperAdmin
    function getUsersBy($column) {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "SELECT UserID, Email, FullName, LastAccess, Enabled, setup.SuperAdmin FROM user LEFT JOIN setup ON setup.SuperAdmin=user.UserID ORDER BY $column";

        $result = $connection -> query($sql);
        
        if (!$result) {
            echo "Error query:" . $connection -> error();
        }
        $connection ->close();
        
        return $result;
    }

    function getUser($id) {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "SELECT * FROM user WHERE UserID= " . $id;

        $result = $connection -> query($sql);
        $data = $result -> fetch_assoc();
        
        if (!$result) {
            echo "Error query:" . $connection -> error();
        }

        $connection -> close();
        
        return $data;
    }

    //Función que elimina al usuario de la BBDD
    function deleteUserDB() {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "DELETE FROM user WHERE UserID = " . $_POST["id"];

        $result = $connection -> query($sql);
        
        if ($result) {
            echo "Usuario eliminado con éxito.";
        } else {
            echo "Error al eliminar:" . $connection -> error();
        }

        $connection -> close();
    }

    //Función que elimina al usuario de la BBDD
    function modifyUserDB($name, $email, $id) {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "UPDATE user SET FullName = '$name' WHERE UserID = $id";

        $result = $connection -> query($sql);

        if ($result) {
            echo "Usuario modificado con éxito.";
        } else {
            echo "Error al modificar los datos.";
        }

        $connection -> close();
    }

    //Cogemos todos los productos
    function getTotalProducts() {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "SELECT count(product.ProductID) FROM product";

        $result = $connection -> query($sql);
        
        if (!$result) {
            echo "Error query:" . $connection->error();
        }
        $connection ->close();
        
        return $result;
    }

    //Cogemos todos los productos
    function getProductsBy($column, $page) {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "SELECT product.ProductID, product.Name AS Product, product.Cost, product.Price, category.Name AS Category FROM product INNER JOIN category on product.CategoryID=category.CategoryID ORDER BY $column LIMIT $page, 10";

        $result = $connection -> query($sql);
        
        if (!$result) {
            echo "Error query:" . $connection->error();
        }
        $connection ->close();
        
        return $result;
    }

    function getProduct($id) {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "SELECT * FROM product WHERE ProductID= " . $id;

        $result = $connection -> query($sql);
        $data = $result -> fetch_assoc();
        
        if (!$result) {
            echo "Error query:" . $connection -> error();
        }

        $connection -> close();
        
        return $data;
    }

    //Función que elimina al usuario de la BBDD
    function deleteProductDB() {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "DELETE FROM product WHERE ProductID = " . $_POST["id"];

        $result = $connection -> query($sql);
        
        if ($result) {
            echo "Producto eliminado con éxito.";
        } else {
            echo "Error al eliminar:" . $connection -> error();
        }

        $connection -> close();
    }

    //Función que elimina al usuario de la BBDD
    function modifyProductDB($id, $name, $cost, $price, $category) {
        $connection = connectDB(HOST, USER, PASSWORD, DB);

        $sql = "UPDATE product SET Name = '$name', Cost = $cost, Price = $price, CategoryID = $category  WHERE ProductID = $id";

        $result = $connection -> query($sql);

        if ($result) {
            echo "Artículo modificado con éxito.";
        } else {
            echo "Error al modificar los datos.";
        }

        $connection -> close();
    }
?>