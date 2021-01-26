import { bidders, context, utils } from '@wikia/ad-engine';

const MAX_NUMBER_OF_CATEGORIES = 3;

function decodeLegacyDartParams(dartString) {
	const params = {};

	if (typeof dartString === 'string') {
		dartString.split(';').forEach((kv) => {
			const pair = kv.split('=');
			const key = pair[0];
			const value = pair[1];

			if (key && value && key !== 'esrb') {
				params[key] = params[key] || [];
				params[key].push(value);
			}
		});
	}

	return params;
}

function getVideoStatus() {
	if (context.get('wiki.targeting.hasFeaturedVideo')) {
		// Comparing with false in order to make sure that API already responds with "isDedicatedForArticle" flag
		const isDedicatedForArticle = context.get('wiki.targeting.featuredVideo.isDedicatedForArticle') !== false;
		const bridgeVideoPlayed = !isDedicatedForArticle && window.canPlayVideo && window.canPlayVideo();

		return {
			isDedicatedForArticle,
			hasVideoOnPage: isDedicatedForArticle || bridgeVideoPlayed,
		};
	}

	return {};
}

function getAdLayout(targeting) {
	let layout = targeting.pageType || 'article';

	if (layout === 'article') {
		const videoStatus = getVideoStatus();
		if (!!videoStatus.hasVideoOnPage) {
			const videoPrefix = videoStatus.isDedicatedForArticle ? 'fv' : 'wv';

			layout = `${videoPrefix}-${layout}`;
		}

		if (context.get('custom.hasIncontentPlayer')) {
			layout = `${layout}-ic`;
		}
	}

	return layout;
}

function getAbExperiments() {
	const abTest = window.Wikia && window.Wikia.AbTest;
	const groups = [];

	if (abTest) {
		abTest.getExperiments().forEach((experiment) => {
			groups.push(`${experiment.id}_${experiment.group.id}`);
		});
	}

	return groups;
}

function getDomain() {
	const hostname = window.location.hostname.toLowerCase();
	const pieces = hostname.split('.');
	const np = pieces.length;

	let domain = '';

	if (pieces[np - 2] === 'co') {
		// .co.uk or .co.jp
		domain = `${pieces[np - 3]}.${pieces[np - 2]}.${pieces[np - 1]}`;
	} else {
		domain = `${pieces[np - 2]}.${pieces[np - 1]}`;
	}

	return domain.replace(/\./g, '');
}

function getHostnamePrefix() {
	const hostname = window.location.hostname.toLowerCase();
	const match = /(^|.)(showcase|externaltest|preview|verify|stable|sandbox-[^.]+)\./.exec(hostname);

	if (match && match.length > 2) {
		return match[2];
	}

	const pieces = hostname.split('.');

	if (pieces.length) {
		return pieces[0];
	}

	return undefined;
}

function getPageCategories(adsContext) {
	if (!adsContext.targeting.enablePageCategories || !window.wgCategories) {
		return undefined;
	}

	const categories = window.wgCategories;
	let outCategories;

	if (categories && categories.length > 0) {
		outCategories = categories.slice(0, MAX_NUMBER_OF_CATEGORIES);

		return outCategories.join('|').toLowerCase().replace(/ /g, '_').split('|');
	}

	return undefined;
}

function getRawDbName(adsContext) {
	return `_${adsContext.targeting.wikiDbName || 'wikia'}`.replace('/[^0-9A-Z_a-z]/', '_');
}

function getRefParam() {
	const ref = document.referrer;
	const searchDomains = /(google|search\.yahooo|bing|baidu|ask|yandex)/;
	const wikiDomains = [
		'wikia.com', 'fandom.com', 'wikia.org', 'ffxiclopedia.org',
		'jedipedia.de', 'memory-alpha.org', 'websitewiki.de',
		'wowwiki.com', 'yoyowiki.org',
	];
	const wikiDomainsRegex = new RegExp(`(^|\\.)(${wikiDomains.join('|').replace(/\./g, '\\.')})$`);

	let hostnameMatch;
	let refHostname;

	if (!ref || typeof ref !== 'string') {
		return 'direct';
	}

	refHostname = ref.match(/\/\/([^/]+)\//);

	if (refHostname) {
		refHostname = refHostname[1];
	}

	hostnameMatch = refHostname === window.location.hostname;

	if (hostnameMatch && (ref.indexOf('search=') > -1 || ref.indexOf('query=') > -1)) {
		return 'wiki_search';
	}
	if (hostnameMatch) {
		return 'wiki';
	}

	hostnameMatch = wikiDomainsRegex.test(refHostname);

	if (hostnameMatch && (ref.indexOf('search=') > -1 || ref.indexOf('query=') > -1 || ref.indexOf('s=') > -1)) {
		return 'wikia_search';
	}

	if (hostnameMatch) {
		return 'wikia';
	}

	if (searchDomains.test(refHostname)) {
		return 'external_search';
	}

	return 'external';
}

function getZone(adsContext) {
	if (adsContext.targeting.pageIsHub) {
		return {
			site: 'hub',
			name: `_${adsContext.targeting.mappedVerticalName}_hub`,
			pageType: 'hub',
		};
	}

	return {
		site: adsContext.targeting.mappedVerticalName,
		name: getRawDbName(adsContext),
		pageType: getAdLayout(adsContext.targeting),
	};
}

export default {
	getVideoStatus,
	getPageLevelTargeting(adsContext = {}) {
		const zone = getZone(adsContext);
		const legacyParams = decodeLegacyDartParams(adsContext.targeting.wikiCustomKeyValues);

		const targeting = {
			s0: zone.site,
			s0v: adsContext.targeting.wikiVertical,
			s0c: adsContext.targeting.newWikiCategories,
			s1: zone.name,
			s2: zone.pageType,
			ab: getAbExperiments(),
			ar: window.innerWidth > window.innerHeight ? '4:3' : '3:4',
			artid: adsContext.targeting.pageArticleId && adsContext.targeting.pageArticleId.toString(),
			cat: getPageCategories(adsContext),
			dmn: getDomain(),
			hostpre: getHostnamePrefix(),
			kid_wiki: adsContext.targeting.directedAtChildren ? '1' : '0',
			lang: adsContext.targeting.wikiLanguage || 'unknown',
			wpage: adsContext.targeting.pageName && adsContext.targeting.pageName.toLowerCase(),
			ref: getRefParam(),
			esrb: adsContext.targeting.esrbRating,
			geo: utils.geoService.getCountryCode() || 'none'
		};

		if (window.pvNumber) {
			targeting.pv = window.pvNumber.toString();
		}

		const cid = utils.queryString.get('cid');

		if (cid !== undefined) {
			targeting.cid = cid;
		}

		Object.keys(legacyParams).forEach((key) => {
			targeting[key] = legacyParams[key];
		});

		if (adsContext.targeting.wikiIsTop1000) {
			targeting.top = '1k';
		}

		return targeting;
	},

	async getBiddersPrices(slotName, markNotRequestedPrices = true) {
		const realSlotPrices = bidders.getDfpSlotPrices(slotName);
		const currentSlotPrices = await bidders.getCurrentSlotPrices(slotName);

		function transformBidderPrice(bidderName) {
			if (!markNotRequestedPrices) {
				return currentSlotPrices[bidderName];
			}

			if (realSlotPrices && realSlotPrices[bidderName]) {
				return realSlotPrices[bidderName];
			}

			if (currentSlotPrices && currentSlotPrices[bidderName]) {
				return `${currentSlotPrices[bidderName]}not_used`;
			}

			return '';
		}

		return {
			bidder_0: transformBidderPrice('wikia'),
			bidder_1: transformBidderPrice('indexExchange'),
			bidder_2: transformBidderPrice('appnexus'),
			bidder_4: transformBidderPrice('rubicon'),
			bidder_6: transformBidderPrice('aol'),
			bidder_8: transformBidderPrice('wikiaVideo'),
			bidder_9: transformBidderPrice('openx'),
			bidder_10: transformBidderPrice('appnexusAst'),
			bidder_11: transformBidderPrice('rubicon_display'),
			bidder_12: transformBidderPrice('a9'),
			bidder_13: transformBidderPrice('onemobile'),
			bidder_14: transformBidderPrice('pubmatic'),
			bidder_15: transformBidderPrice('beachfront'),
			bidder_17: transformBidderPrice('kargo'),
			bidder_19: transformBidderPrice('gumgum'),
			bidder_20: transformBidderPrice('33across'),
			bidder_21: transformBidderPrice('triplelift'),
			bidder_23: transformBidderPrice('oneVideo'),
			bidder_25: transformBidderPrice('nobid'),
			bidder_26: transformBidderPrice('telaria'),
			bidder_27: transformBidderPrice('mediagrid'),
			bidder_28: transformBidderPrice('verizon'),
		};
	},
};
