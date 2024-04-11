<?php

  include 'header.php';
  include 'ft.php';
  include 'db.php';

?>

<div class="container" style="margin-top: 100px;">
  <div class="head" style="padding: 10px 0">
    <h1>Entities List</h1>
    <hr>
    <a class="btn btn-dark" href="addEntity.php">Add New Entity</a>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th  scope="col">Category</th>
        <th class="aligned" scope="col"> Videos</th>
        <th class="aligned" scope="col">Delete Entity</th>
      </tr>
    </thead>
    <?php
        $query = $con->prepare("SELECT * FROM entities");
        $run = $query->execute();

        if($run){
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $catQuery = $con->prepare("SELECT * FROM categories WHERE id =:id");
            $catQuery->bindValue(':id',$row['categoryId']);

            $catQuery->execute();
            $catRow = $catQuery->fetch(PDO::FETCH_ASSOC);

    ?>
          <tbody>
            <tr>
              <th scope="row"><?php echo $row['id']; ?></th>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $catRow['name']; ?></td>
              <td class="aligned"><a class="videoListLink" href="videoList.php?entityId=<?php echo $row['id']; ?>">Videos List</a></td>
               <td class="aligned"><a href="deleteEntity.php?entityId=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash" style="color: black"></i></a></td>
            </tr>
          </tbody>
    <?php
          }
        }
    ?>
  </table>

</div>
