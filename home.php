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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->     
<?php include 'header.php'; ?>

<!--Sekcja reklamowa-->
<section class="home">
   <div class="content">
      <h3>Znajdź coś dla siebie, zamów i czytaj.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="about.php" class="white-btn">Dowiedz się więcej</a>
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
                  // Jeśli użytkownik jest zalogowany, wyświetl formularz dodawania do koszyka
                  ?>
                  <div class="box">
                     <a href="item.php?product_id=<?php echo $fetch_products['id']; ?>">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">PLN<?php echo $fetch_products['price']; ?>/-</div>
                     </a>
                     <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="Dodaj do koszyka" name="add_to_cart" class="btn">
                     </form>
                  </div>
               <?php
               } else {
                  // Jeśli użytkownik nie jest zalogowany, wyświetl komunikat
                  ?>
                  <div class="box">
                     <a href="item.php?product_id=<?php echo $fetch_products['id']; ?>">
                        <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">PLN<?php echo $fetch_products['price']; ?>/-</div>
                     </a>
                     <div class="login-message">Aby zobaczyć więcej, zaloguj się</div>
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


<!--Sekcja o nas, przekierowanie do O Nas-->
<section class="about">
   <div class="flex">
      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>
      <div class="content">
         <h3>O nas</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">Czytaj więcej</a>
      </div>
   </div>
</section>

<!--Sekcja pytania, przekierowanie do wiadomości-->
<section class="home-contact">
   <div class="content">
      <h3>Masz pytanie?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">Kontakt</a>
   </div>
</section>

<!--Wczytanie stopki-->
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>
