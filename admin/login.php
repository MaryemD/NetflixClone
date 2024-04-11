<?php

  session_start();

  include "ft.php";
  include "db.php";

?>

<head>
  <title>LogIn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <div class="container" style="margin-top: 100px">
    <div class="head" style="text-align: center">
      <h1>Login to Continue</h1>
    </div>

    <form action="login.php" method="post">
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

  </div>
</body>

<?php

  if (isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password = hash("sha512", $password);

    $query = $con->prepare("SELECT * FROM admin WHERE username =:un AND password =:pwd");
    $query->bindValue(":un", $username);
    $query->bindValue(":pwd", $password);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);
    if ($row){
      $_SESSION['logInSeccessful'] = 1;
      $_SESSION['user'] = $username;
      header("Location: index.php");
    }
    else{
      echo "<script>alert('Check your Username or Password');</script>";
    }
  }

?>