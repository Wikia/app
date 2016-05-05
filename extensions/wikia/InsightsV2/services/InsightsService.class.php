<?php


class InsightsService extends WikiaService
{

	/*
	 * Returns Insights about a given Model.
	 *
	 * @param string $type type of model
	 * @return array
	 */
	public function getInsightPages($type,$size){
		if(InsightsHelper::isInsightPage($type)){
			$model = InsightsHelper::getInsightModel($type);
			$insightData = (new InsightsContext($model))->fetchData();
			$sortedInsightData = (new InsightsSorting($model->getConfig()))->getSortedData($insightContext,['sort'=>'pvDiff']);
			$aritcles_ids = $this->truncateTo($sortedInsightData,$size);
			return $this->getArticleData($insightContext,$aritcles_ids);
		}
		return [];
	}

	public function getArticleData($articles,$ids){
		$content = [];
		foreach($ids as $id){
			$content[] = $articles[$id];
		}
		return $content;
	}

	public function truncateTo($array,$size){
		return array_slice($array,0,$size);
	}
}
