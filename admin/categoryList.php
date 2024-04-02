<?php

  include 'header.php';
  include 'ft.php';
  include 'db.php';

?>

<div class="container">
  <div class="head catHead">
    <h1>Categories of TuniFlix</h1>
  </div>
  <a class="btn btn-dark addCat" href="addCategory.php">Add New Category</a>
  <hr>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Category Name</th>
        <th class="aligned" scope="col">Delete Category</th>
      </tr>
    </thead>
    <?php
        $query = $con->prepare("SELECT * FROM categories");
        $run = $query->execute();

        if($run){
          while($row = $query->fetch(PDO::FETCH_ASSOC)){

    ?>
            <tbody>
              <tr>
                <th scope="row"><?php echo $row['id']; ?></th>
                <td><?php echo $row['name']; ?></td>
                <td class="aligned"><a href="deleteCategory.php?catId=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash" style="color: black"></i></a></td>
              </tr>
            </tbody>
    <?php
          }
        }
    ?>
  </table>
</div>