<?php

class InsightsService {

	/**
	 * @param string $type type of model
	 * @param int $size number of pages we need
	 * @param string $sortingType define how data should be sorted (@see InsightsSorting::$sorting)
	 * @return array
	 */
	public function getInsightPages( $type, $size, $sortingType ) {
		if ( !InsightsHelper::isInsightPage( $type ) ) {
			return [];
		}
		$model = InsightsHelper::getInsightModel( $type );
		$insightData = ( new InsightsContext( $model ) )->fetchData();

		if ( empty( $insightData ) ) {
			return [];
		}

		$insightCount = count( $insightData );

		if ( empty( $sortingType ) ) {
			return [
				'count' => $insightCount,
				'pages' => array_slice( $insightData, 0, $size )
			];
		}

		$sortedInsightArticleIds = ( new InsightsSorting( $model->getConfig() ) )
			->getSortedData(
				$insightData,
				[ 'sort' => $sortingType ]
			);
		$aritclesIds = array_slice( $sortedInsightArticleIds, 0, $size );

		return [
			'count' => $insightCount,
			'pages' => $this->getArticlesData( $insightData, $aritclesIds )
		];
	}

	/**
	 * @param array $articles all articles data
	 * @param array $ids list of article ids we need data for
	 * @return array
	 */
	private function getArticlesData( $articles, $ids ) {
		$content = [];
		foreach ( $ids as $id ) {
			$content[] = $articles[$id];
		}
		return $content;
	}
}
