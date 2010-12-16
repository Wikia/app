<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * This class contains some static helper functions for other classes.
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2007 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class TranslateUtils {
	const MSG = 'translate-';

	/**
	 * Does quick normalisation of message name so that in can be looked from the
	 * database.
	 * @param $message Name of the message
	 * @param $code Language code in lower case and with dash as delimieter
	 * @return The normalised title as a string.
	 */
	public static function title( $message, $code ) {
		global $wgContLang;

		// Cache some amount of titles for speed
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

	public static function figureMessage( $text ) {
		$pos = strrpos( $text, '/' );
		$code = substr( $text, $pos + 1 );
		$key = substr( $text, 0, $pos );
		return array( $key, $code );
	}

	public static function getMessageContent( $key, $language,
		$namespace = NS_MEDIAWIKI ) {

		$title = self::title( $key, $language );
		$data = self::getContents( array( $title ), $namespace );
		return isset( $data[$title][0] ) ? $data[$title][0] : null;
	}

	/**
	 * Fetches contents for titles in given namespace
	 *
	 * @param $titles Mixed: string or array of titles.
	 * @param $namespace Mixed: the number of the namespace to look in for.
	 */
	public static function getContents( $titles, $namespace ) {
		$dbr = wfGetDB( DB_SLAVE );
		$rows = $dbr->select( array( 'page', 'revision', 'text' ),
			array( 'page_title', 'old_text', 'old_flags', 'rev_user_text' ),
			array(
				'page_is_redirect'  => 0,
				'page_namespace'    => $namespace,
				'page_latest=rev_id',
				'rev_text_id=old_id',
				'page_title'        => $titles
			),
			__METHOD__
		);


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
	 * @param $hours Int: number of hours.
	 * @param $bots  Bool: should bot edits be included.
	 * @param $ns    Array: array of namespace IDs.
	 */
	public static function translationChanges( $hours = 24, $bots = false, $ns = null ) {
		global $wgTranslateMessageNamespaces;

		$dbr = wfGetDB( DB_SLAVE );
		$recentchanges = $dbr->tableName( 'recentchanges' );
		$hours = intval( $hours );
		$cutoff_unixtime = time() - ( $hours * 3600 );
		# $cutoff_unixtime = $cutoff_unixtime - ($cutoff_unixtime % 86400);
		$cutoff = $dbr->timestamp( $cutoff_unixtime );

		$namespaces = $dbr->makeList( $wgTranslateMessageNamespaces );

		$fields = 'rc_title, rc_timestamp, rc_user_text, rc_namespace';

		$sql = "SELECT $fields, substring_index(rc_title, '/', -1) as lang FROM $recentchanges " .
		"WHERE rc_timestamp >= '{$cutoff}' " .
		( $bots ? '' : 'AND rc_bot = 0 ' ) .
		( $ns ? 'AND rc_namespace IN (' . implode( ',', $ns ) . ') ' : "AND rc_namespace in ($namespaces) " ) .
		"ORDER BY lang ASC, rc_timestamp DESC";

		$res = $dbr->query( $sql, __METHOD__ );

		// Fetch results, prepare a batch link existence check query
		$rows = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$rows[] = $row;
		}
		$dbr->freeResult( $res );
		return $rows;
	}

	/* Some other helpers for ouput*/

	public static function selector( $name, $options ) {
		return Xml::tags( 'select', array( 'name' => $name, 'id' => $name ), $options );
	}

	public static function simpleSelector( $name, $items, $selected ) {
		$options = array();
		foreach ( $items as $item ) {
			$item = strval( $item );
			$options[] = Xml::option( $item, $item, $item == $selected );
		}
		return self::selector( $name, implode( "\n", $options ) );
	}

	public static function getLanguageName( $code, $native = false, $language = 'en' ) {
		if ( !$native && is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $language ,
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		$parts = explode( '-', $code );
		$suffix = '';
		switch ( @$parts[1] ) {
			case 'latn':
				$suffix = ' (Latin)'; # TODO: i18n
				unset( $parts[1] );
				break;
			case 'cyrl':
				$suffix = ' (Cyrillic)'; # TODO: i18n
				unset( $parts[1] );
				break;
		}
		$code = implode( '-', $parts );
		return isset( $languages[$code] ) ? $languages[$code] . $suffix : false;
	}

	public static function languageSelector( $language, $selectedId ) {
		global $wgLang;
		if ( is_callable( array( 'LanguageNames', 'getNames' ) ) ) {
			$languages = LanguageNames::getNames( $language,
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		} else {
			$languages = Language::getLanguageNames( false );
		}

		ksort( $languages );

		$selector = new HTMLSelector( 'language', 'language', $selectedId );
		foreach ( $languages as $code => $name ) {
			$selector->addOption( "$code - $name", $code );
		}
		return $selector->getHTML();
	}

	static $mi = null;

	public static function messageKeyToGroup( $namespace, $key ) {
		if ( self::$mi === null ) self::messageIndex();

		# Performance hotspot
		# $normkey = self::normaliseKey( $namespace, $key );
		$normkey = str_replace( " ", "_", strtolower( "$namespace:$key" ) );

		$group = @self::$mi[$normkey];
		if ( is_array( $group ) ) $group = $group[0];
		return $group;
	}

	public static function messageKeyToGroups( $namespace, $key ) {
		if ( self::$mi === null ) self::messageIndex();

		# Performance hotspot
		# $normkey = self::normaliseKey( $namespace, $key );
		$normkey = str_replace( " ", "_", strtolower( "$namespace:$key" ) );

		return (array) @self::$mi[$normkey];
	}

	public static function normaliseKey( $namespace, $key ) {
		return str_replace( " ", "_", strtolower( "$namespace:$key" ) );
	}

	public static function messageIndex() {
		global $wgCacheDirectory;
		$filename = "$wgCacheDirectory/translate_messageindex.cdb";
		if ( !file_exists( $filename ) ) MessageIndexRebuilder::execute();

		if ( file_exists( $filename ) ) {
			$reader = CdbReader::open( $filename );
			$keyToGroup = unserialize( $reader->get( 'map' ) );
		} else {
			$keyToGroup = false;
			wfDebug( __METHOD__ . ": Message index missing." );
		}

		self::$mi = $keyToGroup;
		return $keyToGroup;
	}

	public static function fieldset( $legend, $contents, $attributes = array() ) {
		return
			Xml::openElement( 'fieldset', $attributes ) .
				Xml::tags( 'legend', null, $legend ) . $contents .
			Xml::closeElement( 'fieldset' );
	}

	/**
	 * Escapes the message, and does some mangling to whitespace, so that it is
	 * preserved when outputted as-is to html page. Line feeds are converted to
	 * <br /> and occurances of leading and trailing and multiple consecutive
	 * spaces to non-breaking spaces.
	 *
	 * @param $msg Plain text string.
	 * @return Text string that is ready for outputting.
	 */
	public static function convertWhiteSpaceToHTML( $msg ) {
		$msg = htmlspecialchars( $msg );
		$msg = preg_replace( '/^ /m', '&nbsp; ', $msg );
		$msg = preg_replace( '/ $/m', ' &nbsp;', $msg );
		$msg = preg_replace( '/  /', '&nbsp; ', $msg );
		$msg = str_replace( "\n", '<br />', $msg );
		return $msg;
	}

	public static function injectCSS() {
		static $done = false;
		if ( $done ) return;

		global $wgHooks, $wgOut, $wgTranslateCssLocation;
		if ( $wgTranslateCssLocation ) {
			$wgOut->addExtensionStyle( "$wgTranslateCssLocation/Translate.css" );
		} else {
			$wgHooks['SkinTemplateSetupPageCss'][] = array( __CLASS__ , 'injectCSSCB' );
		}
		$done = true;
	}

	public static function injectCSSCB( &$css ) {
		$file = dirname( __FILE__ ) . '/Translate.css';
		$css .= "/*<![CDATA[*/\n" . htmlspecialchars( file_get_contents( $file ) ) . "\n/*]]>*/";
		return true;
	}

	public static function snippet( &$text, $length = 10 ) {
		global $wgLegalTitleChars, $wgContLang;
		$snippet = preg_replace( "/[^\p{L}]/u", ' ', $text );
		$snippet = preg_replace( "/ {2,}/u", ' ', $snippet );
		$snippet = $wgContLang->truncate( $snippet, $length, '' );
		$snippet = str_replace( ' ', '_', trim( $snippet ) );
		return $snippet;
	}

}

class HTMLSelector {
	private $options = array();
	private $selected = false;
	private $attributes = array();

	public function __construct( $name = false, $id = false, $selected = false ) {
		if ( $name ) $this->setAttribute( 'name', $name );
		if ( $id ) $this->setAttribute( 'id', $id );
		if ( $selected ) $this->selected = $selected;
	}

	public function setSelected( $selected ) {
		$this->selected = $selected;
	}

	public function setAttribute( $name, $value ) {
		$this->attributes[$name] = $value;
	}

	public function addOption( $name, $value = false, $selected = false ) {
		$selected = $selected ? $selected : $this->selected;
		$value = $value ? $value : $name;
		$this->options[] = Xml::option( $name, $value, $value === $selected );
	}

	public function getHTML() {
		return Xml::tags( 'select', $this->attributes, implode( "\n", $this->options ) );
	}
}
