<?php

class PhalanxStatsSpecialController extends WikiaSpecialPageController {
	private $phalanxTitle = null;
	private $title = null;

	function __construct( ) {
		parent::__construct( 'PhalanxStats', 'phalanx', false );

		$this->title = SpecialPage::getTitleFor('PhalanxStats');
		$this->phalanxTitle = SpecialPage::getTitleFor('Phalanx');
	}

	public function index() {
		wfProfileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( wfMsg('phalanx-stats-title') );
		$this->wg->Out->addBacklinkSubtitle( $this->phalanxTitle );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return;
		}

		$par = $this->getPar();
		if ( strpos( $par, 'wiki' ) === 0 ) {
			// show per-wiki stats
			list ( , $wikiId ) = explode( "/", $par, 2 );
			$this->blockWikia($wikiId);
		} else {
			$blockId = $this->wg->Request->getInt('blockId', intval($par));
			if ( !empty( $blockId ) ) {
				// show block stats
				$this->blockStats($blockId);
			} else {
				// show help page
				$this->forward('PhalanxStatsSpecial', 'help');
			}
		}

		wfProfileOut( __METHOD__ );
	}

	private function blockStats($blockId) {
		$out = $this->getOutput();
		$out->setPageTitle( $this->msg( 'phalanx-stats-title' )->text() . "#$blockId" );
		$out->addBacklinkSubtitle( $this->title );

		$data = Phalanx::newFromId($blockId);

		if ( !isset( $data["id"] ) ) {
			$out->addWikiMsg( 'phalanx-stats-block-notfound', $blockId );
			return false; // skip rendering
		}

		$data['author_id'] = User::newFromId($data['author_id'])->getName();
		$data['timestamp'] = $this->getLanguage()->timeanddate( $data['timestamp'] );

		if ( $data['expire'] == null ) {
			$data['expire'] = 'infinite';
		} else {
			$data['expire'] = $this->getLanguage()->timeanddate( $data['expire'] );
		}

		$data['regex'] = $data['regex'] ? 'Yes' : 'No';
		$data['case']  = $data['case']  ? 'Yes' : 'No';
		$data['exact'] = $data['exact'] ? 'Yes' : 'No';
		$data['lang'] = empty( $data['lang'] ) ? 'All' : $data['lang'];

		if ( $data['type'] & Phalanx::TYPE_EMAIL && !$this->getUser()->isAllowed( 'phalanxemailblock' ) ) {
			/* hide email from non-privildged users */
			$data['text'] = $this->msg( 'phalanx-email-filter-hidden' )->escaped();
		}

		$data['type'] = implode( ', ', Phalanx::getTypeNames( $data['type'] ) );

		/* pull these out of the array, so they dont get used in the top rows */
		$row = $data->toArray();
		unset($row['text']);
		unset($row['reason']);
		unset($row['comment']);
		unset($row['ip_hex']);

		// parse block reason and comment
		$parserOptions = ParserOptions::newFromContext( $this->getContext() );
		$parser = ParserPool::get();

		if ($data['reason'] != '') {
			$reason = $parser->parse( $data['reason'], $this->getTitle(), $parserOptions )->getText();
		} else {
			$reason = '';
		}

		if ($data['comment'] != '') {
			$comment = $parser->parse( $data['comment'], $this->getTitle(), $parserOptions )->getText();
		} else {
			$comment = '';
		}

		ParserPool::release( $parser );

		$this->response->setValues( [
			'firstRow' => $row,
			'text' => $data['text'],
			'reason' => $reason,
			'comment' => $comment,
			'editUrl' => $this->phalanxTitle->getLocalURL( [ 'id' => $data['id'] ] ),
			'blockId' => $blockId,
		] );

		/* match statistics */
		$pager = new PhalanxStatsPager( $blockId );
		$pager->setContext( $this->getContext() );
		$this->setVal('statsPager',
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);

		// SUS-269: Add JS for unblock button
		$out->addModules( 'ext.wikia.Phalanx' );
	}

	private function blockWikia($wikiId) {
		$oWiki = WikiFactory::getWikiById( $wikiId );
		if ( !is_object($oWiki) ) {
			return false;
		}

		// process block data for display
		$data = array(
			'wiki_id'         => $oWiki->city_id,
			'sitename'        => WikiFactory::getVarValueByName( "wgSitename", $oWiki->city_id ),
			'url'             => WikiFactory::getVarValueByName( "wgServer", $oWiki->city_id ),
			'last_timestamp'  => $this->wg->Lang->timeanddate( $oWiki->city_last_timestamp ),
		);

		// we have a valid id, change title to use it
		$this->wg->Out->setPageTitle( wfMsg( 'phalanx-stats-title' ) . ': ' . $data['url'] );
		$this->wg->Out->addBacklinkSubtitle( $this->title );

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

		$table = Xml::buildTable( array( $data ), $tableAttribs, $headers );
		$this->setVal('table', $table);
		
		$pager = new PhalanxStatsWikiaPager( $wikiId );
		$this->setVal('statsPager',
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}

	public function help() {
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setVal( 'action', $this->title->getFullURL() );
	}
}
