/**
 * Adds a method to window object for importing wikia local scripts
 */
require(['wikia.window'], function (window) {
	'use strict';
	/**
	 * Imports script from provided JS page in MediaWiki namespace
	 * @param {string} scriptName Name of page without namespace prefix
	 */
	window.importWikiaScriptPage = function (articles, server) {

		for (var i = 0; i < articles.length; i++) {
			if (!isJsPage(articles[i])) {
				console.log('Cannot import MediaWiki:' + articles[i] + '. Provided text is not valid JS page name.');
				return;
			}
			articles[i] = 'MediaWiki:' + articles[i];
		}

		window.importArticles({
			type: 'script',
			articles: articles,
			server: server
		});
	};

	function isJsPage (scriptName) {
		return scriptName.substr(scriptName.length - 3) === '.js';
	}
});
