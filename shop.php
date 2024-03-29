<!--Skcja Sklep--> 
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

//Rozkazy dla bazy danych
if(isset($_POST['add_to_cart'])){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   // Sprawdź, czy klucz 'product_quantity' istnieje w tablicy $_POST
   $product_quantity = isset($_POST['product_quantity']) ? $_POST['product_quantity'] : 1;

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'Już dodano do koszyka!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'Produkt dodany do koszyka!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->  
<?php include 'header.php'; ?>

<!--Sekcja z aktualną pozycją na stronie-->
<div class="heading">
   <h3>Nasz sklep</h3>
   <p> <a href="home.php">Strona główna</a> / Sklep </p>
</div>

<!--Sekcja z produktami w sklepie-->
<section class="products">
   <h1 class="title">Najnowsze produkty</h1>
   <div class="box-container">
      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <a href="item.php?product_id=<?php echo $fetch_products['id']; ?>">
            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="price">PLN <?php echo $fetch_products['price']; ?>/-</div>
         </a>
         <form action="" method="post">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            <input type="submit" value="Dodaj do koszyka" name="add_to_cart" class="btn">
         </form>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">Nie dodano jeszcze żadnych produktów!</p>';
      }
      ?>
   </div>
</section>

<!--Wczytanie stopki-->
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>