<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * Date: 02.07.13 10:53
 *
 */

class PageClassificationController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'PageClassification', '', false );
	}


	public function index() {

		$wikiId = $this->getVal( 'wikiId', 0 );
		if ( $wikiId > 0 ) {
			return $this->pageList( $wikiId );
		}

		$classificationData = new PageClassificationData();
		$wikilist = $classificationData->getWikiList();

		$baseUrl = SpecialPage::getTitleFor( 'PageClassification' )->escapeLocalUrl();

		foreach ( $wikilist as $i => $wiki ) {
			$wikilist[ $i ][ 'browseUrl' ] = $baseUrl . "?wikiId=" . $wiki['wikiId'];
		}


		$this->setVal( 'wikilist', $wikilist );
	}

	public function pageList( $wikiId ) {

		/* TEST */
		$important = new ImportantArticles( $wikiId );
		$wikiTopics = $important->getWikiTopics();
		$importantByTopPages = $important->getImportantPhrasesByTopPages();
		$importantByLinks = $important->getImportantPhrasesByInterlinks();
		$commonPrefix = $important->getCommonPrefix();
		$merged = $important->getMostImportantTopics();

		$this->setVal( 'wikiTopics', $wikiTopics );
		$this->setVal( 'importantByTopPages', $importantByTopPages );
		$this->setVal( 'importantByLinks', $importantByLinks );
		$this->setVal( 'commonPrefix', $commonPrefix );
		$this->setVal( 'merged', $merged );

		$this->overrideTemplate('pageList');
	}
}
