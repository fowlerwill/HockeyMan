<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package incite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<!-- OpenGraph & infoschema markup -->
<meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="http://incitepromo.com" />
<meta property="og:image" content="<?= get_template_directory_uri(); ?>/img/logo.png" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<!-- Load Facebook api -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- End Facebook api -->

<header id="masthead" class="site-header" role="banner">
	<div id="headContainer">
		<div class="site-branding">
			<a href="<?= get_site_url(); ?>"><img src="<?= get_template_directory_uri(); ?>/img/logo.png"></a>
		</div>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'incite' ); ?></h1>
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'incite' ); ?>"><?php _e( 'Skip to content', 'incite' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</div>
</header><!-- #masthead -->

<div id="bg"><img src="<?= get_template_directory_uri(); ?>/img/bg.png" alt="Incite Social Promotion" /></div>


<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<div id="content" class="site-content">
