/**
 * Clear some form's message element.
 *
 * @param {HTMLObject} msgElement	Form message element.
 */
export const clearFormMessage = msgElement => {
	if( ! msgElement ) return

	msgElement.classList.remove( 'success' )
	msgElement.innerHTML = ''
}

/**
 * Add success class to form's message element
 * and put success message content inside.
 *
 * @param {HTMLObject}	msgElement	Form message element.
 * @param {String}		msgContent	Message inner content.
 * @param {Boolean}		isSuccess	Is this success message or not.
 */
export const setFormMessage = ( msgElement, msgContent, isSuccess = false ) => {
	if( ! msgElement || ! msgContent ) return

	if( isSuccess ) msgElement.classList.add( 'success' )

	msgElement.innerHTML = msgContent
}

/**
 * Remove error class from form's labels with it.
 *
 * @param {HTMLObject} form	Specific form.
 */
export const clearFormErrorClasses = form => {
	if( ! form ) return

	form.querySelectorAll( 'label.error' ).forEach( label => label.classList.remove( 'error' ) )
}

export const togglePasswordVisibilityInInput = () => {
	const togglePassButtons = document.querySelectorAll( '.toggle-pass' )

	if( ! togglePassButtons.length ) return

	togglePassButtons.forEach( iconWrapper => {
		iconWrapper.addEventListener( 'click', () => {
			const label		= iconWrapper.closest( 'label' ),
				input		= label.querySelector( 'input' )


			// If password is hidden - show it.
			iconWrapper.querySelector( '.hidden' ).classList.remove( 'hidden' )

			if( input.type === 'password' ){
				input.type = 'text'
				iconWrapper.querySelector( '.show-pass' ).classList.add( 'hidden' )
			}	else {
				input.type = 'password'
				iconWrapper.querySelector( '.hide-pass' ).classList.add( 'hidden' )
			}
		} )
	} )
}