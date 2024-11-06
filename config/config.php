<?php

try{
    $pdo = new PDO("mysql:host=localhost;dbname=blog_khtn", "root" , "");
}catch(PDOEXCEPTION $e){
    echo "Error..." .$e;
}