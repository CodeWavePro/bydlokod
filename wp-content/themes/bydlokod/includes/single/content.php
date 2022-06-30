<?php

/**
 * Single post content.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

// Correct only inside WP loop.
$post_id = get_the_ID();

// If this is NOT single post page - do nothing.
if( ! is_singular( 'post' ) ) return;
?>

<article class="single-post post-<?php echo esc_attr( $post_id ) ?>">
	<h1 class="single-post-title">
		<?php the_title() ?>
	</h1>

	<?php the_content() ?>
</article><!-- .single-post -->

