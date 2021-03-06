<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
            <meta name="theme-color" content="#121212">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

		<header class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

			<div id="inner-header" class="cf astralBanner">
				<a href="#/home"><img class="astralLogo" src="<?php echo get_template_directory_uri(); ?>/library/images/astralStudio.png"/></a>
				<a href="mailto:info@astral-studio.com"><img class="mail" src="<?php echo get_template_directory_uri(); ?>/library/images/mail.png"/></a>
			</div>

			<nav id="nav" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<ul class="menu row list-unstyled">
					<li class="col-xs-6 menuItem">
						<a href="#/home/work">
							Work
						</a>
					</li>
					<li class="col-xs-6 menuItem">
						<a href="#/home/about">
							About
						</a>
					</li>
				</ul>
			</nav>

			<div class="topAnchor" style="display: none;">
				<span>Back to top</span>
			</div>

		</header>
