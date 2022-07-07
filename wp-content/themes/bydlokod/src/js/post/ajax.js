import { getAjaxStatus, setAjaxStatus, bydloAjaxRequest } from '../common/global'

document.addEventListener( 'DOMContentLoaded', () => {
	'use strict'

	clickPostLike()
} )

/**
 * Click on post's likes block.
 */
const clickPostLike = () => {
	const likesBlocks = document.querySelectorAll( '.post-stats-item.reactions' )

	if( ! likesBlocks.length ) return

	likesBlocks.forEach( likesBlock => {
		const postId	= likesBlock.dataset.post
		let likesCount	= likesBlock.querySelector( 'span' ),
			icon		= likesBlock.querySelector( 'i' )

		if( ! postId ) return

		likesBlock.addEventListener( 'click', () => {
			if( getAjaxStatus() ) return

			setAjaxStatus( true )

			const ajaxData = new FormData()

			ajaxData.append( 'action', 'bydlo_ajax_set_post_likes' )
			ajaxData.append( 'post_id', postId )

			bydloAjaxRequest( ajaxData ).then( response => {
				if( response ){
					switch( response.success ){
						case true:
							console.log( response.data.msg )

							// If it was like.
							if( response.data.like ){
								icon.classList.add( 'like-animation' )
								likesBlock.setAttribute( 'title', 'Вам понравилось' )
								setTimeout( () => {
									icon.classList.remove( 'like-animation' )
									likesBlock.classList.add( 'you-liked' )
									likesCount.innerHTML = response.data.count
								}, 750 );
							}	else {	// If it was dislike.
								icon.classList.add( 'dislike-animation' )
								likesBlock.setAttribute( 'title', 'Оценить' )
								setTimeout( () => {
									icon.classList.remove( 'dislike-animation' )
									likesBlock.classList.remove( 'you-liked' )
									likesCount.innerHTML = response.data.count
								}, 750 );
							}

							break

						case false:
							console.error( response.data.msg )
							break
					}
				}

				setAjaxStatus( false )
			} )
		} )
	} );
}