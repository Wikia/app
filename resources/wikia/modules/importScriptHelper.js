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

	function isJsPage(resource) {
		return resource.substr(resource.length - 3) === '.js';
	}

	function isLocal(resource) {
		return resource.indexOf(':') === -1;
	}

	function isExternal(resource) {
		var externalParts = resource.split(':');

		return resource.indexOf(':') !== -1 && externalParts.length === 3
			&& (isExternalDb(externalParts[0])
			|| (isExternalDomain(externalParts[0]) && isProperSubdomain(externalParts[1])));
	}

	function isExternalDb(prefix) {
		return prefix === externals.db;
	}

	function isExternalDomain(prefix) {
		return prefix === externals.domain;
	}

	function isProperSubdomain(subdomain) {
		var subdomainParts;

		if (subdomain.indexOf('.') !== -1) {
			if (hasWikiaDomain(subdomain)) {
				return true;
			} else {
				subdomainParts = subdomain.split('.');
				return subdomainParts.length <= 2;
			}
		}

		return true;
	}

	function hasWikiaDomain(subdomain) {
		if (subdomain.indexOf('.') !== -1) {
			return subdomain.substr(subdomain.length - wikiaDomain.length) === wikiaDomain;
		}
		return false;
	}

	function prepareExternalDomain(subdomain) {
		if (hasWikiaDomain(subdomain)) {
			return subdomain
		} else {
			return subdomain + wikiaDomain;
		}
	}

	function prepareExternalScript(resource) {
		var externalParts = resource.split(':');

		if (isExternalDomain(externalParts[0])) {
			externalParts[1] = prepareExternalDomain(externalParts[1]);
		}

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
