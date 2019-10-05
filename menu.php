<!DOCTYPE html>

<!-- data-ng-app="pigeon-table" in the html is essential to inject ngPigeon-table into the webpage-->
<html lang="en">
<head>
    <title>Menu List</title>
    <meta charset="utf-8"/>
    <meta name="description" content="Modify menu database"/>
    <meta name="author" content="T.W.J"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <!-- Bootstrap -->
    <link href="frameworks/bootstrap.min.css" rel="stylesheet" />
    <!-- Pigeon Table -->
    <link href="frameworks/pigeon-table.css" rel="stylesheet" />
    
	<!-- The includes.php file is required to include all necessary dependencies-->
    <?php
		include "frameworks/php/includes.php"
	?>
    
</head> 

<body>
    <h1>Menu List</h1>
    <div class="container">
        <!-- View Data in table form -->
        <pigeon-table query="SELECT * FROM menu" editable="true" control="true"></pigeon-table>
        
    </div>
    
    <!-- jQuery – required for Bootstrap's JavaScript plugins) -->
    <script src="frameworks/js/jquery.min.js"></script>
    <!-- All Bootstrap plug-ins file -->
    <script src="frameworks/js/bootstrap.min.js"></script>
    <!-- AngularJS -->
    <script src="frameworks/js/angular.min.js"></script>
    <!-- Angular UI Bootstrap -->
    <script src="frameworks/js/ui-bootstrap-tpls-2.5.0.min.js"></script>
    <!-- Pigeon Table -->
    <script src="frameworks/js/pigeon-table.js"></script> 
</body>
</html>

