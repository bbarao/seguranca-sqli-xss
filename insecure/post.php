<?php
require '../sqlidb.class.php';

if(isset($_POST['post']) && isset($_SESSION['user'])) {
  $db->insecurePost($_SESSION['user'],$_POST['post']);
}

header('Location: index.php');
