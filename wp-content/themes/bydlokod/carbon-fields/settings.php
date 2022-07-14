<?php

/**
 * CarbonFields Framework settings.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Global settings, can be used many times on different pages.
Container::make( 'theme_options', __( 'Настройки темы' ) )
	->add_tab( __( 'Хедер' ), [
		Field::make( 'image', 'header_logo', __( 'Лого' ) )
		->set_width( 50 ),

		Field::make( 'text', 'header_button_text', __( 'Текст кнопки хедера' ) )
			->set_width( 50 )
	] )

	->add_tab( __( 'Главная' ), [
		Field::make( 'text', 'home_title_text', __( 'Заголовок постов' ) )
	] )

	->add_tab( __( 'Авторизация' ), [
		Field::make( 'rich_text', 'account_activation_email', __( 'Письмо для активации аккаунта' ) )
			->set_help_text( __( 'Плэйсхолдеры: [user_login], [code].' ) )
	] );

	/*	Field::make( 'rich_text', 'auth_lost_pass_email' . rp_get_carbon_lang_ending(), __( 'Lost Password E-mail Text' ) )
			->set_help_text( __( 'Placeholders: [user_login], [link].' ) )
			->set_width( 33 ),

		Field::make( 'rich_text', 'auth_pass_updated_email' . rp_get_carbon_lang_ending(), __( 'Password Updated E-mail Text' ) )
			->set_help_text( __( 'Placeholders: [user_login].' ) )
			->set_width( 33 )
	] )

	->add_tab( __( 'Profile' ), [
		Field::make( 'rich_text', 'email_change_email' . rp_get_carbon_lang_ending(), __( 'Change E-mail Text' ) )
			->set_help_text( __( 'Placeholders: ###USERNAME###, ###FIRST_NAME###, ###LAST_NAME###, ###ADMIN_EMAIL###, ###EMAIL###, ###SITENAME###, ###SITEURL###.' ) )
	] );*/

