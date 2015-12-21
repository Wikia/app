<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @ingroup Maintenance
 */
class PortableInfoboxesRecalculateUnconverted extends Maintenance {

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgParser, $wgEnableInsightsExt, $wgEnableInsightsInfoboxes, $wgEnablePortableInfoboxExt;

		if ( empty( $wgEnableInsightsExt )
			|| empty( $wgEnableInsightsInfoboxes )
			|| empty( $wgEnablePortableInfoboxExt )
		) {
			return;
		}

		$ui = new InsightsUnconvertedInfoboxesModel();
		$articles = $ui->fetchArticlesData();

		foreach ( $articles as $id => $articleData ) {
			$article = Article::newFromID( $id );
			$parserOptions = $article->getParserOptions();
			$title = $article->getTitle();
			$output = $wgParser->parse( $article->getContent(), $title, $parserOptions );
			( new LinksUpdate(  $title, $output ) )->doUpdate();
		}

		$uip = new UnconvertedInfoboxesPage();
		$uip->recache();
		$ui->purgeInsightsCache();

	}
}

$maintClass = 'PortableInfoboxesRecalculateUnconverted';
require_once RUN_MAINTENANCE_IF_MAIN;
