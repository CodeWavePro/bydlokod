import { disableBodyScroll } from 'body-scroll-lock'
import {
	getAjaxStatus,
	setAjaxStatus,
	bydloAjaxRequest,
	createLoader,
	setTargetElement,
	getTargetElement
} from '../common/global'
import { focusLabels } from '../common/common'
import { login, openAnotherFormInsidePopup } from '../auth/ajax'

document.addEventListener( 'DOMContentLoaded', () => {
	'use strict'

	loadMorePosts()
	clickPostLike()
} )

/**
 * Load more posts on button click.
 */
const loadMorePosts = () => {
	const posts			= document.querySelectorAll( '.post-preview' ),
		postsWrapper	= document.querySelector( '.main-posts' ),
		button			= document.querySelector( '.posts-loadmore .button' )

	if( ! posts.length || ! button || ! postsWrapper ) return

	button.addEventListener( 'click', () => {
		if( getAjaxStatus() ) return

		setAjaxStatus( true )

		const ajaxData	= new FormData(),
			loader		= createLoader(),
			perPage		= parseInt( button.dataset.perPage ),
			totalCount	= parseInt( button.dataset.allPostsCount )
		let offset		= parseInt( button.dataset.offset )

		ajaxData.append( 'action', 'bydlo_ajax_load_more_posts' )
		ajaxData.append( 'per_page', perPage )
		ajaxData.append( 'offset', offset )
		button.appendChild( loader )

		bydloAjaxRequest( ajaxData ).then( response => {
			if( response ){
				loader.remove()

				switch( response.success ){
					case true:
						console.log( response.data.msg )
						postsWrapper.innerHTML += response.data.posts
						clickPostLike()

						// If there are no more posts - remove button.
						if( totalCount <= offset + perPage )
							button.remove()
						else
							button.dataset.offset = offset + perPage

						break

					case false:
						console.error( response.data.msg )
						break
				}
			}

			setAjaxStatus( false )
		} )
	} )
}

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

			const ajaxData	= new FormData(),
				loader		= createLoader()

			ajaxData.append( 'action', 'bydlo_ajax_set_post_likes' )
			ajaxData.append( 'post_id', postId )
			likesBlock.appendChild( loader )

			bydloAjaxRequest( ajaxData ).then( response => {
				if( response ){
					loader.remove()

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
								}, 750 )
							}	else {	// If it was dislike.
								icon.classList.add( 'dislike-animation' )
								likesBlock.setAttribute( 'title', 'Оценить' )
								setTimeout( () => {
									icon.classList.remove( 'dislike-animation' )
									likesBlock.classList.remove( 'you-liked' )
									likesCount.innerHTML = response.data.count
								}, 750 )
							}

							break

						case false:
							console.error( response.data.msg )

							// If User is not logged in - show Login form in popup.
							if( response.data.form ){
								const authPopup = document.querySelector( '.popup-auth' )

								if( ! authPopup ) break

								const popupInner = authPopup.querySelector( '.popup-inner' )

								setTargetElement( '#popup-auth' )
								disableBodyScroll( getTargetElement(), { reserveScrollBarGap: true } )
								popupInner.innerHTML = response.data.form
								authPopup.classList.remove( 'hidden' )
								focusLabels()
								login()
								openAnotherFormInsidePopup()
							}
							break
					}
				}

				setAjaxStatus( false )
			} )
		} )
	} )
}