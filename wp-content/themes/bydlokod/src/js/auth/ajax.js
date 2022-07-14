import { disableBodyScroll } from 'body-scroll-lock'
import {
	getAjaxStatus,
	setAjaxStatus,
	bydloAjaxRequest,
	createLoader,
	setTargetElement,
	getTargetElement,
	processFormErrors
} from '../common/global'
import { focusLabels } from '../common/common'
import { clearFormMessage, clearFormErrorClasses, setFormMessage } from '../common/forms'

document.addEventListener( 'DOMContentLoaded', () => {
	'use strict'

	openAuthPopup()
	logout()
} )

/**
 * Open authorization popup with Login or Register form.
 */
const openAuthPopup = () => {
	const authLinks = document.querySelectorAll( '.header-auth-link' ),
		authPopup	= document.querySelector( '.popup-auth' )

	if( ! authLinks.length || ! authPopup ) return

	const popupInner = authPopup.querySelector( '.popup-inner' )

	authLinks.forEach( link => {
		link.addEventListener( 'click', e => {
			e.preventDefault()

			if( getAjaxStatus() ) return

			setAjaxStatus( true )

			const ajaxData	= new FormData(),
				loader		= createLoader( 'centered lg violet' )
			let type		= link.classList.contains( 'login' ) ? 'login' : 'register'

			ajaxData.append( 'action', 'bydlo_ajax_show_auth_form' )
			ajaxData.append( 'type', type )

			// Show popup with loader.
			setTargetElement( '#popup-auth' )
			disableBodyScroll( getTargetElement(), { reserveScrollBarGap: true } )
			popupInner.innerHTML = ''
			popupInner.appendChild( loader )
			authPopup.classList.remove( 'hidden' )

			bydloAjaxRequest( ajaxData ).then( response => {
				if( response ){
					loader.remove()

					switch( response.success ){
						case true:
							popupInner.innerHTML = response.data.form
							focusLabels()
							type === 'login' ? login() : null
							openAnotherFormInsidePopup()
							break

						case false:
							popupInner.innerHTML = response.data.msg
							break
					}
				}

				setAjaxStatus( false )
			} )
		} )
	} )
}

/**
 * Open another form inside authorization popup on links click.
 */
export const openAnotherFormInsidePopup = () => {
	const authLinks = document.querySelectorAll( '.form-link' ),
		authPopup	= document.querySelector( '.popup-auth' )

	if( ! authLinks.length || ! authPopup ) return

	const popupInner = authPopup.querySelector( '.popup-inner' )

	authLinks.forEach( link => {
		link.addEventListener( 'click', e => {
			e.preventDefault()

			if( getAjaxStatus() ) return

			setAjaxStatus( true )

			const ajaxData	= new FormData(),
				loader		= createLoader( 'centered lg violet' )
			let type		= link.classList.contains( 'login' ) ? 'login' : 'register'

			ajaxData.append( 'action', 'bydlo_ajax_show_auth_form' )
			ajaxData.append( 'type', type )

			// Show popup with loader.
			setTargetElement( '#popup-auth' )
			disableBodyScroll( getTargetElement(), { reserveScrollBarGap: true } )
			popupInner.innerHTML = ''
			popupInner.appendChild( loader )

			bydloAjaxRequest( ajaxData ).then( response => {
				if( response ){
					loader.remove()

					switch( response.success ){
						case true:
							popupInner.innerHTML = response.data.form
							focusLabels()
							type === 'login' ? login() : null
							openAnotherFormInsidePopup()
							break

						case false:
							popupInner.innerHTML = response.data.msg
							break
					}
				}

				setAjaxStatus( false )
			} )
		} )
	} )
}

/**
 * Login.
 */
export const login = () => {
	const form = document.querySelector( '.form-login' )

	if( ! form ) return

	form.addEventListener( 'submit', e => {
		e.preventDefault()

		if( getAjaxStatus() ) return

		setAjaxStatus( true )

		const formData	= new FormData( form ),
			button		= form.querySelector( '.button[type="submit"]' ),
			msg			= form.querySelector( '.form-message' ),
			loader		= createLoader()

		formData.append( 'action', 'bydlo_ajax_login' )
		formData.append( 'form_data', formData )
		button.appendChild( loader )
		clearFormMessage( msg )
		clearFormErrorClasses( form )

		bydloAjaxRequest( formData ).then( response => {
			if( response ){
				loader.remove()

				switch( response.success ){
					case true:
						setFormMessage( msg, response.data.msg, true )

						if( response.data.redirect ) location.href = response.data.redirect
						break

					case false:
						console.error( response.data.msg )
						setFormMessage( msg, response.data.msg )

						// If has errors.
						if( response.data.errors.length )
							processFormErrors( JSON.parse( response.data.errors ), form )

						break
				}
			}

			setAjaxStatus( false )
		} )
	} )
}

/**
 * Logout.
 */
const logout = () => {
	const link = document.querySelector( '.header-logout-link' )

	if( ! link ) return

	link.addEventListener( 'click', e => {
		e.preventDefault()

		if( getAjaxStatus() ) return

		setAjaxStatus( true )

		const formData	= new FormData(),
			loader		= createLoader()

		formData.append( 'action', 'bydlo_ajax_logout' )
		link.appendChild( loader )

		bydloAjaxRequest( formData ).then( response => {
			if( response ){
				loader.remove()

				switch( response.success ){
					case true:
						console.log( response.data.msg )

						if( response.data.redirect ) location.href = response.data.redirect
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