<?php

namespace Wikia\CreateNewWiki\Tasks;

use Article;
use Title;
use Wikia\Logger\Loggable;

class SetMainPageContent extends Task {
	use Loggable;

	public function run() {
		$mainTitle = Title::newFromText( $this->taskContext->getSiteName() );
		$mainId = $mainTitle->getArticleID();
		$mainArticle = Article::newFromID( $mainId );

		if ( !empty( $mainArticle ) ) {
			$newMainPageText = $this->getClassicMainPage($mainArticle);

			$mainArticle->doEdit($newMainPageText, '');
		}

		return TaskResult::createForSuccess();
	}

	/**
	 * setup main page article content for classic main page
	 * @param $mainArticle Article
	 * @return string - main page article wiki text
	 */
	private function getClassicMainPage( $mainArticle ) {
		global $wgParser;
		if ( !isset($wgParser) ) {
			$this->error( "SetMainPageContent: no wgParser in task"  );
		} else {
			$this->error( "SetMainPageContent: wgParser class is " . get_class($wgParser ) );
		}

		$siteName = $this->taskContext->getSiteName();

		$mainPageText = $mainArticle->getRawText();
		$matches = [];

		$description = $this->taskContext->getDescription();

		if ( preg_match( '/={2,3}[^=]+={2,3}/', $mainPageText, $matches ) ) {
			$newSectionTitle = str_replace( 'Wiki', $siteName, $matches[ 0 ] );
			$description = "{$newSectionTitle}\n{$description}";
		}

		$newMainPageText = $wgParser->replaceSection( $mainPageText, 1, $description );

		return $newMainPageText;
	}


}
