<?php

class PhalanxStatsSpecialController extends WikiaSpecialPageController {
	privatet $blockId = 0;
	function __construct( ) {
		parent::__construct( 'PhalanxStats', 'phalanx', false );
	}
	
	public function index() {
		$this->wf->profileIn( __METHOD__ );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->wg->Out->setPageTitle( $this->wf->Msg('phalanx-stats-title') );
			$this->displayRestrictionError();
			$this->wf->profileOut( __METHOD__ );
			return false;
		}

		$this->response->addAsset('extensions/wikia/Phalanx/css/Phalanx.css');		

		$this->blockId = $this->wg->Request->getInt( 'blockId' );
		if ( empty( $this->blockId ) ) {
			$this->showForms();
			return true;
		}

		// show block id or blocks for Wikia
		if ( strpos( $this->blockId, 'wiki' ) !== false ) {
			list ( , $this->blockId ) = explode( "/", $this->blockId );
			$this->blockWikia();
		} else {
			$this->blockStats();
		}
	}

	private function blockStats() {
		$this->wg->Out->setPageTitle( $this->wf->Msg('phalanx-stats-title') . ' #' . $par);

		$block = array();
		$block = Phalanx::getFromId( intval($par) );

		if ( empty( $block ) ) {
			$wgOut->addWikiMsg( 'phalanx-stats-block-notfound', $par );
			return true;
		}

		// process block data for display
		$data = array();
		$data['id'] = $block['id'];
		$data['author_id'] = User::newFromId( $block['author_id'] )->getName();
		$data['type'] = implode( ', ', Phalanx::getTypeNames( $block['type'] ) );

		$data['timestamp'] = $wgLang->timeanddate( $block['timestamp'] );
		if ( $block['expire'] == null ) {
			$data['expire'] = 'infinite';
		} else {
			$data['expire'] = $wgLang->timeanddate( $block['expire'] );
		}
		$data['regex'] = $block['regex'] ? 'Yes' : 'No';
		$data['case']  = $block['case']  ? 'Yes' : 'No';
		$data['exact'] = $block['exact'] ? 'Yes' : 'No';
		$data['lang'] = empty($block['lang']) ? '*' : $block['lang'];

		#pull these out of the array, so they dont get used in the top rows
		if ( $block['type'] & Phalanx::TYPE_EMAIL && !$wgUser->isAllowed( 'phalanxemailblock' ) ) {
			// hide email from non-privildged users
			$data2['text'] = wfMsg( 'phalanx-email-filter-hidden' );
		} else {
			$data2['text'] = $block['text'];
		}
		$data2['reason'] = $block['reason'];

		$headers = array(
			wfMsg('phalanx-stats-table-id'),
			wfMsg('phalanx-stats-table-user'),
			wfMsg('phalanx-stats-table-type'),
			wfMsg('phalanx-stats-table-create'),
			wfMsg('phalanx-stats-table-expire'),
			wfMsg('phalanx-stats-table-regex'),
			wfMsg('phalanx-stats-table-case'),
			wfMsg('phalanx-stats-table-exact'),
			wfMsg('phalanx-stats-table-language'),
		);

		$html = '';

		$tableAttribs = array(
			'border' => 1,
			'class' => 'wikitable',
			'style' => "font-family:monospace;",
		);

		#use magic to build it
		$table = Xml::buildTable( array( $data ), $tableAttribs, $headers );
		#rip off bottom
		$table = str_replace("</table>", "", $table);
		#add some stuff
		$table .= "<tr><th>".wfMsg('phalanx-stats-table-text')."</th><td colspan='8'>" . htmlspecialchars($data2['text']) . "</td></tr>";
		$table .= "<tr><th>".wfMsg('phalanx-stats-table-reason')."</th><td colspan='8'>{$data2['reason']}</td></tr>";
		#seal it back up
		$table .= "</table>";

		$html .=  $table . "\n";

		$phalanxUrl = Title::newFromText( 'Phalanx', NS_SPECIAL )->getFullUrl( array( 'id' => $block['id'] ) );
		$html .= " &bull; <a class='modify' href='{$phalanxUrl}'>" . wfMsg('phalanx-link-modify') . "</a><br/>\n";

		$html .=  "<br/>\n";
		$wgOut->addHTML( $html );

		$pager = new PhalanxStatsPager( $par );

		$html = '';
		$html .= $pager->getNavigationBar();
		$html .= $pager->getBody();
		$html .= $pager->getNavigationBar();

		$wgOut->addHTML( $html );
	}

	private function block_wikia($par) {
		global $wgOut, $wgLang, $wgUser, $wgRequest;

		$oWiki = WikiFactory::getWikiById( $par );
		if ( !is_object($oWiki) ) {
			return false;
		}
		$url = WikiFactory::getVarValueByName( "wgServer", $oWiki->city_id );
		$sitename = WikiFactory::getVarValueByName( "wgSitename", $oWiki->city_id );

		#we have a valid id, change title to use it
		$wgOut->setPageTitle( wfMsg('phalanx-stats-title') . ': ' . $url );

		// process block data for display
		$data['wiki_id'] = $oWiki->city_id;
		$data['sitename'] = $sitename;
		$data['url'] = $url;
		$data['last_timestamp'] = $wgLang->timeanddate( $oWiki->city_last_timestamp );

		$html = '';

		$headers = array(
			wfMsg('phalanx-stats-table-wiki-id'),
			wfMsg('phalanx-stats-table-wiki-name'),
			wfMsg('phalanx-stats-table-wiki-url'),
			wfMsg('phalanx-stats-table-wiki-last-edited'),
		);

		$tableAttribs = array(
			'border' => 1,
			'class' => 'wikitable',
			'style' => "font-family:monospace;",
		);

		#use magic to build it
		$table = Xml::buildTable( array( $data ), $tableAttribs, $headers );
		$html .=  $table . "<br />\n";

		$wgOut->addHTML( $html );

		$pager = new PhalanxWikiStatsPager( $par );

		$html = '';
		$html .= $pager->getNavigationBar();
		$html .= $pager->getBody();
		$html .= $pager->getNavigationBar();

		$wgOut->addHTML( $html );
	}

	private function showForms() {
		global $wgOut;
		# TODO: move text to i18n (will do after coding is finished and text/flow is finalized)

		$PSurl = Title::newFromText( 'PhalanxStats', NS_SPECIAL )->getFullUrl();

		//-------------------------------------------------
		$formParam = array('method'=>'GET', 'action'=>$PSurl);

		$content = '';
		$content .= Xml::openElement( 'form', $formParam ) . "\n";
		$content .= "ID" . ": ";
		$content .= Xml::input( 'blockId', 5, '', array() );
		$content .= Xml::submitButton( 'load' ) . "\n";
		$content .= Xml::closeElement( 'form' ) . "\n";
		$content .= "Example:\n<ul>\n";
		$content .= "<li>http://community.wikia.com/wiki/Special:PhalanxStats/123456</li>\n";
		$content .= "<li>http://community.wikia.com/wiki/Special:PhalanxStats?blockId=123456</li>\n";
		$content .= "</ul>\n";

		$wgOut->addHTML( Xml::fieldset( "Recent triggers of a block", $content, array() ) );

		//-------------------------------------------------
		$formParam = array('method'=>'GET', 'action'=>$PSurl);

		$content = '';
		#commented out until wikiId is supported in the execute logic
		// $content .= Xml::openElement( 'form', $formParam ) . "\n";
		// $content .= "ID" . ": ";
		// $content .= Xml::input( 'wikiId', 5, '', array() );
		// $content .= Xml::submitButton( 'load' ) . "\n";
		// $content .= Xml::closeElement( 'form' ) . "\n";
			$content .= "<i>form coming soon</i><br/>\n";
		$content .= "Example:\n<ul>\n";
		$content .= "<li>http://community.wikia.com/wiki/Special:PhalanxStats/wiki/123456</li>\n";
		$content .= "</ul>\n";

		$wgOut->addHTML( Xml::fieldset( "Recent blocks on a wiki", $content, array() ) );

		return;
	}
}
