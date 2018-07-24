<?php

class InsightsService {

	public function getInsightPagesForModel( InsightsModel $model, $size ): array {
		$insightData = ( new InsightsContext( $model ) )->fetchData();

		if ( empty( $insightData ) ) {
			return [];
		}

		$insightCount = count( $insightData );

		return [
			'count' => $insightCount,
			'pages' => array_slice( $insightData, 0, $size )
		];
	}

}
