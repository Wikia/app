<?php
/**
 * This file contains classes with static helper functions for other classes.
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2007, 2012 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Essentially random collection of helper functions, similar to GlobalFunctions.php.
 */
class TranslateUtils {

	/**
	 * Does quick normalisation of message name so that in can be looked from the
	 * database.
	 * @param $message \string Name of the message
	 * @param $code \string Language code in lower case and with dash as delimieter
	 * @return \string The normalised title as a string.
	 */
	public static function title( $message, $code ) {
		global $wgContLang;

		// Cache some amount of titles for speed.
		static $cache = array();

		if ( !isset( $cache[$message] ) ) {
			$cache[$message] = $wgContLang->ucfirst( $message );
		}

		if ( $code ) {
			return $cache[$message] . '/' . $code;
		} else {
			return $cache[$message];
		}
	}

	/**
	 * Splits page name into message key and language code.
	 * @param $text \string
	 * @return Array \type{Tuple[String,String]} Key and language code.
	 * @todo Handle names without slash.
	 */
	public static function figureMessage( $text ) {
		$pos = strrpos( $text, '/' );
		$code = substr( $text, $pos + 1 );
		$key = substr( $text, 0, $pos );

		return array( $key, $code );
	}

	/**
	 * Loads page content *without* side effects.
	 * @param $key \string Message key.
	 * @param $language \string Language code.
	 * @param $namespace \int Namespace number.
	 * @return \types{\string,\null} The contents or null.
	 */
	public static function getMessageContent( $key, $language,
		$namespace = NS_MEDIAWIKI ) {

		$title = self::title( $key, $language );
		$data = self::getContents( array( $title ), $namespace );

		return isset( $data[$title][0] ) ? $data[$title][0] : null;
	}

	/**
	 * Fetches contents for pagenames in given namespace without side effects.
	 *
	 * @param $titles \types{String,\list{String}} Database page names.
	 * @param $namespace \int The number of the namespace.
	 * @return Array \arrayof{\string,\type{Tuple[String,String]}} Tuples of page
	 * text and last author indexed by page name.
	 */
	public static function getContents( $titles, $namespace ) {
		$dbr = wfGetDB( DB_SLAVE );
		$rows = $dbr->select( array( 'page', 'revision', 'text' ),
			array( 'page_title', 'old_text', 'old_flags', 'rev_user_text' ),
			array(
				'page_namespace'    => $namespace,
				'page_latest=rev_id',
				'rev_text_id=old_id',
				'page_title'        => $titles
			),
			__METHOD__
		);

		$titles = array();
		foreach ( $rows as $row ) {
			$titles[$row->page_title] = array(
				Revision::getRevisionText( $row ),
				$row->rev_user_text
			);
		}
		$rows->free();

		return $titles;
	}

	/**
	 * Fetches recent changes for titles in given namespaces
	 *
	 * @param $hours \int Number of hours.
	 * @param $bots \bool Should bot edits be included.
	 * @param $ns \list{Integer} List of namespace IDs.
	 * @return \array List of recent changes.
	 */
	public static function translationChanges( $hours = 24, $bots = false, $ns = null ) {
		global $wgTranslateMessageNamespaces;

		$dbr = wfGetDB( DB_SLAVE );
		$recentchanges = $dbr->tableName( 'recentchanges' );
		$hours = intval( $hours );
		$cutoff_unixtime = time() - ( $hours * 3600 );
		$cutoff = $dbr->timestamp( $cutoff_unixtime );

		$namespaces = $dbr->makeList( $wgTranslateMessageNamespaces );
		if ( $ns ) {
			$namespaces = $dbr->makeList( $ns );
		}

		$fields = 'rc_title, rc_timestamp, rc_user_text, rc_namespace';

		// @todo Raw SQL
		$sql = "SELECT $fields, substring_index(rc_title, '/', -1) as lang FROM $recentchanges " .
		"WHERE rc_timestamp >= '{$cutoff}' " .
		( $bots ? '' : 'AND rc_bot = 0 ' ) .
		"AND rc_namespace in ($namespaces) " .
		"ORDER BY lang ASC, rc_timestamp DESC";

		$res = $dbr->query( $sql, __METHOD__ );
		$rows = iterator_to_array( $res );
		return $rows;
	}

	/* Some other helpers for output */

	/**
	 * Returns a localised language name.
	 * @param $code \string Language code.
	 * @param $native \string Use only native names.
	 * @param $language \string Language code of language the the name should be in.
	 * @return \string Best-effort localisation of wanted language name.
	 */
	public static function getLanguageName( $code, $native = false, $language = 'en' ) {
		if ( !$native && is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $language ,
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		if ( isset( $languages[$code] ) ) {
			return $languages[$code];
		} else {
			return $code;
		}
	}

	/**
	 * Returns a language selector.
	 * @param $language \string Language code of the language the names should
	 * be localised to.
	 * @param $selectedId \string The language code that is selected by default.
	 * @return string
	 */
	public static function languageSelector( $language, $selectedId ) {
		$languages = self::getLanguageNames( $language );
		ksort( $languages );

		$selector = new XmlSelect( 'language', 'language' );
		$selector->setDefault( $selectedId );
		foreach ( $languages as $code => $name ) {
			$selector->addOption( "$code - $name", $code );
		}

		return $selector->getHTML();
	}

	/**
	 * Get translated language names.
	 * @return array
	 */
	public static function getLanguageNames( /*string */ $code ) {
		if ( is_callable( array( 'Language', 'getTranslatedLanguageNames' ) ) ) {
			return Language::getTranslatedLanguageNames( $code );
		} elseif ( is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			return LanguageNames::getNames( $code,
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW
			);
		} else {
			return Language::getLanguageNames( false );
		}
	}

	/**
	 * Returns the primary group message belongs to.
	 * @param $namespace \int
	 * @param $key \string
	 * @return string|null Group id or null.
	 */
	public static function messageKeyToGroup( $namespace, $key ) {
		$groups = self::messageKeyToGroups( $namespace, $key );
		return count( $groups ) ? $groups[0] : null;
	}

	/**
	 * Returns the all the groups message belongs to.
	 * @param $namespace \int
	 * @param $key \string
	 * @return \list{String} Possibly empty list of group ids.
	 */
	public static function messageKeyToGroups( $namespace, $key ) {
		$mi = MessageIndex::singleton()->retrieve();
		$normkey = self::normaliseKey( $namespace, $key );

		if ( isset( $mi[$normkey] ) ) {
			return (array) $mi[$normkey];
		} else {
			return array();
		}
	}

	/**
	 * Converts page name and namespace to message index format.
	 * @param $namespace \int
	 * @param $key \string
	 * @return \string
	 */
	public static function normaliseKey( $namespace, $key ) {
		return strtr( strtolower( "$namespace:$key" ), " ", "_"  );
	}

	/**
	 * Constructs a fieldset with contents.
	 * @param $legend \string Raw html.
	 * @param $contents \string Raw html.
	 * @param $attributes \array Html attributes for the fieldset.
	 * @return \string Html.
	 */
	public static function fieldset( $legend, $contents, $attributes = array() ) {
		return Xml::openElement( 'fieldset', $attributes ) .
			Xml::tags( 'legend', null, $legend ) . $contents .
			Xml::closeElement( 'fieldset' );
	}

	/**
	 * Escapes the message, and does some mangling to whitespace, so that it is
	 * preserved when outputted as-is to html page. Line feeds are converted to
	 * \<br /> and occurances of leading and trailing and multiple consecutive
	 * spaces to non-breaking spaces.
	 *
	 * @param $msg \string Plain text string.
	 * @return \string Text string that is ready for outputting.
	 */
	public static function convertWhiteSpaceToHTML( $msg ) {
		$msg = htmlspecialchars( $msg );
		$msg = preg_replace( '/^ /m', '&#160;', $msg );
		$msg = preg_replace( '/ $/m', '&#160;', $msg );
		$msg = preg_replace( '/  /', '&#160; ', $msg );
		$msg = str_replace( "\n", '<br />', $msg );

		return $msg;
	}

	/**
	 * Construct the web address to given asset.
	 * @param $path \string Path to the resource relative to extensions root directory.
	 * @return \string Full or partial web path.
	 */
	public static function assetPath( $path ) {
		global $wgExtensionAssetsPath;
		return "$wgExtensionAssetsPath/Translate/$path";
	}

	/**
	 * Gets the path for cache files
	 * @param $filename \string
	 * @return \string Full path.
	 * @throws \type{MWException} If cache directory is not configured.
	 */
	public static function cacheFile( $filename ) {
		global $wgTranslateCacheDirectory, $wgCacheDirectory;

		if ( $wgTranslateCacheDirectory !== false ) {
			$dir = $wgTranslateCacheDirectory;
		} elseif ( $wgCacheDirectory !== false ) {
			$dir = $wgCacheDirectory;
		} else {
			throw new MWException( "\$wgCacheDirectory must be configured" );
		}

		return "$dir/$filename";
	}

	public static function groupSelector( $default = false ) {
		$groups = MessageGroups::getAllGroups();
		$selector = new XmlSelect( 'group', 'group', $default );

		foreach ( $groups as $id => $class ) {
			if ( MessageGroups::getGroup( $id )->exists() ) {
				$selector->addOption( $class->getLabel(), $id );
			}
		}

		return $selector;
	}

	/**
	 * @since 2012-01-12
	 */
	public static function addSpecialHelpLink( OutputPage $out, /*string*/$to, $overrideBaseUrl = false ) {
		$out->addModules( 'ext.translate.helplink' );
		$text = wfMessage( 'translate-gethelp' )->escaped();

		if ( $overrideBaseUrl ) {
			$helpUrl = $to;
		} else {
			$helpUrl = "//www.mediawiki.org/wiki/Special:MyLanguage/$to";
		}

		$link = Html::rawElement(
			'a',
			array(
				'href' => $helpUrl,
				'target' => '_blank'
			),
			"$text" );
		$wrapper = Html::rawElement( 'div', array( 'class' => 'mw-translate-helplink' ), $link );
		$out->addHtml( $wrapper );
	}
}
