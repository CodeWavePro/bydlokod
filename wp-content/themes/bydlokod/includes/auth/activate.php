<?php

/**
 * Activation form template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

$legend		= $args['legend'] ?? 'Активация';
$user_id	= $args['user_id'] ?? null;
?>

<form class="form form-activate">
	<fieldset>
		<legend><?php printf( esc_html__( '%s', 'bydlokod' ), $legend ) ?></legend>

		<label for="code" class="label-focus">
			<input id="code" type="text" name="code" placeholder="<?php esc_attr_e( 'Код активации из письма *', 'bydlokod' ) ?>" />
		</label>

		<?php if( $user_id ) echo '<input type="hidden" name="user" value="' . esc_attr( $user_id ) . '" />' ?>

		<div class="form-message"></div>

		<div class="form-submit">
			<button class="button lg rounded violet" type="submit">
				<?php esc_html_e( 'Подтвердить', 'bydlokod' ) ?>
			</button>
		</div>

		<?php wp_nonce_field( 'bydlo_ajax_activate', 'bydlo_activate_nonce' ) ?>
	</fieldset>

	<div class="form-links">
		<a href="#" class="form-link send-activation">
			<?php esc_html_e( 'Отправить код ещё раз', 'bydlokod' ) ?>
			<span></span>
		</a>
	</div>
</form>

