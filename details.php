<?php
require 'config/database.php';
require 'config/config.php';



$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, descripcion, precio FROM productos WHERE activo = 1"
);

$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); 

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp){
        $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo = 1");

        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre, descripcion, precio FROM productos WHERE id=? AND activo = 1");

            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];

        } else {
            echo 'Producto no encontrado o no activo';
        }
    } else {
        echo 'Error al procesar la petición';
        exit;
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
      h1{
        margin-left: -200px;
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

        <h1>Detalles del producto</h1>

    
        <div >
        <a href="checkout.php" class="btn btn-primary carrito">Carrito  <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
        </a>
        </div>

    </nav>

 <div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php
            $rutaImagen = "img/" . sprintf("%02d", $id) . ".jpg";
            
            // Verificar si la imagen existe en el sistema de archivos
            if (file_exists($rutaImagen)) {
                // Si la imagen existe, la cargamos
                echo "<img src='$rutaImagen' alt='' class='img_producto_detalles'>";
                
            } else {
                // Si la imagen no existe, mostramos una imagen predeterminada o un mensaje
                echo "<img src='img/no-photo.jpg' alt='Imagen no encontrada'>";
                echo "Imagen no encontrada para el producto con ID: " . $id;
            }
            ?>
        </div>
        
        <div class="col-md-6 order-md-2">
            <h2> <?php echo $nombre; ?></h2>
            <h2> <?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
            <p class="lead">
                <?php echo $descripcion  ?>
            </p>

            <div class="d-grid gap-3 col-10 mx-auto">

                <button class="btn btn-outline-primary" type="button" 
                onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al carrito</button>
            </div>
        </div>
    </div>
</div>



<script>
        function addProducto(id, token) {
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            })
            .then(response => response.json())
            .then(data => {
                if (data.ok) {
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero;
                }
            })
            .catch(error => {
                console.error('Error en la solicitud fetch:', error);
            });
        }
    </script>



  
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