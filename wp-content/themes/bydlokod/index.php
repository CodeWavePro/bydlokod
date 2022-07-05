<?php

/**
 * Index page default template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

get_header();

$home_title_text = carbon_get_theme_option( 'home_title_text' );
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
			</main>
		</div><!-- .main-wrapper-inner -->
	</div><!-- .container -->
</div><!-- .main-wrapper -->

<?php
get_footer();

