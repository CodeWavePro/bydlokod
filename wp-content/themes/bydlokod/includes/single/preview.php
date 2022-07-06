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
			<div class="post-terms">
				<?php
				$terms = get_the_terms( $post_id, 'category' );

				foreach( $terms as $term ){
					?>
					<div class="post-term">
						<?php printf( esc_html__( '%s', 'bydlokod' ), $term->name ) ?>
					</div>
					<?php
				}
				?>
			</div>

			<h4 class="post-preview-title">
				<?php printf( esc_html__( '%s', 'bydlokod' ), get_the_title( $post_id ) ) ?>
			</h4>

			<div class="post-preview-bottom">
				<div class="post-preview-bottom-left">
					<div class="post-author">
						<?php
						$author_id		= get_post_field ( 'post_author', $post_id );
						$author_name	= get_the_author_meta( 'display_name', $author_id );
						$author_email	= get_the_author_meta( 'email', $author_id );
						$avatar			= '<img src="' . get_avatar_url( $author_email ) . '" width="35" height="35" class="avatar" alt="' . esc_attr( $author_name ) . '" />';
						echo $avatar;
						echo esc_html( $author_name );
						?>
					</div>
					<div class="post-date">
						<?php echo get_the_date( '', $post_id ) ?>
					</div>
				</div>

				<div class="post-preview-bottom-right">
					<div class="post-stats">
						<div class="post-stats-item">
							<i class="fa-solid fa-eye"></i>
							<span>999</span>
						</div>

						<div class="post-stats-item">
							<i class="fa-solid fa-comments"></i>
							<span>123</span>
						</div>

						<div class="post-stats-item">
							<i class="fa-solid fa-fire"></i>
							<span>123</span>
						</div>
					</div>

					<a href="<?php echo get_the_permalink( $post_id ) ?>">
						<i class="fa-solid fa-arrow-right-long"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</article><!-- .single-post -->

