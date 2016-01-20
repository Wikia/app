<?php

require_once __DIR__ . '/../Maintenance.php';

/**
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @ingroup Maintenance
 */
class PortableInfoboxesScanUnconverted extends Maintenance {
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
		$ui->initModel( null );
		$articles = $ui->fetchArticlesData();
		\Wikia\Logger\WikiaLogger::instance()->debug( 'Templates with unconverted infoboxes', [ 'list_of_templates' => json_encode($articles) ] );

		foreach ( $articles as $id => $articleData ) {
			$article = Article::newFromID( $id );
			$title = $article->getTitle();
			$prop = PortableInfoboxDataService::newFromTitle( $title )->getData();
			if ( !empty( $prop ) ) {
				continue;
			}
			$parserOptions = $article->getParserOptions();
			/* @var ParserOutput $output */
			$output = $wgParser->parse( $article->getContent(), $title, $parserOptions );
			$prop = trim( $output->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME ) );
			if ( !empty( $prop ) ) {
				\Wikia\Logger\WikiaLogger::instance()->debug('Infoboxes property for article after parsing before save', [
					'ArticleId' => $title->getArticleID(),
					'ArticleTitle' => $title->getFullText(),
					PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME => print_r( $prop, true )
				]);
			}
		}
	}
}

$maintClass = 'PortableInfoboxesScanUnconverted';
require_once RUN_MAINTENANCE_IF_MAIN;
