
<?php
	session_start();
	if(!isset($_SESSION['userid'])){
		header("Location: index.php");		
	}

	include_once "connectdb.php";
	
	$query="SELECT itemlist FROM purchases WHERE userid=".$_SESSION['userid'];
	$result= mysqli_query($con, $query);
	
	if($result){
		$technology=0;
		$personal=0;
		$entertainment=0;
		$groceries=0;


		$purchases = [];
		while ($col = $result->fetch_array(MYSQLI_NUM)){

			array_push($purchases, $col[0]);
		}
		$result->close();
		
		for ($i=0; $i<sizeof($purchases); $i++){
			 
			$itemlist= explode(" ", $purchases[$i]);

			for ($j=0; $j<sizeof($itemlist);$j++){
				$query2= "SELECT * FROM items WHERE id=".$itemlist[$j]."";
	
				$itemresult= mysqli_query($con, $query2);
				$itemrow=mysqli_fetch_array($itemresult);


				if (strcmp($itemrow['category'], 'technology')==0){
					$technology+=$itemrow['price'];
				}
				if (strcmp($itemrow['category'], 'personal')==0){
					$personal+=$itemrow['price'];
				}
				if (strcmp($itemrow['category'], 'entertainment')==0){
					$entertainment+=$itemrow['price'];
				}
				if (strcmp($itemrow['category'], 'groceries')==0){
					$groceries+=$itemrow['price'];
				}	
			}
		}
		$totalexpense = $technology+ $personal +$entertainment + $groceries;
	
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<title>Wallet | iExpense</title>
			<meta content = "width = device.width , initial-scale = 1.0" name = "viewport">
			<link rel = "stylesheet" href = "vendor/font-awesome/css/font-awesome.min.css"/>
	        <link rel = "stylesheet" href = "vendor/bootstrap/css/bootstrap.min.css" type="text/css"/>
	        <link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.carousel.css" type="text/css"/>
	        <link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.theme.css" type="text/css"/>
	        <link rel = "stylesheet" href = "vendor/owl-carousel/css/owl.transitions.css" type="text/css"/>
	        <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet"/> 
	        <link rel = "stylesheet" href = "css/main.css" type = "text/css"/>
	</head>
	<body>
		<nav class = "navbar navbar-default" role = "navigation">
            <div class = "container-fluid">
                <div class= " navbar-header">
                    <button type = "button" class = "navbar-toggle" data-toggle ="collapse" data-target = "#navbar">
                        <span class ="sr-only"> navigation </span>
                        <span class ="icon-bar"></span>
                        <span class = "icon-bar"></span>
                        <span class = "icon-bar"></span>
                    </button>
                    <a class = "navbar-brand" href= "index.php">
                        iExpense
                    </a>
                </div>

                <div class = "collapse navbar-collapse" id = "navbar">
                    <ul class = "nav navbar-nav navbar-right">
						<li>
							<a href = "purchases.php">Purchases</a>
						</li>
						<li>
							<a href = "employeeprofile.php">Employee profile</a>
						</li>
						<li>
							<a href = "transactions.php">Transactions</a>
						</li>
						<li>
							<a href = "wallet.php" class = "active">Wallet</a>
						</li>
                        <li>
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        		<i class="icon-user" aria-hidden="true"></i>
                         		 <?php echo $_SESSION['username'];?>
                         		<span class="caret"></span>
                         	</a>
							<ul class="dropdown-menu">
								<li>
									<a href="logout.php">
										<span class = "glyphicon glyphicon-log-out"></span>
										 Logout
									</a>
								</li>
							</ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

          <div class = "container">
          	<div class = "row">
          		<h2 class = "text-center page-header">Your wallet</h2>
          	</div>
        	<div class = "row">
        		

        		<div class = "col-md-5 col-md-offset-1">
    				<table class = "table table-hover">
    					<thead>
    						<tr><th class = "text-center">Your money spent per category</th></tr>
    						<tr>
    							<th>Category</th>
    							<th>Amount</th>
    						</tr>
    					</thead>
    					<tbody>
    						<tr>
    							<td>Technology</td>
    							<td><?php echo $technology;?></td>
    						</tr>
    						<tr>
    							<td>Personal </td>
    							<td><?php echo $personal;?></td>
    						</tr>
    						<tr>
    							<td>Entertainment</td>
    							<td><?php echo $entertainment;?></td>
    						</tr>
    						<tr>
    							<td>Groceries</td>
    							<td><?php echo $groceries;?></td>

	    					</tr>

        				</tbody>
        			</table>
        		</div>
        		<div class = "col-md-5">

        			<div id = "wallet-chart"> </div>

        		</div>

        	</div>

        	
        </div>

		<script src = "vendor/jquery/jquery-3.1.0.min.js"></script>
		<script src = "vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src = "vendor/owl-carousel/js/owl.carousel.min.js"></script>
		<script src = "js/main.js"></script>
		<script type="text/javascript" src="js/canvasjs.min.js"></script>
		<script src="js/walletchart.js"></script>
		<script>
			$('.owl-carousel').owlCarousel({
				loop: true,
				items: 4
			});
		</script>
	</body>
</html>