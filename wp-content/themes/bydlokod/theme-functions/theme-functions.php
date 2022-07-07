<?php

/**
 * Theme custom functions.
 * Please place all your custom functions declarations inside this file.
 *
 * @package WordPress
 * @subpackage bydlokod
 */

add_action( 'wp_default_scripts', 'bydlo_remove_jq_migrate' );
/**
 * Prevent jQuery scripts from loading on the front-end.
 *
 * @param	WP_Scripts	$scripts	WordPress default scripts.
 */
function bydlo_remove_jq_migrate( WP_Scripts $scripts ){
	if( ! is_admin() ) $scripts->remove( 'jquery' );
}

add_action( 'init', 'bydlo_register_session' );
/**
 * For user sessions.
 */
function bydlo_register_session(){
	if( ! session_id() ) session_start();
}

/**
 * Remove double view count when opening post.
 */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

add_action( 'wp_head', 'bydlo_js_vars_for_frontend' );
/**
 * JS variables for frontend, such as AJAX URL.
 */
function bydlo_js_vars_for_frontend(){
	$variables = ['ajaxUrl' => admin_url( 'admin-ajax.php' )];
	echo '<script type="text/javascript">
		window.wpData = ' . json_encode( $variables ) . ';
	</script>';
}

/**
 * Clean incoming value from trash.
 *
 * @param	mixed	$value	Some value to clean.
 * @return	mixed	$value	The same value, but after cleaning.
 */
function bydlo_clean( mixed $value ): mixed
{
	$value	= wp_unslash( $value );
	$value	= trim( $value );
	$value	= stripslashes( $value );
	$value	= strip_tags( $value );

	return htmlspecialchars( $value );
}

/**
 * Clean password data.
 *
 * @param	string	$pass	Some password to clean.
 * @return	string	$pass	Same password, cleaned.
 */
function bydlo_clean_pass( string $pass ): mixed
{
	$pass	= trim( $pass );
	$pass	= str_replace( ' ', '', $pass );

	return strip_tags( $pass );
}

/**
 * Function checks if value length is between min and max parameters.
 *
 * @param   string	$value	Any string value.
 * @param   int     $min    Minimum symbols value length.
 * @param   int     $max    Maximum symbols value length.
 * @return  bool            True if OK, false if value length is too small or large.
 */
function bydlo_check_length( string $value = '', int $min, int $max ): bool
{
	return ! ( mb_strlen( $value ) < $min || mb_strlen( $value ) > $max );
}

/**
 * E-mail filters for HTML content type and letter title.
 */
function bydlo_set_html_filters_for_email(){
	add_filter( 'wp_mail_content_type', 'bydlo_set_html_content_type' );
}

/**
 * Function sets HTML content type in E-mails.
 *
 * @return	string	Letter content type.
 */
function bydlo_set_html_content_type(): string
{
	return 'text/html';
}

add_filter( 'wp_mail_from', 'bydlo_sender_email' );
/**
 * Function to change default email address.
 *
 * @param	string	$original_email_address	Original E-mail address. :-)
 * @return	string							New E-mail address.
 */
function bydlo_sender_email( string $original_email_address ): string
{
    return 'andrew.stezenko@gmail.com';
}

add_filter( 'wp_mail_from_name', 'bydlo_sender_name' );
/**
 * Function to change default sender name.
 *
 * @param	string	$original_email_from	Original letter 'From:' title.
 * @return	string							New letter 'From:' title.
 */
function bydlo_sender_name( string $original_email_from ): string
{
    return 'БыдлоКод';
}

/**
 * Get current language ending for Carbon Fields.
 *
 * @return string Current language with underscore at the beginning.
 *
function rp_get_carbon_lang_ending(): string
{
	$ending = '';

	if( ! defined( 'ICL_LANGUAGE_CODE' ) ) return $ending;

	return '_' . ICL_LANGUAGE_CODE;
}*/

add_filter( 'upload_mimes', 'bydlo_mime_types' );
/**
 * Allow SVG upload.
 *
 * @param	array	$mimes	Media library allowed files types.
 * @return	array	$mimes	Media library allowed files types + new one - SVG.
 */
function bydlo_mime_types( $mimes ): array
{
	if( is_admin() ) $mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

/**
 * Get post terms.
 *
 * @param	int			$post_id	Specific post ID.
 * @param	string		$post_type	Specific post type.
 * @param	string		$taxonomy	Specific post taxonomy.
 * @return	string|null	$html		Post terms HTML structure.
 */
function bydlo_get_post_terms( int $post_id, string $post_type = 'post', string $taxonomy = 'category' ): ?string
{
	if( ! $post_id ) return null;

	$terms = get_the_terms( $post_id, $taxonomy );

	if( is_wp_error( $terms ) || empty( $terms ) ) return null;

	$html = '<div class="post-terms">';

	foreach( $terms as $term ){
		$html .= '<a class="post-term" href="' . get_term_link( $term->term_id, $taxonomy ) . '" title="' . sprintf( esc_attr__( 'На страницу категории %s', 'bydlokod' ), $term->name ) . '">' .
			sprintf( esc_html__( '%s', 'bydlokod' ), $term->name ) .
		'</a>';
	}

	return $html . '</div>';
}

/**
 * Get post author avatar.
 *
 * @param	int			$post_id	Specific post ID.
 * @return	string|null	$html		HTML structure for author avatar.
 */
function bydlo_get_author_avatar( int $post_id ): ?string
{
	if( ! $post_id ) return null;

	$author_id		= get_post_field( 'post_author', $post_id );
	$author_name	= get_the_author_meta( 'display_name', $author_id );
	$author_email	= get_the_author_meta( 'email', $author_id );
	$avatar			= '<div class="author-avatar img-cover-inside opacity-075-on-hover">
		<a href="' . get_author_posts_url( $author_id ) . '" title="' . esc_attr( 'На страницу автора', 'bydlokod' ) . '">
			<img src="' . get_avatar_url( $author_email ) . '" width="35" height="35" class="avatar" alt="' . esc_attr( $author_name ) . '" />
		</a>
	</div>';

	return $avatar;
}

/**
 * Get post author name.
 *
 * @param	int			$post_id	Specific post ID.
 * @return	string|null	$html		HTML structure for author name.
 */
function bydlo_get_author_name( int $post_id ): ?string
{
	if( ! $post_id ) return null;

	$author_id	= get_post_field( 'post_author', $post_id );
	$user_roles	= get_user_by( 'ID', $author_id )->roles;
	$html		= '<div class="author-name">' .
		'<a class="opacity-075-on-hover" href="' . get_author_posts_url( $author_id ) . '" title="' . esc_attr( 'На страницу автора', 'bydlokod' ) . '">' .
			get_the_author_meta( 'display_name', $author_id ) .
		'</a>';

	// If Author is Administrator.
	if( in_array( 'administrator', $user_roles ) ){
		$html .= '<span class="author-name-icon" title="' . esc_attr__( 'Администратор', 'bydlokod' ) . '">
			<i class="fa-solid fa-shield-halved"></i>
		</span>';
	}

	return $html . '</div>';
}

/**
 * Get post views count.
 *
 * @param	int	$post_id	Specific post ID.
 * @return	int				Current post views count.
 */
function bydlo_get_post_views_count( int $post_id ): ?int
{
	if( ! $post_id ) return null;

	if( ! $count = get_post_meta( $post_id, 'views_count', true ) )
		$count = 0;

	return ( int ) $count;
}

/**
 * Set post views count.
 *
 * @param	int		$post_id	Specific post ID.
 * @return	bool				True on success, false on failure.
 */
function bydlo_set_post_views_count( int $post_id ): ?bool
{
	if( ! $post_id ) return null;

	// If visited posts array exists in current User's session.
	if( isset( $_SESSION['visited_posts'] ) ){
		// If current post was already visited by this User - exit.
		if( in_array( $post_id, $_SESSION['visited_posts'] ) ) return null;

		// Add current post ID to current User's session.
		$_SESSION['visited_posts'][] = $post_id;
	}	else {
		// Create array of visited posts in session and write current post ID in it.
		$_SESSION['visited_posts'] = [$post_id];
	}

	$new_count = bydlo_get_post_views_count( $post_id ) + 1;

	return update_post_meta( $post_id, 'views_count', $new_count );
}

/**
 * Like or dislike post.
 *
 * @param	int			$post_id	Specific post ID.
 * @return	array|null				Reaction type and post likes count.
 */
function bydlo_process_reaction_on_post( int $post_id ): ?array
{
	if(
		! $post_id ||
		! ( $current_user_id = get_current_user_id() )
	) return null;

	// Get string of Users' IDs who already liked this post.
	$liked_by = get_post_meta( $post_id, 'liked_by', true );

	// If field is not existing yet - current User is the first who liked this post.
	if( ! $liked_by ){
		bydlo_like_post( $post_id, $current_user_id );
		$reaction = 'like';
	}

	// Turn IDs string to array of IDs.
	$liked_by_ids = explode( ',', $liked_by );

	// If current User is already in array - now he dislikes this post.
	if( in_array( $current_user_id, $liked_by_ids ) ){
		bydlo_dislike_post( $post_id, $current_user_id, $liked_by_ids );
		$reaction = 'dislike';
	}	else {
		bydlo_like_post( $post_id, $current_user_id, $liked_by );
		$reaction = 'like';
	}

	return [
		'reaction'	=> $reaction,
		'count'		=> bydlo_get_post_likes_count( $post_id )
	];
}

/**
 * Check if specific post already liked by current User.
 *
 * @param	int			$post_id	Specific post ID.
 * @return	bool					True if already liked, false if not.
 */
function bydlo_check_if_post_already_liked( int $post_id ): ?bool
{
	if( ! $post_id ) return null;

	// Get string of Users' IDs who already liked this post.
	$liked_by		= get_post_meta( $post_id, 'liked_by', true );
	$liked_by_ids	= explode( ',', $liked_by );	// Turn IDs string to array of IDs.

	// Check if current User ID is already in array.
	if( in_array( get_current_user_id(), $liked_by_ids ) ) return true;

	return false;
}

/**
 * Like specific post.
 *
 * @param	int			$post_id			Specific post ID.
 * @param	int			$current_user_id	Current User ID.
 * @param	string		$liked_by			String of Users IDs who liked post.
 * @return	bool|null						True if like added, false if not.
 */
function bydlo_like_post( int $post_id, int $current_user_id, string $liked_by = '' ): ?bool
{
	if(
		! $post_id ||
		! ( $current_user_id = get_current_user_id() )
	) return null;

	if( ! $liked_by )
		return update_post_meta( $post_id, 'liked_by', $current_user_id );
	else
		return update_post_meta( $post_id, 'liked_by', $liked_by . ',' . $current_user_id );
}

/**
 * Dislike specific post.
 *
 * @param	int			$post_id			Specific post ID.
 * @param	int			$current_user_id	Current User ID.
 * @param	array		$liked_by_ids		Array of Users IDs who liked post.
 * @return	bool|null						True if like removed, false if not.
 */
function bydlo_dislike_post( int $post_id, int $current_user_id, array $liked_by_ids = [] ): ?bool
{
	if(
		! $post_id ||
		! ( $current_user_id = get_current_user_id() )
	) return null;

	$found = false;

	// Search for current User ID in post liked array.
	foreach( $liked_by_ids as $key => $id ){
		// If found - remove ID from array and exit loop.
		if( $current_user_id == $id ){
			array_splice( $liked_by_ids, $key, 1 );
			$found = true;
			break;
		}
	}

	// Update post meta field with string of other liked IDs.
	if( $found ) return update_post_meta( $post_id, 'liked_by', implode( ',', $liked_by_ids ) );
	else return false;
}

/**
 * Dislike specific post.
 *
 * @param	int			$post_id	Specific post ID.
 * @return	int|null				Post likes count.
 */
function bydlo_get_post_likes_count( int $post_id ): ?int
{
	if( ! $post_id ) return null;

	$liked_by = get_post_meta( $post_id, 'liked_by', true );

	if( ! $liked_by ) return 0;

	return count( explode( ',', $liked_by ) );
}

