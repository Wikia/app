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

		// TODO: Load the wfMsg in, parse it into an associative array, store that array in Memcached for a couple of hours.
		// TODO: Load the wfMsg in, parse it into an associative array, store that array in Memcached for a couple of hours.
		//wfLoadExtensionMessages('FBConnectLanguage');
		//$rawMappingText = wfMsg('fbconnect-mediawiki-lang-to-fb-locale');
		
		// TODO: Use the array to find if there is a mapping from mediaWikiLangCode to a Facebook locale.
		// TODO: Use the array to find if there is a mapping from mediaWikiLangCode to a Facebook locale.

		wfProfileOut(__METHOD__);
		return $locale;
	} // end getFbLocaleForLangCode()

}
