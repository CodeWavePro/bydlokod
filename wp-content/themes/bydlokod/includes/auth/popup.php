<?php

/**
 * Authorization popup template.
 * For non-logged Users only.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

if( is_user_logged_in() ) return;
?>

<div id="popup-auth" class="popup popup-auth hidden">
	<div class="close popup-close">
		<i class="fa-solid fa-xmark"></i>
	</div>

	<div class="popup-inner"></div>
</div>

