define(
	'ext.createNewWiki.helper',
	['wikia.stringhelper', 'AuthModal', 'wikia.querystring'],
	function (stringHelper, auth, qs) {
		function sanitizeWikiName(wikiName) {
			return $.trim(stringHelper.latinise(wikiName).replace(/[^a-zA-Z0-9 ]+/g, '')).replace(/ +/g, '-');
		}

		function getAnswer() {
			var keys = WikiBuilderCfg['cnw-keys'],
				v = 0,
				i;

			for (i = 0; i < keys.length; i++) {
				v *= (i % 5) + 1;
				v += keys[i];
			}
			return v;
		}

		function login(onSuccess, redirectURL) {
			auth.load({
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
			getAnswer: getAnswer,
			login: login,
			getLoginRedirectURL: getLoginRedirectURL
		}
	}
);
