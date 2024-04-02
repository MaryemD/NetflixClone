<?php

  include 'header.php';
  include 'ft.php';
  include 'db.php';

?>

<div class="container top">
  <div class="head">
    <div class="jumbotron">
      <h1 class="display-4">Add a New Category</h1>
      <form action="" method="post">
        <label for="categoryName" class="form-label">Category Name:</label>
        <input type="text" name="categoryName" id="categoryName" class="form-control" aria-describedby="catHelpBlock">
        <div id="catHelpBlock" class="form-text">
          Please pick out a significant category name.
        </div>     
        <hr class="my-4">
        <input type="submit" class="btn btn-dark btn-lg" name="submit">
      </form>
    </div>
  </div>
</div>


<?php

  if(isset($_POST['submit'])){
    $catName = $_POST["categoryName"];
    
    $query = $con->prepare("SELECT * FROM category WHERE name =:cat");
    $query->bindValue(':name',$catName);

    $query->execute();

    if ($query->rowCount() == 1){
      echo "<script>alert('Category Already Exists in Database.');</script>";
      header("Location:categoryList.php");
    }else{
      $query1 = $con->prepare("INSERT INTO categories(name)
                            VALUES (:cat)");
      $query1->bindValue(':cat',$catName);
      $run = $query1->execute();

      if($run){
        echo "<script>alert('Category Successfully Added.');</script>";
        header("Location:categoryList.php");
      }else{
        echo "<script>alert('There Was a Problem While Adding Category'); window.location.href='addCategory.php';</script>";
    }
    }
  }

?>