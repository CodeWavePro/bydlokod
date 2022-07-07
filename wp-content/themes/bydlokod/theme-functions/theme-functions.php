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
 */
function rp_get_carbon_lang_ending(): string
{
	$ending = '';

	if( ! defined( 'ICL_LANGUAGE_CODE' ) ) return $ending;

	return '_' . ICL_LANGUAGE_CODE;
}

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

