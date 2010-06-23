<?php
/**
 * @author Sean Colombo
 *
 * This file helps with languages and internationalization (i18n) for dealing with facebook.
 * Since MediaWiki has a custom list of languages that differs from the Facebook languages, this class
 * will help with the conversion.
 *
 * No automated conversions are attempted because that could result in much stranger results than just defaulting to english.  For instance,
 * if we just searched for a facebook locale which started with the MediaWiki language code, we could attempt to deliver en_PI (Pirate English)
 * and there would be false-negatives in the other direction also (such as chr -> ck_US being missed).
 *
 * Relevant documentaion:
 *	- Tutorial in making the FBConnect popups from Facebook be internationalized: http://developers.facebook.com/blog/post/264
 *	- XML of Facebook's languages: http://www.facebook.com/translations/FacebookLocales.xml
 *	- Overview of where Facebook's lang-codes come from: http://wiki.developers.facebook.com/index.php/Facebook_Locales
 *	- MediaWiki i18n: http://www.mediawiki.org/wiki/Internationalisation
 *	- List which has MediaWiki fallback languages all on the same page: http://www.mediawiki.org/wiki/Localisation_statistics (will be helpful in building the mapping).
 *	- Comments in /languages/Names.php in MediaWiki has comments next to each mapping which should help. It is approximately RFC 3066
 */

class FBConnectLanguage{

	// All of the Facebook Locales according to http://www.facebook.com/translations/FacebookLocales.xml as of 20100622
	private static $allFbLocales = array(
		'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_DE', 'eu_ES', 'en_PI', 'en_UD', 'ck_US', 'en_US', 'es_LA', 'es_CL', 'es_CO', 'es_ES', 'es_MX',
		'es_VE', 'fb_FI', 'fi_FI', 'fr_FR', 'gl_ES', 'hu_HU', 'it_IT', 'ja_JP', 'ko_KR', 'nb_NO', 'nn_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'pt_PT',
		'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sv_SE', 'th_TH', 'tr_TR', 'ku_TR', 'zh_CN', 'zh_HK', 'zh_TW', 'fb_LT', 'af_ZA', 'sq_AL', 'hy_AM',
		'az_AZ', 'be_BY', 'bn_IN', 'bs_BA', 'bg_BG', 'hr_HR', 'nl_BE', 'en_GB', 'eo_EO', 'et_EE', 'fo_FO', 'fr_CA', 'ka_GE', 'el_GR', 'gu_IN',
		'hi_IN', 'is_IS', 'id_ID', 'ga_IE', 'jv_ID', 'kn_IN', 'kk_KZ', 'la_VA', 'lv_LV', 'li_NL', 'lt_LT', 'mk_MK', 'mg_MG', 'ms_MY', 'mt_MT',
		'mr_IN', 'mn_MN', 'ne_NP', 'pa_IN', 'rm_CH', 'sa_IN', 'sr_RS', 'so_SO', 'sw_KE', 'tl_PH', 'ta_IN', 'tt_RU', 'te_IN', 'ml_IN', 'uk_UA',
		'uz_UZ', 'vi_VN', 'xh_ZA', 'zu_ZA', 'km_KH', 'tg_TJ', 'ar_AR', 'he_IL', 'ur_PK', 'fa_IR', 'sy_SY', 'yi_DE', 'gn_PY', 'qu_PE', 'ay_BO',
		'se_NO', 'ps_AF', 'tl_ST'
	);
	
	private static $messageKey = 'fbconnect-mediawiki-lang-to-fb-locale';

	/**
	 * Given a MediaWiki language code, gets a corresponding Facebook locale.
	 */
	public static function getFbLocaleForLangCode($mediaWikiLangCode){
		wfProfileIn(__METHOD__);
		$locale = 'en_US'; // default facebook locale to use

		// See if the mapping is in memcache already.  If not, figure out the mapping from the mediawiki message.
		global $wgMemc;
		$memkey = wfMemcKey( 'FBConnectLanguage', self::$messageKey);
		$langMapping = $wgMemc->get($memkey);
		if(!$langMapping){
			$langMapping = array();
			wfLoadExtensionMessages('FBConnectLanguage');
			$rawMappingText = wfMsg( self::$messageKey );

			// Split the message by line.
			$lines = explode("\n", $rawMappingText);
			foreach($lines as $line){
				// Remove comments
				$index = strpos($line, "#");
				if($index !== false){
					$line = substr($line, 0, $index); // keep only the text before the comment
				}
			
				// Split the line into two pieces (if present) for the mapping.
				$tokens = explode(',', $line, 2);
				if(count($tokens) == 2){
					// Trim off whitespace
					$mwLang = trim($tokens[0]);
					$fbLocale = trim($tokens[1]);

					if(($mwLang != "") && ($fbLocale != "")){
						// Verify that this is a valid fb locale before storing (otherwise a typo in the message could break FBConnect javascript by including an invalid fbScript URL).
						if(self::isValidFacebookLocale($fbLocale)){
							$langMapping[$mwLang] = $fbLocale;
						} else {
							error_log("FBConnect: WARNING: Facebook Locale was found in the wiki-message but does not appear to be a Facebook Locale that we know about: \"$fbLocale\".\n");
							error_log("FBConnect: Skipping locale for now.  If you want this locale to be permitted, please add it to FBConnectLanguage::\$allFbLocales.\n");
						}
					}
				}
			}

			$wgMemc->set($memkey, $langMapping, 60 * 60 * 3); // cache for a while since this is fairly expensive to compute & shouldn't change often
		}

		// Use the array to find if there is a mapping from mediaWikiLangCode to a Facebook locale.
		if(isset($langMapping[$mediaWikiLangCode])){
			$locale = $langMapping[$mediaWikiLangCode];
		}

		wfProfileOut(__METHOD__);
		return $locale;
	} // end getFbLocaleForLangCode()
	
	/**
	 * Returns true if the value provided is one of the Facebook Locales that was supported according to
	 * http://www.facebook.com/translations/FacebookLocales.xml
	 * at the last time that this code was updated.  This is a manual process, so if FacebookLocales.xml changes,
	 * we will most likely be out of sync until someone brings this to our attention).
	 */ 
	public static function isValidFacebookLocale($locale){
		return in_array($locale, self::$allFbLocales);
	}
	
	/**
	 * This function can be run as a unit-test to test the coverage of the mapping (to make sure that there is at least a row in
	 * the MediaWiki message to potentially map to a Facebook locale.
	 */
	public static function testCoverage(){
		global $wgLanguageNames;
		$passed = true;
		
		// Split the message by line.
		$langMapping = array();
		wfLoadExtensionMessages('FBConnectLanguage');
		$rawMappingText = wfMsg( self::$messageKey );
		$lines = explode("\n", $rawMappingText);
		foreach($lines as $line){
			// Remove comments
			$index = strpos($line, "#");
			if($index !== false){
				$line = substr($line, 0, $index); // keep only the text before the comment
			}
		
			// Split the line into two pieces (if present) for the mapping.
			$tokens = explode(',', $line, 2);
			if(count($tokens) == 2){
				// Trim off whitespace
				$mwLang = trim($tokens[0]);
				$fbLocale = trim($tokens[1]);

				// NOTE: THIS DIFFERS FROM NORMAL LOADING BECAUSE WE WANT EVEN THE MAPPINGS WITH NO DESTINATION.
				if($mwLang != ""){
					// Verify that this is a valid fb locale before storing (otherwise a typo in the message could break FBConnect javascript by including an invalid fbScript URL).
					$langMapping[$mwLang] = $fbLocale;
					if(($fbLocale != "") && (!self::isValidFacebookLocale($fbLocale))){
						error_log("FBConnect: WARNING: Facebook Locale was found in the wiki-message but does not appear to be a Facebook Locale that we know about: \"$fbLocale\".\n");
						error_log("FBConnect: Skipping locale for now.  If you want this locale to be permitted, please add it to FBConnectLanguage::\$allFbLocales.\n");
					}
				}
			}
		}

		// Look through each of the MediaWiki langauges.
		foreach(array_keys($wgLanguageNames) as $lang){
			if( !isset($langMapping[$lang]) ){
				$passed = false;
				error_log("FBConnect: MediaWiki language \"$lang\" does not have a row for mapping it to a Facebook Locale. Add it to the MediaWiki message!\n");
			}
		}

		return $passed;
	} // end testCoverage()

}
