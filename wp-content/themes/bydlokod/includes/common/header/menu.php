<?php

/**
 * Menu template.
 *
 * @see Appearance -> Menus -> Header Menu.
 *
 * @package WordPress
 * @subpackage bydlokod
 */
?>

<div class="header-mobile-button">
	<div></div>
	<div></div>
	<div></div>
</div>

<div id="header-nav-wrapper" class="header-nav-wrapper">
	<?php
	wp_nav_menu(
		[
			'theme_location'	=> 'header_menu',
			'container'			=> 'nav',
			'container_class'	=> 'header-nav'
		]
	);
	?>
</div>

