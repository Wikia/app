<?php

class WikiaCorporateModel extends WikiaModel
{
	/**
	 * Get corporate wikiId by content lang
	 *
	 * @param $lang
	 *
	 * @return int
	 *
	 * @throws Exception
	 */
	public function getCorporateWikiIdByLang($lang) {
		$visualizationData = $this->getVisualizationData();
		if (!isset($visualizationData[$lang]['wikiId'])) {
			throw new Exception('Corporate Wiki not defined for this lang');
		}

		return $visualizationData[$lang]['wikiId'];
	}

	/**
	 * get data about corporate wikis
	 * @return array
	 */
	protected function getVisualizationData() {
		$visualizationModel = new CityVisualization();
		return $visualizationModel->getVisualizationWikisData();
	}
}
