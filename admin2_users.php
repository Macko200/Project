<!--Sekcja użytkowników Administratora--> 
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin2_users.php');
}
// Rozkazy dla bazy danych
if(isset($_POST['save_user_type'])){
   $user_id = $_POST['user_id'];
   $user_type = $_POST['user_type'];
   mysqli_query($conn, "UPDATE `users` SET user_type = '$user_type' WHERE id = '$user_id'") or die('query failed');
   header('location:admin2_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
<!--Sekcja nagłówka-->   
<?php include 'admin2_header.php'; ?>

<!--Sekcja użytkowników-->
<section class="users">
   <h1 class="title"> Konta użytkowników </h1>
   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <p> Id użytkownika : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> Nazwa : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> E-mail : <span><?php echo $fetch_users['email']; ?></span> </p>
         <form action="" method="post">
      <p> Uprawnienia :
         <select name="user_type" class="box">
            <option value="user" <?php if($fetch_users['user_type'] == 'user') echo 'selected'; ?>>user</option>
            <option value="admin" <?php if($fetch_users['user_type'] == 'admin') echo 'selected'; ?>>admin</option>
            <option value="moder" <?php if($fetch_users['user_type'] == 'moder') echo 'selected'; ?>>moder</option>
         </select>
      <input type="hidden" name="user_id" value="<?php echo $fetch_users['id']; ?>">
      </p>
      <p>
      <input type="submit" name="save_user_type" value="Zapisz uprawnienia" class="delete-btn">
      </p>
</form>

         <a href="admin2_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Usunąć tego użytkownika?');" class="delete-btn">Usuń użytkownika</a>
      </div>
      <?php
         };
      ?>
   </div>
</section>

<script src="js/admin_script.js"></script>
</body>
</html>