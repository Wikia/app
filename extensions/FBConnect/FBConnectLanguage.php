<?php
/**
 * @author Sean Colombo
 *
 * This file helps with languages and internationalization (i18n) for dealing with facebook.
 * Since MediaWiki has a custom list of languages that differs from the Facebook languages, this class
 * will help with the conversion.
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

	/**
	 * Given a MediaWiki language code, gets a corresponding Facebook locale.
	 */
	public static function getFbLocaleForLangCode($mediaWikiLangCode){
		wfProfileIn(__METHOD__);
		$locale = 'en_US'; // default facebook locale to use

		// See if the mapping is in memcache already.  If not, figure out the mapping from the mediawiki message.
		global $wgMemc;
		$messageKey = 'fbconnect-mediawiki-lang-to-fb-locale';
		$memkey = wfMemcKey( 'FBConnectLanguage', $messageKey);
		$langMapping = $wgMemc->get($memkey);
		if(!$langMapping){
			wfLoadExtensionMessages('FBConnectLanguage');
			$rawMappingText = wfMsg( $messageKey );

			// Split the message by line.
			$lines = explode("\n", $rawMappingText);
			foreach($lines as $line){
				// Split the line into two pieces (if present) for the mapping.
				$tokens = explode(',', $line, 2);
				if(count($tokens) == 2){
					// Trim off comments and whitespace
					$mwLang = trim($tokens[0]);
					$fbLocale = $tokens[1];
					$index = strpos($fbLocale, "#");
					if($index !== false){
						$fbLocale = substr(0, $index); // keep only the text before the comment
					}
					$fbLocale = trim($fbLocale);
					if(($mwLang != "") && ($fbLocale != "")){
						$langMapping[$mwLang] = $fbLocale;
					}
				}
			}

			$wgMemc->set($memkey, $langMapping, 60 * 60 * 3); // cache for a while since this is expensive to compute
		}

		// Use the array to find if there is a mapping from mediaWikiLangCode to a Facebook locale.
		if(isset($langMapping[$mediaWikiLangCode])){
			$locale = $langMapping[$mediaWikiLangCode];

	// TODO: Verify that this is a valid FBLocale! (otherwise a typo in the message could break FBConnect javascript)
	// TODO: Verify that this is a valid FBLocale! (otherwise a typo in the message could break FBConnect javascript)
		}

		wfProfileOut(__METHOD__);
		return $locale;
	} // end getFbLocaleForLangCode()
	
	

}
