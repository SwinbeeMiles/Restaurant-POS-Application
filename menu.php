<!DOCTYPE html>

<!-- data-ng-app="pigeon-table" in the html is essential to inject ngPigeon-table into the webpage-->
<html lang="en">
<head>
    <title>Example</title>
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
    
    <div class="container">
        <!-- View Data in table form -->
        <pigeon-table query="SELECT * FROM account" editable="true" control="true"></pigeon-table>
        
    </div>
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="pigeon-table/js/jquery.min.js"></script>
    <!-- All Bootstrap plug-ins file -->
    <script src="pigeon-table/js/bootstrap.min.js"></script>
    <!-- AngularJS -->
    <script src="pigeon-table/js/angular.min.js"></script>
    <!-- Angular UI Bootstrap -->
    <script src="pigeon-table/js/ui-bootstrap-tpls-2.5.0.min.js"></script>
    <!-- Pigeon Table -->
    <script src="pigeon-table/js/pigeon-table.js"></script> 
</body>
</html>

