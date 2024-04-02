<?php

  include 'db.php';

  if (isset($_GET['catId'])){
    $id = $_GET['catId'];

    $query = $con->prepare("DELETE FROM categories WHERE id = :id");
    $query->bindValue(':id', $id);

    $run = $query->execute();

    if($run){
      echo "<script>alert('Category Has been Deleted.')</script>";
      header("Location: categoryList.php");
    }else{
      echo "<script>alert('Something went Wrong.')</script>";
      header("Location: categoryList.php");
    }
  }else{
    echo "<script>alert('No ID passed in URL.')</script>";
    header("Location: categoryList.php");
  }

  

?>