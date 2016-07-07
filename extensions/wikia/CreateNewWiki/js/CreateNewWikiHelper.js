define(
	'ext.createNewWiki.helper',
	['wikia.stringhelper', 'wikia.querystring'],
	function (stringHelper, qs) {
		function sanitizeWikiName(wikiName) {
			return $.trim(stringHelper.latinise(wikiName).replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
		}

		function login(onSuccess, redirectURL) {
			window.wikiaAuthModal.load({
				forceLogin: true,
				url: redirectURL,
				origin: 'create-new-wikia',
				onAuthSuccess: onSuccess
			});
		}

		function getLoginRedirectURL(wikiName, wikiDomain, wikiLanguage) {
			var redirectUrl = new qs();

			redirectUrl.setVal({
				wikiName: wikiName,
				wikiDomain: wikiDomain,
				wikiLanguage: wikiLanguage
			});

			return '/signin?redirect=' + encodeURIComponent(redirectUrl.toString());
		}

		return {
			sanitizeWikiName: sanitizeWikiName,
			login: login,
			getLoginRedirectURL: getLoginRedirectURL
		}
	}
);
