<!DOCTYPE html>

<!-- data-ng-app="pigeon-table" in the html is essential to inject ngPigeon-table into the webpage-->
<html lang="en" data-ng-app="pigeon-table">
<head>
    <title>Order List</title>
    <meta charset="utf-8"/>
    <meta name="description" content="Modify accounts database"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <!-- Bootstrap -->
    <link href="pigeon-table/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Pigeon Table -->
    <link href="pigeon-table/css/pigeon-table.css" rel="stylesheet" />
    
	<!-- The includes.php file is required to include all necessary dependencies-->
    <?php
		include "pigeon-table/php/includes.php"
	?>
    
</head> 

<body>
    <h1>Order List</h1>
    <div class="container">
        <pigeon-table query="SELECT * FROM account" editable="true" control="true"></pigeon-table>
    </div>
    <script src="pigeon-table/js/jquery.min.js"></script>
    <script src="pigeon-table/js/bootstrap.min.js"></script>
    <script src="pigeon-table/js/angular.min.js"></script>
    <script src="pigeon-table/js/ui-bootstrap-tpls-2.5.0.min.js"></script>
    <script src="pigeon-table/js/pigeon-table2.js"></script> 
</body>
</html>

