<!DOCTYPE html>

<!-- data-ng-app="pigeon-table" in the html is essential to inject ngPigeon-table into the webpage-->
<html lang="en">
<head>
    <title>Coupon List</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap -->
    <link href="pigeon-table/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Pigeon Table -->
    <link href="pigeon-table/css/pigeon-table.css" rel="stylesheet" />

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

  <div class="container-fluid">
    <div class="container">
      <div class="card cardTableBody">
        <div class="card-body cardTableBodies">
            <button type="button" class="btn" id="adminButton" onclick="location.href='couponlist.php'">Edit Coupon</button>
          <br><br>
        <h2 class="listTitle">Coupon Listing</h2>
        <!-- View Data in table form -->
		      <pigeon-table query="SELECT * FROM coupons" editable="false" control="true"></pigeon-table>
        </div>
      </div>
    </div>
  </div>

  <script src="pigeon-table/js/jquery.min.js"></script>
  <script src="pigeon-table/js/bootstrap.min.js"></script>
  <script src="pigeon-table/js/angular.min.js"></script>
  <script src="pigeon-table/js/ui-bootstrap-tpls-2.5.0.min.js"></script>
  <script src='pigeon-table/js/pigeon-table-coupon.js'></script>
</body>
</html>
