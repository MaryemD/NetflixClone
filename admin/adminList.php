<?php

  include 'header.php';
  include 'ft.php';
  include 'db.php';

?>

<!-- table -->

<div class="container" style="margin-top: 100px">
  <div class="head" style="padding: 10px 0">
    <h1>Admins of Tuniflix</h1>
    <hr>
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Username</th>
        <th class="aligned" scope="col">Delete Admin</th>
      </tr>
    </thead>
    <?php
        $query = $con->prepare("SELECT * FROM admin");
        $run = $query->execute();

        if($run){
          while($row = $query->fetch(PDO::FETCH_ASSOC)){

    ?>
            <tbody>
              <tr>
                <th scope="row"><?php echo $row['id']; ?></th>
                <td><?php echo $row['username']; ?></td>
                <td class="aligned"><a href="deleteAdmin.php?userId=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash" style="color: black"></i></a></td>
              </tr>
            </tbody>
    <?php
          }
        }
    ?>
  </table>

  <a class="btn btn-dark addAdmin" href="registerAdmin.php">Add New Admin</a>

</div>

<!-- end of table -->