(function( window, $ ) {

var baseUri = mw.config.get( 'wgLoadScript' ) + '?=',
	defaults = {
		lang: mw.config.get( 'wgUserLanguage' ),
		mode: 'articles',
		skin: mw.config.get( 'skin' )
	},
	slice = [].slice;

function log( text ) {
	return $().log( text, 'importArticle' );
}

/**
 * Import JavaScript and Stylesheet articles from any wiki.
 *
 * >> Examples:
 *
 * // Importing a single Stylesheet from the local wiki
 * importArticle({
 *     type: "style",
 *     article: "Mediawiki:MyCustomStyles.css"
 * });
 *
 * // Importing multiple JavaScript files from an external wiki
 * importArticles({
 *     type: "script",
 *     articles: [
 *         "Mediawiki:MyCustomJavaScript.js",
 *         "w:starwars:Mediawiki:External.js"
 *     ]
 * });
 *
 * @param {...Object} Any number of modules to load.
 *
 * @returns {Array} An array of DOM nodes used to inject the
 *                  content into the page.
 *
 * @author Kyle Florence <kflorence@wikia-inc.com>
 */
var importArticle = function() {
	var i, l, module,
		modules = slice.call(arguments),
		result = [];

	for ( i = 0, l = modules.length; i < l; i++ ) {
		module = $.extend( {}, defaults, modules[ i ] );

		// Resource loader expects "articles" param
		module.articles = module.article || module.articles;
		delete module.article;

		if ( !module.articles || !module.articles.length ) {
			log( 'Missing required argument: articles' );
			continue;
		}

		// Resource loader expects pipe separated article names
		if ( $.isArray( module.articles ) ) {
			module.articles = module.articles.join( '|' );
		}

		// These import methods are in /skins/common/wikibits.js
		var importMethod;
		if ( module.type == 'script' ) {
			importMethod = window.importScriptURI;

		} else if ( module.type == 'style' ) {
			importMethod = window.importStylesheetURI;
		}

		if ( !importMethod ) {
			log( 'Invalid article type: ' + ( module.type || '(none provided)' ) );
			continue;
		}

		// Resource loader expects "only" param instead of "type"
		module.only = module.type + 's';
		delete module.type;

		result.push( importMethod( baseUri + $.param( module ) ) );
	}

	return result;
};

// Exports
window.importArticle = window.importArticles = importArticle;

})( this, jQuery );