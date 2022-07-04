<?php

/**
 * Button template.
 *
 * @see Theme Settings -> Header.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

$button_text = carbon_get_theme_option( 'header_button_text' );

if( ! $button_text ) return;
?>

<div class="header-button">
	<button class="button lg rounded violet">
		<?php printf( esc_html__( '%s', 'bydlokod' ), $button_text ) ?>
	</button>
</div>

