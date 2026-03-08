<?php
$dns = 'mysql:host=sql112.infinityfree.com;dbname=if0_40762452_finalarray';
$user = 'if0_40762452';
$pass = 'ej4YiaqaItDlPO';
$options = array(
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);


try {

  $connect = new PDO($dns, $user, $pass, $options);
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

  echo 'Connection failed: ' . $e->getMessage();

}


?>