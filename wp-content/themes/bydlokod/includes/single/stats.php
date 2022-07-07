<?php

/**
 * Single post statistics.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

if( ! $post_id = $args['post_id'] ?? null ) return;

$class	= bydlo_check_if_post_already_liked( $post_id ) ? ' you-liked' : '';
$title	= $class ? esc_attr__( 'Вам понравилось', 'bydlokod' ) : esc_attr__( 'Оценить', 'bydlokod' );
?>

<div class="post-stats">
	<div class="post-stats-item" title="<?php esc_attr_e( 'Просмотров', 'bydlokod' ) ?>">
		<i class="fa-solid fa-eye"></i>
		<span><?php echo esc_html( bydlo_get_post_views_count( $post_id ) ) ?></span>
	</div>

	<div class="post-stats-item" title="<?php esc_attr_e( 'Комментариев', 'bydlokod' ) ?>">
		<i class="fa-solid fa-comments"></i>
		<span><?php echo esc_html( get_comments_number( $post_id ) ) ?></span>
	</div>

	<div
		class="post-stats-item reactions<?php echo esc_attr( $class ) ?>"
		title="<?php echo $title ?>"
		data-post="<?php echo esc_attr( $post_id ) ?>"
	>
		<i class="fa-solid fa-heart"></i>
		<span><?php echo esc_html( bydlo_get_post_likes_count( $post_id ) ) ?></span>
	</div>
</div>

