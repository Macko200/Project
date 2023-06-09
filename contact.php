<!--Sekcja Kontakt-->
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

//Rozkazy dla bazy danych
if(isset($_POST['send'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);
   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'Wiadomośc już wysłana!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message[] = 'Wiadomość została wysłana!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!--Wcztanie menu / nagłówka -->    
<?php include 'header.php'; ?>

<!--Sekcja z aktualną pozycją na stronie-->
<div class="heading">
   <h3>Kontakt</h3>
   <p> <a href="home.php">Strona główna</a> / Kontakt </p>
</div>

<!--Sekcja wysyłania wiadomości-->
<section class="contact">
   <form action="" method="post">
      <h3>Czekamy na wiadomość!</h3>
      <input type="text" name="name" required placeholder="podaj imię" class="box">
      <input type="email" name="email" required placeholder="podaj email" class="box">
      <input type="number" name="number" required placeholder="podaj nr tel" class="box">
      <textarea name="message" class="box" placeholder="napisz wiadomość" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="Wyśli wiadomość" name="send" class="btn">
   </form>
</section>

<!--Wczytanie stopki-->
<?php include 'footer.php'; ?>


<script src="js/script.js"></script>
</body>
</html>