<?php

/**
 * Search form template.
 *
 * @package WordPress
 * @subpackage bydlokod
 */
?>

<div id="searchform-popup" class="popup hidden">
	<div class="close popup-close">
		<i class="fa-solid fa-xmark"></i>
	</div>

	<form role="search" method="get" id="searchform" class="popup-form searchform" action="<?php echo home_url( '/' ) ?>">
		<fieldset>
			<label for="s" class="label-focus">
				<input
					id="s"
					class="input"
					type="text"
					value="<?php echo get_search_query() ?>"
					name="s"
					placeholder="<?php esc_attr_e( 'Чё хотел?..', 'bydlokod' ) ?>"
				/>
			</label>
		</fieldset>
	</form>
</div>

