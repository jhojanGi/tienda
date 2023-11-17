<?php
require 'config/database.php';
require 'config/config.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE activo = 1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 




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

        <h1>Tienda online de zapatos</h1>

    
        <div >
        <a href="checkout.php" class="btn btn-primary carrito">Carrito  <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
        </div>

    </nav>



<div class="oferta">
    <p class="animado">¡LO MAS VENDIDO!</p>
</div>


<section class="productos">
<?php foreach($resultado as $row) { ?>
    <div class="producto">
      <?php
     $id = $row['id'];
     $imagen = "img/" . sprintf("%02d", $id) . ".jpg";
     
     if (!file_exists($imagen)){
       $imagen = "img/no-photo.jpg";
       echo "Imagen no encontrada para el producto con ID: " . $id;
     }

      ?>
        <img src="<?php echo $imagen; ?>" alt="">
        <h3><?php echo $row['nombre']; ?></h3>
   
        <span>Precio: $<?php echo $row['precio']; ?></span>
        <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>">Detalles</a>

    </div>
  <?php } ?>

  </section>
  
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