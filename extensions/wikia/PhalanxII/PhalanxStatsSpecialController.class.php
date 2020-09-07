<?php

class PhalanxStatsSpecialController extends WikiaSpecialPageController {
	private $phalanxTitle = null;
	private $title = null;

	function __construct( ) {
		parent::__construct( 'PhalanxStats', 'phalanx', false );

		$this->title = SpecialPage::getTitleFor( 'PhalanxStats' );
		$this->phalanxTitle = SpecialPage::getTitleFor( 'Phalanx' );
	}

	public function index() {
		$this->wg->Out->setPageTitle( wfMsg( 'phalanx-stats-title' ) );
		$this->wg->Out->addBacklinkSubtitle( $this->phalanxTitle );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			return false;
		}

		$par = $this->getPar();

		// Look for paths with a wiki ID like /wiki/Special:PhalanxStats/wiki/125951
		if ( strpos( $par, 'wiki' ) === 0 ) {
			// show per-wiki stats
			return $this->forward( 'PhalanxStatsSpecial', 'blockWiki' );
		}

		// Look for paths with a block ID like /wiki/Special:PhalanxStats/123456
		$blockId = $this->wg->Request->getInt( 'blockId', intval( $par ) );
		if ( empty( $blockId ) ) {
			// show help page
			return $this->forward( 'PhalanxStatsSpecial', 'help' );
		}

		// show block stats
		return $this->blockStats( $blockId );
	}

	/**
	 * Show a list of blocks for a specific wiki
	 *
	 * @return bool
	 */
	public function blockWiki() {

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			return false;
		}
	
		$par = $this->getPar();
		list ( , $wikiId ) = explode( '/', $par, 2 );

		$wikiData = $this->getWikiData( $wikiId );
		if ( empty( $wikiData ) ) {
			return false;
		}

		// We have a valid id, change title to use it
		$this->wg->Out->setPageTitle(
			wfMessage( 'phalanx-stats-title' )->text() . ': ' . $wikiData['url']
		);
		$this->wg->Out->addBacklinkSubtitle( $this->title );

		$this->getResponse()->setValues( [
			'wikiData' => $wikiData,
			'statsPager' => $this->buildWikiPager( $wikiId ),
		] );

		return true;
	}

	/**
	 * Show information for a specific block ID
	 *
	 * @param $blockId
	 * @return bool
	 */
	private function blockStats( $blockId ) {
		$out = $this->getOutput();
		$out->setPageTitle( $this->msg( 'phalanx-stats-title' )->text() . "#$blockId" );
		$out->addBacklinkSubtitle( $this->title );

		$data = $this->getPhalanxData( $blockId );
		if ( empty( $data ) ) {
			$out->addWikiMsg( 'phalanx-stats-block-notfound', $blockId );
			return false;
		}

		// pull these out of the array, so they don't get used in the top rows
		$row = $data->toArray();
		unset( $row['text'], $row['reason'], $row['comment']);

		$this->response->setValues( [
			'firstRow' => $row,
			'text' => $data['text'],
			'reason' => $this->getParsedContent( $data, 'reason' ),
			'comment' => $this->getParsedContent( $data, 'comment' ),
			'editUrl' => $this->phalanxTitle->getLocalURL( [ 'id' => $data['id'] ] ),
			'blockId' => $blockId,
			'statsPager' => $this->buildPager( $blockId )
		] );

		// SUS-269: Add JS for unblock button
		$out->addModules( 'ext.wikia.Phalanx' );

		return true;
	}

	/**
	 * Show a help page if the expected wiki ID or block ID were not provided
	 */
	public function help() {
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			return;
		}

		$this->setVal( 'action', $this->title->getFullURL() );
	}

	/**
	 * @param $blockId
	 * @return bool|Phalanx
	 */
	private function getPhalanxData( $blockId ) {
		$data = Phalanx::newFromId( $blockId );
		if ( empty( $data['id'] ) ) {
			return false;
		}

		$data['author_id'] = User::newFromId( $data['author_id'] )->getName();
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

		if ( $data->isOfType( Phalanx::TYPE_EMAIL ) && !$this->getUser()->isAllowed( 'phalanxemailblock' ) ) {
			/* hide email from non-privileged users */
			$data['text'] = $this->msg( 'phalanx-email-filter-hidden' )->escaped();
		}

		$data['type'] = implode( ', ', Phalanx::getTypeNames( $data['type'] ) );

		return $data;
	}

	private function getParsedContent( $data, $key ) {
		$content = '';

		if ( $data[$key] != '' ) {
			$parserOptions = ParserOptions::newFromContext( $this->getContext() );
			$parser = ParserPool::get();

			$content = $parser
				->parse( $data[$key], $this->getTitle(), $parserOptions )
				->getText();

			ParserPool::release( $parser );
		}

		return $content;
	}

	private function getWikiData( $wikiId ) {
		$wiki = WikiFactory::getWikiByID( $wikiId );
		if ( !is_object( $wiki ) ) {
			return false;
		}

		$sitename = WikiFactory::getVarValueByName( "wgSitename", $wiki->city_id );
		return [
			'wiki_id' => $wiki->city_id,
			'sitename' => empty( $sitename ) ? $wiki->city_title : $sitename,
			// language-path - this returns the full url now. Is it handled properly?
			'url' => WikiFactory::cityIDtoUrl( $wiki->city_id ),
			'last_timestamp' => $this->wg->Lang->timeanddate( $wiki->city_last_timestamp ),
		];
	}

	private function buildWikiPager( $wikiId ) {
		$pager = new PhalanxStatsWikiaPager( $wikiId );
		return $pager->getNavigationBar() .
		       $pager->getBody() .
		       $pager->getNavigationBar();
	}

	private function buildPager( $blockId ) {
		$pager = new PhalanxStatsPager( $blockId );
		$pager->setContext( $this->getContext() );
		return $pager->getNavigationBar() .
		       $pager->getBody() .
		       $pager->getNavigationBar();
	}
}
