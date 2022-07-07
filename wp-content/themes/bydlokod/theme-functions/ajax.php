<?php

/**
 * Theme AJAX functions.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

add_action( 'wp_ajax_bydlo_ajax_set_post_likes', 'bydlo_ajax_set_post_likes' );
add_action( 'wp_ajax_nopriv_bydlo_ajax_set_post_likes', 'bydlo_ajax_set_post_likes' );
/**
 * Like/dislike post.
 */
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

add_action( 'wp_ajax_bydlo_ajax_load_more_posts', 'bydlo_ajax_load_more_posts' );
add_action( 'wp_ajax_nopriv_bydlo_ajax_load_more_posts', 'bydlo_ajax_load_more_posts' );
/**
 * Load more posts.
 */
function bydlo_ajax_load_more_posts(){
	$per_page	= isset( $_POST['per_page'] ) ? bydlo_clean( $_POST['per_page'] ) : get_option( 'posts_per_page' );
	$offset		= isset( $_POST['offset'] ) ? bydlo_clean( $_POST['offset'] ) : 0;
	$new_posts	= new WP_Query( [
		'post_type'		=> 'post',
		'post_status'	=> 'publish',
		'offset'		=> $offset
	] );

	if( ! $new_posts->have_posts() )
		wp_send_json_error( ['msg' => esc_html__( 'Записи не найдены.', 'bydlokod' )] );

	$posts = '';

	while( $new_posts->have_posts() ){
		$new_posts->the_post();
		$posts .= bydlo_get_template_part( 'includes/single/preview' );
	}

	wp_reset_query();

	wp_send_json_success( [
		'msg'	=> esc_html__( 'Записи успешно загружены.', 'bydlokod' ),
		'posts'	=> $posts
	] );
}

