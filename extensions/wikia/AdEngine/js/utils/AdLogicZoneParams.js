/*global define*/
define('ext.wikia.adEngine.utils.adLogicZoneParams', [
	'ext.wikia.adEngine.adContext',
	'wikia.log',
	'wikia.location'
], function (adContext, log, loc) {
	'use strict';

	var calculated = false,
		context = {},
		hostname = loc.hostname,
		logGroup = 'ext.wikia.adEngine.utils.adLogicZoneParams',
		maxNumberOfCategories = 3,
		site,
		zone1,
		zone2;

	function updateContext() {
		context = adContext.getContext();
		calculated = false;
	}

	function getDomain() {
		var lhost, pieces, sld = '', np;
		lhost = hostname.toLowerCase();

		pieces = lhost.split('.');
		np = pieces.length;

		if (pieces[np - 2] === 'co') {
			// .co.uk or .co.jp
			sld = pieces[np - 3] + '.' + pieces[np - 2] + '.' + pieces[np - 1];
		} else {
			sld = pieces[np - 2] + '.' + pieces[np - 1];
		}

		return sld.replace(/\./g, '');
	}

	function getHostnamePrefix() {
		var lhost = hostname.toLowerCase(),
			match = /(^|\.)(showcase|externaltest|preview|verify|stable|sandbox-[^\.]+)\./.exec(lhost);

		if (match && match.length > 2) {
			return match[2];
		}

		var pieces = lhost.split('.');

		if (pieces.length) {
			return pieces[0];
		}
	}

	function getVerticalName(targeting) {
		if (getHostnamePrefix() === 'showcase' || context.opts.showcase === true) {
			return 'showcase';
		}

		return targeting.mappedVerticalName;
	}

	function getRawDbName() {
		return '_' + (context.targeting.wikiDbName || 'wikia').replace('/[^0-9A-Z_a-z]/', '_');
	}

	function getAdLayout(params) {
		var layout = params.pageType || 'article';

		if (layout === 'article' && context.targeting.hasFeaturedVideo) {
			layout = 'fv-' + layout;
		}

		return layout;
	}

	function calculateParams() {
		log('calculateParams', 'info', logGroup);
		var mappedVertical = getVerticalName(context.targeting);

		if (context.targeting.pageIsHub) {
			site = 'hub';
			zone1 = '_' + mappedVertical + '_hub';
			zone2 = 'hub';
		} else {
			site = mappedVertical;
			zone1 = getRawDbName();
			zone2 = getAdLayout(context.targeting);
		}
		calculated = true;
		log(['calculateParams', site, zone1, zone2], 'info', logGroup);
	}

	function getSite() {
		if (!calculated) {
			calculateParams();
		}

		return site;
	}

	function getName() {
		if (!calculated) {
			calculateParams();
		}

		return zone1;
	}

	function getPageType() {
		if (!calculated) {
			calculateParams();
		}

		return zone2;
	}

	function getVertical() {
		return context.targeting.wikiVertical;
	}

	function getPageCategories() {
		var categories = context.targeting.pageCategories,
			outCategories;

		if (categories instanceof Array && categories.length > 0) {
			outCategories = categories.slice(0, maxNumberOfCategories);
			return outCategories.join('|').toLowerCase().replace(/ /g, '_').split('|');
		}
	}

	function getLanguage() {
		return context.targeting.wikiLanguage || 'unknown';
	}

	function getWikiCategories() {
		return context.targeting.newWikiCategories;
	}

	updateContext();
	adContext.addCallback(updateContext);

	return {
		getDomain: getDomain,
		getHostnamePrefix: getHostnamePrefix,
		getSite: getSite,
		getName: getName,
		getPageType: getPageType,
		getVertical: getVertical,
		getPageCategories: getPageCategories,
		getWikiCategories: getWikiCategories,
		getLanguage: getLanguage,
		getRawDbName: getRawDbName
	};
});
