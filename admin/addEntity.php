<?php
  ob_start();

  include 'header.php';
  include 'ft.php';
  include 'db.php';

?>

<div class="container top">
  <div class="head">
    <div class="jumbotron">
      <h1 class="display-4">Add a New Entity</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <label for="entityName" class="form-label">Entity Name:</label>
        <input type="text" name="entityName" id="entityName" class="form-control">
        <label for="catName" class="form-label">Category Name:</label>
        <input type="text" name="catName" id="catName" class="form-control" aria-describedby="catHelpBlock">
        <div id="catHelpBlock" class="form-text">
          Make sure to properly spell the category name.
        </div>
        <div class="mb-3">
          <label for="formFile" class="form-label">Thumbnail Image:</label>
          <input class="form-control" type="file" id="thumbnailFile" name="thumbnailFile">
        </div> 
        <div class="mb-3">
          <label for="formFile" class="form-label">Preview Video:</label>
          <input class="form-control" type="file" id="previewFile" name="previewFile">
        </div> 
        <hr class="my-4">
        <input type="submit" class="btn btn-dark btn-lg" name="submit">
      </form>
    </div>
  </div>
</div>


<?php

  if(isset($_POST['submit']) && isset($_FILES['previewFile']) && isset($_FILES['thumbnailFile'])){

    $errorArray = array();

    //extracting flies names and tmp locations
    $preview = $_FILES['previewFile']['name'];
    $previewTmp = $_FILES['previewFile']['tmp_name'];
    if ($_FILES['previewFile']['error'] != 0){
      $errorArray[] = $_FILES['previewFile']['error'];
    }

    $thumbnail = $_FILES['thumbnailFile']['name'];
    $thumbnailTmp = $_FILES['thumbnailFile']['tmp_name'];
    if($_FILES['thumbnailFile']['error'] != 0){
      $errorArray[] = $_FILES['thumbnailFile']['error'];
    }

    if (sizeof($errorArray) == 0){

      //getting the extensions of the files
      $thumbnailExtension = strtolower(pathinfo($thumbnail, PATHINFO_EXTENSION));
      $previewExtension = strtolower(pathinfo($preview, PATHINFO_EXTENSION));

      $allowedVidEx = array("mp4", "mov", "avi", "wmv", "avchd", "webm", "flv",);

      $allowedImgEx = array("jpg", "jpeg", "png", "psd", "svg");

      //checking if the extensions are valid and allowed and uploading files to the right location
      if(in_array($previewExtension, $allowedVidEx) && in_array($thumbnailExtension, $allowedImgEx)){
        $newThumbnailName = uniqid("thumbnail-", true) . '.' . $thumbnailExtension;
        $newPreviewName = uniqid("preview-", true) . '.' . $previewExtension;

        $thumbnailUploadPath = '../entities/thumbnails/' . $newThumbnailName;
        $previewUploadPath = '../entities/previews/' . $newPreviewName;

        $newThumbnailName = "entities/thumbnails/" . $newThumbnailName;
        $newPreviewName = "entities/previews/" . $newPreviewName;

        move_uploaded_file($previewTmp, $previewUploadPath);
        move_uploaded_file($thumbnailTmp, $thumbnailUploadPath);

        //inserting values into the database
        $catName = $_POST['catName'];
        if(verifyCategory($catName, $con) == 0){
          echo "<script>alert('Inexistant Category in Database. Please Add New Category or Choose One From the Category List.');</script>";
        }else{
          $entityName = $_POST['entityName'];
          $categoryId = verifyCategory($catName, $con);
          $query = $con->prepare("INSERT INTO entities(name, thumbnail, preview, categoryId)
                                  VALUES(:name, :thumbnail, :preview, :categoryId)");

          $query->bindValue(':name', $entityName);
          $query->bindValue(':thumbnail', $newThumbnailName);
          $query->bindValue(':preview', $newPreviewName);
          $query->bindValue(':categoryId', $categoryId);

          $run = $query->execute();

          $fetchQuery = $con->prepare("SELECT * FROM entities WHERE name = :name AND categoryId = :categoryId");
          $fetchQuery->bindValue(':name', $entityName);
          $fetchQuery->bindValue(':categoryId', $categoryId);
          $fetchQuery->execute();
          $row = $fetchQuery->fetch(PDO::FETCH_ASSOC);
          if ($run){
            header("Location: addVideo.php?entityId=" . $row['id']);
          }
          else{
              echo "<script>alert('There Was a Problem While Adding Entity'); window.location.href='entitiesList.php';</script>";
          }
        }
      }else{
        echo "<script>alert('Cannot Upload Flies of This Type.');</script>";
        header("Location:entitiesList.php");
      }

    }

  }

  function verifyCategory($cat, $con){

    $query = $con->prepare("SELECT * FROM categories WHERE name =:cat");
    $query->bindValue(':cat',$cat);

    $query->execute();

    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($query->rowCount() == 1){
      return $row['id'];
    }else{
      return 0;
    }
  }

?>