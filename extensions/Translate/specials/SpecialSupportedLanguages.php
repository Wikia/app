<?php
/**
 * Contains logic for special page Special:SupportedLanguages
 *
 * @file
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright  Copyright © 2010, Niklas Laxström, Siebrand Mazeland
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
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialSupportedLanguages extends UnlistedSpecialPage {
	public function __construct() {
		parent::__construct( 'SupportedLanguages' );
	}

	public function execute( $par ) {
		global $wgLang, $wgOut;

		/**
		 * Requires NS_PORTAL. If not present, display error text.
		 */
		if ( !defined( 'NS_PORTAL' ) ) {
			$wgOut->showErrorPage( 'supportedlanguages-noportal-title', 'supportedlanguages-noportal' );
			return;
		}

		$this->outputHeader();
		$this->setHeaders();

		/**
		 * Check if CLDR extension has been installed.
		 */
		$cldrInstalled = class_exists( 'LanguageNames' );

		if ( $cldrInstalled ) {
			$locals = LanguageNames::getNames( $wgLang->getCode(),
				LanguageNames::FALLBACK_NORMAL,
				LanguageNames::LIST_MW_AND_CLDR
			);
		}

		$natives = Language::getLanguageNames( false );
		ksort( $natives );

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
				@$users[$code][] = $user;
			}
		}

		$lb->execute();

		global $wgUser;

		$skin = $wgUser->getSkin();
		$portalBaseText = wfMsg( 'portal' );

		/**
		 * Information to be used inside the foreach loop.
		 */
		$linkInfo['rc']['title'] = SpecialPage::getTitleFor( 'Recentchanges' );
		$linkInfo['rc']['msg'] = wfMsg( 'supportedlanguages-recenttranslations' );
		$linkInfo['stats']['title'] = SpecialPage::getTitleFor( 'LanguageStats' );
		$linkInfo['stats']['msg'] = wfMsg( 'languagestats' );

		foreach ( array_keys( $users ) as $code ) {
			$portalTitle = Title::makeTitleSafe( NS_PORTAL, $code );
			$portalText = $portalBaseText;

			/**
			 * If CLDR is installed, add localised header and link title.
			 */
			if ( $cldrInstalled ) {
				$headerText = wfMsg( 'supportedlanguages-portallink', $code, $locals[$code], $natives[$code] );
				$portalText .= ' ' . $locals[$code];
			} else {
				/**
				 * No CLDR, so a less localised header and link title.
				 */
				$headerText = wfMsg( 'supportedlanguages-portallink-nocldr', $code, $natives[$code] );
				$portalText .= ' ' . $natives[$code];
			}

			$portalLink = $skin->link(
				$portalTitle,
				$headerText,
				array(
					'id' => $code,
					'title' => $portalText
				),
				array(),
				array( 'known', 'noclasses' )
			);

			$wgOut->addHTML( "<h2>" . $portalLink . "</h2>" );

			/**
			 * Add useful links for language stats and recent changes for the language.
			 */
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

			foreach ( $users[$code] as $index => $username ) {
				$title = Title::makeTitleSafe( NS_USER, $username );
				$users[$code][$index] = $skin->link( $title, $username );
			}

			$wgOut->addHTML( "<p>" . wfMsgExt(
				'supportedlanguages-translators',
				'parsemag',
				$wgLang->listToText( $users[$code] ),
				count( $users[$code] )
			) . "</p>\n" );
		}
	}
}
