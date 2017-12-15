<!DOCTYPE html>
<html>

<?php
	ini_set('display_errors', 1);
	require_once(__DIR__ . '/config/config.php');
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
					require_once($GLOBALS['parsedown_path']);
					require_once(__DIR__ . '/src/post_functions.php');

					$most_recent_posts = most_recent_posts();
					$i = 0;
					$len = count($most_recent_posts);
					$pd = new Parsedown(); 
					foreach ($most_recent_posts as $timestamp => $metadata) {
						?> 

						<!-- Date of post -->
						<p class="text-muted">
						<?php
							echo date("m/d/Y - g:i a", $metadata['last_modified']);
						?>
						</p>

						<!-- Post tags -->
						<?php
						echo "<p>";
						foreach ($metadata['tags'] as $tag) {
							echo'<a ' 
								. 'class="rounded text-white bg-secondary" '
								. 'href="/blog/search.php?tags[]=' . str_replace('#', '', $tag) . '" '
								. 'style="text-decoration:none;"'
								. '>'
								. $tag
								. '</a> ';
							}
							echo '</p>' . PHP_EOL;
						?>


						<!-- Post content -->
						<div class="blog-post">
						<?php
							$html = $pd->text(file_get_contents($metadata['path']));
							$html = preg_replace('/<blockquote>/', '<blockquote class="blockquote">', $html);
							echo $html;
						?>
						</div>

						<!-- Dividing line -->
						<?php
						if ($i < $len - 1) {
							?>
							<hr>
							<?php
						}
						$i++;
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