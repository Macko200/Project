<!--Sekcja kasy-->
<?php
//Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

//Rozkazy dla bazy danych
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, ' '. $_POST['street'].'  '. $_POST['flat'].', '. $_POST['city'].' - '. $_POST['pin_code'].', '. $_POST['country']);
   $placed_on = date('d-M-Y');
   $cart_total = 0;
   $cart_products[] = '';
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }
   $total_products = implode(', ',$cart_products);
   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'Twój koszyk jest pusty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'Zamówienie już złożone!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'Zamówienie złożone pomyślnie!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
   }   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title> 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->     
<?php include 'header.php'; ?>

<!--Sekcja z aktualną pozycją na stronie-->
<div class="heading">
   <h3>Kasa</h3>
   <p> <a href="home.php">Strona główna</a> / Kasa </p>
</div>

<!--Rozkazy dla bazy danych-->
<section class="display-order">
   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo 'PLN '.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">Twój koszyk jest pusty</p>';
   }
   ?>
   <div class="grand-total"> Suma : <span>PLN <?php echo $grand_total; ?>/-</span> </div>
</section>

<!--Sekcja danych do zamówienia-->
<section class="checkout">
   <form action="" method="post">
      <h3>Dane do zamówienia</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Imie i nazwisko:</span>
            <input type="text" name="name" required placeholder="podaj imię i nazwisko">
         </div>
         <div class="inputBox">
            <span>Nr tel :</span>
            <input type="number" name="number" required placeholder="podaj nr telefonu">
         </div>
         <div class="inputBox">
            <span>Twój email :</span>
            <input type="email" name="email" required placeholder="podaj email">
         </div>
         <div class="inputBox">
            <span>Metoda płatnosci :</span>
            <select name="method">
               <option value="karta kredytowa">Karta kredytowa</option>
               <option value="paypal">PayPal</option>
               <option value="paytm">Paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Ulica :</span>
            <input type="text" name="street" required placeholder="np. Polna">
         </div>
         <div class="inputBox">
            <span>Nr domu/mieszkania :</span>
            <input type="text" min="0" name="flat" required placeholder="np. 5/2">
         </div>
         <div class="inputBox">
            <span>Miasto :</span>
            <input type="text" name="city" required placeholder="np. Poznań">
         </div>
         <div class="inputBox">
            <span>Województwo :</span>
            <input type="text" name="state" required placeholder="np. Wielkopolska">
         </div>
         <div class="inputBox">
            <span>Kraj :</span>
            <input type="text" name="country" required placeholder="np. Polska">
         </div>
         <div class="inputBox">
            <span>Kod pocztowy :</span>
            <input type="number" min="0" name="pin_code" required placeholder="np. 10100">
         </div>
      </div>
      <input type="submit" value="Zamów teraz" class="btn" name="order_btn">
   </form>
</section>

<!--Wczytanie stopki-->
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>