<!DOCTYPE html>
<html lang="en" data-ng-app="tableDispApp">

<head>
    <title>FoodSmith-Table List</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- Bootstrap -->
    <link href="frameworks/css/bootstrap.min.css" rel="stylesheet" />
</head>

<header id="myHeader">
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
<body data-ng-controller="tableControl">
  <div class="container-fluid">
  <div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="card">
        <div class="card-body cardTableBodies">
          <button type="button" class="btn" id="adminButton" onclick="location.href='tablelist.php'">Edit Table</button>
          <br><br>
            <div class="flex-container">

              <div data-ng-repeat="x in table track by $index">

          <span data-ng-if="x.Status=='available'">
            <button type="button" id="tableAvailable" data-ng-click="displayTableStatus($index)" onclick="location.href='createorder.php'">
                Table No:{{x.TableID}} Chairs:{{x.Chairs}}
            </button>
        </span>

        <span data-ng-if="x.Status=='reserved'">
            <button type="button" id="tableReserved" data-ng-click="displayTableStatus($index)" data-toggle="modal" data-target="#reservedModal">
                Table No:{{x.TableID}} Chairs:{{x.Chairs}}
            </button>

        </span>


        <span data-ng-if="x.Status=='occupied'">
            <button type="button" id="tableOccupied" data-ng-click="displayTableStatus($index)" data-toggle="modal" data-target="#orderModal">
                Table No:{{x.TableID}} Chairs:{{x.Chairs}}
            </button>

              </span>
            </div>
  </div>
          </div>
        </div>
      </div>
    </div>
</div>
    <data-order-Info></data-order-Info>
    <data-reserved-Info></data-reserved-Info>

    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <script src="frameworks/js/bootstrap.min.js"></script>
    <script src="frameworks/js/angular.min.js"></script>
    <script src="frameworks/js/angular-route.min.js"></script>
    <script src="frameworks/js/tableDisplayApp.js"></script>
</body>

</html>
