(function( window, $ ) {

/**
 * Import JavaScript and Stylesheet articles from any wiki.
 * @author Kyle Florence <kflorence@wikia-inc.com>
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
 * @returns {Array} An array of DOM nodes used for injection.
 */
var importArticle = (function() {
	var baseUri = mw.config.get( 'wgLoadScript' ) + '?',
		defaults = {
			debug: mw.config.get( 'debug' ),
			lang: mw.config.get( 'wgUserLanguage' ),
			mode: 'articles',
			skin: mw.config.get( 'skin' ),
			missingCallback: 'importNotifications.importArticleMissing'
		},
		loaded = {},
		slice = [].slice;

	function log( text ) {
		return $().log( text, 'importArticle' );
	}

	return function() {
		var i, l, module, uri,
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

			if ( mw.config.get('wgContentReviewExtEnabled') ) {
				if ( module.articles.search(/mediawiki:/i) != -1 ) {
					if ( mw.config.get('wgContentReviewTestModeEnabled') ) {
						module.current = mw.config.get('wgScriptsTimestamp');
					} else {
						module.reviewed = mw.config.get('wgReviewedScriptsTimestamp');
					}
				}
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

			uri = baseUri + $.param( module );

			// Make sure we don't load the same URI again
			if ( loaded[ uri ] ) {
				continue;
			}

			loaded[ uri ] = true;

			// Inject request into DOM
			result.push( importMethod( uri ) );
		}

		return result;
	}
}());

/**
 * Notify users about missing user-supplied assets.
 * @author Wladyslaw Bodzek
 * @author Kamil Koterba
 *
 * @param {Array} The names of the missing assets
 */
var importNotifications = (function() {
	var reportMissing = ( $.isArray( window.wgUserGroups )
			&& ( $.inArray( 'staff', window.wgUserGroups ) > -1
			|| $.inArray( 'sysop', window.wgUserGroups ) > -1
			|| $.inArray( 'bureaucrat', window.wgUserGroups ) > -1 ) ),
		missingText = {
			single:  'import-article-missing-single',
			multiple: 'import-article-missing-multiple'
		},
		moreText = {
			single: 'import-article-missing-more-single',
			multiple: 'import-article-missing-more-multiple'
		},
		notJsText = {
			single:  'import-article-not-js-single',
			multiple: 'import-article-not-js-multiple'
		};

	function showBannerNotification(articles, baseText) {
		var missingLength;

		// Don't show notificaton for regular users
		if (!reportMissing) {
			return;
		}

		if (!$.isArray(articles)) {
			articles = [articles];
		}

		// Use BannerNotification to show the error to the user
		if (window.BannerNotification && (missingLength = articles.length)) {
			var moreLength = missingLength - 1,
				baseMessageName = baseText[ missingLength < 2 ? 'single' : 'multiple' ],
				moreMessageName = moreText[ moreLength < 2 ? 'single' : 'multiple'],
				message;

			message = mw.message(baseMessageName).params([
				'"' + articles[0] + '"',
				mw.message(moreMessageName).params([moreLength]).escaped()
			]).escaped();

			$(function () {
				new window.BannerNotification(message, 'error').show();
			});
		}
	}

	function importArticleMissing(missing) {
		showBannerNotification(missing, missingText);
	}

	function importNotJsFailed(missing) {
		showBannerNotification(missing, notJsText);
	}

	return {
		importArticleMissing: importArticleMissing,
		importNotJsFailed: importNotJsFailed
	};
}());


// Exports
window.importArticle = window.importArticles = importArticle;
window.importNotifications = importNotifications;

window.importWikiaScriptPages = function(articles) {
	require(['wikia.importScript'], function(importScript){
		importScript.importWikiaScriptPages(articles);
	});
}

})( this, jQuery );
