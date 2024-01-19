<!--Skcja Sklep--> 
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->    
<?php include 'header.php'; ?>

<!--Sekcja z aktualną pozycją na stronie-->
<div class="heading">
   <h3>Twoje zamówienia</h3>
   <p> <a href="home.php">Strona główna</a> / Zamówienia </p>
</div>

<!--Sekcja z zamówieniami-->
<section class="placed-orders">
   <h1 class="title">złożone zamówienia</h1>
   <div class="box-container">
      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
      <div class="box">
         <p> Zamówione w dniu : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
         <p> Imię i nazwisko : <span><?php echo $fetch_orders['name']; ?></span> </p>
         <p> Nr tel : <span><?php echo $fetch_orders['number']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_orders['email']; ?></span> </p>
         <p> Adres : <span><?php echo $fetch_orders['address']; ?></span> </p>
         <p> Metoda płatności : <span><?php echo $fetch_orders['method']; ?></span> </p>
         <p> Twoje zamówienie : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
         <p> Cena całkowita : <span>PLN <?php echo $fetch_orders['total_price']; ?>/-</span> </p>
         <p> Status płatności : <span style="color:<?php if($fetch_orders['payment_status'] == 'Oczekujące'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
         </div>
      <?php
       }
      }else{
         echo '<p class="empty">Nie ma jeszcze złożonych zamówień!</p>';
      }
      ?>
   </div>
</section>

<!--Wczytanie stopki-->
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>