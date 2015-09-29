(function (context) {
	'use strict';

	function facebookLocale() {
		/** https://www.facebook.com/translations/FacebookLocales.xml
		 *  Note: only one code per language is used since proper country cannot be reliably retrieved. **/
		var codes = {
			'af': 'ZA',
			'ak': 'GH',
			'am': 'ET',
			'ar': 'AR',
			'as': 'IN',
			'ay': 'BO',
			'az': 'AZ',
			'be': 'BY',
			'bg': 'BG',
			'bn': 'IN',
			'br': 'FR',
			'bs': 'BA',
			'ca': 'ES',
			'cb': 'IQ',
			'ck': 'US',
			'co': 'FR',
			'cs': 'CZ',
			'cx': 'PH',
			'cy': 'GB',
			'da': 'DK',
			'de': 'DE',
			'el': 'GR',
			'en': 'US',
			'eo': 'EO',
			'es': 'ES',
			'et': 'EE',
			'eu': 'ES',
			'fa': 'IR',
			'fb': 'LT',
			'ff': 'NG',
			'fi': 'FI',
			'fo': 'FO',
			'fr': 'FR',
			'fy': 'NL',
			'ga': 'IE',
			'gl': 'ES',
			'gn': 'PY',
			'gu': 'IN',
			'gx': 'GR',
			'ha': 'NG',
			'he': 'IL',
			'hi': 'IN',
			'hr': 'HR',
			'hu': 'HU',
			'hy': 'AM',
			'id': 'ID',
			'ig': 'NG',
			'is': 'IS',
			'it': 'IT',
			'ja': 'JP',
			'jv': 'ID',
			'ka': 'GE',
			'kk': 'KZ',
			'km': 'KH',
			'kn': 'IN',
			'ko': 'KR',
			'ku': 'TR',
			'la': 'VA',
			'lg': 'UG',
			'li': 'NL',
			'ln': 'CD',
			'lo': 'LA',
			'lt': 'LT',
			'lv': 'LV',
			'mg': 'MG',
			'mk': 'MK',
			'ml': 'IN',
			'mn': 'MN',
			'mr': 'IN',
			'ms': 'MY',
			'mt': 'MT',
			'my': 'MM',
			'nb': 'NO',
			'nd': 'ZW',
			'ne': 'NP',
			'nl': 'NL',
			'nn': 'NO',
			'ny': 'MW',
			'or': 'IN',
			'pa': 'IN',
			'pl': 'PL',
			'ps': 'AF',
			'pt': 'PT',
			'qu': 'PE',
			'rm': 'CH',
			'ro': 'RO',
			'ru': 'RU',
			'rw': 'RW',
			'sa': 'IN',
			'sc': 'IT',
			'se': 'NO',
			'si': 'LK',
			'sk': 'SK',
			'sl': 'SI',
			'sn': 'ZW',
			'so': 'SO',
			'sq': 'AL',
			'sr': 'RS',
			'sv': 'SE',
			'sw': 'KE',
			'sy': 'SY',
			'sz': 'PL',
			'ta': 'IN',
			'te': 'IN',
			'tg': 'TJ',
			'th': 'TH',
			'tk': 'TM',
			'tl': 'PH',
			'tr': 'TR',
			'tt': 'RU',
			'tz': 'MA',
			'uk': 'UA',
			'ur': 'PK',
			'uz': 'UZ',
			'vi': 'VN',
			'wo': 'SN',
			'xh': 'ZA',
			'yi': 'DE',
			'yo': 'NG',
			'zh': 'CN',
			'zu': 'ZA',
			'zz': 'TR'
		};

		function getSdkUrl(langCode) {
			var lowerLangCode = langCode.toLowerCase(),
				countryCode = codes[langCode];
			if (langCode.length !== 2 || !countryCode) {
				lowerLangCode = 'en';
				countryCode = 'US';
			}

			return '//connect.facebook.net/' + lowerLangCode + '_' + countryCode + '/sdk.js';
		}

		return {
			getSdkUrl: getSdkUrl
		};
	}

	//UMD inclusive
	if (!context.Wikia) {
		context.Wikia = {};
	}

	//namespace
	context.Wikia.fbLocale = facebookLocale(context);

	if (context.define && context.define.amd) {
		context.define('wikia.fbLocale', ['wikia.window'], facebookLocale);
	}
}(this));
