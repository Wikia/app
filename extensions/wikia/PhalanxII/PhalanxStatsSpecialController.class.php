<?php

class PhalanxStatsSpecialController extends WikiaSpecialPageController {
	private $phalanxTitle = null;
	private $title = null;

	function __construct() {
		parent::__construct( 'PhalanxStats', 'phalanx', false );

		$this->title = SpecialPage::getTitleFor( 'PhalanxStats' );
		$this->phalanxTitle = SpecialPage::getTitleFor( 'Phalanx' );

	}

	public function index()	{
		wfProfileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( wfMsg( 'phalanx-stats-title' ) );
		$this->wg->Out->addModuleStyles( 'ext.wikia.PhalanxStats' );

		if ( !$this->userCanExecute( $this->wg->User ) ) {
			wfProfileOut( __METHOD__ );
			$this->displayRestrictionError();
			return;
		}

		$par = $this->getPar();
		if ( strpos( $par, 'wiki' ) === 0 ) {
			// show per-wiki stats
			list ( , $wikiId ) = explode( "/", $par, 2 );
			$this->blockWikia( $wikiId );
		} else {
			$blockId = $this->wg->Request->getInt( 'blockId', intval( $par ) );
			if ( !empty( $blockId ) ) {
				// show block stats
				$this->blockStats( $blockId );
			} else {
				// show help page
				$this->forward( 'PhalanxStatsSpecial', 'help' );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function help() {
		if ( !$this->userCanExecute( $this->wg->User ) ) {
			$this->displayRestrictionError();
			return;
		}

		$navLinksData = [
			[
				'text' => wfMessage( 'phalanx' )->escaped(),
				'url' => $this->phalanxTitle->getFullURL(),
			],
		];
		$this->wg->Out->prependHTML( $this->getNavLinks( $navLinksData ) );

		$this->setVal( 'action', $this->title->getFullURL() );
	}

	private function blockStats( $blockId ) {
		$this->wg->Out->setPageTitle( sprintf( "%s #%s", wfMsg( 'phalanx-stats-title' ), $blockId ) );

		$navLinksData = [
			[
				'text' => wfMessage( 'phalanx' )->escaped(),
				'url' => $this->phalanxTitle->getFullURL(),
			],
			[
				'text' => wfMessage( 'phalanx-stats-title' )->escaped(),
				'url' => $this->title->getFullURL(),
			],
		];
		$this->wg->Out->prependHTML( $this->getNavLinks( $navLinksData ) );

		$data = Phalanx::newFromId( $blockId );

		if ( !isset( $data["id"] ) ) {
			$this->wg->Out->addWikiMsg( 'phalanx-stats-block-notfound', $blockId );
			return;
		}

		$data['author_id'] = User::newFromId( $data['author_id'] )->getName();
		$data['timestamp'] = $this->wg->Lang->timeanddate( $data['timestamp'] );

		if ( $data['expire'] == null ) {
			$data['expire'] = 'infinite';
		} else {
			$data['expire'] = $this->wg->Lang->timeanddate( $data['expire'] );
		}

		$data['regex'] = $data['regex'] ? 'Yes' : 'No';
		$data['case'] = $data['case'] ? 'Yes' : 'No';
		$data['exact'] = $data['exact'] ? 'Yes' : 'No';
		$data['lang'] = empty( $data['lang'] ) ? 'All' : $data['lang'];

		if ( $data['type'] & Phalanx::TYPE_EMAIL && !$this->wg->User->isAllowed( 'phalanxemailblock' ) ) {
			/* hide email from non-privildged users */
			$data['text'] = wfMsg( 'phalanx-email-filter-hidden' );
		}

		$data['type'] = implode( ', ', Phalanx::getTypeNames( $data['type'] ) );

		/* stats table */
		$headers = [
			wfMessage( 'phalanx-stats-table-id' )->escaped(),
			wfMessage( 'phalanx-stats-table-user' )->escaped(),
			wfMessage( 'phalanx-stats-table-type' )->escaped(),
			wfMessage( 'phalanx-stats-table-create' )->escaped(),
			wfMessage( 'phalanx-stats-table-expire' )->escaped(),
			wfMessage( 'phalanx-stats-table-exact' )->escaped(),
			wfMessage( 'phalanx-stats-table-regex' )->escaped(),
			wfMessage( 'phalanx-stats-table-case' )->escaped(),
			wfMessage( 'phalanx-stats-table-language' )->escaped(),
		];

		$tableAttribs = array(
			'class' => 'wikitable',
			'width' => '100%',
		);

		/* pull these out of the array, so they dont get used in the top rows */
		$row = $data->toArray();
		unset( $row['text'] );
		unset( $row['reason'] );
		unset( $row['comment'] );
		unset( $row['ip_hex'] );

		// parse block comment
		if ( $data['comment'] != '' ) {
			$comment = ParserPool::parse( $data['comment'], $this->wg->Title, new ParserOptions() )->getText();
		} else {
			$comment = '';
		}

		$table = Xml::buildTable( array( $row ), $tableAttribs, $headers );
		$table = str_replace( "</table>", "", $table );
		$table .= "<tr><th>" . wfMsg( 'phalanx-stats-table-text' ) . "</th><td colspan='8'>" . htmlspecialchars( $data['text'] ) . "</td></tr>";
		$table .= "<tr><th>" . wfMsg( 'phalanx-stats-table-reason' ) . "</th><td colspan='8'>{$data['reason']}</td></tr>";
		$table .= "<tr><th>" . wfMsg( 'phalanx-stats-table-comment' ) . "</th><td colspan='8'>{$comment}</td></tr>";
		$table .= "</table>";

		$this->setVal( 'table', $table );
		$this->setVal( 'editUrl', $this->phalanxTitle->getLocalUrl( array( 'id' => $data['id'] ) ) );

		/* match statistics */
		$pager = new PhalanxStatsPager( $blockId );
		$this->setVal( 'statsPager',
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}

	private function blockWikia( $wikiId ) {
		$oWiki = WikiFactory::getWikiById( $wikiId );
		if ( !is_object( $oWiki ) ) {
			return false;
		}

		// process block data for display
		$data = array(
			'wiki_id' => $oWiki->city_id,
			'sitename' => WikiFactory::getVarValueByName( "wgSitename", $oWiki->city_id ),
			'url' => WikiFactory::getVarValueByName( "wgServer", $oWiki->city_id ),
			'last_timestamp' => $this->wg->Lang->timeanddate( $oWiki->city_last_timestamp ),
		);

		// we have a valid id, change title to use it
		$this->wg->Out->setPageTitle( wfMsg( 'phalanx-stats-title' ) . ': ' . $data['url'] );

		$headers = array(
			wfMessage( 'phalanx-stats-table-wiki-id' )->escaped(),
			wfMessage( 'phalanx-stats-table-wiki-name' )->escaped(),
			wfMessage( 'phalanx-stats-table-wiki-url' )->escaped(),
			wfMessage( 'phalanx-stats-table-wiki-last-edited' )->escaped(),
		);

		$tableAttribs = array(
			'border' => 1,
			'class' => 'wikitable',
			'style' => "font-family:monospace;",
		);

		$table = Xml::buildTable( array( $data ), $tableAttribs, $headers );
		$this->setVal( 'table', $table );

		$pager = new PhalanxStatsWikiaPager( $wikiId );
		$this->setVal( 'statsPager',
			$pager->getNavigationBar() .
			$pager->getBody() .
			$pager->getNavigationBar()
		);
	}

	/**
	 * Returns a rendered mustache template with navigation links for PhalanxStats
	 * @param array $linksData [ 'url' => '', 'text' => '' ]
	 * @return string
	 * @throws Exception
	 */
	private function getNavLinks( array $linksData ) {
		return MustacheService::getInstance()->render(
			__DIR__ . '/templates/PhalanxStatsNav.mustache',
			[
				'navLinks' => $linksData,
			]
		);
	}
}
