<?php
/**
 * Contains logic for special page Special:Translations.
 *
 * @file
 * @author Siebrand Mazeland
 * @author Niklas Laxstörm
 * @copyright Copyright © 2008-2010 Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Implements a special page which shows all translations for a message.
 * Bits taken from SpecialPrefixindex.php and TranslateTasks.php
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialTranslations extends SpecialAllpages {
	function __construct() {
		parent::__construct( 'Translations' );
	}

	/**
	 * Entry point : initialise variables and call subfunctions.
	 * @param $par \string Message key. Becomes "MediaWiki:Allmessages" when called like
	 *             Special:Translations/MediaWiki:Allmessages (default null)
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();
		$this->outputHeader();

		self::includeAssets();

		if ( $this->including() ) {
			$title = Title::newFromText( $par );
			if ( !$title ) {
				$wgOut->addWikiMsg( 'translate-translations-including-no-param' );
			} else {
				$this->showTranslations( $title );
			}

			return;
		}

		/**
		 * GET values.
		 */
		$message = $wgRequest->getText( 'message' );
		$namespace = $wgRequest->getInt( 'namespace', NS_MAIN );
		if ( $message !== '' ) {
			$title = Title::newFromText( $message, $namespace );
		} else {
			$title = Title::newFromText( $par, $namespace );
		}

		if ( !$title ) {
			$title = Title::makeTitle( NS_MEDIAWIKI, '' );
			$wgOut->addHTML( $this->namespaceMessageForm( $title ) );
		} else {
			$wgOut->addHTML( $this->namespaceMessageForm( $title ) . '<br />' );
			$this->showTranslations( $title );
		}
	}

	/**
	 * Message input fieldset
	 *
	 * @param $title Title (default: null)
	 * @return \string HTML for fieldset.
	 */
	function namespaceMessageForm( Title $title = null ) {
		global $wgScript;

		$namespaces = new XmlSelect( 'namespace', 'namespace' );
		$namespaces->setDefault( $title->getNamespace() );

		foreach ( $this->getSortedNamespaces() as $text => $index ) {
			$namespaces->addOption( $text, $index );
		}

		$out  = Xml::openElement( 'div', array( 'class' => 'namespaceoptions' ) );
		$out .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) );
		$out .= Html::hidden( 'title', $this->getTitle()->getPrefixedText() );
		$out .= Xml::openElement( 'fieldset' );
		$out .= Xml::element( 'legend', null, wfMsg( 'translate-translations-fieldset-title' ) );
		$out .= Xml::openElement( 'table', array( 'id' => 'nsselect', 'class' => 'allpages' ) );
		$out .= "<tr>
				<td class='mw-label'>" .
				Xml::label( wfMsg( 'translate-translations-messagename' ), 'message' ) .
				"</td>
				<td class='mw-input'>" .
					Xml::input( 'message', 30, $title->getText(), array( 'id' => 'message' ) ) .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'translate-translations-project' ), 'namespace' ) .
				"</td>
				<td class='mw-input'>" .
					$namespaces->getHTML() . ' ' .
					Xml::submitButton( wfMsg( 'allpagessubmit' ) ) .
				"</td>
				</tr>";
		$out .= Xml::closeElement( 'table' );
		$out .= Xml::closeElement( 'fieldset' );
		$out .= Xml::closeElement( 'form' );
		$out .= Xml::closeElement( 'div' );

		return $out;
	}

	/**
	 * Returns sorted array of namespaces.
	 *
	 * @return \arrayof{String,Integer}
	 */
	public function getSortedNamespaces() {
		global $wgTranslateMessageNamespaces, $wgContLang;

		$nslist = array();
		foreach ( $wgTranslateMessageNamespaces as $ns ) {
			$nslist[$wgContLang->getFormattedNsText( $ns )] = $ns;
		}
		ksort( $nslist );

		return $nslist;
	}

	/**
	 * Builds a table with all translations of $title.
	 *
	 * @param $title Title (default: null)
	 * @return void
	 */
	function showTranslations( Title $title ) {
		global $wgOut, $wgUser, $wgLang;

		$sk = $wgUser->getSkin();

		$namespace = $title->getNamespace();
		$message = $title->getDBkey();

		$inMessageGroup = TranslateUtils::messageKeyToGroup( $title->getNamespace(), $title->getText() );

		if ( !$inMessageGroup ) {
			$wgOut->addWikiMsg( 'translate-translations-no-message', $title->getPrefixedText() );
			return;
		}

		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select( 'page',
			array( 'page_namespace', 'page_title' ),
			array(
				'page_namespace' => $namespace,
				'page_title ' . $dbr->buildLike( "$message/", $dbr->anyString() ),
			),
			__METHOD__,
			array(
				'ORDER BY'  => 'page_title',
				'USE INDEX' => 'name_title',
			)
		);

		if ( !$res->numRows() ) {
			$wgOut->addWikiMsg( 'translate-translations-no-message', $title->getPrefixedText() );
			return;
		} else {
			$wgOut->addWikiMsg( 'translate-translations-count', $wgLang->formatNum( $res->numRows() ) );
		}

		// Normal output.
		$titles = array();

		foreach ( $res as $s ) {
			$titles[] = $s->page_title;
		}

		$pageInfo = TranslateUtils::getContents( $titles, $namespace );

		$tableheader = Xml::openElement( 'table', array(
			'class'   => 'mw-sp-translate-table sortable'
		) );

		$tableheader .= Xml::openElement( 'tr' );
		$tableheader .= Xml::element( 'th', null, wfMsg( 'allmessagesname' ) );
		$tableheader .= Xml::element( 'th', null, wfMsg( 'allmessagescurrent' ) );
		$tableheader .= Xml::closeElement( 'tr' );

		// Adapted version of TranslateUtils:makeListing() by Nikerabbit.
		$out = $tableheader;

		$canTranslate = $wgUser->isAllowed( 'translate' );

		$ajaxPageList = array();
		$historyText = "&#160;<sup>" . wfMsgHtml( 'translate-translations-history-short' ) . "</sup>&#160;";

		foreach ( $res as $s ) {
			$key = $s->page_title;
			$tTitle = Title::makeTitle( $s->page_namespace, $key );
			$ajaxPageList[] = $tTitle->getDBkey();

			$code = $this->getCode( $s->page_title );

			$text = TranslateUtils::getLanguageName( $code, false, $wgLang->getCode() ) . " ($code)";
			$text = htmlspecialchars( $text );

			if ( $canTranslate ) {
				$tools['edit'] = TranslationHelpers::ajaxEditLink(
					$tTitle,
					$text
				);
			} else {
				$tools['edit'] = $sk->link( $tTitle, $text );
			}

			$tools['history'] = $sk->link(
				$tTitle,
				$historyText,
				array(
					'action',
					'title' => wfMsg( 'history-title', $tTitle->getPrefixedDbKey() )
				),
				array( 'action' => 'history' )
			);

			if ( TranslateEditAddons::isFuzzy( $tTitle ) ) {
				$class = 'orig';
			} else {
				$class = 'def';
			}

			$leftColumn = $tools['history'] . $tools['edit'];
			$out .= Xml::tags( 'tr', array( 'class' => $class ),
				Xml::tags( 'td', null, $leftColumn ) .
				Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $pageInfo[$key][0] ) )
			);
		}

		$out .= Xml::closeElement( 'table' );
		$wgOut->addHTML( $out );

		$vars = array(
			'trlKeys' => $ajaxPageList,
			'trlMsgNoNext' => wfMsg( 'translate-js-nonext' ),
			'trlMsgSaveFailed' => wfMsg( 'translate-js-save-failed' ),
		);

		$wgOut->addScript( Skin::makeVariablesScript( $vars ) );
	}

	/**
	 * Get code for a page name
	 *
	 * @param $name \string Page title (f.e. "MediaWiki:Main_page/nl").
	 * @return \string Language code
	 */
	private function getCode( $name ) {
		$from = strrpos( $name, '/' );
		return substr( $name, $from + 1 );
	}

	/**
	 * Add JavaScript assets
	 *
	 * @return void
	 */
	private static function includeAssets() {
		global $wgOut;
		TranslationHelpers::addModules( $wgOut );
		TranslateUtils::addModules( $wgOut, 'ext.translate.messagetable' );
	}
}
