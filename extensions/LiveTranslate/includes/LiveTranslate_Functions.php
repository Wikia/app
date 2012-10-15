<?php

/**
 * Static class with utility methods for the Live Translate extension.
 *
 * @since 0.1
 *
 * @file LiveTranslate_Functions.php
 * @ingroup LiveTranslate
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class LiveTranslateFunctions {
	
	/**
	 * Loads the needed JavaScript.
	 * Takes care of non-RL compatibility.
	 * 
	 * @since 0.1
	 */
	public static function loadJs() {
		global $wgOut;
		
		$wgOut->addScript(
			Html::inlineScript(
				'var ltDebugMessages = ' . FormatJson::encode( $GLOBALS['egLiveTranslateDebugJS'] ) . ';'
			)
		);
		
		// For backward compatibility with MW < 1.17.
		if ( is_callable( array( $wgOut, 'addModules' ) ) ) {
			$modules = array( 'ext.livetranslate' );
			
			switch( $GLOBALS['egLiveTranslateService'] ) {
				case LTS_GOOGLE: 
					$modules[] = 'ext.lt.google';
					$wgOut->addHeadItem(
						'ext.lt.google.jsapi',
						Html::linkedScript( 'https://www.google.com/jsapi?key=' . htmlspecialchars( $GLOBALS['egGoogleApiKey'] ) )
					);
					break;
				case LTS_MS:
					$modules[] = 'ext.lt.ms';
					$wgOut->addScript(
						Html::inlineScript(
							'var ltMsAppId = ' . FormatJson::encode( $GLOBALS['egLiveTranslateMSAppId'] ) . ';'
						)
					);
					break;
			}
			
			$wgOut->addModules( $modules );
		}
		else {
			global $egLiveTranslateScriptPath;
			
			self::addJSLocalisation();
			
			$wgOut->includeJQuery();
			
			$wgOut->addHeadItem(
				'ext.livetranslate',
				Html::linkedScript( $egLiveTranslateScriptPath . '/includes/ext.livetranslate.js' ) .
				Html::linkedScript( $egLiveTranslateScriptPath . '/includes/ext.lt.tm.js' ) .
				Html::linkedScript( $egLiveTranslateScriptPath . '/includes/jquery.replaceText.js' ) .
				Html::linkedScript( $egLiveTranslateScriptPath . '/includes/jquery.liveTranslate.js' )
			);
			
			switch( $GLOBALS['egLiveTranslateService'] ) {
				case LTS_GOOGLE:
					$wgOut->addHeadItem(
						'ext.lt.google.jsapi',
						Html::linkedScript( 'https://www.google.com/jsapi?key=' . htmlspecialchars( $GLOBALS['egGoogleApiKey'] ) )
					);
					
					$wgOut->addHeadItem(
						'ext.lt.google',
						Html::linkedScript( $egLiveTranslateScriptPath . '/includes/ext.lt.google.js' )
					);
					break;
				case LTS_MS:
					$wgOut->addScript(
						Html::inlineScript(
							'var ltMsAppId = ' . FormatJson::encode( $GLOBALS['egLiveTranslateMSAppId'] ) . ';'
						)
					);
					$wgOut->addHeadItem(
						'ext.lt.ms',
						Html::linkedScript( $egLiveTranslateScriptPath . '/includes/ext.lt.ms.js' )
					);
					break;
			}
		}		
	}	
	
	/**
	 * Adds the needed JS messages to the page output.
	 * This is for backward compatibility with pre-RL MediaWiki.
	 * 
	 * @since 0.1
	 */
	protected static function addJSLocalisation() {
		global $egLTJSMessages, $wgOut;
		
		$data = array();
	
		foreach ( $egLTJSMessages as $msg ) {
			$data[$msg] = wfMsgNoTrans( $msg );
		}
	
		$wgOut->addInlineScript( 'var wgLTEMessages = ' . FormatJson::encode( $data ) . ';' );		
	}
	
	/**
	 * Returns the language code for a title.
	 * 
	 * @param Title $title
	 * 
	 * @return string
	 */
	public static function getCurrentLang( Title $title ) {
		$subPage = explode( '/', $title->getSubpageText() );
		$subPage = array_pop( $subPage );

		if ( $subPage != '' && array_key_exists( $subPage, Language::getLanguageNames( false ) ) ) {
			return $subPage;
		}
		
		global $wgLanguageCode;
		return $wgLanguageCode;
	}
	
	/**
	 * Returns a list of languages that can be translated to.
	 * 
	 * @since 1.2
	 * 
	 * @param string $currentLang
	 * 
	 * @return array
	 */
	public static function getLanguages( $currentLang ) {
		global $wgUser, $wgLanguageCode, $egLiveTranslateLanguages;
		
		$allowedLanguages = array_merge( $egLiveTranslateLanguages, array( $currentLang ) );
		
		$targetLang = $wgLanguageCode;
		
		$languages = Language::getLanguageNames( false );
		
		if ( $wgUser->isLoggedIn() ) {
			$userLang = $wgUser->getOption( 'language' );
			
			if ( array_key_exists( $userLang, $languages ) && in_array( $userLang, $allowedLanguages ) ) {
				$targetLang = $userLang;
			}
		}
		
		$options = array();
		ksort( $languages );
		
		foreach ( $languages as $code => $name ) {
			if ( in_array( $code, $allowedLanguages ) && $code != $currentLang ) {
				$display = wfBCP47( $code ) . ' - ' . $name;
				$options[$display] = $code;				
			}
		}

		return $options;
	}
	
	/**
	 * Returns a PHP version of the JavaScript google.language.Languages enum of the Google Translate v1 API.
	 * @see https://code.google.com/apis/language/translate/v1/getting_started.html#LangNameArray
	 * 
	 * @since 0.1
	 * 
	 * @return array LANGUAGE_NAME => 'code' 
	 */
	public static function getGTSupportedLanguages() {
		return array(
			'AFRIKAANS' => 'af',
			'ALBANIAN' => 'sq',
			'AMHARIC' => 'am',
			'ARABIC' => 'ar',
			'ARMENIAN' => 'hy',
			'AZERBAIJANI' => 'az',
			'BASQUE' => 'eu',
			'BELARUSIAN' => 'be',
			'BENGALI' => 'bn',
			'BIHARI' => 'bh',
			'BRETON' => 'br',
			'BULGARIAN' => 'bg',
			'BURMESE' => 'my',
			'CATALAN' => 'ca',
			'CHEROKEE' => 'chr',
			'CHINESE' => 'zh',
			'CHINESE_SIMPLIFIED' => 'zh-CN',
			'CHINESE_TRADITIONAL' => 'zh-TW',
			'CORSICAN' => 'co',
			'CROATIAN' => 'hr',
			'CZECH' => 'cs',
			'DANISH' => 'da',
			'DHIVEHI' => 'dv',
			'DUTCH'=> 'nl',	
			'ENGLISH' => 'en',
			'ESPERANTO' => 'eo',
			'ESTONIAN' => 'et',
			'FAROESE' => 'fo',
			'FILIPINO' => 'tl',
			'FINNISH' => 'fi',
			'FRENCH' => 'fr',
			'FRISIAN' => 'fy',
			'GALICIAN' => 'gl',
			'GEORGIAN' => 'ka',
			'GERMAN' => 'de',
			'GREEK' => 'el',
			'GUJARATI' => 'gu',
			'HAITIAN_CREOLE' => 'ht',
			'HEBREW' => 'iw',
			'HINDI' => 'hi',
			'HUNGARIAN' => 'hu',
			'ICELANDIC' => 'is',
			'INDONESIAN' => 'id',
			'INUKTITUT' => 'iu',
			'IRISH' => 'ga',
			'ITALIAN' => 'it',
			'JAPANESE' => 'ja',
			'JAVANESE' => 'jw',
			'KANNADA' => 'kn',
			'KAZAKH' => 'kk',
			'KHMER' => 'km',
			'KOREAN' => 'ko',
			'KURDISH'=> 'ku',
			'KYRGYZ'=> 'ky',
			'LAO' => 'lo',
			'LATIN' => 'la',
			'LATVIAN' => 'lv',
			'LITHUANIAN' => 'lt',
			'LUXEMBOURGISH' => 'lb',
			'MACEDONIAN' => 'mk',
			'MALAY' => 'ms',
			'MALAYALAM' => 'ml',
			'MALTESE' => 'mt',
			'MAORI' => 'mi',
			'MARATHI' => 'mr',
			'MONGOLIAN' => 'mn',
			'NEPALI' => 'ne',
			'NORWEGIAN' => 'no',
			'OCCITAN' => 'oc',
			'ORIYA' => 'or',
			'PASHTO' => 'ps',
			'PERSIAN' => 'fa',
			'POLISH' => 'pl',
			'PORTUGUESE' => 'pt',
			'PORTUGUESE_PORTUGAL' => 'pt-PT',
			'PUNJABI' => 'pa',
			'QUECHUA' => 'qu',
			'ROMANIAN' => 'ro',
			'RUSSIAN' => 'ru',
			'SANSKRIT' => 'sa',
			'SCOTS_GAELIC' => 'gd',
			'SERBIAN' => 'sr',
			'SINDHI' => 'sd',
			'SINHALESE' => 'si',
			'SLOVAK' => 'sk',
			'SLOVENIAN' => 'sl',
			'SPANISH' => 'es',
			'SUNDANESE' => 'su',
			'SWAHILI' => 'sw',
			'SWEDISH' => 'sv',
			'SYRIAC' => 'syr',
			'TAJIK' => 'tg',
			'TAMIL' => 'ta',
			'TATAR' => 'tt',
			'TELUGU' => 'te',
			'THAI' => 'th',
			'TIBETAN' => 'bo',
			'TONGA' => 'to',
			'TURKISH' => 'tr',
			'UKRAINIAN' => 'uk',
			'URDU' => 'ur',
			'UZBEK' => 'uz',
			'UIGHUR' => 'ug',
			'VIETNAMESE' => 'vi',
			'WELSH' => 'cy',
			'YIDDISH' => 'yi',
			'YORUBA' => 'yo',
		);
	}
	
	/**
	 * Returns an array with mapping from input language codes to MediaWiki language codes.
	 * 
	 * @since 0.4
	 * 
	 * @return array 
	 */	
	public static function getInputLangMapping() {
		return array(
			'en-us' => 'en',
		);
	}
	
	/**
	 * Returns an array with mapping from MediaWiki language codes to Google Translate language codes.
	 * 
	 * @since 0.4
	 * 
	 * @return array 
	 */	
	public static function getOuputLangMapping() {
		return array(
			'en-us' => 'en',
			'en-gb' => 'en',
		);
	}	
	
	/**
	 * Returns the provided text starting with a letter in toggled case.
	 * If there is no difference between lowercase and upercase for the first
	 * character, false is returned.
	 * 
	 * @since 0.1
	 * 
	 * @param string $text
	 * 
	 * @return mixed
	 */
	public static function getToggledCase( $text ) {
		$isUpper = Language::firstChar( $text) == strtoupper( Language::firstChar( $text) );
		$isLower = Language::firstChar( $text) == strtolower( Language::firstChar( $text) );
		
		if ( $isUpper XOR $isLower ) {
			$text = $isUpper ? Language::lcfirst( $text ) : Language::ucfirst( $text );
			return $text;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Returns the names of the pages containing a translation memory.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	public static function getLocalMemoryNames() {
		$dbr = wfGetDb( DB_MASTER );
		
		$res = $dbr->select(
			'live_translate_memories',
			array( 'memory_location' ),
			array( 'memory_local' => 1 ),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);

		$names = array();
		
		foreach ( $res as $tm ) {
			$names[] = $tm->memory_location;
		}

		return $names;
	}
	
	/**
	 * Returns the type of a translation memory when given it's location.
	 * If the memory is not found, -1 is returned.
	 * 
	 * @since 0.4
	 * 
	 * @param string $location
	 * 
	 * @return integer
	 */
	public static function getMemoryType( $location ) {
		$dbr = wfGetDb( DB_MASTER );
		
		$res = $dbr->select(
			'live_translate_memories',
			array( 'memory_type' ),
			array( 'memory_location' => $location ),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);

		$type = -1;

		foreach ( $res as $row ) {
			$type = $row->memory_type;
			break;
		}
		
		return $type;
	}
	
	/**
	 * Returns if there is a translation service that can be used or not.
	 * 
	 * @since 1.1.1
	 * 
	 * @return boolean
	 */
	public static function hasTranslationService() {
		global $egLiveTranslateService, $egGoogleApiKey, $egLiveTranslateMSAppId;
		
		return ( $egLiveTranslateService == LTS_GOOGLE && $egGoogleApiKey != '' )
			|| ( $egLiveTranslateService == LTS_MS && $egLiveTranslateMSAppId != '' );
	}
	
}