<!--Sekcja rejestracji użytkowników--> 
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

// Rozkazy dla bazy danych
if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $confirmPassword = $_POST['cpassword'];
   $user_type = 'user'; // Domyślny typ użytkownika

   // Sprawdź, czy użytkownik już istnieje
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Użytkownik już istnieje!';
   }else{
      if($password != $confirmPassword){
         $message[] = 'Hasło musi być takie samo!';
      }else{
         // Wygeneruj hasło z użyciem bcrypt
         $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

         // Wstaw użytkownika do bazy danych
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$hashedPassword', '$user_type')") or die('query failed');
         $message[] = 'Rejestracja przebiegła pomyślnie!';
         header('location:login.php');
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
   <title>register</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style2.css">
</head>
<body>
<!--Wiadomość--> 
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

<!--Okno rejestracji--> 
<div class="form-container">
   <form action="" method="post">
      <h3>Zarejestruj się</h3>
      <input type="text" name="name" placeholder="podaj swoje imię" required class="box">
      <input type="email" name="email" placeholder="podaj swój email" required class="box">
      <input type="password" name="password" placeholder="podaj hasło" required class="box">
      <input type="password" name="cpassword" placeholder="powtórz hasło" required class="box">
      <input type="submit" name="submit" value="Zarejestruj" class="btn">
      <p>Masz już konto? <a href="login.php">Zaloguj</a></p>
   </form>
</div>
</body>
</html>
