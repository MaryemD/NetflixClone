<?php

  include 'db.php';

  if (isset($_GET['entityId'])){
    $id = $_GET['entityId'];

    $query = $con->prepare("DELETE FROM entities WHERE id = :id");
    $query->bindValue(':id', $id);

    $run = $query->execute();

    if($run){
      echo "<script>alert('Entity Has been Deleted.'); window.location.replace('entitiesList.php');</script>";
      //header("Location: entitiesList.php");
    }else{
      echo "<script>alert('Something went Wrong.'); window.location.replace('entitiesList.php');</script>";
      //header("Location: entitiesList.php");
    }
  }else{
    echo "<script>alert('No ID passed in URL.'); window.location.replace('entitiesList.php');</script>";
    //header("Location: entitiesList.php");
  }

  

?>