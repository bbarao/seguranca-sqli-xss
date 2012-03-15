<?php

class sqlidb {

    private $db;
    private $salt = 'SALT-GRANDE-E-NADA-PREVISIVEL-';

    public function __construct($dsn, $username, $password) {
        $this->db = new PDO($dsn, $username, $password);
    }

    public function getPosts($limit=0) {
	$sql = "SELECT users.name, posts.post, posts.post_date
                FROM posts INNER JOIN 
                  users ON posts.user_id=users.id
                ORDER BY post_date DESC";
        if($limit>0) {
	  $sql .= " LIMIT ".((int)$limit);
        }
        $res = $this->db->query($sql);
        if($res === FALSE) {
	  return FALSE;
	}
	return $res->fetchAll(PDO::FETCH_OBJ);
    }

    public function insecureLogin($username, $password) {
	
	$password = sha1($this->salt.$password);

        $sql = "SELECT id,name,email FROM users WHERE username='{$username}' AND password='{$password}'";
        $res = $this->db->query($sql);

        if($res === FALSE) {
            // Query Error?
            return FALSE;
        }
        $res = $res->fetch(PDO::FETCH_OBJ);
        if($res === FALSE) {
            // Wrong user/pass combination
            return FALSE;
        }

        // User exists!
        return $res;
    }

    public function secureLogin($username, $password) {

	$password = sha1($this->salt.$password);

        $sql  = "SELECT id,name,email FROM users WHERE username=? AND password=?";
        $psql = $this->db->prepare($sql);
        $psql->execute(array($username, $password));

        if($psql === FALSE) {
            // Query Error?
            return FALSE;
        }

        $res = $psql->fetch(PDO::FETCH_OBJ);
        if($res === FALSE) {
            // Wrong user/pass combination
            return FALSE;
        }

        // User exists!
        return $res;
    }
    
    public function insecurePost($user_id, $post) {
        $sql = "INSERT INTO posts (user_id,post) VALUES ('{$user_id}', '{$post}')";
        $res = $this->db->query($sql);

        if($res === FALSE) {
            // Query Error?
            return FALSE;
        }

        return TRUE;
    }

    public function securePost($user_id, $post) {
        $sql = "INSERT INTO posts (user_id,post) VALUES (?,?)";
        $psql = $this->db->prepare($sql);
        $res = $psql->execute(array($user_id, $post));
        
        return $res;
    }
    
}

# Common stuff
set_magic_quotes_runtime(FALSE);
session_start();
$db = new sqlidb('mysql:dbname=sqli;host=localhost', 'DB-USERNAME', 'DB-PASSWORD');
