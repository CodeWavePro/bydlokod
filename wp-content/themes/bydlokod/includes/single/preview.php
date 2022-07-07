<?php

/**
 * Single post preview.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

$post_id	= $args['post_id'] ?? null;
$post_id	= ! $post_id ? get_the_ID() : null;

if( ! $post_id ) return;

$permalink = get_the_permalink( $post_id );
?>

<article class="post-preview" data-post="<?php echo esc_attr( $post_id ) ?>">
	<div class="post-preview-inner">
		<?php
		if( has_post_thumbnail( $post_id ) ){
			?>
			<div class="post-preview-thumb img-cover-inside">
				<a class="opacity-075-on-hover" href="<?php echo $permalink ?>">
					<?php echo get_the_post_thumbnail( $post_id, 'medium' ) ?>
				</a>
			</div>
			<?php
		}
		?>

		<div class="post-preview-info">
			<?php echo bydlo_get_post_terms( $post_id ) ?>

			<h4 class="post-preview-title">
				<a href="<?php echo $permalink ?>">
					<?php printf( esc_html__( '%s', 'bydlokod' ), get_the_title( $post_id ) ) ?>
				</a>
			</h4>

			<div class="post-author">
				<?php echo bydlo_get_author_avatar( $post_id ) ?>

				<div class="author-info">
					<?php echo bydlo_get_author_name( $post_id ) ?>

					<div class="post-date">
						<?php echo get_the_date( '', $post_id ) ?>
					</div>
				</div>
			</div>

			<div class="post-preview-bottom">
				<div class="post-stats">
					<div class="post-stats-item" title="<?php esc_attr_e( 'Просмотров', 'bydlokod' ) ?>">
						<i class="fa-solid fa-eye"></i>
						<span><?php echo bydlo_get_post_views_count( $post_id ) ?></span>
					</div>

					<div class="post-stats-item" title="<?php esc_attr_e( 'Комментариев', 'bydlokod' ) ?>">
						<i class="fa-solid fa-comments"></i>
						<span><?php echo get_comments_number( $post_id ) ?></span>
					</div>

					<div class="post-stats-item reactions opacity-075-on-hover" title="<?php esc_attr_e( 'Оценить', 'bydlokod' ) ?>">
						<i class="fa-solid fa-heart"></i>
						<span>123</span>
					</div>
				</div>

				<a class="post-preview-button" href="<?php echo $permalink ?>" title="<?php esc_attr_e( 'Перейти к статье', 'bydlokod' ) ?>">
					<i class="fa-solid fa-arrow-right-long"></i>
				</a>
			</div>
		</div>
	</div>
</article><!-- .single-post -->

