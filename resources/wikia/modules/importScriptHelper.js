define('wikia.importScriptHelper', function() {
	'use strict';

	var wikiaDomain = 'wikia.com',
		namespacePrefix = 'MediaWiki',
		externals = {
			'db': 'external',
			'domain': 'url'
		},
		// Functions
		isJsPage, isLocal, isExternal, isExternalDb, isExternalDomain,
		prepareExternalScript, hasWikiaDomain,
		getNamespacePrefix;

	getNamespacePrefix = function() {
		return namespacePrefix;
	};

	isJsPage = function(scriptName) {
		return scriptName.substr(scriptName.length - 3) === '.js';
	};

	isLocal = function(scriptName) {
		return scriptName.indexOf(':') === -1;
	};

	isExternal = function(scriptName) {
		var externalParts = scriptName.split(':');

		return scriptName.indexOf(':') !== -1 && externalParts.length === 3
			&& ( isExternalDb(externalParts[0]) || isExternalDomain(externalParts[0], externalParts[1]) );
	};

	isExternalDb = function(prefix) {
		return prefix === externals.db;
	};

	isExternalDomain = function(prefix, domain) {
		return prefix === externals.domain && hasWikiaDomain(domain);
	};

	hasWikiaDomain = function(scriptName) {
		if (scriptName.indexOf('.') !== -1) {
			return scriptName.substr(scriptName.length - wikiaDomain.length) === wikiaDomain;
		}
		return true;
	};

	prepareExternalScript = function(scriptName) {
		var externalParts = scriptName.split(':');

		externalParts.splice(2, 0, namespacePrefix);

		return externalParts.join(':');
	};

	return {
		getNamespacePrefix: getNamespacePrefix,
		isJsPage: isJsPage,
		isLocal: isLocal,
		isExternal: isExternal,
		prepareExternalScript: prepareExternalScript
	};
});