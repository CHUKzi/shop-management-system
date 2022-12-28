<?php
  
  /*Connection*/

  $connection = mysqli_connect('localhost', 'root', '', 'lal');

  if (mysqli_connect_errno()) {
    die('Database connection failed ' . mysqli_connect_error());
  } else {
    echo "";
  }

  /*DO NOT CHANGE*/

  session_start();

  if (isset($_SESSION['user_id'])) {
    $query = "SELECT * FROM users WHERE id='{$_SESSION['user_id']}'";
    $login = mysqli_query($connection, $query);
    $login_u = mysqli_fetch_assoc($login);
  }

  $BaseUrl = "http://localhost/lal/"; //Mobile http://192.168.82.90/lal

?>