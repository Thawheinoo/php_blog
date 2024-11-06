<?php 
 require_once "../config/config.php";
 
 $id = $_GET['id'];

  $res = $pdo -> prepare("DELETE FROM posts WHERE id =  $id");
  $data = $res -> execute();

  header('location:index.php');