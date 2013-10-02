/*!
 * VisualEditor UserInterface Frame class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface iframe abstraction.
 *
 * @class
 * @extends ve.Element
 * @mixins ve.EventEmitter
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.Frame = function VeUiFrame( config ) {
	// Parent constructor
	ve.Element.call( this, config );

	// Mixin constructors
	ve.EventEmitter.call( this );

	// Properties
	this.initialized = false;
	this.config = config;

	// Initialize
	this.$
		.addClass( 've-ui-frame' )
		.attr( { 'frameborder': 0, 'scrolling': 'no' } );

};

/* Inheritance */

ve.inheritClass( ve.ui.Frame, ve.Element );

ve.mixinClass( ve.ui.Frame, ve.EventEmitter );

/* Static Properties */

ve.ui.Frame.static.tagName = 'iframe';

/* Events */

/**
 * @event initialize
 */

/* Methods */

/**
 * Load the frame contents.
 *
 * Once the iframe's stylesheets are loaded, the `initialize` event will be emitted.
 *
 * Sounds simple right? Read on...
 *
 * When you create a dynamic iframe using open/write/close, the window.load event for the
 * iframe is triggered when you call close, and there's no further load event to indicate that
 * everything is actually loaded.
 *
 * By dynamically adding stylesheet links, we can detect when each link is loaded by testing if we
 * have access to each of their `sheet.cssRules` properties. Every 10ms we poll to see if we have
 * access to the style's `sheet.cssRules` property yet.
 *
 * However, because of security issues, we never have such access if the stylesheet came from a
 * different site. Thus, we are left with linking to the stylesheets through a style element with
 * multiple `@import` statements - which ends up being simpler anyway. Since we created that style,
 * we always have access, and its contents are only available when everything is done loading.
 *
 * @emits initialize
 */
ve.ui.Frame.prototype.load = function () {
	var win = this.$.prop( 'contentWindow' ),
		doc = win.document;

	// Figure out directionality:
	this.dir = this.$.closest( '[dir]' ).prop( 'dir' ) || 'ltr';

	// Initialize contents
	doc.open();
	doc.write(
		'<!doctype html>' +
		'<html>' +
			'<body class="ve-ui-frame-body ve-' + this.dir + '" style="direction:' + this.dir + ';" dir="' + this.dir + '">' +
				'<div class="ve-ui-frame-content"></div>' +
			'</body>' +
		'</html>'
	);
	doc.close();

	// Properties
	this.$$ = ve.Element.get$$( doc, this );
	this.$content = this.$$( '.ve-ui-frame-content' );
	this.$document = this.$$( doc );

	this.transplantStyles();
	this.initialized = true;
	this.emit( 'initialize' );
};

/**
 * Transplant the CSS styles from the frame's parent document to the frame's document.
 *
 * This loops over the style sheets in the parent document, and copies their tags to the
 * frame's document. `<link>` tags pointing to same-origin style sheets are inlined as `<style>` tags;
 * `<link>` tags pointing to foreign URLs and `<style>` tags are copied verbatim.
 */
ve.ui.Frame.prototype.transplantStyles = function () {
	var i, ilen, j, jlen, sheet, rules, cssText, styleNode,
		newDoc = this.$document[0],
		parentDoc = this.getElementDocument();
	for ( i = 0, ilen = parentDoc.styleSheets.length; i < ilen; i++ ) {
		sheet = parentDoc.styleSheets[i];
		styleNode = undefined;
		try {
			rules = sheet.cssRules;
		} catch ( e ) { }
		if ( sheet.ownerNode.nodeName.toLowerCase() === 'link' && rules ) {
			// This is a <link> tag pointing to a same-origin style sheet. Rebuild it as a
			// <style> tag. This needs to be in a try-catch because it sometimes fails in Firefox.
			try {
				cssText = '';
				for ( j = 0, jlen = rules.length; j < jlen; j++ ) {
					if ( typeof rules[j].cssText !== 'string' ) {
						// WTF; abort and fall back to cloning the node
						throw new Error( 'sheet.cssRules[' + j + '].cssText is not a string' );
					}
					cssText += rules[j].cssText + '\n';
				}
				cssText += '/* Transplanted styles from ' + sheet.href + ' */\n';
				styleNode = newDoc.createElement( 'style' );
				styleNode.textContent = cssText;
			} catch ( e ) {
				styleNode = undefined;
			}
		}
		if ( !styleNode ) {
			// It's either a <style> tag or a <link> tag pointing to a foreign URL; just copy
			// it to the new document
			styleNode = newDoc.importNode( sheet.ownerNode, true );
		}
		newDoc.body.appendChild( styleNode );
	}
};

/**
 * Run a callback as soon as the frame has been initialized.
 *
 * @param {Function} callback
 */
ve.ui.Frame.prototype.run = function ( callback ) {
	if ( this.initialized ) {
		callback();
	} else {
		this.once( 'initialize', callback );
	}
};

/**
 * Sets the size of the frame.
 *
 * @method
 * @param {number} width Frame width in pixels
 * @param {number} height Frame height in pixels
 * @chainable
 */
ve.ui.Frame.prototype.setSize = function ( width, height ) {
	this.$.css( { 'width': width, 'height': height } );
	return this;
};
