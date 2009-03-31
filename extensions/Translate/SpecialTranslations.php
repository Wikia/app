<?php
if ( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Implements a special page which shows all translations for a message.
 * Bits taken from SpecialPrefixindex.php and TranslateTasks.php
 *
 * @author Siebrand Mazeland
 * @copyright Copyright © 2008 Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class SpecialTranslations extends SpecialAllpages {
	// Inherit $maxPerPage

	// Define other properties
	protected $nsfromMsg = 'translate-messagename';

	function __construct(){
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

		if( $this->including() ){
			$title = Title::newFromText( $par );
			if( $title instanceof Title ){
				$message = $title->getText();
				$namespace = $title->getNamespace();

				$this->showTranslations( $namespace, $message );
			} else {
				$wgOut->addWikiMsg( 'translate-translations-including-no-param' );
			}
		} else {
			# GET values
			$message = $wgRequest->getVal( 'message' );
			$namespace = $wgRequest->getInt( 'namespace' );

			if( isset( $message ) && $message != '' ){
				$this->showTranslations( $namespace, $message );
			} else {
				$title = Title::newFromText( $par );
				if( $title instanceof Title ){
					$message = $title->getText();
					$namespace = $title->getNamespace();
	
					$this->showTranslations( $namespace, $message );
				} else {
					$wgOut->addHTML( $this->namespaceMessageForm( $namespace, null ) );
				}
			}
		}
	}

	/**
	* HTML for the top form
	* @param integer $namespace A namespace constant (default NS_MAIN).
	* @param string $from dbKey we are starting listing at.
	*/
	function namespaceMessageForm( $namespace = NS_MAIN, $message = '' ) {
		global $wgContLang, $wgScript, $wgTranslateMessageNamespaces;
		$t = $this->getTitle();

		$namespaces = new XmlSelect( 'namespace' );
		foreach ($wgTranslateMessageNamespaces as $ns ) {
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
					Xml::input( 'message', 30, str_replace('_',' ',$message), array( 'id' => 'message' ) ) .
				"</td>
			</tr>
			<tr>
				<td class='mw-label'>" .
					Xml::label( wfMsg( 'namespace' ), 'namespace' ) .
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
	 * @param integer $namespace (Default NS_MAIN)
	 * @param string $from list all pages from this name (default FALSE)
	 */
	function showTranslations( $namespace = NS_MAIN, $message ) {
		global $wgOut, $wgUser, $wgContLang, $wgLang;

		$sk = $wgUser->getSkin();

		$messageList = $this->getNamespaceKeyAndText( $namespace, $message );
		list( $namespace, $message, $pageName ) = $messageList;
		$title = Title::newFromText( $message, $namespace );

		$inMessageGroup = TranslateUtils::messageKeyToGroup( $title->getNamespace(), $title->getBaseText() );

		if( !$this->including() )
			$wgOut->addHTML( $this->namespaceMessageForm( $namespace, $message ) );

		if( !$inMessageGroup ) {
			if( $namespace ) {
				$out = wfMsg( 'translate-translations-no-message', $title->getPrefixedText() );
			} else {
				$out = wfMsg( 'translate-translations-no-message', $message );
			}
		} else {
			$dbr = wfGetDB( DB_SLAVE );

			$res = $dbr->select( 'page',
				array( 'page_namespace', 'page_title' ),
				array(
					'page_namespace' => $namespace,
					'page_title LIKE \'' . $dbr->escapeLike( $message ) .'\/%\'',
				),
				__METHOD__,
				array(
					'ORDER BY'  => 'page_title',
					'USE INDEX' => 'name_title',
				)
			);

			if( $res->numRows() ) {
				$titles = array();
				foreach ( $res as $s ) { $titles[] = $s->page_title; }
				$pageInfo = TranslateUtils::getContents( $titles, $namespace );

				// Adapted version of TranslateUtils:makeListing() by Nikerabbit
				$out = TranslateUtils::tableHeader();

				foreach ( $res as $s ) {
					$key = $s->page_title;
					$t = Title::makeTitle( $s->page_namespace, $key );

					$niceTitle = htmlspecialchars( $wgLang->truncate( $key, - 30, '…' ) );

					if ( 1 || $wgUser->isAllowed( 'translate' ) ) {
						$tools['edit'] = $sk->makeKnownLinkObj( $t, $niceTitle, "action=edit&loadgroup=$inMessageGroup" );
					} else {
						$tools['edit'] = '';
					}

					$anchor = 'msg_' . $key;
					$anchor = Xml::element( 'a', array( 'name' => $anchor, 'href' => "#$anchor" ), "↓" );

					$extra = '';

					$leftColumn = $anchor . $tools['edit'] . $extra;
					$out .= Xml::tags( 'tr', array( 'class' => 'def' ),
						Xml::tags( 'td', null, $leftColumn ) .
						Xml::tags( 'td', null, TranslateUtils::convertWhiteSpaceToHTML( $pageInfo[$key][0] ) )
					);
				}
				TranslateUtils::injectCSS();

				$out .= Xml::closeElement( 'table' );
			} else {
				if( $namespace ) {
					$out = wfMsg( 'translate-translations-none', $title->getPrefixedText() );
				} else {
					$out = wfMsg( 'translate-translations-none', $message );
				}
			}

		}
		$wgOut->addHTML( $out );
	}
}
