<!--Sekcja nagłówkowa-->
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!--Nagłówek / menu-->
<header class="header">
   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="https://www.facebook.com/" class="fab fa-facebook-f"></a>
            <a href="https://www.twitter.com/" class="fab fa-twitter"></a>
            <a href="https://www.instagram.com" class="fab fa-instagram"></a>
         </div>
         <p> Nowe <a href="login.php">Logowanie</a> | <a href="register.php">Rejestracja</a> </p>
      </div>
   </div>
   <div class="header-2">
      <div class="flex">
         <h1 href="home.php" class="logo">e-Books. </h1>
         <nav class="navbar">
            <a href="home.php">Strona główna</a>
            <a href="about.php">O nas</a>
            <a href="shop.php">Sklep</a>
            <a href="contact.php">Kontakt</a>
            <a href="orders.php">Zamówienia</a>
         </nav>
      <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
            // Sprawdź, czy użytkownik jest zalogowany
            if(isset($_SESSION['user_id'])){
               // Pobierz liczbę elementów w koszyku dla zalogowanego użytkownika
               $user_id = $_SESSION['user_id'];
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            } else {
               // Sprawdź, czy istnieje zapisana sesja dla niezalogowanego użytkownika
               if(isset($_SESSION['cart'])){
                  // Pobierz liczbę elementów w koszyku dla niezalogowanego użytkownika
                  $cart_items = $_SESSION['cart'];
                  $cart_rows_number = count($cart_items);
               } else {
                  // Jeśli sesja dla niezalogowanego użytkownika nie istnieje, ustaw liczbę elementów w koszyku na 0
                  $cart_rows_number = 0;
                  }
            }
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
      </div>
         <div class="user-box">
            <?php if(isset($_SESSION['user_id'])) { ?>
               <p>nazwa  : <span><?php echo $_SESSION['user_name']; ?></span></p>
               <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
               <a href="logout.php" class="delete-btn">Wyloguj</a>
            <?php } else { ?>
               <p>Nie zalogowano</p>
            <?php } ?>
         </div>
      </div>
   </div>
</header>