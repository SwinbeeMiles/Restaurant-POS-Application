
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <div class="row justify-content-around">
      
      <div class="col-xl-4"><button type="button" class="main mainButton" onclick=location.href="tablepage.php">Table</button></div>
      <div class="col-xl-4"><button type="button" class="main mainButton" onclick=location.href="menulisting.php">Menu</button></div>
      <div class="col-xl-4"><button type="button" class="main mainButton" onclick=location.href="reservation.php">Reservation</button></div>
      <div class="col-xl-4"><button type="button" class="main mainButton" onclick=location.href="couponlist.php">Coupon</button></div>
      <div class="col-xl-4"><button type="button" class="main mainButton" onclick=location.href="#.php">Report</button></div>
      <div class="col-xl-4"><button type="button" class="main mainButton" onclick=location.href="accountlist.php">Account</button></div>
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
