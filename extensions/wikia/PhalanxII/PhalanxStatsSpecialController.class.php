<?php

class PhalanxStatsSpecialController extends WikiaSpecialPageController {
	private $blockId = 0;
	private $phalanxTitle = null;
	private $title = null;
	private $wikiId = 0;
	
	function __construct( ) {
		parent::__construct( 'PhalanxStats', 'phalanx', false );
		$this->title = Title::newFromText( 'PhalanxStats', NS_SPECIAL );
		$this->phalanxTitle = Title::newFromText( 'Phalanx', NS_SPECIAL );
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
			$this->form();
		} elseif ( strpos( $this->blockId, 'wiki' ) !== false ) {
			list ( , $this->wikiId ) = explode( "/", $this->blockId );
			$this->blockWikia();
		} else {
			$this->blockStats();
		}
	}

	private function blockStats() {
		$this->wg->Out->setPageTitle( sprintf( "%s#%s", $this->wf->Msg('phalanx-stats-title'), $this->blockId ) );

		$block = array();
		$data = Phalanx::newFromId( $this->blockId );

		if ( !isset( $data["id"] ) ) {
			$this->wg->Out->addWikiMsg( 'phalanx-stats-block-notfound', $this->blockId );
			return true;
		}

		$phalanxUrl = $this->phalanxTitle->getFullUrl( array( 'id' => $data['id'] ) );
		
		$data['author_id'] = User::newFromId( $data['author_id'] )->getName();
		$data['type'] = implode( ', ', Phalanx::getTypeNames( $data['type'] ) );
		$data['timestamp'] = $this->wg->Lang->timeanddate( $data['timestamp'] );
		
		if ( $data['expire'] == null ) {
			$data['expire'] = 'infinite';
		} else {
			$data['expire'] = $this->wg->Lang->timeanddate( $data['expire'] );
		}
		
		$data['regex'] = $data['regex'] ? 'Yes' : 'No';
		$data['case']  = $data['case']  ? 'Yes' : 'No';
		$data['exact'] = $data['exact'] ? 'Yes' : 'No';
		$data['lang'] = empty( $data['lang'] ) ? '*' : $data['lang'];

		/* pull these out of the array, so they dont get used in the top rows */
		if ( $data['type'] & Phalanx::TYPE_EMAIL && !$this->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			/* hide email from non-privildged users */
			$data['text'] = $this->wf->Msg( 'phalanx-email-filter-hidden' );
		} 

		/* stats table */
		$headers = array(
			$this->wf->Msg('phalanx-stats-table-id'),
			$this->wf->Msg('phalanx-stats-table-user'),
			$this->wf->Msg('phalanx-stats-table-type'),
			$this->wf->Msg('phalanx-stats-table-create'),
			$this->wf->Msg('phalanx-stats-table-expire'),
			$this->wf->Msg('phalanx-stats-table-regex'),
			$this->wf->Msg('phalanx-stats-table-case'),
			$this->wf->Msg('phalanx-stats-table-exact'),
			$this->wf->Msg('phalanx-stats-table-language'),
		);

		$tableAttribs = array(
			'border' => 1,
			'class' => 'wikitable',
			'style' => "font-family:monospace;",
		);

		$table  = Xml::buildTable( array( $data ), $tableAttribs, $headers );
		$table  = str_replace("</table>", "", $table);
		$table .= "<tr><th>" . $this->wf->Msg('phalanx-stats-table-text') . "</th><td colspan='8'>" . htmlspecialchars( $data['text'] ) . "</td></tr>";
		$table .= "<tr><th>" . $this->wf->Msg('phalanx-stats-table-reason')  ."</th><td colspan='8'>{$data['reason']}</td></tr>";
		$table .= "</table>";

		$link = Html::element( 'a', array( 'class' => 'modify', 'href' => $phalanxUrl ), $this->wf->Msg('phalanx-link-modify') );
		$html = $table . "\n&bull; " . $link . "<br/>\n";
		$this->wg->Out->addHTML( $html );

		/* pager */
		$pager = new PhalanxStatsPager( $this->blockId );
		$html  = $pager->getNavigationBar();
		$html .= $pager->getBody();
		$html .= $pager->getNavigationBar();
		$this->wg->Out->addHTML( $html );
	}

	private function blockWikia() {
		$oWiki = WikiFactory::getWikiById( $this->wikiId );
		if ( !is_object($oWiki) ) {
			return false;
		}
		
		/* process block data for display */
		$data = array(
			'wiki_id'         => $oWiki->city_id,
			'sitename'        => WikiFactory::getVarValueByName( "wgSitename", $oWiki->city_id ),
			'url'             => WikiFactory::getVarValueByName( "wgServer", $oWiki->city_id ),
			'last_timestamp'  => $this->wg->Lang->timeanddate( $oWiki->city_last_timestamp ),
		);
		
		/* we have a valid id, change title to use it */
		$this->wg->Out->setPageTitle( $this->wf->Msg( 'phalanx-stats-title' ) . ': ' . $data['url'] );

		$headers = array(
			$this->wf->Msg('phalanx-stats-table-wiki-id'),
			$this->wf->Msg('phalanx-stats-table-wiki-name'),
			$this->wf->Msg('phalanx-stats-table-wiki-url'),
			$this->wf->Msg('phalanx-stats-table-wiki-last-edited'),
		);

		$tableAttribs = array(
			'border' => 1,
			'class' => 'wikitable',
			'style' => "font-family:monospace;",
		);

		$table = Xml::buildTable( array( $data ), $tableAttribs, $headers );
		$wgOut->addHTML( $table . "<br />\n" );

		$pager = new PhalanxStatsWikiaPager( $this->wikiId );
		$html  = $pager->getNavigationBar();
		$html .= $pager->getBody();
		$html .= $pager->getNavigationBar();
		$wgOut->addHTML( $html );
	}

	private function form() {
		$this->setVal( 'title', $this->title );
		$this->setVal( 'phalanxTitle', $this->phalanxTitle );
	}
}
