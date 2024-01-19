<!--Skcja wyszukiwania--> 
<?php
//Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

//Rozkazy dla bazy danych
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];
   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->     
<?php include 'header.php'; ?>

<!--Sekcja z aktualną pozycją na stronie-->
<div class="heading">
   <h3>Wyszukiwanie</h3>
   <p> <a href="home.php">Strona główna</a> / Szukaj </p>
</div>

<!--Wyszukiwanie-->
<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="wyszukaj produkt..." class="box">
      <input type="submit" name="submit" value="Szukaj" class="btn">
   </form>
</section>

<!--Wyszukane produkty-->
<section class="products" style="padding-top: 0;">
   <div class="box-container">
      <?php
         if(isset($_POST['submit'])){
            $search_item = $_POST['search'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
            if(mysqli_num_rows($select_products) > 0){
               while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>
                  <div class="box">
                     <a href="item.php?product_id=<?php echo $fetch_product['id']; ?>">
                        <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">PLN<?php echo $fetch_product['price']; ?>/-</div>
                     </a>
                     <form action="" method="post" class="box-form">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <input type="submit" class="btn" value="Dodaj do koszyka" name="add_to_cart">
                     </form>
                  </div>
      <?php
               }
            } else {
               echo '<p class="empty">Brak wyników wyszukiwania!</p>';
            }
         } else {
            echo '<p class="empty">Wyszukaj coś!</p>';
         }
      ?>
   </div>  
</section>


<!--Wczytanie stopki-->
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>