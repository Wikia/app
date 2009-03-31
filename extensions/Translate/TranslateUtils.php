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
		return $cache[$message] . '/' . $code;
	}

	/**
	 * Fills the actual translation from database, if any.
	 *
	 * @param $messages MessageCollection
	 * @param $namespaces Array: two-item 1-d array with namespace numbers
	 */
	public static function fillContents( MessageCollection $messages,
		array $namespaces ) {
		wfMemIn( __METHOD__ ); wfProfileIn( __METHOD__ );

		$titles = array();
		foreach ( $messages->keys() as $key ) {
			$titles[] = self::title( $key, $messages->code );
		}

		if ( !count( $titles ) ) return;

		// Fetch contents
		$titles = self::getContents( $titles, $namespaces[0] );

		foreach ( $messages->keys() as $key ) {
			$title = self::title( $key, $messages->code );
			if ( isset( $titles[$title] ) ) {
				$messages[$key]->database = $titles[$title][0];
				$messages[$key]->addAuthor( $titles[$title][1] );
			}
		}

		wfProfileOut( __METHOD__ ); wfMemOut( __METHOD__ );
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
		wfMemIn( __METHOD__ ); wfProfileIn( __METHOD__ );
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
		wfProfileOut( __METHOD__ ); wfMemOut( __METHOD__ );
	}

	public static function translationChanges( $hours = 24 ) {
		wfMemIn( __METHOD__ );
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
		"AND rc_namespace in ($namespaces) " .
		"ORDER BY lang ASC, rc_timestamp DESC";

		$res = $dbr->query( $sql, __METHOD__ );

		// Fetch results, prepare a batch link existence check query
		$rows = array();
		while ( $row = $dbr->fetchObject( $res ) ) {
			$rows[] = $row;
		}
		$dbr->freeResult( $res );
		wfMemOut( __METHOD__ );
		return $rows;
	}

	/* Table output helpers */

	public static function tableHeader( $title = '' ) {
		$tableheader = Xml::openElement( 'table', array(
			'class'   => 'mw-sp-translate-table',
			'border'  => '1',
			'cellspacing' => '0' )
		);

		$tableheader .= Xml::openElement( 'tr' );
		$tableheader .= Xml::element( 'th',
			array( 'rowspan' => '2' ),
			$title ? $title : wfMsgHtml( 'allmessagesname' )
		);
		$tableheader .= Xml::element( 'th', null, wfMsgHtml( 'allmessagesdefault' ) );
		$tableheader .= Xml::closeElement( 'tr' );

		$tableheader .= Xml::openElement( 'tr' );
		$tableheader .= Xml::element( 'th', null, wfMsgHtml( 'allmessagescurrent' ) );
		$tableheader .= Xml::closeElement( 'tr' );

		return $tableheader;
	}

	public static function makeListing( MessageCollection $messages, $group,
		$review = false, array $namespaces ) {

		global $wgUser;
		$sk = $wgUser->getSkin();
		wfLoadExtensionMessages( 'Translate' );

		$uimsg = array();
		foreach ( array( 'edit', 'optional' ) as $msg ) {
			$uimsg[$msg] = wfMsgHtml( self::MSG . $msg );
		}

		$output =  '';

		foreach ( $messages as $key => $m ) {

			$tools = array();

			$title = Title::makeTitle(
				$namespaces[0],
				self::title( $key, $messages->code )
			);

			$original = $m->definition;
			$message = $m->translation ? $m->translation : $original;

			global $wgLang;
			$niceTitle = htmlspecialchars( $wgLang->truncate( $key, - 30, '…' ) );

			if ( 1 || $wgUser->isAllowed( 'translate' ) ) {
				$tools['edit'] = $sk->makeKnownLinkObj( $title, $niceTitle, "action=edit&loadgroup=$group" );
			} else {
				$tools['edit'] = '';
			}

			$anchor = 'msg_' . $key;
			$anchor = Xml::element( 'a', array( 'name' => $anchor, 'href' => "#$anchor" ), "↓" );

			$extra = '';
			if ( $m->optional ) $extra = '<br />' . $uimsg['optional'];

			$leftColumn = $anchor . $tools['edit'] . $extra;

			if ( $review ) {
				$output .= Xml::tags( 'tr', array( 'class' => 'orig' ),
					Xml::tags( 'td', array( 'rowspan' => '2' ), $leftColumn ) .
					Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $original ) )
				);

				$output .= Xml::tags( 'tr', array( 'class' => 'new' ),
					Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $message ) ) .
					Xml::closeElement( 'tr' )
				);
			} else {
				$output .= Xml::tags( 'tr', array( 'class' => 'def' ),
					Xml::tags( 'td', null, $leftColumn ) .
					Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $message ) )
				);
			}

		}

		return $output;
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
		wfMemIn( __METHOD__ );
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
		wfMemOut( __METHOD__ );
		return isset( $languages[$code] ) ? $languages[$code] . $suffix : false;
	}

	public static function languageSelector( $language, $selectedId ) {
		wfMemIn( __METHOD__ );
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
		wfMemOut( __METHOD__ );
		return $selector->getHTML();
	}

	public static function messageKeyToGroup( $namespace, $key ) {
		$key = self::normaliseKey( $namespace, $key );
		$index = self::messageIndex();
		return @$index[$key];
	}

	public static function normaliseKey( $namespace, $key ) {
		return str_replace( " ", "_", strtolower( "$namespace:$key" ) );
	}

	public static function messageIndex() {
		wfMemIn( __METHOD__ );
		$keyToGroup = array();
		if ( file_exists( TRANSLATE_INDEXFILE ) ) {
			$keyToGroup = unserialize( file_get_contents( TRANSLATE_INDEXFILE ) );
		} else {
			wfDebug( __METHOD__ . ": Message index missing." );
		}

		wfMemOut( __METHOD__ );
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
			$wgOut->addLink( array( 'rel' => 'stylesheet', 'type' => 'text/css',
				'href' => "$wgTranslateCssLocation/Translate.css", )
			);
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
		$snippet = $wgContLang->truncate( $snippet, $length );
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
