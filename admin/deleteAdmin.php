<?php

  include 'db.php';

  $id = $_GET['userId'];

  $query = $con->prepare("DELETE FROM admin WHERE id = :id");
  $query->bindValue(':id', $id);

  $run = $query->execute();

  if($run){
    echo "<script>alert('Admin Has been Deleted.'); window.location.replace('adminList.php');</script>";
    //header("Location: adminList.php");
  }else{
    echo "<script>alert('Something went Wrong.'); window.location.replace('adminList.php');</script>";
    //header("Location: adminList.php");
  }

?>