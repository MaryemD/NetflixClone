<?php 

include 'db.php';
include 'header.php';
include 'ft.php';
 ?>
<div class="center">
  <div class="row">
    <div class="col-lg-7 position-relative z-index-2">
      <div class="mb-4 mt-4">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6">
                <h2 class="font-weight-bolder mb-0">General Statistics</h2>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-5 col-sm-5">
          <div class="card  mb-2">
            <div class="card-header p-3 pt-2 bg-transparent">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Admins</p>
                <h4 class="mb-0 ">
                <?php 
                  $query = $con->prepare("SELECT count(*) as total_admin from admin");
                  $run = $query->execute();
                  if ($run) {
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                      echo $row['total_admin'];
                    }
                  }
                ?>
                  </h4>
              </div>
            </div>

            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            <a class="btn btn-dark btn-sm" href="registerAdmin.php">Admins List</a>
            </div>
          </div>

          <div class="card  mb-2">
            <div class="card-header p-3 pt-2 bg-transparent">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Categories</p>
                <h4 class="mb-0">
                  <?php 
                    $query = $con->prepare("SELECT count(*) as total_category from categories");
                    $run = $query->execute();
                    if ($run) {
                      while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                        echo $row['total_category'];
                      }
                    }
                  ?>
                </h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            <a class="btn btn-dark btn-sm" href="categoryList.php">Categories List</a>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-2">
            <div class="card-header p-3 pt-2 bg-transparent">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize ">Total Entities</p>
                <h4 class="mb-0 ">
                  <?php 

                    $query = $con->prepare("SELECT count(*) as total_entities from entities");
                    $run = $query->execute();
                    if ($run) {
                      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo $row['total_entities'];
                      }
                    }
                  ?>
                </h4>
              </div>
            </div>
            <hr class="horizontal my-0 dark">
            <div class="card-footer p-3">
            <a class="btn btn-dark btn-sm" href="entitiesList.php">Entities List</a>
            </div>
          </div>

          <div class="card userCard ">
          <div class="card-header p-3 pt-2 bg-transparent">
            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            </div>
            <div class="text-end pt-1">
              <p class="text-sm mb-0 text-capitalize ">Total Users</p>
              <h4 class="mb-0 ">
                <?php 
                    $query = $con->prepare("SELECT count(*) as total_users from users");
                    $run = $query->execute();
                    if ($run) {
                      while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                        echo $row['total_users'];
                      }
                    }
                  ?>
              </h4>
            </div>
          </div>
          <hr class="horizontal my-0 dark">
            <div class="card-footer p-3">
            <a class="btn btn-dark btn-sm" href="usersList.php">Users List</a>
            </div>
      </div>
  </div>
</div>

    