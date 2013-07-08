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
		$art = $important->getWikiTopics();
		foreach ( $art as $a ) {
			//var_dump( $a );
		}
		echo "<Pre>";
		print_r( $important->getImportantPhrasesByTopPages() );
		die("<HR>");
		/* TEST */

		$classificationData = new PageClassificationData();
		$pagelist = $classificationData->getClassifiedArticles();
		$this->setVal( 'pagelist', $pagelist );


		$this->overrideTemplate('pageList');
	}
}