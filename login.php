<!--Skcja logowania--> 
<?php
//Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();
// Rozkazy dla bazy danych
if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $row = mysqli_fetch_assoc($select_users);
      $hashedPassword = $row['password'];

      // Sprawdź, czy hasło jest poprawne
      if(password_verify($password, $hashedPassword)){
         if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin2_page.php');
         }elseif($row['user_type'] == 'user'){
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }elseif($row['user_type'] == 'moder'){
            $_SESSION['moder_name'] = $row['name'];
            $_SESSION['moder_email'] = $row['email'];
            $_SESSION['moder_id'] = $row['id'];
            header('location:admin_page.php');
         }
      }else{
         $message[] = 'Nieprawidłowy email lub hasło!';
      }
   }else{
      $message[] = 'Nieprawidłowy email lub hasło!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">   
   <link rel="stylesheet" href="css/style.css">
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

<!--Okno logowania-->    
<div class="form-container">
   <form action="" method="post">
      <h3>Zaloguj się</h3>
      <input type="email" name="email" placeholder="podaj swój email" required class="box">
      <input type="password" name="password" placeholder="podaj hasło" required class="box">
      <input type="submit" name="submit" value="Zaloguj" class="btn">
      <p>Nie masz jeszce konta? <a href="register.php">Zarejestruj się</a></p>
   </form>
</div>
</body>
</html>