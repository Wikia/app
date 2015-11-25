<?php

class InsightsCountService extends WikiaService {

	public function getCount( $type ) {
		return $this->calculateCount( $type );
	}

	public function getAllCounts() {
		$response = [];
		foreach ( InsightsHelper::getInsightsPages() as $type => $className ) {
			$response[$type] = $this->calculateCount( $type );
		}

		return $response;
	}

	private function calculateCount( $type, $className = false ) {
		if ( $className === false ) {
			$className = InsightsHelper::getInsightsPages()[$type];
		}

		$subpageModel = new $className;
		$subpageModel->initModel( [] );
		return count($subpageModel->fetchArticlesData());
	}

	private function getMemcKey( $type ) {
		return wfMemcKey(
			InsightsPageModel::INSIGHTS_MEMC_PREFIX,
			$type,
			InsightsPageModel::INSIGHTS_MEMC_ARTICLES_KEY,
			InsightsPageModel::INSIGHTS_MEMC_VERSION
		);
	}
}
