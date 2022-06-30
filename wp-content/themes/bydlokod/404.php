<?php

/**
 * 404 page default template.
 *
 * @see Options -> 404 Page.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

get_header();
?>

<main class="main">
	<div class="hero hero-404">
		<div class="container">
			<div class="hero-inner">
				<div class="hero-body">
					<h1 class="hero-title">
						<?php esc_html_e( '404 - Not Found', 'bydlokod' ) ?>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<div class="page-content page-content-404">
		<div class="container">
			<?php esc_html_e( 'Ooops!.. Seems something went wrong.', 'bydlokod' ) ?>
		</div>
	</div>
</main>

<?php
get_footer();

