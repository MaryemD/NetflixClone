<?php
ob_start();

include 'header.php';
include 'ft.php';
include 'db.php';

?>
<div class="container top">
  <div class="head">
    <div class="jumbotron">
      <h1 class="display-4">Add a New Video to Entity</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <label for="vidTitle" class="form-label">Video Title:</label>
        <input type="text" name="videoTitle" id="vidTitle" class="form-control">
        <label for="vidDescription" class="form-label">Description:</label>
        <div class="form-floating">
          <textarea class="form-control" name="vidDescription" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 150px"></textarea>
          <label for="floatingTextarea2">Description</label>
        </div> 
        <label for="vidDate" class="form-label">Release Date:</label>
        <input type="date" name="vidDate" id="vidDate" class="form-control">
        <label for="vidDuration" class="form-label">Video Duration:</label>
        <input type="text" name="vidDuration" id="duration" class="form-control">
        
        <div class="mb-3">
          <label for="formFile" class="form-label">Video File:</label>
          <input class="form-control" type="file" id="videoFile" name="videoFile">
        </div> 
        <label class="form-check-label movieLabel">
          Is the Video a Movie?
        </label> 
        <div class="form-check">
          <input class="form-check-input" type="radio" name="Radios" id="radioYes" value="Yes" onclick="change(this)">
          <label class="form-check-label" for="exampleRadios1">
            Yes
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="Radios" id="radioNo" value="No" onclick="change(this)">
          <label class="form-check-label" for="exampleRadios2">
            No
          </label>
        </div>

        <div id="htmlToChange">
        </div>

        <hr class="my-4">
        <input type="submit" class="btn btn-dark btn-lg" name="submit">
      </form>
    </div>
  </div>
</div>

<script>
  function change(radio){
    if (radio.checked && radio.id === "radioNo"){
      document.getElementById("htmlToChange").innerHTML = "<div class='row'> <div class='col'><input type='text' class='form-control' name='episode' placeholder='Episode Number' aria-label='Episode Number'></div><div class='col'><input type='text' class='form-control' name='season' placeholder='Season Number' aria-label='Season Number'></div></div>";
    }
  }
</script>


<?php

if(isset($_GET["entityId"])){
  $entityId = $_GET["entityId"];

  if(isset($_POST['submit']) && isset($_FILES['videoFile'])){

    //extracting flies names and tmp locations
    $video = $_FILES['videoFile']['name'];
    $videoTmp = $_FILES['videoFile']['tmp_name'];
    $error = $_FILES['videoFile']['error'];

    if ($error == 0){

      //getting the extensions of the files
      $videoExtension = strtolower(pathinfo($video, PATHINFO_EXTENSION));

      $allowedVidEx = array("mp4", "mov", "avi", "wmv", "avchd", "webm", "flv",);

      //checking if the extensions are valid and allowed and uploading files to the right location
      if(in_array($videoExtension, $allowedVidEx)){
        $newVideoName = uniqid("video-", true) . '.' . $videoExtension;

        $videoUploadPath = '../entities/videos/' . $newVideoName;

        $newVideoName = "entities/videos/" . $newVideoName;


        move_uploaded_file($videoTmp, $videoUploadPath);

        //inserting values into the database
        $title = $_POST['videoTitle'];
        $description = $_POST['vidDescription'];
        $releaseDate = $_POST['vidDate'];
        $duration = $_POST['vidDuration'];
        $episode = 1;
        $season = 1;
        $isMovie = 1;

        $radioVal = $_POST['Radios'];

        if ($radioVal == "No"){
          $episode = $_POST['episode'];
          $season = $_POST['season'];
          $isMovie = 0;
        }

        $query = $con->prepare("INSERT INTO videos(title, description, filePath, isMovie, uploadDate, releaseDate, duration, season, episode, entityId)
                                VALUES(:title, :description, :filePath, :isMovie, SYSDATE(), :releaseDate, :duration, :season, :episode, :entityId)");

        $query->bindValue(':title', $title);
        $query->bindValue(':description', $description);
        $query->bindValue(':filePath', $newVideoName);
        $query->bindValue(':isMovie', $isMovie);
        $query->bindValue(':releaseDate', $releaseDate);
        $query->bindValue(':duration', $duration);
        $query->bindValue(':episode', $episode);
        $query->bindValue(':season', $season);
        $query->bindValue(':entityId', $entityId);

        $run = $query->execute();
        if ($run){
          echo "<script>alert('Video Successfully Added.');</script>";
          header("Location: videoList.php?entityId=" . $entityId);
          exit(); 
        }
        else{
          echo "<script>alert('There Was a Problem While Adding Video');</script>";        
        }
      }else{
        echo "<script>alert('Cannot Upload Files of This Type.');</script>";
        header("Location: entitiesList.php");
        exit(); 
      }

    }

  }

}else{
  echo "<script>alert('No Entity Id Passed in URL.'); </script>";
  //window.location.href='entitiesList.php';
  header("Location: entitiesList.php");
  exit(); 
}

?>
