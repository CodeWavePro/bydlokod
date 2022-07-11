<?php

/**
 * Registration form template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */
?>

<form class="form form-register">
	<fieldset>
		<legend><?php esc_html_e( 'Регистрация', 'bydlokod' ) ?></legend>

		<label for="login" class="label-focus">
			<input id="login" type="text" name="login" placeholder="<?php esc_attr_e( 'Логин / почта', 'bydlokod' ) ?>" />
		</label>
		<label for="pass1" class="label-focus">
			<input id="pass1" type="text" name="pass1" placeholder="<?php esc_attr_e( 'Пароль', 'bydlokod' ) ?>" />
		</label>
		<label for="pass2" class="label-focus">
			<input id="pass2" type="text" name="pass2" placeholder="<?php esc_attr_e( 'Повторите пароль', 'bydlokod' ) ?>" />
		</label>

		<div class="form-submit">
			<button class="button lg rounded violet" type="submit">
				<?php esc_html_e( 'Зарегистрироваться', 'bydlokod' ) ?>
			</button>
		</div>

		<?php wp_nonce_field( 'bydlo_ajax_register', 'bydlo_register_nonce' ) ?>
	</fieldset>
</form>

