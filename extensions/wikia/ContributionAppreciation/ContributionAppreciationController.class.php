<?php

class ContributionAppreciationController extends WikiaController {

	public function appreciate() {
		global $wgUser;

		if ( $this->request->wasPosted() && $wgUser->matchEditToken( $this->getVal( 'token' ) ) ) {
			//TODO: do something with apprecation
			$this->response->setFormat( WikiaResponse::FORMAT_JSON );
			$this->setVal( 'user', $wgUser->getName() );
			$this->setVal( 'for', Revision::newFromId( $this->request->getInt( 'revision' ) )->getUserText() );
		}
	}

	public static function onDiffHeader( DifferenceEngine $diffPage, $oldRev, Revision $newRev ) {
		Wikia::addAssetsToOutput( 'contribution_appreciation_js' );
		$diffPage->getOutput()->addHTML( self::getAppreciationLink( $newRev->getId() ) );

		return true;
	}

	public static function onPageHistoryLineEnding( HistoryPager $pager, $row, &$s, $classes ) {
		$s .= self::getAppreciationLink( $row->rev_id );

		return true;
	}

	public static function onPageHistoryBeforeList() {
		Wikia::addAssetsToOutput( 'contribution_appreciation_js' );

		return true;
	}

	private static function getAppreciationLink( $revision ) {
		return Html::element( 'a',
			[
				'class' => 'like',
				'href' => '#',
				'data-revision' => $revision
			],
			wfMessage( 'appreciation-text' )->escaped() );
	}

	public function sendMail() {
		global $wgUser;
		$controller = Email\Controller\ContributionAppreciationMessageController::class;

		$editedPageTitle = \Title::newFromText('Ponies');
		$editedWikiName = 'MY WIKIANAME';
		$buttonLink = SpecialPage::getTitleFor( 'Community' )->getLocalUrl();

		var_dump($buttonLink);
		$params = [
			'buttonLink' => $buttonLink,
			'targetUser' => $wgUser, //testing
			'editedPageTitle' => $editedPageTitle->getText(),
			'editedWikiName' => $editedWikiName,
			'revisionUrl' => 'http://mlp.wikia.com/index.php?title=Cranky_Doodle_Donkey&diff=1697147&oldid=1697137'
		];

		F::app()->sendRequest( $controller, 'handle', $params );
	}
}
