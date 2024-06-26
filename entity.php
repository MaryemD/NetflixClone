<?php

  //entity page that holds specific information to each entity

  require_once("includes/header.php");

  if(!isset($_GET["id"])){
    ErrorMessage::show("No ID passed in url.");
  }

  $entityId = $_GET["id"];

  $entity = new Entity($con, $entityId);

  $preview = new PreviewProvider($con, $userLoggedIn);
  echo $preview->createPreviewVideo($entity);

  $seasonProvider = new SeasonProvider($con, $userLoggedIn);
  echo $seasonProvider->create($entity);

  //gets all shows and movies from the same category as the specified entity
  $categoryContainers = new CategoryContainers($con, $userLoggedIn);
  echo $categoryContainers->showCategory($entity->getCategoryId(), "You might also like");
?>