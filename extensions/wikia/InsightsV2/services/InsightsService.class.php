<?php


class InsightsService extends WikiaService{

	/**
	 * @param string $type type of model
	 * @param int $size number of pages we need
	 * @return array
	 */
	public function getInsightPages( $type, $size, $sortingType ) {
		if ( !InsightsHelper::isInsightPage( $type ) ) {
			return [];
		}else{
			$model = InsightsHelper::getInsightModel( $type );
			$insightData = ( new InsightsContext( $model ) )->fetchData();
			$sortedInsightArticleIds = (
			new InsightsSorting( $model->getConfig() ) )
				->getSortedData( $insightData,
					['sort' => $sortingType]
				);
			$aritclesIds = $this->truncateTo( $sortedInsightArticleIds, $size );
			return $this->getArticlesData( $insightData, $aritclesIds );
		}
	}

	/**
	 * @param array $articles all articles data
	 * @param array $ids list of article ids we need data for
	 * @return array
	 */
	public function getArticlesData( $articles, $ids ) {
		$content = [];
		foreach ( $ids as $id ) {
			$content[] = $articles[$id];
		}
		return $content;
	}

	private function truncateTo( $array, $size ) {
		return array_slice( $array, 0, $size );
	}
}
