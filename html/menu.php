<?php

$pages = array(
    '/'         => 'Home',
    '/projects' => 'Projects',
    '/hobbies'  => 'Hobbies',
    '/about'    => 'About',
    '/blog'     => 'Blog',
) ;

$currentPage = basename($_SERVER['REQUEST_URI']);
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Devin Gunay</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php foreach ($pages as $filename => $pageTitle) { 
                    if ($filename == '/' . $currentPage) { 
                ?>
                <li class="nav-item active">
                    <?php } else { ?>
                <li class="nav-item">
                <?php } ?>
                <a class="nav-link" href="<?php echo $filename;?>">
                <?php echo $pageTitle ; ?></a>
                </li>
                    <?php }?>
            </ul>
            <small class="text-muted">Site under construction</small>
	    <!--
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
	    -->
        </div>
    </nav>

