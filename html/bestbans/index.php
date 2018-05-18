<!DOCTYPE html>
<html>
<?php
	ini_set('display_errors', 1);
	require_once(__DIR__ . '/../../config.php');
?>	
<head>
	<!-- required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
		crossorigin="anonymous">
	<!-- Other -->
	<title>Best Bans</title>
</head>

<body>
	<?php
		include($GLOBALS['site_root'] . '/menu.php');
	?>

	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-md">
					<h1 class="display-2"> Best Bans </h1>
				</div>
			</div>
			<div class="row">
				<div class="col-md">
					<p class="lead">A basic reimplementation of 
					<a href="http://bestbans.com">bestbans.com</a>,
					which has been out of service since January 2017</p>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row justify-content-md-left align-items-center">
			<div class="col-md-6">
				<h2 class="display-4">
					Patch 8.10
					<!-- TODO: dynamically load this -->
				</h2>
				<div class="row justify-content-md-left align-items-center">
					<div class="col-md-6">
						<p>haha</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<img src="/img/code_crop.jpg" alt="" class="img-fluid">
			</div>
		</div>
	</div>


	<?php
		include($GLOBALS['site_root'] . '/footer.php');
	?>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
		crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
		crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
		crossorigin="anonymous"></script>
</body>
</html>