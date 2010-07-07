<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Chris Stafford <c.stafford@gmail.com>
 * @version: 0.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class TitleDebug extends SpecialPage {
	
	function  __construct() {
		parent::__construct( "TitleDebug"  /*class*/, '' /*restriction*/);
		wfLoadExtensionMessages("TitleDebug");
		$this->pname = null;
	}
	
	public function execute( $subpage ) {
		global $wgRequest, $wgUser, $wgOut;

		if( wfReadOnly() ) {
			#$wgOut->readOnlyPage();
			#return;
		}
		if( $wgUser->isBlocked() ) {
			#$wgOut->blockedPage();
			#return;
		}

		/**
		 * initial output
		 */

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'TitleDebug' );
		$wgOut->setPageTitle( 'wgTitle Debugger' );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * show form
		 */

		$this->pname = $wgRequest->gettext('pagename');

		#$wgOut->addHtml("<pre>" . print_r($_GET, true) . "</pre>\n");
		$this->showInputForm();
		$this->showResults();
	}
	
	function showInputForm()
	{
		global $wgOut;
		$wgOut->addHtml( Xml::openElement( 'form', array(
													'action' => $this->mTitle->getLocalURL(),
													'method' => 'GET',
													) ) . "\n" );

		$wgOut->addHtml( wfMsg('titledebug-pagename') . " " );
		$wgOut->addHtml( Xml::input( 'pagename', 40, $this->pname) . " " );

		$wgOut->addHtml( Xml::submitButton( wfMsg('titledebug-button') ) . "\n" );
		$wgOut->addHtml( Xml::closeElement('form') . "\n");
		
	}

	function showResults()
	{
		if( empty($this->pname) ){
			return;
		}

		$t = Title::newFromText($this->pname);
		
		global $wgOut;
		$wgOut->addHtml( Xml::element( 'hr', null, '', true ) . "\n" );
		
		$wgOut->addHtml("<table border='1'>\n");
		
		$wgOut->addHtml("<tr><td>getText</td>" .           "<td>" . $t->getText() .           "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getPartialURL</td>" .     "<td>" . $t->getPartialURL() .     "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getDBkey</td>" .          "<td>" . $t->getDBkey() .          "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getNamespace</td>" .      "<td>" . $t->getNamespace() .      "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getNsText</td>" .         "<td>" . $t->getNsText() .         "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getUserCaseDBKey</td>" .  "<td>" . $t->getUserCaseDBKey() .  "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getSubjectNsText</td>" .  "<td>" . $t->getSubjectNsText() .  "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getTalkNsText</td>" .     "<td>" . $t->getTalkNsText() .     "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getInterwiki</td>" .      "<td>" . $t->getInterwiki() .      "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getFragment</td>" .       "<td>" . $t->getFragment() .       "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getFragmentForURL</td>" . "<td>" . $t->getFragmentForURL() . "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getPrefixedDBkey</td>" .  "<td>" . $t->getPrefixedDBkey() .  "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getPrefixedText</td>" .   "<td>" . $t->getPrefixedText() .   "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getFullText</td>" .       "<td>" . $t->getFullText() .       "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getBaseText</td>" .       "<td>" . $t->getBaseText() .       "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getSubpageText</td>" .    "<td>" . $t->getSubpageText() .    "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getPrefixedURL</td>" .    "<td>" . $t->getPrefixedURL() .    "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getFullURL</td>" .        "<td>" . $t->getFullURL() .        "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getLocalURL</td>" .       "<td>" . $t->getLocalURL() .       "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getLinkUrl</td>" .        "<td>" . $t->getLinkUrl() .        "</td></tr>\n");
		$wgOut->addHtml("<tr><td>escapeLocalURL</td>" .    "<td>" . $t->escapeLocalURL() .    "</td></tr>\n");
		$wgOut->addHtml("<tr><td>escapeFullURL</td>" .     "<td>" . $t->escapeFullURL() .     "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getInternalURL</td>" .    "<td>" . $t->getInternalURL() .    "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getEditURL</td>" .        "<td>" . $t->getEditURL() .        "</td></tr>\n");
		$wgOut->addHtml("<tr><td>getEscapedText</td>" .    "<td>" . $t->getEscapedText() .    "</td></tr>\n");
		#$wgOut->addHtml("<tr><td></td>" .                  "<td>" . $t->() .                  "</td></tr>\n");
		
		$wgOut->addHtml("</table>\n");
	}
}
