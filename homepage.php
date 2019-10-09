

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">

  <title>FoodSmith Cafe House</title>

</head>
<body>
  <header>
    <?php
		include('includes/header.php');
		include('includes/loginCheck.php');
    ?>
    <div class="menuNavigation">
      <?php
		include('includes/navMenu.php');
      ?>
    </div>
  </header>

  <body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4 col-sm-4"><button type="button" id="mainbutton" class="btn">Table</button></div>
      <div class="col-lg-4 col-sm-4"><button type="button" id="mainbutton" class="btn">Menu</button></div>
      <div class="col-lg-4 col-sm-4"><button type="button" id="mainbutton" class="btn">Reservation</button></div>
    </div>
  </div>

  </body>

  <footer>
    <?php
		include('includes/footer.php');
    ?>
  </footer>

</body>
</html>
