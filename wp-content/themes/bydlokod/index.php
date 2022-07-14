<?php

/**
 * Index page default template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

get_header();

$home_title_text	= carbon_get_theme_option( 'home_title_text' );
$posts_per_page		= get_option( 'posts_per_page' );
$all_posts_count	= count( get_posts( ['post_type' => 'post', 'posts_per_page' => -1] ) );
?>

<div class="main-wrapper">
	<div class="container">
		<div class="main-wrapper-inner">
			<?php get_sidebar() ?>

			<main class="main">
				<div class="main-title">
					<?php
					if( $home_title_text ){
						?>
						<h1>
							<?php printf( esc_html__( '%s', 'bydlokod' ), $home_title_text ) ?>
						</h1>
						<?php
					}
					?>
				</div>

				<div class="main-posts">
					<?php
					if( have_posts() ){
						while( have_posts() ){
							the_post();
							get_template_part( 'includes/single/preview', get_post_type() );
						}
					}	else {
						esc_html_e( 'Статьи не найдены.', 'bydlokod' );
					}
					?>
				</div>

				<div class="posts-loadmore">
					<button
						class="button lg rounded violet"
						data-per-page="<?php echo esc_attr( $posts_per_page ) ?>"
						data-offset="<?php echo esc_attr( $posts_per_page ) ?>"
						data-all-posts-count="<?php echo esc_attr( $all_posts_count ) ?>"
					>
						<?php esc_html_e( 'Загрузить ещё', 'bydlokod' ) ?>
					</button>
				</div>
			</main>
		</div><!-- .main-wrapper-inner -->
	</div><!-- .container -->
</div><!-- .main-wrapper -->

<?php
get_footer();

