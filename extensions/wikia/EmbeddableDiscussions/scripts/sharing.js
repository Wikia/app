/**
 * Functionality for social network sharing for Embeddable Discussions extension
 */
define('EmbeddableDiscussionsSharing',
	function () {
		'use strict';

		var socialNetworks = {
			en: [
				'facebook',
				'twitter',
				'reddit',
				'tumblr'
			],
			ja: [
				'facebook',
				'twitter',
				'google',
				'line'
			],
			'pt-br': [
				'facebook',
				'twitter',
				'reddit',
				'tumblr'
			],
			zh: [
				'facebook',
				'weibo'
			],
			de: [
				'facebook',
				'twitter',
				'tumblr'
			],
			fr: [
				'facebook',
				'twitter'
			],
			es: [
				'facebook',
				'twitter',
				'meneame',
				'tumblr'
			],
			ru: [
				'vkontakte',
				'facebook',
				'odnoklassniki',
				'twitter'
			],
			pl: [
				'facebook',
				'twitter',
				'nk',
				'wykop'
			]
		};

		var socialNetworkUrls = {
			'meneame': 'https://www.meneame.net/submit.php?url=URL',
			'wykop': 'http://www.wykop.pl/dodaj/link/?url=URL&title=TITLE',
			'nk': 'http://nk.pl/sledzik?shout=URL',
			'odnoklassniki': 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=URL',
			'vkontakte': 'http://vk.com/share.php?url=URL&title=TITLE',
			'weibo': 'http://service.weibo.com/share/share.php?url=URL&title=TITLE',
			'tumblr': 'http://www.tumblr.com/share/link?url=URL&name=TITLE',
			'reddit': 'http://www.reddit.com/submit?url=URL&title=TITLE',
			'google': 'https://plus.google.com/share?url=URL',
			'twitter': 'https://twitter.com/share?url=URL',
			'facebook': 'http://www.facebook.com/sharer/sharer.php?u=URL',
			'line': 'http://line.me/R/msg/text/?URL TITLE',
		};

		function getShareUrl(network, sharedUrl, sharedTitle) {
			if (socialNetworkUrls[network]) {
				return socialNetworkUrls[network].replace('URL', encodeURIComponent(sharedUrl))
				  .replace('TITLE', encodeURIComponent(sharedTitle));
			}

			return '';
		}

		function getNetworks(lang) {
			if (typeof(socialNetworks[lang]) === 'undefined') {
				return socialNetworks['en'];
			}

			return socialNetworks[lang];
		}

		function getData(lang, sharedUrl, sharedTitle) {
			var networks = getNetworks(lang),
				i,
				network,
				ret = [];

			for (i in networks) {
				network = networks[i];

				ret.push({
					url: getShareUrl(network, sharedUrl, sharedTitle),
					icon: network,
				})
			}

			return ret;
		}

		return {
			getData: getData,
		};
	}
);
