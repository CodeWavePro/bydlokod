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
		wp_send_json_error( ['msg' => __( '<b>Ошибка:</b> Неверные данные.', 'bydlokod' )] );

	$login		= bydlo_clean( $_POST['login'] );
	$pass		= bydlo_clean_pass( $_POST['pass'] );
	$remember	= bydlo_clean( $_POST['remember-me'] ) ? true : false;
	$errors		= [];

	// If data is not set - add errors.
	if( ! $login || ! $pass ){
		if( ! $login ) $errors[] = 'login';

		if( ! $pass ) $errors[] = 'pass';

		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Неверные данные.', 'bydlokod' ),
			'errors'	=> json_encode( $errors )
		] );
	}

	// If can't find such login or email - user not exists, send error.
	if( ! username_exists( $login ) && ! email_exists( $login ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Такой Пользователь не существует.', 'bydlokod' ),
			'errors'	=> json_encode( ['login'] )
		] );

	// First - trying to find user by login field.
	$user = get_user_by( 'login', $login );

	// If not success - trying to find user by email field.
	if( ! $user ){
		$user = get_user_by( 'email', $login );

		// If fail again - user not found, send error.
		if( ! $user )
			wp_send_json_error( [
				'msg'		=> __( '<b>Ошибка:</b> Не удалось получить данные Пользователя.', 'bydlokod' ),
				'errors'	=> json_encode( ['login'] )
			] );
	}

	// Get user ID for user data.
	$user_id = $user->ID;

	// If User have not activated accout yet - send error.
	if( get_user_meta( $user_id, 'has_to_be_activated', true ) != false )
		wp_send_json_error( ['msg' => __( '<b>Ошибка:</b> Аккаунт не активирован. Пожалуйста, проверьте указанную при создании Вашего аккаунта почту на предмет письма со ссылкой на активацию. Если письма нет во "Входящих" - не забудьте проверить также "Спам".', 'bydlokod' )] );

	$user_data	= get_userdata( $user_id )->data;
	$hash		= $user_data->user_pass;

	// If passwords are not equal - send error.
	if( ! wp_check_password( $pass, $hash, $user_id ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Неверный пароль. ', 'bydlokod' ),
			'errors'	=> json_encode( ['pass'] )
		] );

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
		'msg'		=> sprintf( esc_html__( 'Привет, %s! Перезагрузка...', 'bydlokod' ), $login ),
		'redirect'	=> $redirect
	] );
}

add_action( 'wp_ajax_bydlo_ajax_logout', 'bydlo_ajax_logout' );
/**
 * Logout.
 */
function bydlo_ajax_logout(){
	wp_logout();

	wp_send_json_success( [
		'msg'		=> esc_html__( 'Давай, до свидания!', 'bydlokod' ),
		'redirect'	=> home_url( '/' )
	] );
}

add_action( 'wp_ajax_nopriv_bydlo_ajax_register', 'bydlo_ajax_register' );
/**
 * Registration.
 */
function bydlo_ajax_register(){
	if( empty( $_POST ) || ! wp_verify_nonce( $_POST['bydlo_register_nonce'], 'bydlo_ajax_register' ) )
		wp_send_json_error( ['msg' => __( '<b>Ошибка:</b> Неверные данные.', 'bydlokod' )] );

	$firstname	= ! empty( $_POST['firstname'] ) ? bydlo_clean( $_POST['firstname'] ) : null;
	$lastname	= ! empty( $_POST['lastname'] ) ? bydlo_clean( $_POST['lastname'] ) : '';
	$email		= ! empty( $_POST['email'] ) ? bydlo_clean( $_POST['email'] ) : null;
	$login		= ! empty( $_POST['login'] ) ? bydlo_clean( $_POST['login'] ) : null;
	$pass1		= ! empty( $_POST['pass1'] ) ? bydlo_clean_pass( $_POST['pass1'] ) : null;
	$pass2		= ! empty( $_POST['pass2'] ) ? bydlo_clean_pass( $_POST['pass2'] ) : null;
	$errors		= [];

	// If data is not set - add errors.
	if(
		! $firstname || ! $email ||
		! $login || ! $pass1 || ! $pass2
	){
		if( ! $firstname ) $errors[] = 'firstname';

		if( ! $email ) $errors[] = 'email';

		if( ! $login ) $errors[] = 'login';

		if( ! $pass1 ) $errors[] = 'pass1';

		if( ! $pass2 ) $errors[] = 'pass2';

		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Неверные данные.', 'bydlokod' ),
			'errors'	=> json_encode( $errors )
		] );
	}

	if( ! bydlo_check_length( $firstname, 1, 20 ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Имя слишком длинное. Попробуйте ограничиться 20 символами.', 'bydlokod' ),
			'errors'	=> json_encode( ['firstname'] )
		] );

	if( $lastname && ! bydlo_check_length( $lastname, 1, 30 ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Фамилия слишком длинная. Попробуйте ограничиться 30 символами.', 'bydlokod' ),
			'errors'	=> json_encode( ['lastname'] )
		] );

	// If email is already used.
	if( email_exists( $email ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Эта почта занята другим Пользователем.', 'bydlokod' ),
			'errors'	=> json_encode( ['email'] )
		] );

	// Validate email.
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Проверьте формат почты.', 'bydlokod' ),
			'errors'	=> json_encode( ['email'] )
		] );

	// If login is already used.
	if( username_exists( $login ) )
		wp_send_json_error( [
			'msg'		=> __( '<b>Ошибка:</b> Этот логин занят другим Пользователем.', 'bydlokod' ),
			'errors'	=> json_encode( ['login'] )
		] );

	// Data to create new User.
	$userdata = [
		'user_login'			=> $login,
		'user_email'			=> $email,
		'first_name'			=> $firstname,
		'last_name'				=> $lastname,
		'show_admin_bar_front'	=> 'false'
	];
	date_default_timezone_set( 'Europe/Moscow' );
	$new_user_id = wp_insert_user( $userdata );

	// If errors while creating new User.
	if( is_wp_error( $new_user_id ) ) bydlo_check_errors_on_user_creation( $new_user_id );

	// Set new User password.
	wp_set_password( $pass1, $new_user_id );
	// Add activation.
	$code = sha1( $new_user_id . time() . $_POST['bydlo_register_nonce'] );
	add_user_meta( $new_user_id, 'has_to_be_activated', $code, true );

	/**
	 * @see Theme Settings -> Authorization -> Lost Password E-mail Text.
	 */
	$msg = carbon_get_theme_option( 'account_activation_email' );

	if( ! $msg )
		wp_send_json_error( ['msg' => esc_html__( 'Не удалось отправить письмо для активации. Попробуйте ещё раз позднее.', 'bydlokod' )] );

	// Replace placehokders with User data and send email.
	$msg = str_replace( '[user_login]', $login, $msg );
	$msg = str_replace( '[code]', $code, $msg );
	bydlo_set_html_filters_for_email();
	wp_mail( $email, 'БыдлоКод', $msg );
	remove_filter( 'wp_mail_content_type', 'bydlo_set_html_content_type' );

	wp_send_json_success( ['msg' => esc_html__( 'Регистрация прошла успешно!', 'bydlokod' )] );
}

