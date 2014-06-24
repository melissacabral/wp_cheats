<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="A description about your site" />
	<title><?php bloginfo( 'name' ) ?> - <?php bloginfo( 'description' ); ?></title>
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/css/normalize.css" media="screen" />
	
	<?php wp_head();  //HOOK. necessary for plugins and admin bar to work ?>
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" />

<!--[if IE]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body <?php body_class( ); ?>>
	<div class="page-wrap">
	<header role="banner">
		<?php get_search_form();  //includes searchform.php if it exists ?>	
		<h1 class="site-name"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?></a></h1>
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		
		<?php    
		$args = array(
			'theme_location' => 'top_menu',
			'container' => 'nav',
			'fallback_cb' => '',
			);		
			wp_nav_menu( $args ); ?>

</header>