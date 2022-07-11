<?php

/**
 * Authorization AJAX functions.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

add_action( 'wp_ajax_bydlo_ajax_show_auth_form', 'bydlo_ajax_show_auth_form' );
add_action( 'wp_ajax_nopriv_bydlo_ajax_show_auth_form', 'bydlo_ajax_show_auth_form' );
/**
 * Show Login or Register form.
 */
function bydlo_ajax_show_auth_form(){
	$type	= isset( $_POST['type'] ) ? bydlo_clean( $_POST['type'] ) : 'login';
	$form	= bydlo_get_template_part( 'includes/auth/' . $type );

	wp_send_json_success( [
		'msg'	=> esc_html__( 'Форма успешно загружена.', 'bydlokod' ),
		'form'	=> $form
	] );
}

add_action( 'wp_ajax_nopriv_bydlo_ajax_login', 'bydlo_ajax_login' );
/**
 * Login.
 */
function bydlo_ajax_login(){
	if( empty( $_POST ) || ! wp_verify_nonce( $_POST['bydlo_login_nonce'], 'bydlo_ajax_login' ) )
		wp_send_json_error( ['msg' => esc_html__( 'Неверные данные.', 'bydlokod' )] );

	$login		= bydlo_clean( $_POST['login'] );
	$pass		= bydlo_clean_pass( $_POST['pass'] );
	$remember	= bydlo_clean( $_POST['remember-me'] ) ? true : false;

	// If data is not set - send error.
	if( ! $login || ! $pass )
		wp_send_json_error( ['msg' => esc_html__( 'Неверные данные.2', 'bydlokod' )] );

	// If can't find such login or email - user not exists, send error.
	if( ! username_exists( $login ) && ! email_exists( $login ) )
		wp_send_json_error( ['msg' => esc_html__( 'Такой Пользователь не существует.', 'bydlokod' )] );

	// First - trying to find user by login field.
	$user = get_user_by( 'login', $login );

	// If not success - trying to find user by email field.
	if( ! $user ){
		$user = get_user_by( 'email', $login );

		// If fail again - user not found, send error.
		if( ! $user )
			wp_send_json_error( ['msg' => esc_html__( 'Ошибка во время получения данных Пользователя.', 'bydlokod' )] );
	}

	// Get user ID for user data.
	$user_id = $user->ID;

	// If User have not activated accout yet - send error.
	if( get_user_meta( $user_id, 'has_to_be_activated', true ) != false )
		wp_send_json_error( ['msg' => esc_html__( 'Аккаунт не активирован. Пожалуйста, проверьте указанную при создании Вашего аккаунта почту на предмет письма со ссылкой на активацию. Если письма нет во "Входящих" - не забудьте проверить также "Спам".', 'bydlokod' )] );

	$user_data	= get_userdata( $user_id )->data;
	$hash		= $user_data->user_pass;

	// If passwords are not equal - send error.
	if( ! wp_check_password( $pass, $hash, $user_id ) )
		wp_send_json_error( ['msg' => esc_html__( 'Неверный пароль. ', 'bydlokod' )] );

	// If all is OK - trying to sign user on.
	$creds = [
		'user_login'	=> $login,
		'user_password'	=> $pass,
		'remember'		=> $remember
	];
	$signon = wp_signon( $creds, false );

	// If there is error during signon - send it.
	if( is_wp_error( $signon ) )
		wp_send_json_error( ['msg' => $signon->get_error_message()] );

	wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id, $remember );
	$redirect = home_url( '/' );

	wp_send_json_success( [
		'msg'		=> "Привет, $login!",
		'redirect'	=> $redirect
	] );
}

