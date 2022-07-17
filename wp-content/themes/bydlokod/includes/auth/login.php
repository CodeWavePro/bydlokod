<?php

/**
 * Login form template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */
?>

<form class="form form-login">
	<fieldset>
		<legend><?php esc_html_e( 'Вход', 'bydlokod' ) ?></legend>

		<label for="login" class="label-focus">
			<input id="login" type="text" name="login" placeholder="<?php esc_attr_e( 'Логин / почта *', 'bydlokod' ) ?>" />
		</label>
		<label for="pass" class="label-focus label-for-pass">
			<input id="pass" type="password" name="pass" placeholder="<?php esc_attr_e( 'Пароль *', 'bydlokod' ) ?>" />
			<span class="toggle-pass">
				<i class="fa-solid fa-eye show-pass" title="<?php esc_attr_e( 'Показать пароль', 'bydlokod' ) ?>"></i>
				<i class="fa-solid fa-eye-slash hide-pass hidden" title="<?php esc_attr_e( 'Скрыть пароль', 'bydlokod' ) ?>"></i>
			</span>
		</label>
		<input id="remember-me" type="checkbox" name="remember-me" />
		<label for="remember-me" class="label-for-checkbox">
			<span class="label-text">
				<?php esc_html_e( 'Запомнить меня', 'bydlokod' ) ?>
			</span>
		</label>

		<div class="form-message"></div>

		<div class="form-submit">
			<button class="button lg rounded violet" type="submit">
				<?php esc_html_e( 'Войти', 'bydlokod' ) ?>
			</button>
		</div>

		<?php wp_nonce_field( 'bydlo_ajax_login', 'bydlo_login_nonce' ) ?>
	</fieldset>

	<div class="form-links">
		<a href="#" class="form-link register">
			<?php esc_html_e( 'Регистрация', 'bydlokod' ) ?>
		</a>
		<span>|</span>
		<a href="#" class="form-link lost-pass">
			<?php esc_html_e( 'Я посеял пароль', 'bydlokod' ) ?>
		</a>
	</div>
</form>

