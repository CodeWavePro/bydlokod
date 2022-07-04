<?php

/**
 * Header default template.
 *
 * @see Options -> Header.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

global $page, $paged;
// Theme URI for favicon and etc.
$uri = get_template_directory_uri();
?>

<!doctype html>
<html <?php language_attributes() ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta content="" name="description" />
	<meta content="" name="keywords" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="HandheldFriendly" content="true" />

	<title>
		<?php
		wp_title( '|', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );

		if( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		if( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'bydlokod' ), max( $paged, $page ) );
		?>
	</title>

	<!-- FAVICON -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $uri ?>/favicon/apple-touch-icon.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $uri ?>/favicon/favicon-32x32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $uri ?>/favicon/favicon-16x16.png" />
	<link rel="manifest" href="<?php echo $uri ?>/favicon/site.webmanifest" />
	<link rel="mask-icon" href="<?php echo $uri ?>/favicon/safari-pinned-tab.svg" color="#5bbad5" />
	<meta name="msapplication-TileColor" content="#da532c" />
	<meta name="theme-color" content="#ffffff" />
	<!-- /FAVICON -->

	<?php wp_head() ?>
</head>

<body <?php body_class() ?>>
	<?php wp_body_open() ?>

	<div class="wrapper">
		<header class="header">
			<div class="container">
				<div class="header-inner">
					<?php
					get_template_part( 'includes/common/header/logo' );
					get_template_part( 'includes/common/header/search' );
					get_template_part( 'includes/common/header/menu' );
					get_template_part( 'includes/common/header/button' );
					get_template_part( 'includes/common/header/auth' );
					?>
				</div>
			</div>
		</header>

