<?php

try {
  $con = new PDO("mysql:dbname=tuniflix;host=localhost", "root", "");
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
  exit("Connections failed: " . $e->getMessage());
}

?>