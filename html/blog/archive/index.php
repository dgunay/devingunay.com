<?php
	$year_and_month_set = isset($_GET['m']) && isset($_GET['y']); 
	if ($year_and_month_set) {
		$year_and_month_valid = is_numeric($_GET['m']) && is_numeric($_GET['y']);
		if (!$year_and_month_valid) { // redirect in case of bullshit
			header('Location: http://devingunay.com/blog/archive');
		}
	}
?>

<!DOCTYPE html>
<html>

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
		include('/var/www/html/menu.php');
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
        <ul>
				<?php
					require_once('/var/www/html/blog/post_functions.php');

					$archive = json_decode(
						file_get_contents('/var/www/html/blog/archive.json'), 
						true
					);
					
					if ($year_and_month_set) { // Just posts for a certain month
						$year = $_GET['y'];
						$month = date("F", mktime(0, 0, 0, $_GET['m'], 10));
	
						echo "<h3>{$month} {$year}</h3>";
						foreach ($archive[$year][$month] as $post) {
							echo '<li><a href="/blog/post.php?t=' . $post['last_modified'] . '">'
								. $post['title']
								. '</a></li>' . PHP_EOL;
						}
					}
					else { // Entire archive
						echo '<h1>Archive</h1><hr>';
						foreach($archive as $year => $months) {
							echo '<h3>' . $year . '</h3>';
							foreach ($months as $month => $posts) {
								echo '<h5><a href="/blog/archive?m='.date('m', strtotime($month)).'&y='.$year.'">' 
								. $month . ' (' . count($archive[$year][$month]) . ')'
								. '</a></h5>' . PHP_EOL;
							}
						}
					}
        ?>
        </ul>
			</div>

			<!-- Side bar -->
			<div class="col-sm-3">
			<?php
				include('/var/www/html/blog/side_bar.php');
			?>
		</div>
	</div>

	<?php
		include('/var/www/html/footer.php');
	?>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
				crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
				crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
				crossorigin="anonymous"></script>
</body>

</html>