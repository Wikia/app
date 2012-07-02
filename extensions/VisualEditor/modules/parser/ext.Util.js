/**
 * General utilities for token transforms
 * XXX: move this to MWParserEnvironment?
 */

function Util () {
}


/**
 * Determine if a token is block-level or not
 *
 * @static
 * @method
 * @param {Object} token: The token to check
 * @returns {Boolean}: True if token is block-level, false otherwise.
 */
Util.prototype.isBlockToken = function ( token ) {
	if ( token.constructor === TagTk || 
			token.constructor === EndTagTk || 
			token.constructor === SelfclosingTagTk ) {
		return this.isBlockTag( token.name.toLowerCase() );
	} else {
		return false;
	}
};

/**
 * Determine if a tag name is block-level or not
 *
 * @static
 * @method
 * @param {String} name: Lower-case tag name
 * @returns {Boolean}: True if tag is block-level, false otherwise.
 */
Util.prototype.isBlockTag = function ( name ) {
	switch ( name ) {
		case 'div':
		case 'table':
		case 'td':
		case 'tr':
		case 'tbody':
		case 'p':
		case 'ul':
		case 'ol':
		case 'li':
		case 'dl':
		case 'dt':
		case 'dd':
		case 'img': // hmm!
		case 'pre':
		case 'center':
		case 'blockquote':
		case 'h1':
		case 'h2':
		case 'h3':
		case 'h4':
		case 'h5':
		case 'h6':
			return true;
		default:
			return false;
	}
};

if (typeof module == "object") {
	module.exports.Util = Util;
}
