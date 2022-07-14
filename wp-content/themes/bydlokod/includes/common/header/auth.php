<?php

/**
 * Authorization links template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */
?>

<div class="header-auth">
	<?php
	if( ! is_user_logged_in() ){
		?>
		<a class="header-auth-link login" href="#">
			<?php esc_html_e( 'Вход', 'bydlokod' ) ?>
		</a>
		<a class="header-auth-link register" href="#">
			<?php esc_html_e( 'Регистрация', 'bydlokod' ) ?>
		</a>
		<?php
	}	else {
		?>
		<a class="header-logout-link" href="#">
			<?php esc_html_e( 'Выйти', 'bydlokod' ) ?>
		</a>
		<?php
	}
	?>
</div>

