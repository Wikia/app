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

		$insightsCountService = new InsightsCountService();
		$count = $insightsCountService->getCount( InsightsUnconvertedInfoboxesModel::INSIGHT_TYPE );

		if ( empty( $count ) ) {
			return;
		}

		$ui = new InsightsUnconvertedInfoboxesModel();
		$articles = ( new InsightsContext( $ui ) )->fetchData();
		\Wikia\Logger\WikiaLogger::instance()->debug( 'Templates with unconverted infoboxes', [ 'list_of_templates' => json_encode($articles) ] );

		foreach ( $articles as $id => $articleData ) {
			$article = Article::newFromID( $id );
			$parserOptions = $article->getParserOptions();
			$title = $article->getTitle();
			/* @var ParserOutput $output */
			$output = $wgParser->parse( $article->getContent(), $title, $parserOptions );
			$prop = $output->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME );
			\Wikia\Logger\WikiaLogger::instance()->debug( 'Infoboxes property for article after parsing before save', [
				'ArticleId' => $title->getArticleID(),
				'ArticleTitle' => $title->getFullText(),
				PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME => print_r( $prop, true )
			] );
			( new LinksUpdate(  $title, $output ) )->doUpdate();
		}

		$uip = new UnconvertedInfoboxesPage();
		$uip->recache();
		( new InsightsCache( $ui->getConfig() ) )->purgeInsightsCache();

	}
}

$maintClass = 'PortableInfoboxesRecalculateUnconverted';
require_once RUN_MAINTENANCE_IF_MAIN;
