<?php
/**
 * Created by PhpStorm.
 * User: lukevital
 * Date: 19.04.16
 * Time: 16:07
 */

class ContributionExperimentsController extends \WikiaController {
	public function getNextPages() {
		$pages = [
			'deadendpages' => 'Links are missing on this page.',
			'withoutimages' => 'Photos are missing on this page.',
			'uncategorizedpages' => 'There are no categories on this page.',
			'wantedpages' => 'Create this page.'
		];

		$order = array_keys( $pages );

		$counter = 0;
		$added = 0;
		$items = [];
		$count = count( $order );
		$insightsCounts = ( new \InsightsCountService() )->getAllCounts();

		while( $counter < $count && $added < 2 ) {
			$insight = $order[$counter];
			if ( !empty( $insightsCounts[$insight] ) ) {
				$content = ( new \InsightsContext( \InsightsHelper::getInsightModel( $insight ) ) )->getContent();
				if ( !empty( $content ) ) {
					$titleText = $content[0]['link']['title'];
					$items[] = [
						'title' => $titleText,
						'url' => \Title::newFromText( $titleText )->getFullURL(),
						'category' => $insight,
						'category-desc' => $pages[$insight]
					];
					$added++;
				}
			}
			$counter++;
		}
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal('items', $items);
	}
}