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
?>

<article class="post-preview" data-post="<?php echo esc_attr( $post_id ) ?>">
	<div class="post-preview-inner">
		<?php
		if( has_post_thumbnail( $post_id ) ){
			?>
			<div class="post-preview-thumb">
				<?php echo get_the_post_thumbnail( $post_id, 'medium' ) ?>
			</div>
			<?php
		}
		?>

		<div class="post-preview-info">
			<div class="post-preview-terms"></div>

			<h4 class="post-preview-title">
				<?php printf( esc_html__( '%s', 'bydlokod' ), get_the_title( $post_id ) ) ?>
			</h4>

			<div class="post-preview-bottom">
				<div class="post-preview-bottom-left">
					<div class="post-author"></div>
					<div class="post-date">
						<?php echo get_the_date() ?>
					</div>
				</div>

				<div class="post-preview-bottom-right">
					<div class="post-stats"></div>
					<a href="<?php echo get_the_permalink( $post_id ) ?>">arrow</a>
				</div>
			</div>
		</div>
	</div>
</article><!-- .single-post -->

