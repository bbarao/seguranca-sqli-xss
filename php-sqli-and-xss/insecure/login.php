<?php
require '../sqlidb.class.php';

if(isset($_POST['username']) && isset($_POST['password'])) {
  $login = $db->insecureLogin($_POST['username'], $_POST['password']);
  if($login!==FALSE) {
    $_SESSION['user'] = $login->id;
    $_SESSION['name'] = $login->name;
    session_regenerate_id(TRUE);
  } else {
    # Hammer Time
    $_SESSION['flashmessage'] = 'Invalid Username/Password';
  }
}

header('Location: index.php');
