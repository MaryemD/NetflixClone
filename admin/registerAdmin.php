<?php

  include 'header.php';
  include 'ft.php';
  include 'db.php';

?>

<!-- registration form -->
<div class="container">
  <div class="head" style="text-align: center">
    <h1>Register New Admin</h1>
  </div>

  <form action="registerAdmin.php" method="post">
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Username</label>
      <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input type="password" name="password" class="form-control" id="exampleInputPassword1">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
<!-- end of registration form -->

<?php

  if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password = hash("sha512", $password);

    $query = $con->prepare("INSERT INTO admin(username, password) VALUES
                                              (:un, :pwd)");
    $query->bindValue(':un', $username);
    $query->bindValue(':pwd', $password);

    $success = $query->execute();

    if($success){
      echo "<script>alert('New Admin Added.'); window.location.replace('adminList.php');</script>";
      //header("Location: adminList.php");
    }
    else{
      echo "<script>alert('An error occurred'); window.location.replace('adminList.php');</script>";
    }

  }

?>
