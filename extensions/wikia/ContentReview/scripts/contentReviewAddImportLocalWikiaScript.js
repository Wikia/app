/**
 * Adds a method to window object for importing wikia local scripts
 */
require(['wikia.window'], function (window) {
	'use strict';
	/**
	 * Imports script from provided JS page in MediaWiki namespace
	 * @param {string} scriptName Name of page without namespace prefix
	 */
	window.importLocalWikiaScript = function (scriptName) {
		if (!isJsPage(scriptName)) {
			console.log('Cannot import MediaWiki:' + scriptName + '. Provided text is not valid JS page name.');
			return;
		}
		window.importArticles({
			type: 'script',
			articles: [
				'MediaWiki:' + scriptName,
			]
		});
	};

	function isJsPage (scriptName) {
		return scriptName.substr(scriptName.length - 3) === '.js';
	}
});
