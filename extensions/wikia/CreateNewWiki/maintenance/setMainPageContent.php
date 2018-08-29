<?php

/**
 * This script updates the main page content adding wiki name and description provided by the founding user.
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class SetMainPageContent extends Maintenance {

	public function execute() {
		global $wgWikiDescription, $wgCityId;

		$this->output( 'SetMainPageContent: Started' );
		$this->output( 'SetMainPageContent: description is ' . $wgWikiDescription );
		if ( empty( $wgWikiDescription ) ) {
			$this->output( 'SetMainPageContent: Empty wiki description, skipping' );
			return;
		}

		// this runs before the StartPostCreationTasks so main page is available under the old address
		// @see: CreateNewWikiTask::moveMainPage
		$mainTitle = Title::newFromText( wfMsgForContent( 'Mainpage' ) );
		if ( !$mainTitle ) {
			$mainTitle = Title::newFromText( 'Main_Page' );
			if ( !$mainTitle ) {
				$this->error( 'SetMainPageContent: Cannot find the main title!' );
				return;
			}
		}
		$this->output( 'SetMainPageContent: mainTitle ' . $mainTitle->getText() );
		$mainId = $mainTitle->getArticleID( Title::GAID_FOR_UPDATE );
		$this->output( 'SetMainPageContent: mainId ' . $mainId );
		$mainArticle = Article::newFromID( $mainId );

		if ( empty( $mainArticle ) ) {
			$this->error( 'SetMainPageContent: Cannot find the main article!' );
			return;
		}

		// set description on main page
		$newMainPageText = $this->getClassicMainPage( $mainArticle, $wgWikiDescription );
		$status = $mainArticle->doEdit( $newMainPageText, '' );
		if ( $status->isOK() ) {
			$this->output( 'SetMainPageContent: Main article edited' );
			WikiFactory::removeVarByName( 'wgWikiDescription', $wgCityId,
				'Description was put in the main page' );
		} else {
			$this->warning( 'SetMainPageContent: Failed to edit the main page' );
			// Still, don't fail. It is better still to show the wiki to the user, the main page will be edited anyway.
		}
		$this->output( 'SetMainPageContent: Finishing' );
	}

	/**
	 * setup main page article content for classic main page
	 * @param $mainArticle Article
	 * @param $description Description text
	 * @return string - main page article wiki text
	 */
	private function getClassicMainPage( $mainArticle, $description ) {
		global $wgParser, $wgSitename;

		$mainPageText = $mainArticle->getRawText();
		$matches = [];

		if ( preg_match( '/={2,3}[^=]+={2,3}/', $mainPageText, $matches ) ) {
			$newSectionTitle = str_replace( 'Wiki', $wgSitename, $matches[ 0 ] );
			$description = "{$newSectionTitle}\n{$description}";
		}

		$newMainPageText = $wgParser->replaceSection( $mainPageText, 1, $description );

		return $newMainPageText;
	}
}

$maintClass = 'SetMainPageContent';
require_once( RUN_MAINTENANCE_IF_MAIN );
