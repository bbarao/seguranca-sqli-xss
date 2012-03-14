<?php
require 'sqlidb.class.php';

if(isset($_POST['post']) && isset($_SESSION['user'])) {
  $db->securePost($_SESSION['user'],$_POST['post']);
}

header('Location: index.php');