<?php
/**
 * Contains logic for special page Special:SupportedLanguages
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2012, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements unlisted special page Special:SupportedLanguages. The wiki
 * administrator must define NS_PORTAL, otherwise this page does not work.
 * This page displays a list of language portals for all portals corresponding
 * with a language code defined for MediaWiki and a subpage called
 * "translators". The subpage "translators" must contain the template
 * [[:{{ns:template}}:User|User]], taking a user name as parameter.
 *
 * @ingroup SpecialPage TranslateSpecialPage Stats
 */
class SpecialSupportedLanguages extends SpecialPage {
	/// Whether to skip and regenerate caches
	protected $purge = false;

	/// Cutoff time for inactivity in days
	protected $period = 180;

	public function __construct() {
		parent::__construct( 'SupportedLanguages' );
	}

	public function execute( $par ) {
		global $wgLang, $wgOut, $wgRequest;

		$this->purge = $wgRequest->getVal( 'action' ) === 'purge';

		$this->setHeaders();
		TranslateUtils::addSpecialHelpLink( $wgOut, 'Help:Extension:Translate/Statistics_and_reporting#List_of_languages_and_translators' );
		$wgOut->addModules( 'ext.translate.special.supportedlanguages' );

		$cache = wfGetCache( CACHE_ANYTHING );
		$cachekey = wfMemcKey( 'translate-supportedlanguages', $wgLang->getCode() );
		$data = $cache->get( $cachekey );
		if ( !$this->purge && is_string( $data ) ) {
			$wgOut->addHtml( $data );
			return;
		}

		$this->outputHeader();
		$wgOut->addWikiMsg( 'supportedlanguages-colorlegend', $this->getColorLegend() );
		$wgOut->addWikiMsg( 'supportedlanguages-localsummary' );

		// Check if CLDR extension has been installed.
		$cldrInstalled = class_exists( 'LanguageNames' );

		if ( $cldrInstalled ) {
			$locals = LanguageNames::getNames( $wgLang->getCode(),
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		}

		$natives = Language::getLanguageNames( false );
		ksort( $natives );

		$this->outputLanguageCloud( $natives );


		// Requires NS_PORTAL. If not present, display error text.
		if ( !defined( 'NS_PORTAL' ) ) {
			$users = $this->fetchTranslatorsAuto();
		} else {
			$users = $this->fetchTranslatorsPortal( $natives );
		}

		$this->preQueryUsers( $users );

		list( $editcounts, $lastedits ) = $this->getUserStats();
		global $wgUser;

		$skin = $wgUser->getSkin();

		// Information to be used inside the foreach loop.
		$linkInfo['rc']['title'] = SpecialPage::getTitleFor( 'Recentchanges' );
		$linkInfo['rc']['msg'] = wfMsg( 'supportedlanguages-recenttranslations' );
		$linkInfo['stats']['title'] = SpecialPage::getTitleFor( 'LanguageStats' );
		$linkInfo['stats']['msg'] = wfMsg( 'languagestats' );

		foreach ( array_keys( $natives ) as $code ) {
			if ( !isset( $users[$code] ) ) continue;

			// If CLDR is installed, add localised header and link title.
			if ( $cldrInstalled ) {
				$headerText = wfMsg( 'supportedlanguages-portallink', $code, $locals[$code], $natives[$code] );
			} else {
				// No CLDR, so a less localised header and link title.
				$headerText = wfMsg( 'supportedlanguages-portallink-nocldr', $code, $natives[$code] );
			}

			$headerText = htmlspecialchars( $headerText );

			$wgOut->addHtml( Html::openElement( 'h2', array( 'id' => $code ) ) );
			if ( defined( 'NS_PORTAL' ) ) {
				$portalTitle = Title::makeTitleSafe( NS_PORTAL, $code );
				$wgOut->addHtml( $skin->linkKnown( $portalTitle, $headerText ) );
			} else {
				$wgOut->addHtml( $headerText );
			}

			$wgOut->addHTML( "</h2>" );

			// Add useful links for language stats and recent changes for the language.
			$links = array();
			$links[] = $skin->link(
				$linkInfo['stats']['title'],
				$linkInfo['stats']['msg'],
				array(),
				array(
					'code' => $code,
					'suppresscomplete' => '1'
				),
				array( 'known', 'noclasses' )
			);
			$links[] = $skin->link(
				$linkInfo['rc']['title'],
				$linkInfo['rc']['msg'],
				array(),
				array(
					'translations' => 'only',
					'trailer' => "/" . $code
				),
				array( 'known', 'noclasses' )
			);
			$linkList = $wgLang->listToText( $links );

			$wgOut->addHTML( "<p>" . $linkList . "</p>\n" );
			$this->makeUserList( $users[$code], $editcounts, $lastedits );

		}
		$wgOut->addHtml( Html::element( 'hr' ) );
		$wgOut->addWikiMsg( 'supportedlanguages-count', $wgLang->formatNum( count( $users ) ) );

		$cache->set( $cachekey, $wgOut->getHTML(), 3600 );
	}

	protected function languageCloud() {
		global $wgTranslateMessageNamespaces;

		$cache = wfGetCache( CACHE_ANYTHING );
		$cachekey = wfMemcKey( 'translate-supportedlanguages-language-cloud' );
		$data = $cache->get( $cachekey );
		if ( !$this->purge && is_array( $data ) ) {
			return $data;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( 'recentchanges' );
		$fields = array( 'substring_index(rc_title, \'/\', -1) as lang', 'count(*) as count' );
		$conds = array(
			'rc_title' . $dbr->buildLike( $dbr->anyString(), '/', $dbr->anyString() ),
			'rc_namespace' => $wgTranslateMessageNamespaces,
			'rc_timestamp > ' . $dbr->timestamp( TS_DB, wfTimeStamp( TS_UNIX ) - 60 * 60 * 24 * $this->period ),
		);
		$options = array( 'GROUP BY' => 'lang', 'HAVING' => 'count > 20' );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options );

		$data = array();
		foreach ( $res as $row ) {
			$data[$row->lang] = $row->count;
		}

		$cache->set( $cachekey, $data, 3600 );
		return $data;
	}

	protected function fetchTranslatorsAuto() {
		global $wgTranslateMessageNamespaces;

		$cache = wfGetCache( CACHE_ANYTHING );
		$cachekey = wfMemcKey( 'translate-supportedlanguages-translator-list' );
		$data = $cache->get( $cachekey );
		if ( !$this->purge && is_array( $data ) ) {
			return $data;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'revision' );
		$fields = array( 'rev_user_text', 'substring_index(page_title, \'/\', -1) as lang', 'count(page_id) as count' );
		$conds = array(
			'page_title' . $dbr->buildLike( $dbr->anyString(), '/', $dbr->anyString() ),
			'page_namespace' => $wgTranslateMessageNamespaces,
			'page_id=rev_page',
		);
		$options = array( 'GROUP BY' => 'rev_user_text, lang' );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options );

		$data = array();
		foreach ( $res as $row ) {
			$data[$row->lang][$row->rev_user_text] = $row->count;
		}

		$cache->set( $cachekey, $data, 3600 );
		return $data;
	}

	public function fetchTranslatorsPortal( $natives ) {
		$titles = array();
		foreach ( $natives as $code => $_ ) {
			$titles[] = Title::capitalize( $code, NS_PORTAL ) . '/translators';
		}

		$dbr = wfGetDB( DB_SLAVE );
		$tables = array( 'page', 'revision', 'text' );
		$vars = array_merge( Revision::selectTextFields(), array( 'page_title', 'page_namespace' ), Revision::selectFields() );
		$conds = array(
			'page_latest = rev_id',
			'rev_text_id = old_id',
			'page_namespace' => NS_PORTAL,
			'page_title' => $titles,
		);

		$res = $dbr->select( $tables, $vars, $conds, __METHOD__ );

		$users = array();
		$lb = new LinkBatch;

		foreach ( $res as $row ) {
			$rev = new Revision( $row );
			$text = $rev->getText();
			$code = strtolower( preg_replace( '!/translators$!', '', $row->page_title ) );

			preg_match_all( '!{{[Uu]ser\|([^}|]+)!', $text, $matches,  PREG_SET_ORDER );
			foreach ( $matches as $match ) {
				$user = Title::capitalize( $match[1], NS_USER );
				$lb->add( NS_USER, $user );
				$lb->add( NS_USER_TALK, $user );
				if ( !isset( $users[$code] ) ) $users[$code] = array();
				$users[$code][strtr( $user, '_', ' ' )] = -1;
			}
		}

		$lb->execute();
		return $users;
	}

	protected function outputLanguageCloud( $names ) {
		global $wgOut;

		$langs = $this->languageCloud();
		$wgOut->addHtml( '<div class="tagcloud">' );
		$langs = $this->shuffle_assoc( $langs );
		foreach ( $langs as $k => $v ) {
			$name = isset( $names[$k] ) ? $names[$k] : $k;
			$size = round( log( $v ) * 20 ) + 10;

			$params = array(
				'href' => "#$k",
				'class' => 'tag',
				'style' => "font-size:$size%",
				'lang' => $k,
			);

			$tag = Html::element( 'a', $params, $name );
			$wgOut->addHtml( $tag . "\n" );
		}
		$wgOut->addHtml( '</div>' );
	}

	protected function makeUserList( $users, $editcounts, $lastedits ) {
		global $wgOut, $wgLang, $wgUser;
		$skin = $wgUser->getSkin();

		$day = 60 * 60 * 24;

		// Scale of the activity colors, anything
		// longer than this is just inactive
		$period = $this->period;

		$links = array();

		foreach ( $users as $username => $count ) {
			$title = Title::makeTitleSafe( NS_USER, $username );
			$enc = htmlspecialchars( $username );

			$attribs = array();
			$styles = array();
			if ( isset( $editcounts[$username] ) ) {
				if ( $count === -1 ) $count = $editcounts[$username];

				$styles['font-size'] = round( log( $count, 10 ) * 30 ) + 70 . '%';

				$last = wfTimestamp( TS_UNIX ) - $lastedits[$username];
				$last = round( $last / $day );
				$attribs['title'] = wfMsgExt( 'supportedlanguages-activity', 'parsemag',
					$username, $wgLang->formatNum( $count ), $wgLang->formatNum( $last ) );
				$last = max( 1, min( $period, $last ) );
				$styles['border-bottom'] = '3px solid #' . $this->getActivityColour( $period - $last, $period );
				# $styles['color'] = '#' . $this->getBackgroundColour( $period - $last, $period );
			} else {
				$enc = "<s>$enc</s>";
			}

			$stylestr = $this->formatStyle( $styles );
			if ( $stylestr ) $attribs['style'] = $stylestr;

			$links[] = $skin->link( $title, $enc, $attribs );
		}

		$wgOut->addHTML( "<p class='mw-translate-spsl-translators'>" . wfMsgExt(
			'supportedlanguages-translators',
			'parsemag',
			$wgLang->listToText( $links ),
			count( $links )
		) . "</p>\n" );
	}

	protected function getUserStats() {
		$cache = wfGetCache( CACHE_ANYTHING );
		$cachekey = wfMemcKey( 'translate-supportedlanguages-userstats' );
		$data = $cache->get( $cachekey );
		if ( !$this->purge && is_array( $data ) ) {
			return $data;
		}

		$dbr = wfGetDB( DB_SLAVE );
		$editcounts = $lastedits = array();
		$tables = array( 'user', 'revision' );
		$fields = array( 'user_name', 'user_editcount', 'MAX(rev_timestamp) as lastedit' );
		$conds = array( 'user_id = rev_user' );
		$options = array( 'GROUP BY' => 'user_name' );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options );
		foreach ( $res as $row ) {
			$editcounts[$row->user_name] = $row->user_editcount;
			$lastedits[$row->user_name] = wfTimestamp( TS_UNIX, $row->lastedit );
		}

		$data = array( $editcounts, $lastedits );
		$cache->set( $cachekey, $data, 3600 );
		return $data;
	}

	protected function formatStyle( $styles ) {
		$stylestr = '';
		foreach ( $styles as $key => $value ) {
			$stylestr .= "$key:$value;";
		}
		return $stylestr;
	}

	/// FIXME: copied from Special:LanguageStats
	protected function getActivityColour( $subset, $total ) {
		$v = @round( 255 * $subset / $total );

		if ( $v < 128 ) {
			// Red to Yellow
			$red = 'FF';
			$green = sprintf( '%02X', 2 * $v );
		} else {
			// Yellow to Green
			$red = sprintf( '%02X', 2 * ( 255 - $v ) );
			$green = 'FF';
		}
		$blue = '00';

		return $red . $green . $blue;
	}

	function shuffle_assoc( $list ) {
		if ( !is_array( $list ) ) return $list;

		$keys = array_keys( $list );
		shuffle( $keys );
		$random = array();
		foreach ( $keys as $key )
			$random[$key] = $list[$key];

		return $random;
	}

	protected function preQueryUsers( $users ) {
		$lb = new LinkBatch;
		foreach ( $users as $translators ) {
			foreach ( $translators as $user => $count ) {
				$user = Title::capitalize( $user, NS_USER );
				$lb->add( NS_USER, $user );
				$lb->add( NS_USER_TALK, $user );
			}
		}
		$lb->execute();
	}

	protected function getColorLegend() {
		global $wgLang;

		$legend = '';
		$period = $this->period;

		for ( $i = 0; $i <= $period; $i += 30 ) {
			$iFormatted = $wgLang->formatNum( $i );
			$legend .= '<span style="background-color:#' . $this->getActivityColour( $period - $i, $period ) . "\"> $iFormatted</span>";
		}
		return $legend;
	}
}
