<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php 
        include('baseDatos.php');
        if (isset($_GET["orderby"])) {
            $orderBy = $_GET["orderby"];
        } else {
            $orderBy = "UserID";
        }
    
    ?>
    <div class="container">
        <a href="index.php">Volver al índice</a>
        <h1>Lista de usuarios</h1>
        <p>Los usuarios administradores están marcados en verde</p>
        <table>
            <thead>
                <tr>
                    <th class="row-title">
                        <a href='listaUsuario.php?orderby=UserID'>ID</a> 
                    </th>
                    <th class="row-title">
                        <a href='listaUsuario.php?orderby=FullName'>Nombre</a>
                    </th>
                    <th class="row-title">
                        <a href='listaUsuario.php?orderby=Email'>Email</a>
                    </th>
                    <th class="row-title">
                        <a href='listaUsuario.php?orderby=LastAccess'>Último acceso</a>
                    </th>
                    <th class="row-title">
                        <a href='listaUsuario.php?orderby=Enabled'>Enabled</a>
                    </th>
                    <th class="row-title"></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $result = getUsersBy($orderBy);
                    while ($row = $result->fetch_assoc()) {?>
                        <tr
                            <?php
                                if ($row["SuperAdmin"]) {
                                    echo "class=row-admin";
                                }
                            ?>
                        >
                            <td class="row"><?php echo $row["UserID"]?></td>
                            <td class="row"><?php echo $row["FullName"]?></td>
                            <td class="row"><?php echo $row["Email"]?></td>
                            <td class="row"><?php echo $row["LastAccess"] ?></td>
                            <td class="row"><?php echo $row["Enabled"] ?></td>
                            <td class="row">
                                <?php
                                    if (!$row["SuperAdmin"]) {
                                        ?>
                                            <form action="formUsuario.php" method="POST">
                                                <input name="id" type="hidden" value="<?php echo $row["UserID"]?>">
                                                <input name="action" type="hidden" value="modify" >
                                                <input type="submit" value="Modificar">
                                            </form>
                                            <form action="formUsuario.php" method="POST">
                                                <input name="id" type="hidden" value="<?php echo $row["UserID"]?>">
                                                <input name="action" type="hidden" value="delete" >
                                                <input type="submit" value="Eliminar">              
                                            </form>
                                        <?php
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php     
                    }
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>