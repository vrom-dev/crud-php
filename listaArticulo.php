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
        $totalProducts = getTotalProducts()->fetch_row();
        $numOfPages = ceil($totalProducts[0]/10);
        $currentPage;
        $orderBy;
        if (isset($_GET["pagina"])) {
            $currentPage = $_GET["pagina"];
        } else {
            $currentPage = 1;
        }
        if (isset($_GET["orderby"])) {
            $orderBy = $_GET["orderby"];
        } else {
            $orderBy = "ProductID";
        }
        
    ?>
    <div class="container">
        <a href="index.php">Volver al índice</a>
        <h1>Lista de artículos</h1>
        <table>
            <thead>
                <tr>
                    <th class="row-title">                               
                        <?php echo "<a href='listaArticulo.php?pagina=$currentPage&orderby=ProductID'>ID</a>"; ?>          
                    </th>
                    <th class="row-title">
                        <?php echo "<a href='listaArticulo.php?pagina=$currentPage&orderby=Category'>Categoría</a>"; ?>       
                    </th>
                    <th class="row-title">
                        <?php echo "<a href='listaArticulo.php?pagina=$currentPage&orderby=Product'>Nombre</a>"; ?>   
                    </th>
                    <th class="row-title">
                        <?php echo "<a href='listaArticulo.php?pagina=$currentPage&orderby=Cost'>Coste</a>"; ?>   
                    </th>
                    <th class="row-title">
                        <?php echo "<a href='listaArticulo.php?pagina=$currentPage&orderby=Price'>Precio</a>"; ?>   
                    </th>
                    <th class="row-title"></th>
                </tr>
            </thead>
            <tbody>
                <?php

                    $startFrom = ($currentPage-1)*10;
                    $result = getProductsBy($orderBy, $startFrom);
                    while ($row = $result->fetch_assoc()) {?>
                        <tr>
                            <td class="row"><?php echo $row["ProductID"]?></td>
                            <td class="row"><?php echo $row["Category"]?></td>
                            <td class="row"><?php echo $row["Product"]?></td>
                            <td class="row"><?php echo $row["Cost"] . "€" ?></td>
                            <td class="row"><?php echo $row["Price"]  . "€"?></td>
                            <td class="row">
                                <form action="formArticulo.php" method="POST">
                                    <input name="id" type="hidden" value="<?php echo $row["ProductID"]?>">
                                    <input name="action" type="hidden" value="modify" >
                                    <input type="submit" value="Modificar">
                                </form>
                                <form action="formArticulo.php" method="POST">
                                    <input name="id" type="hidden" value="<?php echo $row["ProductID"]?>">
                                    <input name="action" type="hidden" value="delete" >
                                    <input type="submit" value="Eliminar">               
                                </form>
                            </td>
                        </tr>
                    <?php
                    } 
                ?>
            </tbody>
        </table>
        <div class="pages">
            <?php
                for ($i = 1; $i <= $numOfPages; $i++) {
                    if ($i == $currentPage) {
                        echo "<a href='listaArticulo.php?pagina=$i&orderby=$orderBy' class='current'>$i</a>";
                    } else {
                        echo "<a href='listaArticulo.php?pagina=$i&orderby=$orderBy'>$i</a>";
                    }
                    
                }
            ?>
        </div>
    </div>
    
</body>
</html>