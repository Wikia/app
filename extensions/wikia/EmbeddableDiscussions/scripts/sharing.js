/**
 * Functionality for social network sharing for Embeddable Discussions extension
 */
define('EmbeddableDiscussionsSharing',
	['jquery'],
	function ($) {
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

		function getShareUrl(network, sharedUrl, sharedTitle) {
			switch (network) {
				case 'meneame':
					return 'https://www.meneame.net/submit.php' +
						'?url=' + encodeURIComponent(sharedUrl);
				case 'wykop':
					return 'http://www.wykop.pl/dodaj/link/' +
						'?url=' + encodeURIComponent(sharedUrl) +
						'&title=' + encodeURIComponent(sharedTitle);
				case 'nk':
					return 'http://nk.pl/sledzik?shout=' + encodeURIComponent(sharedUrl);
				case 'odnoklassniki':
					return 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1' +
						'&st._surl=' + encodeURIComponent(sharedUrl);
				case 'vkontakte':
					return 'http://vk.com/share.php?url=' + encodeURIComponent(sharedUrl) +
						'&title=' + encodeURIComponent(sharedTitle);
				case 'weibo':
					return 'http://service.weibo.com/share/share.php' +
						'?url=' + encodeURIComponent(sharedUrl) +
						'&title=' + encodeURIComponent(sharedTitle);
				case 'tumblr':
					return 'http://www.tumblr.com/share/link' +
						'?url=' + encodeURIComponent(sharedUrl) +
						'&name=' + encodeURIComponent(sharedTitle);
				case 'reddit':
					return 'http://www.reddit.com/submit' +
						'?url=' + encodeURIComponent(sharedUrl) +
						'&title=' + encodeURIComponent(sharedTitle);
				case 'google':
					return 'https://plus.google.com/share?url=' + encodeURIComponent(sharedUrl);
				case 'twitter':
					return 'https://twitter.com/share?url=' + encodeURIComponent(sharedUrl);
				case 'facebook':
					return 'http://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(sharedUrl);
				case 'line':
					return 'http://line.me/R/msg/text/?' +
						encodeURIComponent(sharedTitle + ' ' + sharedUrl);
				default:
					return '';
			}
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
		}
	}
);
