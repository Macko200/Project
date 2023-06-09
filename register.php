<!--Sekcja rejestracji użytkowników--> 
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

// Wczytanie biblioteki PHPMailer
require 'path/to/PHPMailer/PHPMailerAutoload.php';

// Rozkazy dla bazy danych
if(isset($_POST['submit'])){
   // reszta kodu rejestracji

   // Wygeneruj unikalny kod aktywacyjny
   $activation_code = uniqid();

   // Wstaw użytkownika do bazy danych
   mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type, activation_code) VALUES('$name', '$email', '$hashedPassword', '$user_type', '$activation_code')") or die('query failed');

   // Wysłanie wiadomości e-mail z linkiem aktywacyjnym
   $mail = new PHPMailer;

   // Ustawienia poczty wychodzącej
   $mail->isSMTP();
   $mail->Host = 'smtp.example.com';
   $mail->Port = 587;
   $mail->SMTPAuth = true;
   $mail->Username = 'your_email@example.com';
   $mail->Password = 'your_email_password';

   // Adres nadawcy i odbiorcy
   $mail->setFrom('your_email@example.com', 'Your Name');
   $mail->addAddress($email, $name);

   // Temat i treść wiadomości e-mail
   $mail->Subject = 'Aktywacja konta';
   $mail->Body = 'Kliknij poniższy link, aby aktywować swoje konto:<br><br>
      <a href="http://www.example.com/activate.php?code='.$activation_code.'">Aktywuj konto</a>';

   // Ustawienia HTML
   $mail->isHTML(true);

   // Wyślij wiadomość e-mail
   if(!$mail->send()) {
      echo 'Błąd podczas wysyłania wiadomości: ' . $mail->ErrorInfo;
   } else {
      echo 'Wiadomość aktywacyjna została wysłana na Twój adres e-mail. Sprawdź skrzynkę odbiorczą.';
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
