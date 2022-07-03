<?php

/**
 * Logo template.
 *
 * @see Theme Settings -> Header.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

$header_logo = carbon_get_theme_option( 'header_logo' );

if( ! $header_logo ) return;
?>

<div class="header-logo">
	<a href="<?php echo home_url( '/' ) ?>" title="<?php esc_attr_e( 'На Главную', 'bydlokod' ) ?>">
		<?php echo wp_get_attachment_image( $header_logo, 'full', false, ['loading' => 'eager'] ) ?>
	</a>
</div>

