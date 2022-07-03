<?php

/**
 * Header default template.
 *
 * @see Options -> Header.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

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
		global $page, $paged;

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
					get_template_part( 'includes/common/header/menu' );
					?>
				</div>
			</div>
		</header>

