<!--Sekcja wylogowania-->
<?php
// Wczytanie konfiguracji do bazy danych
include 'config.php';

session_start();
session_unset();
session_destroy();

header('location:home.php');

?>