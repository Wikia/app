/*
 * General token sanitizer. Strips out (or encapsulates) unsafe and disallowed
 * tag types and attributes. Should run last in the third, synchronous
 * expansion stage. Tokens from extensions which should not be sanitized
 * can bypass sanitation by setting their rank to 3.
 *
 * @author Gabriel Wicke <gwicke@wikimedia.org>
 */

// Include general utilities
var Util = require('./ext.Util.js').Util,
	u = new Util();


function Sanitizer ( manager ) {
	this.manager = manager;
	this.register( manager );
}

// constants
Sanitizer.prototype.handledRank = 2.99;
Sanitizer.prototype.anyRank = 2.9901;


// Register this transformer with the TokenTransformer
Sanitizer.prototype.register = function ( manager ) {
	this.manager = manager;
	manager.addTransform( this.onAnchor.bind(this), this.handledRank, 'tag', 'a' );
};

Sanitizer.prototype.onAnchor = function ( token ) {
	// perform something similar to Sanitizer::cleanUrl
	if ( token.constructor === EndTagTk ) {
		return { token: token };
	}
	var hrefKV = this.manager.env.lookupKV( token.attribs, 'href' );
	// FIXME: Should the flattening of attributes to text be performed as part
	// of the AttributeTransformManager processing? This certainly is not the
	// right place!
	if ( hrefKV !== null ) {
		hrefKV.v = this.manager.env.tokensToString( hrefKV.v );
		var bits = hrefKV.v.match( /(.*?\/\/)([^\/]+)(\/?.*)/ );
		if ( bits ) {
			proto = bits[1];
			host = bits[2];
			path = bits[3];
		} else {
			proto = '';
			host = '';
			path = hrefKV.v;
		}
		host = this._stripIDNs( host );
		hrefKV.v = proto + host + path;
	}
	return { token: token };
};

// XXX: We actually need to strip IDN ignored characters in the link text as
// well, so that readers are not mislead. This should perhaps happen at an
// earlier stage, while converting links to html.
Sanitizer.prototype._IDNRegexp = new RegExp(
		"[\t ]|" +  // general whitespace
		"\u00ad|" + // 00ad SOFT HYPHEN
		"\u1806|" + // 1806 MONGOLIAN TODO SOFT HYPHEN
		"\u200b|" + // 200b ZERO WIDTH SPACE
		"\u2060|" + // 2060 WORD JOINER
		"\ufeff|" + // feff ZERO WIDTH NO-BREAK SPACE
		"\u034f|" + // 034f COMBINING GRAPHEME JOINER
		"\u180b|" + // 180b MONGOLIAN FREE VARIATION SELECTOR ONE
		"\u180c|" + // 180c MONGOLIAN FREE VARIATION SELECTOR TWO
		"\u180d|" + // 180d MONGOLIAN FREE VARIATION SELECTOR THREE
		"\u200c|" + // 200c ZERO WIDTH NON-JOINER
		"\u200d|" + // 200d ZERO WIDTH JOINER
		"[\ufe00-\ufe0f]" // fe00-fe0f VARIATION SELECTOR-1-16
		, 'g' 
		);

Sanitizer.prototype._stripIDNs = function ( host ) {
	return host.replace( this._IDNRegexp, '' );
};
	
	


if (typeof module == "object") {
	module.exports.Sanitizer = Sanitizer;
}
