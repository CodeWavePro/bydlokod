<?php

/**
 * Theme AJAX functions.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

/**
 * Check if city is set to be used in Qualify Now form later.
 */
add_action( 'wp_ajax_bydlo_ajax_set_post_likes', 'bydlo_ajax_set_post_likes' );
add_action( 'wp_ajax_nopriv_bydlo_ajax_set_post_likes', 'bydlo_ajax_set_post_likes' );
function bydlo_ajax_set_post_likes(){
	$post_id = isset( $_POST['post_id'] ) ? bydlo_clean( $_POST['post_id'] ) : null;

	if( ! $post_id )
		wp_send_json_error( ['msg' => esc_html__( 'Некорректные данные.', 'bydlokod' )] );

	// Only logged in User can add/remove his reaction.
	if( ! is_user_logged_in() ){
		wp_send_json_error( [
			'msg'			=> esc_html__( 'Пользователь не залогинен.', 'bydlokod' ),
			'must_login'	=> 1
		] );
	}

	// Check if current User already liked this post or not.
	$process		= bydlo_process_reaction_on_post( $post_id );
	$reaction		= $process['reaction'];
	$likes_count	= $process['count'];

	if( $reaction === 'like' )
		$msg = esc_html__( 'Вам понравился пост. Спасибо за реакцию! \(^_^)/', 'bydlokod' );
	else
		$msg = esc_html__( 'Вам не понравился пост. Жаль... (Т_Т)', 'bydlokod' );

	wp_send_json_success( [
		'msg'	=> $msg,
		'like'	=> $reaction === 'like' ? 1 : 0,
		'count'	=> $likes_count
	] );
}

