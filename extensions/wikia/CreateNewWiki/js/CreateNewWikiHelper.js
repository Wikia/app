define(
	'ext.createNewWiki.helper',
	['wikia.stringhelper', 'wikia.querystring'],
	function (stringHelper, qs) {
		function sanitizeWikiName(wikiName) {
			return $.trim(stringHelper.latinise(wikiName).replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
		}

		function login(onSuccess, redirectURL) {
			window.location = redirectURL;
		}

		function getLoginRedirectURL(wikiName, wikiDomain, wikiLanguage) {
			var redirectUrl = new qs();

			redirectUrl.setVal({
				wikiName: wikiName,
				wikiDomain: wikiDomain,
				wikiLanguage: wikiLanguage
			});

			return window.wgScriptPath + '/register?redirect=' + encodeURIComponent(redirectUrl.toString());
		}

		return {
			sanitizeWikiName: sanitizeWikiName,
			login: login,
			getLoginRedirectURL: getLoginRedirectURL
		}
	}
);
