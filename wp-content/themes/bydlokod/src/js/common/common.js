import { enableBodyScroll } from 'body-scroll-lock'
import { renderSVGs, getTargetElement } from './global'

document.addEventListener( 'DOMContentLoaded', () => {
	'use strict'

	renderSVGs( document )
	focusLabels()
	popupClose()
	popupCloseOnClick()
} )

/**
 * Focus inputs inside specific labels.
 */
export const focusLabels = () => {
	const inputs = document.querySelectorAll( '.label-focus input' )

	if( ! inputs.length ) return

	inputs.forEach( input => {
		const label = input.parentElement

		input.addEventListener( 'focus', () => label.classList.add( 'focus' ) )
		input.addEventListener( 'blur', () => label.classList.remove( 'focus' ) )
	} );
}

/**
 * Close popup by clicking on close button.
 */
const popupClose = () => {
	const popupCloseButtons = document.querySelectorAll( '.popup-close' )

	if( ! popupCloseButtons.length ) return

	popupCloseButtons.forEach( button => {
		button.addEventListener( 'click', () => {
			const popup = button.closest( '.popup' )

			if( ! popup ) return

			popup.classList.add( 'hidden' )
			enableBodyScroll( getTargetElement() )
		} )
	} )
}

/**
 * Close popup if its area clicked.
 */
const popupCloseOnClick = () => {
	const popups = document.querySelectorAll( '.popup' )

	if( ! popups.length ) return

	popups.forEach( popup => {
		popup.addEventListener( 'click', e => {
			e.stopPropagation()

			// If popup area clicked.
			if( e.target.classList.contains( 'popup' ) ){
				enableBodyScroll( getTargetElement() )
				popup.classList.add( 'hidden' )
			}
		} )
	} )
}