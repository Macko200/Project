<!--Sekcja wiadomości Moderatora--> 
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

$moder_id = $_SESSION['moder_id'];

if(!isset($moder_id)){
   header('location:login.php');
};
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>

<!--Sekcja nagłówka-->   
<?php include 'admin_header.php'; ?>

<!--Sekcja wiadomości-->
<section class="messages">
   <h1 class="title"> Wiadomości </h1>
   <div class="box-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){      
   ?>
   <div class="box">
      <p> Id użytkownika : <span><?php echo $fetch_message['user_id']; ?></span> </p>
      <p> Imię i nazwisko : <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> Nr telefonu : <span><?php echo $fetch_message['number']; ?></span> </p>
      <p> E-mail : <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> Wiadomość : <span><?php echo $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Usunąć tą wiadomość?');" class="delete-btn">Usuń Wiadomość</a>
   </div>
   <?php
      };
   }else{
      echo '<p class="empty">Nie masz wiadomości!</p>';
   }
   ?>
   </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>