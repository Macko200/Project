<!--Sekcja nagłówka Administratora-->
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
}//<a href="admin_users.php">Użytkownicy</a>
?>
<!--Sekcja nagłówka-->
<header class="header">
   <div class="flex">
      <a href="admin_page.php" class="logo">Moder<span>Panel</span></a>
      <nav class="navbar">
         <a href="admin_page.php">Strona główna</a>
         <a href="admin_products.php">Produkty</a>
         <a href="admin_orders.php">Zamówienia</a>
         
         <a href="admin_contacts.php">Wiadomości</a>
      </nav>
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="account-box">
         <p>nazwa : <span><?php echo $_SESSION['moder_name']; ?></span></p>
         <p>email : <span><?php echo $_SESSION['moder_email']; ?></span></p>
         <a href="logout.php" class="delete-btn">Wyloguj</a>
         <div>Nowe <a href="login.php">Logowanie</a> | <a href="register.php">Zarejestruj</a></div>
      </div>
   </div>
</header>