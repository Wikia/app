/*global Geo*/
(function (context) {
	'use strict';

	/**
	 * Determines the locale for a Facebook user based on Wikia language and user's location
	 *
	 * Facebook languages/countries supported: https://www.facebook.com/translations/FacebookLocales.xml
	 **/
	function facebookLocale() {
		/** Note: only one default country per language is used. */
		var defaultCountryCodes = {
			// languageCode: CountryCode
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
			},
			languagesOfCountry = {
				// CountryCode: languageCodes
				'AF': ['ps'],
				'AL': ['sq'],
				'AM': ['hy'],
				'AR': ['ar'],
				'AZ': ['az'],
				'BA': ['bs'],
				'BE': ['nl'],
				'BG': ['bg'],
				'BO': ['ay'],
				'BR': ['pt'],
				'BY': ['be'],
				'CA': ['fr'],
				'CD': ['ln'],
				'CH': ['rm'],
				'CL': ['es'],
				'CN': ['zh'],
				'CO': ['es'],
				'CZ': ['cs'],
				'DE': ['de', 'yi'],
				'DK': ['da'],
				'EE': ['et'],
				'EO': ['eo'],
				'ES': ['ca', 'es', 'eu', 'gl'],
				'ET': ['am'],
				'FI': ['fi'],
				'FR': ['br', 'co', 'fr'],
				'FO': ['fo'],
				'GB': ['cy', 'en'],
				'GE': ['ka'],
				'GH': ['ak'],
				'GR': ['el', 'gx'],
				'HK': ['zh'],
				'HR': ['hr'],
				'HU': ['hu'],
				'ID': ['id', 'jv'],
				'IE': ['ga'],
				'IL': ['he'],
				'IN': ['as', 'bn', 'en', 'gu', 'hi', 'kn', 'ml', 'mr', 'or', 'pa', 'sa', 'ta', 'te'],
				'IQ': ['cb'],
				'IR': ['fa'],
				'IS': ['is'],
				'IT': ['it', 'sc'],
				'JP': ['ja'],
				'KE': ['sw'],
				'KH': ['km'],
				'KR': ['ko'],
				'KS': ['ja'],
				'KZ': ['kk'],
				'LA': ['es', 'lo'],
				'LK': ['si'],
				'LT': ['fb', 'lt'],
				'LV': ['lv'],
				'MA': ['tz'],
				'MG': ['mg'],
				'MK': ['mk'],
				'MM': ['my'],
				'MN': ['mn'],
				'MT': ['mt'],
				'MW': ['ny'],
				'MX': ['es'],
				'MY': ['ms'],
				'NG': ['ff', 'ha', 'ig', 'yo'],
				'NL': ['fy', 'li', 'nl'],
				'NO': ['nb', 'nn', 'se'],
				'NP': ['ne'],
				'PE': ['qu'],
				'PH': ['cx', 'tl'],
				'PI': ['en'],
				'PK': ['ur'],
				'PL': ['pl', 'sz'],
				'PT': ['pt'],
				'PY': ['gn'],
				'RO': ['ro'],
				'RS': ['sr'],
				'RU': ['ru', 'tt'],
				'RW': ['rw'],
				'SE': ['sv'],
				'SI': ['sl'],
				'SK': ['sk'],
				'SN': ['wo'],
				'SO': ['so'],
				'ST': ['tl'],
				'SY': ['sy'],
				'TH': ['th'],
				'TJ': ['tg'],
				'TM': ['tk'],
				'TR': ['ku', 'tr', 'zz'],
				'TW': ['zh'],
				'UA': ['uk'],
				'UD': ['en'],
				'UG': ['lg'],
				'US': ['ck', 'en'],
				'UZ': ['uz'],
				'VA': ['la'],
				'VE': ['es'],
				'VN': ['vi'],
				'ZA': ['af', 'xh', 'zu'],
				'ZW': ['nd', 'sn']
			};

		/**
		 * Gets the Localized URL of the FB JS SDK
		 * To localize, it attempts to match user location (country) with the language;
		 * if unsuccessful, it falls back to a default country associated with the language
		 * In case language is invalid or unsupported, defaults to en/US
		 *
		 * @param {string} inputLanguageCode
		 * @returns {string} URL of localized Facebook SDK
		 */
		function getSdkUrl(inputLanguageCode) {
			var matchingLanguages,
				languageCode = inputLanguageCode.length === 2 ? inputLanguageCode.toLowerCase() : 'en',
				geoCountryCode = Geo.getCountryCode(),
				countryCode = '';
			if (geoCountryCode) {
				matchingLanguages = languagesOfCountry[geoCountryCode.toUpperCase()];
				if (matchingLanguages && languageCode in matchingLanguages) {
					countryCode = geoCountryCode.toUpperCase();
				}
			}
			if (!countryCode) {
				countryCode = defaultCountryCodes[languageCode];
				if (!countryCode) {
					languageCode = 'en';
					countryCode = 'US';
				}
			}

			return '//connect.facebook.net/' + languageCode + '_' + countryCode + '/sdk.js';
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
	context.Wikia.fbLocale = facebookLocale();

	if (context.define && context.define.amd) {
		context.define('wikia.fbLocale', [], facebookLocale);
	}
}(this));
