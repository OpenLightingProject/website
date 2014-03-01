<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header Template
 *
 *
 * @file           header.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.3
 * @filesource     wp-content/themes/responsive/header.php
 * @link           http://codex.wordpress.org/Theme_Development#Document_Head_.28header.php.29
 * @since          available since Release 1.0
 */
?>
	<!doctype html>
	<!--[if !IE]>
	<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 7 ]>
	<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 8 ]>
	<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
	<!--[if IE 9 ]>
	<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
	<!--[if gt IE 9]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title><?php wp_title( '&#124;', true, 'right' ); ?></title>

		<link rel="profile" href="http://gmpg.org/xfn/11"/>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

		<?php wp_head(); ?>
	</head>

<body <?php body_class(); ?>>

<?php responsive_container(); // before container hook ?>
<div id="container" class="hfeed">

<?php responsive_header(); // before header hook ?>
	<div id="header">

		<?php responsive_header_top(); // before header content hook ?>

		<?php if( has_nav_menu( 'top-menu', 'responsive' ) ) { ?>
			<?php wp_nav_menu( array(
								   'container'      => '',
								   'fallback_cb'    => false,
								   'menu_class'     => 'top-menu',
								   'theme_location' => 'top-menu'
							   )
			);
			?>
		<?php } ?>

		<?php responsive_in_header(); // header hook ?>

		<?php if( get_header_image() != '' ) : ?>
  
  <?php  $openlighting_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; 
	 if (false !== strpos($openlighting_url,'ola/')) {
    $openlighting_header_image = 'http://www.openlighting.org/wp-content/uploads/2014/03/72px_OLA-Logo.png';
	} elseif (false !== strpos($openlighting_url,'libartnet-main/')) {
    $openlighting_header_image = 'http://www.openlighting.org/wp-content/uploads/2014/03/72px_libartnetlogo.png';
  } elseif (false !== strpos($openlighting_url,'rdm-tools/')) {
    $openlighting_header_image = 'http://www.openlighting.org/wp-content/uploads/2014/03/72px_dmx-rdm.png';
  } else { $openlighting_header_image = 'http://www.openlighting.org/wp-content/uploads/2014/03/72px_openlightingprojectlogo.png';
         }

?>
  
  

			<div id="logo">
				<a href="<?php echo home_url( '/' ); ?>"><img height="68px" src="<?php echo $openlighting_header_image ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
        
			</div><!-- end of #logo -->

		<?php endif; // header image was removed ?>

		<?php if( !get_header_image() ) : ?>

			<div id="logo">
				<span class="site-name"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
				<span class="site-description"><?php bloginfo( 'description' ); ?></span>
			</div><!-- end of #logo -->

		<?php endif; // header image was removed (again) ?>

		<?php get_sidebar( 'top' ); ?>

<!--
This is where the per-page menus happen. Each page/post you would like to have a custom menu must have a custom field added, with the name 'MenuName', and value of the desired menu's name.
-->
		<?php wp_nav_menu( array(
							   'container'       => 'div',
							   'container_class' => 'main-nav',
							   'fallback_cb'     => 'responsive_fallback_menu',
							   'theme_location'  => 'header-menu',
						           'menu' => get_post_meta( $post->ID, 'MenuName', true)
						   )
		);
		?>

		<?php if( has_nav_menu( 'sub-header-menu', 'responsive' ) ) { ?>
			<?php wp_nav_menu( array(
								   'container'      => '',
								   'menu_class'     => 'sub-header-menu',
								   'theme_location' => 'sub-header-menu'
							   )
			);
			?>
		<?php } ?>

		<?php responsive_header_bottom(); // after header content hook ?>

	</div><!-- end of #header -->
<?php responsive_header_end(); // after header container hook ?>

<?php responsive_wrapper(); // before wrapper container hook ?>
	<div id="wrapper" class="clearfix">
<?php responsive_wrapper_top(); // before wrapper content hook ?>
<?php responsive_in_wrapper(); // wrapper hook ?>
