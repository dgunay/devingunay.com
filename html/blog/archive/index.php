<!DOCTYPE html>
<html>

<?php
	ini_set('display_errors', 1);
  require_once(__DIR__ . '/../config/config.php');  
  require_once($GLOBALS['blog_root'] . '/src/post_functions.php');

	$params = array(
		'y'	=> isset($_GET['y']),
		'm'	=> isset($_GET['m']),
	);

	foreach ($params as $param => $isset) {
		if ($isset && !is_numeric($_GET[$param])) {
			header("Location: http://{$_SERVER['HTTP_HOST']}/blog");			
		}
	}
?>
<head>
	<!-- required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M"
		crossorigin="anonymous">

	<style>
		blockquote {
			border-left: 5px solid #ccc;
			background: #f9f9f9;
		}
		blockquote > p {
			margin: 1.5em 10px; 
			padding: 10px; 
		}
	</style>

	<!-- Other -->
	<title>Devin Gunay</title>
</head>

<body>
	<?php
		include($GLOBALS['site_root'] . '/menu.php');
	?>

	<!-- Top row -->
	<div class="container" style="margin-bottom: 40px;margin-top: 40px;">
		<h1 class="display-3">Devin's Blog</h1>
	</div>

	<!-- Main -->
	<div class="container">
		<div class="row">
			<!-- Content -->
			<div class="col-sm-8">
				<?php
					$archive = get_archive_by_year();
					
					if (isset($_GET['y'])) {
						$year = $_GET['y'];
						if (isset($_GET['m'])) { 
							// display all posts in a month
							$month = $_GET['m'];
							$month_text = date("F", mktime(0, 0, 0, $month, 10));
							
							echo "<h3>" . $month_text . " {$year}</h3>";
							foreach ($archive[$year][$month] as $post) {
								echo '<li><a href="/blog/post.php?t=' . $post['last_modified'] . '">'
									. $post['title']
									. '</a></li>' . PHP_EOL;
							}
						}
						else {
							// display months in a year with how many posts they have
							echo '<h3>' . $year . '</h3>';
							foreach ($archive[$year] as $month => $posts) {
								echo '<h5><a href="/blog/archive?m=' . $month .'&y=' . $year . '">' 
									. date("F", mktime(0, 0, 0, $month, 10)) . ' (' . count($archive[$year][$month]) . ')'
									. '</a></h5>' . PHP_EOL;
							}
						}	
					}					
					else {
						// Entire blog
						echo '<h1>Archive</h1><hr>';
						foreach($archive as $year => $months) {
							echo '<h3>' . $year . '</h3>';
							foreach ($months as $month => $posts) {
								echo '<h5><a href="/blog/archive?m=' . $month .'&y=' . $year . '">' 
									. date("F", mktime(0, 0, 0, $month, 10)) . ' (' . count($archive[$year][$month]) . ')'
									. '</a></h5>' . PHP_EOL;
							}
						}
					}
				?>
			</div>
			
			<!-- Side bar -->
			<div class="col-sm-3">
				<?php
					include($GLOBALS['blog_root'] . '/side_bar.php');
				?>
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