define('wikia.importScript', ['wikia.importScriptHelper', 'wikia.window'], function(importScriptHelper, window) {
	'use strict';

	/**
	 * Imports script from provided JS page name
	 * Page has to be in MediaWiki namespace and has .js extension
	 *
	 * Article name can point a page on other wikia by db name
	 * (e.g. 'external:otherwikiadatabasename:Pagename.js')
	 *
	 * or by subdomain or host
	 * (e.g. 'url:otherwikiasubdomain:Pagename.js')
	 * (e.g. 'url:otherwikiasubdomain.wikia.com:Pagename.js')
	 *
	 * @param {array} articles Names of pages to import without namespace prefix
	 */
	function importWikiaScriptPages(articles) {
		var articlesToImport = [],
			articlesFailed = [],
			scriptName;

		if (!$.isArray(articles)) {
			articles = [articles];
		}

		for (var i = 0; i < articles.length; i++) {
			if (!importScriptHelper.isJsPage(articles[i])) {
				articlesFailed.push(importScriptHelper.getNamespacePrefix() + ':' + articles[i]);
				continue;
			}
			if (importScriptHelper.isLocal(articles[i])) {
				articlesToImport.push(importScriptHelper.getNamespacePrefix() + ':' + articles[i]);
			} else if (importScriptHelper.isExternal(articles[i])) {
				scriptName = importScriptHelper.prepareExternalScript(articles[i]);
				articlesToImport.push(scriptName);
			} else {
				articlesFailed.push(articles[i]);
			}
		}

		window.importNotifications.importNotJsFailed(articlesFailed);

		window.importArticles({
			type: 'script',
			articles: articlesToImport
		});
	}

	return {
		importWikiaScriptPages: importWikiaScriptPages
	};
});
