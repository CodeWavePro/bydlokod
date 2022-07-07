export const TRANSITION_DURATION = 350,
	ajaxUrl = window.wpData.ajaxUrl

let ajaxStatus = false,
	targetElement

/**
 * Render SVG code from images (<img /> tags).
 *
 * @param {DOMElement}	wrapper		DOM element, inside which need to render svgs.
 * @param {String}		imgSelector	Specific selector for <img /> tag to render SVG.
 */
export const renderSVGs = ( wrapper, imgSelector = '' ) => {
	if( ! wrapper ) return

	// Get images with specific selector only OR all images.
	const selector	= imgSelector ? `img${imgSelector}` : 'img',
		images		= wrapper.querySelectorAll( selector ),
		svgs		= []

	// If there are no images - exit.
	if( ! images.length ) return

	// Get only svg images to svgs array.
	images.forEach( img => {
		let src			= img.src,
			extension	= src.slice( -4 )

		if( extension === '.svg' ) svgs.push( img )
	} )

	// If there are no svgs - exit.
	if( ! svgs.length ) return

	const parser = new DOMParser()

	svgs.forEach( svg => {
		// Fetch the file from the server.
		fetch( svg.src )
			.then( response => response.text() )
			.then( text => {
				// Turn the raw text into a document with the svg element in it.
				const parsed = parser.parseFromString( text, 'text/html' )
				// Select the <svg> element from that document.
				const svgTag = parsed.querySelector( 'svg' )

				// If the svg is found, replace the image with the svg.
				if( svgTag ) svg.replaceWith( svgTag )
			} )
	} )
}

/**
 * Set variable for disableScrollLock.
 *
 * @param	{String}	elementId	Specific element ID.
 * @returns	{Boolean}				True if element is set, false if not.
 */
export const setTargetElement = elementId => {
	targetElement = document.querySelector( elementId )

	if( ! targetElement ) return false

	return true
}

/**
 * Get element for disableScrollLock.
 *
 * @returns targetElement value.
 */
export const getTargetElement = () => {
	return targetElement
}

/**
 * Get AJAX working status: is in work now or not.
 *
 * @returns	{Boolean} AJAX working status.
 */
export const getAjaxStatus = () => ajaxStatus

/**
 * Set AJAX working status: is in work now or not.
 *
 * @param	{Boolean}	state	Working status - true or false.
 * @returns	{Boolean}			True on success, false on failure.
 */
export const setAjaxStatus = state => {
	if( typeof state === 'boolean' ) ajaxStatus = state
	else return false

	return true
}

/**
 * Custom AJAX request.
 *
 * @param	{Object}	formData	Data for fetch body.
 * @returns	{Array}					Reponse data array.
 */
export const bydloAjaxRequest = async formData => {
	let response = await fetch( ajaxUrl, {
		method		: 'post',
		credentials	: 'same-origin',
		body		: formData
	} )
	let data = await response.json()

	return data
}

/**
 * Create loader HTML Object.
 *
 * @returns {HTMLObject}	loader	HTML Object to insert in some block/element.
 */
export const createLoader = () => {
	const loader = document.createElement( 'span' )

	loader.classList.add( 'loader' )
	loader.innerHTML = '<i class="fa-solid fa-circle-notch"></i>'

	return loader
}