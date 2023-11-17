<?php
require 'config/database.php';
require 'config/config.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id, nombre, descripcion, precio, $cantidad AS cantidad  FROM productos WHERE id=? AND activo = 1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC); 
    }
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@1,300&family=Ubuntu:ital,wght@1,500&display=swap" rel="stylesheet">
    <title>SHOES STORE</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
      .img_producto_detalles{
        margin-left:200px;
        width: 50%;
      }
      .carrito{
        margin-left: -200px;
      }
      .producto span{
        margin-bottom: 20px;
      }

    </style>

</head>
<body>
    <header>
        🔥APROVECHA NUESTRO ENVÍO GRATIS POR TIEMPO LIMITADO🔥
    </header>
    <nav>
        <div class="logo">
            <img src="img/logo.jpg" alt="">
        </div>

        <h1>Carrito de compras</h1>

    
        <div >
        <a href="clases/carrito.php" class="btn btn-primary carrito">Carrito  <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
        </div>

    </nav>


    <div class="container">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($lista_carrito == null){
                        echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                    }else{
                        $total = 0;
                        foreach($lista_carrito as $producto){
                            $_id = $producto['id'];
                            $_nombre = $producto['nombre'];
                            $_precio = $producto['precio'];
                            $cantidad = $producto['cantidad'];
                            $_subtotal = $cantidad * $_precio;
                            $total  += $_subtotal;
                        
                    
                    ?>
                    <tr>
                        <td> <?php echo $_nombre; ?> </td>
                        <td> <?php echo MONEDA . number_format($_precio,2, '.', ','); ?> </td>
                        <td>
                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>"
                            size="5" id="cantidad_<?php echo $_id; ?>" onchange="">
                        </td>
                        <td>
                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($_subtotal,2, '.', ','); ?></div>
                        </td>
                        <td>
                            <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-ds-toogles="modal" data-bs-target="eliminaModal">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">
                            <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                        </td>

                    </tr>
                </tbody>
            <?php } ?>
            </table>
        </div>
    </div>





  
<div class="espacio">
    <span></span>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <footer class="footer-main bg-dark ">
  <div class="container">
    <div class="row address-main">
      <div class="col-lg-4 col-sm-12 col-xs-12">
        <div class="address-box clearfix">
          <div class="add-icon">
            <img src="Img/footer-icon-01.png" alt="" />
          </div>
          <div class="add-content">
            <h5>Address</h5>
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit,
			sed do eiusmod tempor incididunt ut veniam </p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12 col-xs-12">
        <div class="address-box clearfix">
          <div class="add-icon">
            <img src="Img/footer-icon-02.png" alt="" />
          </div>
          <div class="add-content">
            <h5>Phone</h5>
            <p>  +57 312 494 2326 <br />
            
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-sm-12 col-xs-12">
        <div class="address-box clearfix">
          <div class="add-icon">
            <img src="Img/footer-icon-03.png" alt="" />
          </div>
          <div class="add-content">
            <h5>Email</h5>
            <p> <a href="mailto:" style="text-decoration:none">jhojanvaron862@gmial.com</a> </p>
          </div>
        </div>
      </div>
    </div>
</div>


<!-- Copyright Footer -->
<footer class="bg-dark text-center text-white">

<!-- Grid container -->
<div class="container p-4 pb-0">
  <!-- Section: Social media -->
  <section class="mb-4">
    <!-- Facebook -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fa fa-facebook-f"></i
    ></a>

    <!-- Twitter -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fa fa-twitter"></i
    ></a>

    <!-- Google -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fa fa-google"></i
    ></a>

    <!-- Instagram -->
    <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
      ><i class="fa fa-instagram"></i
    ></a>

  </section>
  <!-- Section: Social media -->
</div>
<!-- Grid container -->

<!-- Copyright -->
<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
SHOES STORE © 2023 All Rights Reserved.
</div>
<!-- Copyright -->
</footer>
</footer>



</body>
</html>