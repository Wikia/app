<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Implements a special page which shows all translations for a message.
 * Bits taken from SpecialPrefixindex.php and TranslateTasks.php
 *
 * @author Siebrand Mazeland
 * @author Niklas Laxstörm
 * @copyright Copyright © 2008 Siebrand Mazeland
 * @copyright Copyright © 2009 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class SpecialTranslations extends SpecialAllpages {
	function __construct() {
		parent::__construct( 'Translations' );
	}

	/**
	 * Entry point : initialise variables and call subfunctions.
	 * @param $par String: becomes "MediaWiki:Allmessages" when called like
	 *             Special:Translations/MediaWiki:Allmessages (default null)
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut;

		wfLoadExtensionMessages( 'Translate' );
		$this->setHeaders();
		$this->outputHeader();

		$title = null;

		if ( $this->including() ) {
			$title = Title::newFromText( $par );
			if ( !$title ) {
				$wgOut->addWikiMsg( 'translate-translations-including-no-param' );
			} else {
				$this->showTranslations( $title );
			}
			return;
		}


		# GET values
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
	*/
	function namespaceMessageForm( Title $title = null ) {
		global $wgContLang, $wgScript, $wgTranslateMessageNamespaces;
		$t = $this->getTitle();

		$namespaces = new XmlSelect( 'namespace' );
		$namespaces->setDefault( $title->getNamespace() );

		foreach ( $wgTranslateMessageNamespaces as $ns ) {
			$namespaces->addOption( $wgContLang->getFormattedNsText( $ns ), $ns );
		}

		$out  = Xml::openElement( 'div', array( 'class' => 'namespaceoptions' ) );
		$out .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) );
		$out .= Xml::hidden( 'title', $t->getPrefixedText() );
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

	function showTranslations( Title $title ) {
		global $wgOut, $wgUser, $wgContLang, $wgLang;

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
				'page_title LIKE \'' . $dbr->escapeLike( $message ) . '\/%\'',
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
		}

		// Normal output
		$titles = array();
		foreach ( $res as $s ) { $titles[] = $s->page_title; }
		$pageInfo = TranslateUtils::getContents( $titles, $namespace );

		$tableheader = Xml::openElement( 'table', array(
			'class'   => 'mw-sp-translate-table',
			'border'  => '1',
			'cellspacing' => '0' )
		);

		$tableheader .= Xml::openElement( 'tr' );
		$tableheader .= Xml::element( 'th', null, wfMsg( 'allmessagesname' ) );
		$tableheader .= Xml::element( 'th', null, wfMsg( 'allmessagescurrent' ) );
		$tableheader .= Xml::closeElement( 'tr' );

		// Adapted version of TranslateUtils:makeListing() by Nikerabbit
		$out = $tableheader;

		$canTranslate = $wgUser->isAllowed( 'translate' );

		foreach ( $res as $s ) {
			$key = $s->page_title;
			$t = Title::makeTitle( $s->page_namespace, $key );

			$niceTitle = htmlspecialchars( $this->getTheCode( $s->page_title ) );

			if ( $canTranslate ) {
				$tools['edit'] = $sk->link(
					$t,
					$niceTitle,
					array( 'action' ),
					array(
						'action' => 'edit',
						'loadgroup' => $inMessageGroup
					)
				);
			} else {
				$tools['edit'] = $sk->link( $t, $niceTitle );
			}

			$tools['history'] = $sk->link(
				$t,
				"&nbsp;<sup>h</sup>&nbsp;",
				array( 'action' ),
				array( 'action' => 'history' )
			);

			$anchor = 'msg_' . $key;
			$anchor = Xml::element( 'a', array( 'name' => $anchor, 'href' => "#$anchor" ), "↓" );

			$extra = '';

			if ( TranslateEditAddons::isFuzzy( $t ) ) {
				$class = 'orig';
			} else {
				$class = 'def';
			}
			
			$leftColumn = $anchor . $tools['history'] . $tools['edit'] . $extra;
			$out .= Xml::tags( 'tr', array( 'class' => $class ),
				Xml::tags( 'td', null, $leftColumn ) .
				Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $pageInfo[$key][0] ) )
			);
		}
		TranslateUtils::injectCSS();

		$out .= Xml::closeElement( 'table' );
		$wgOut->addHTML( $out );
	}

	public function getTheCode( $name ) {
		$from = strrpos( $name, '/' );
		return substr( $name, $from + 1 );
	}
}
