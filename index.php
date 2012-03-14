<?php
require 'sqlidb.class.php';

$posts = $db->getPosts();

?>
<html>
<head>
  <title>Postas de Pescada</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
  <h3>Postas de Pescada</h3>
  <div>
<?php if(isset($_SESSION['user'])): ?>
    <h4>Hello <?php echo htmlspecialchars($_SESSION['name']); ?> - <a href="logout.php">LogOut</a></h4>
    <form action="post.php" method="post">
      Message:<br />
      <textarea cols="50" rows="8" name="post"></textarea><br />
      <input type="submit" value="Post" />
    </form>
<?php else: ?>
<?php if(isset($_SESSION['flashmessage'])): ?>
    <h4><?php echo $_SESSION['flashmessage']; unset($_SESSION['flashmessage']); ?></h4>
<?php endif; ?>
    <form action="login.php" method="post">
      Username: <input type="text" name="username" value="" />
      Password: <input type="password" name="password" value="" />
      <input type="submit" value="Login" />
    </form>
<?php endif; ?>
  </div>
<?php foreach($posts as $post) : ?>
  <hr />
  <h4><?php echo htmlspecialchars($post->name); ?> said on <?php echo $post->post_date; ?>:</h4>
  <h5><?php echo nl2br(htmlspecialchars($post->post)); ?></h5>
<?php endforeach; ?>
</body>
</html>