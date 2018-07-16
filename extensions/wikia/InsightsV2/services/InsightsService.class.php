<?php

class InsightsService {

	public function getInsightPagesForModel( InsightsModel $model, $size, $sortingType ): array {
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

		$articleIds = array_slice( $sortedInsightArticleIds, 0, $size );

		return [
			'count' => $insightCount,
			'pages' => $this->getArticlesData( $insightData, $articleIds )
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
