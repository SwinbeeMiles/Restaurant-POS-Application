<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Authenticator</title>
    <meta charset="utf-8" />
    <script src="js/script.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>



  <div ="container-fluid">

  <?php
  require_once 'includes/connectDB.php';

  $user = $pass = "";
  $username_err = $password_err = "";
  $nousername = $nopassword = "";

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Ensures username and password is not empty
    if(empty(trim($_POST["username"]))){
      $username_err = "Please enter username.";
    } else{
      $user = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
      $password_err = "Please enter your password.";
    } else{
      $pass = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
      $sql = "SELECT Username, Password, AdminPrivilege FROM account WHERE Username = ?";
      $conn = connect();
      $stmt = mysqli_prepare($conn, $sql);
      //Replace ? in sql statement with username input
      mysqli_stmt_bind_param($stmt, 's', $user);
      mysqli_stmt_execute($stmt);
      //Stores new statement
      mysqli_stmt_store_result($stmt);

      //Check if the username matches exactly another username stored in DB
      if(mysqli_stmt_num_rows($stmt) == 1){
        //Bind the data to variables
        mysqli_stmt_bind_result($stmt, $user, $stored_password, $privilege);

        if(mysqli_stmt_fetch($stmt)){
          if($pass == $stored_password){
            session_start();
            $_SESSION['loggedin'] = true;

            if($privilege > 0){
              $privilege = 1;
            }
            else{
              $privilege = 0;
            }

            $_SESSION['privilege'] = $privilege;

            header("location: homepage.php");
          }
          else{
            $nopassword = "Incorrect Password.";
            //echo "<p>Incorrect Password.</p>";
          }
        }
      }
      else{
        $nousername = "Username does not exist.";
        //echo "<p>Username does not exist.</p>";
      }
      mysqli_close($conn);
    }
    else{
      if(empty(trim($_POST["username"]))){
        $username_err;
      }
      if(empty(trim($_POST["password"]))){
        $password_err;
      }
    }
  }
?>

  <div style="height: 100vh">
    <div class="container h-100">
      <div class="row h-100 justify-content-center align-items-center">
        <div class="card">
          <div class="card-body">
            <div class="form-group">

              <form action="index.php" method="post" novalidate="novalidate">
                <img src="assets/foodsmith.png" id="loginlogo" alt="cafelogo">
                <label for="_username">Username:</label>
                <input type="text" name="username" id="_username" class="form-control"><br>
                <span style="color: red;"><?php echo $username_err; ?></span>
                <span style="color: red;"><?php echo $nousername; ?></span>
                <br><br><label for="_password">Password: </label>
                <input type="text" name="password" id="_password" class="form-control"><br>

                <span style="color: red;"><?php echo $password_err; ?></span>
                <span style="color: red;"><?php echo $nopassword; ?></span>
                <br><br>

                <div class="row justify-content-around">
                <button type="submit" id="loginbutton" class="btn btn-secondary">Login</button>
                <button type="reset" id="loginbutton" class="btn btn-outline-secondary">Reset</button>
              </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</body>

</html>
