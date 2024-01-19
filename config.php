<?php
//Połączenie z bazą danych lokalną
$conn = mysqli_connect('localhost','root','','shop_db') or die('connection failed');
// Połączenie z bazą danych online
/*$host = 'mysql5.webio.pl'; // np. example.com
$db_user = '22843_userdb';
$db_password = '#1234qwe#';
$db_name = '22843_shop_db';

$conn = mysqli_connect($host, $db_user, $db_password, $db_name) or die('connection failed');
*/
?>