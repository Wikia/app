define('wikia.importScriptHelper', function() {
	'use strict';

	var wikiaDomain = '.wikia.com',
		namespacePrefix = 'MediaWiki',
		externals = {
			'db': 'external',
			'domain': 'url'
		};

	function getNamespacePrefix() {
		return namespacePrefix;
	}

	function isJsPage(scriptName) {
		return scriptName.substr(scriptName.length - 3) === '.js';
	}

	function isLocal(scriptName) {
		return scriptName.indexOf(':') === -1;
	}

	function isExternal(scriptName) {
		var externalParts = scriptName.split(':');

		return scriptName.indexOf(':') !== -1 && externalParts.length === 3
			&& ( isExternalDb(externalParts[0]) || isExternalDomain(externalParts[0], externalParts[1]) );
	}

	function isExternalDb(prefix) {
		return prefix === externals.db;
	}

	function isExternalDomain(prefix, domain) {
		return prefix === externals.domain && hasWikiaDomain(domain);
	}

	function hasWikiaDomain(scriptName) {
		if (scriptName.indexOf('.') !== -1) {
			return scriptName.substr(scriptName.length - wikiaDomain.length) === wikiaDomain;
		}
		return true;
	}

	function prepareExternalScript(scriptName) {
		var externalParts = scriptName.split(':');

		externalParts.splice(2, 0, namespacePrefix);

		return externalParts.join(':');
	}

	return {
		getNamespacePrefix: getNamespacePrefix,
		isJsPage: isJsPage,
		isLocal: isLocal,
		isExternal: isExternal,
		prepareExternalScript: prepareExternalScript
	};
});
