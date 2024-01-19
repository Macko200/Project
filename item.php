<!--Sekcja Główna-->
<?php
//Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

//Rozkazy dla bazy danych
if(isset($_POST['add_to_cart'])){
   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
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
   } else {
      // Komunikat dla niezalogowanego użytkownika
      $message[] = 'Aby dodać do koszyka, zaloguj się';
   }
}
// Sprawdź, czy przekazano identyfikator produktu w parametrze GET
if(isset($_GET['product_id'])){
   $productId = $_GET['product_id'];
   
   // Pobierz dane produktu na podstawie identyfikatora z bazy danych
   $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$productId' LIMIT 1") or die('query failed');
   if(mysqli_num_rows($select_product) > 0){
      $fetch_product = mysqli_fetch_assoc($select_product);
   } else {
      // Obsłuż sytuację, gdy nie znaleziono produktu
      echo 'Produkt nie istnieje';
      exit;
   }
} else {
   // Obsłuż sytuację, gdy nie przekazano identyfikatora produktu
   echo 'Brak identyfikatora produktu';
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>item</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->     
<?php include 'header.php'; ?>

<!--Sekcja z aktualną pozycją na stronie-->
<div class="heading">
   <h3>Produkt</h3>
   <p> <a href="home.php">Strona główna</a> / Produkt </p>
</div>

<!--Sekcja pojedynczego produktu-->
<section class="products2">
   <div class="box-container">
      <div class="box">
         <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="<?php echo $fetch_product['name']; ?>">
      </div>
      <div class="box">
         <h2 class="name"><?php echo $fetch_product['name']; ?></h2>
         <p class="description">Twój krótki tekst tutaj.</p>
         <div class="price">PLN<?php echo $fetch_product['price']; ?>/-</div>
         <?php if(isset($_SESSION['user_id'])){ // Sprawdzenie, czy użytkownik jest zalogowany ?>
            <form action="" method="post" >
               <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
               <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
               <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
               <input type="submit" value="Dodaj do koszyka" name="add_to_cart" class="btn">
            </form>
         <?php } else { ?>
            <div class="login-message">Aby dodać do koszyka, zaloguj się</div>
         <?php } ?>
      </div>
   </div>
</section>

<!--Sekcja produktów-->
<section class="products">
   <h1 class="title">Najnowsze produkty</h1>
   <div class="box-container">
      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 4") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
               if(isset($_SESSION['user_id'])){ // Sprawdzenie, czy użytkownik jest zalogowany
                  // Jeśli użytkownik jest zalogowany, wyświetl link do strony item.php
                  ?>
                  <div class="box">
                     <a href="item.php?product_id=<?php echo $fetch_products['id']; ?>">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">PLN<?php echo $fetch_products['price']; ?>/-</div>
                     </a>
                     <form action="" method="post" class="box-form">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="Dodaj do koszyka" name="add_to_cart" class="btn">
                     </form>
                  </div>
               <?php
               } else {
                  // Ilość produktów -> <input type="number" min="1" name="product_quantity" value="1" class="qty">
                  // Jeśli użytkownik nie jest zalogowany, wyświetl komunikat
                  ?>
                  <div class="box">
                     <a href="item.php?product_id=<?php echo $fetch_products['id']; ?>">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">PLN<?php echo $fetch_products['price']; ?>/-</div>
                     </a>
                     <div class="login-message">Aby dodać do koszyka, zaloguj się</div>
                  </div>
               <?php
               }
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
