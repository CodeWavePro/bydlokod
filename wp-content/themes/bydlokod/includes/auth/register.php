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

		<label for="firstname" class="label-focus">
			<input id="firstname" type="text" name="firstname" placeholder="<?php esc_attr_e( 'Имя *', 'bydlokod' ) ?>" />
		</label>
		<label for="lastname" class="label-focus">
			<input id="lastname" type="text" name="lastname" placeholder="<?php esc_attr_e( 'Фамилия', 'bydlokod' ) ?>" />
		</label>
		<label for="email" class="label-focus">
			<input id="email" type="text" name="email" placeholder="<?php esc_attr_e( 'Почта *', 'bydlokod' ) ?>" />
		</label>
		<label for="login" class="label-focus">
			<input id="login" type="text" name="login" placeholder="<?php esc_attr_e( 'Логин *', 'bydlokod' ) ?>" />
		</label>
		<label for="pass1" class="label-focus">
			<input id="pass1" type="text" name="pass1" placeholder="<?php esc_attr_e( 'Пароль *', 'bydlokod' ) ?>" />
		</label>
		<label for="pass2" class="label-focus">
			<input id="pass2" type="text" name="pass2" placeholder="<?php esc_attr_e( 'Повторите пароль *', 'bydlokod' ) ?>" />
		</label>

		<div class="form-message"></div>

		<div class="form-submit">
			<button class="button lg rounded violet" type="submit">
				<?php esc_html_e( 'Зарегистрироваться', 'bydlokod' ) ?>
			</button>
		</div>

		<?php wp_nonce_field( 'bydlo_ajax_register', 'bydlo_register_nonce' ) ?>
	</fieldset>

	<div class="form-links">
		<a href="#" class="form-link login">
			<?php esc_html_e( 'Вход', 'bydlokod' ) ?>
		</a>
		<span>|</span>
		<a href="#" class="form-link lost-pass">
			<?php esc_html_e( 'Я посеял пароль', 'bydlokod' ) ?>
		</a>
	</div>
</form>

