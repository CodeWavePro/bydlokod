import { disableBodyScroll } from 'body-scroll-lock'
import { setTargetElement, getTargetElement } from './global'

document.addEventListener( 'DOMContentLoaded', () => {
	'use strict'

	openSearchForm()
} )

/**
 * Open search form popup.
 */
const openSearchForm = () => {
	const buttons	= document.querySelectorAll( '.open-searchform' ),
		popup		= document.querySelector( '#searchform-popup' )

	if( ! buttons.length || ! popup ) return

	setTargetElement( '#searchform-popup' )

	buttons.forEach( button => {
		button.addEventListener( 'click', e => {
			e.preventDefault()

			popup.classList.remove( 'hidden' )
			disableBodyScroll( getTargetElement(), { reserveScrollBarGap: true } )
		} )
	} )
}