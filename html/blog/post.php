<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	if (!isset($_GET['t']) || !is_numeric($_GET['t'])) {
		header('Location: http://devingunay.com/blog');
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
		<h1 class="display-3">
			<a style="text-decoration:none; color:#000;" href="/blog">Devin's Blog</a>
		</h1>
	</div>

	<!-- Main -->
	<div class="container">
		<div class="row">
			<!-- Blog Post -->
			<div class="col-sm-8">
				<div class="blog-post">
					<p class="text-muted">
					<?php
					// unix to datetime
					if (isset($_GET['t'])) {
						echo date("m/d/Y - g:i a", $_GET['t']);
					}
					?>
					</p>
					<p>
					<?php
						if (isset($_GET['t'])) {
							require_once('/var/www/Parsedown.php');
							require_once(__DIR__ . '/post_functions.php');
							$archive = load_archive();
							if (isset($archive[$_GET['t']])) {
								$post = $archive[$_GET['t']];

								// echo post tags with links to search
								echo "<p>";
								foreach ($post['tags'] as $tag) {
									echo '<a ' 
										. 'class="rounded text-white bg-secondary" '
										. 'href="/blog/search.php?tags[]=' . str_replace('#', '', $tag) . '" '
										. 'style="text-decoration:none;"'
										. '>'
										. $tag
										. '</a> ';
								}
								echo '</p>' . PHP_EOL;

								// parse post Markdown to HTML
								$pd = new Parsedown(); 
								$html = $pd->text(file_get_contents($archive[$_GET['t']]['path']));

								// extra styling
								$html = preg_replace(
									'/<blockquote>/', 
									'<blockquote class="blockquote">', 
									$html
								);

								// output
								echo $html;					
								
								// grab for later use
								// prev / next page
								$archive = array_values($archive);
								$index_of_post = array_search($post, $archive);
								if (isset($archive[$index_of_post - 1])) {
									$next_link = generate_link_to_post(
										$archive[$index_of_post - 1], 
										'Next'
									);
								}
								if (isset($archive[$index_of_post + 1])) {
									$prev_link = generate_link_to_post(
										$archive[$index_of_post + 1], 
										'Previous'
									);
								}
							}
							else {
								?>
								<h1>Post Not Found</h1>
								<p>Sorry, the post you were looking for could not be found.</p>
								<?php
								$posts_close_to_time = array_filter($archive, function($timestamp) {
										return abs($timestamp - $_GET['t']) < 259200;
									}, ARRAY_FILTER_USE_KEY
								);

								if (!empty($posts_close_to_time)) {

									?>
									<p>Were you perhaps looking for posts at these times?:</p>
									<ul>
									<?php
									foreach ($posts_close_to_time as $post) {
										echo '<li><a href="/blog/post.php?t=' . $post['last_modified'] . '">'
											. date("m-d-Y - g:i a", $post['last_modified'])
											. '</a></li>' . PHP_EOL;
									}
									?></ul><?php
								}
							}
						}
					?>
					</p>
					<hr>
				</div>
			</div>
			<!-- Side bar -->
			<div class="col-sm-3">
				<?php
					include('/var/www/html/blog/side_bar.php');
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
			<?php echo (isset($prev_link) ? $prev_link : ''); ?>	
			</div>
			<div class="col-sm-4 text-right">
			<?php echo (isset($next_link) ? $next_link : '');?>				
			</div>
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