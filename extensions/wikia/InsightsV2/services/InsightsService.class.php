<?php

/**
 * Created by IntelliJ IDEA.
 * User: gautambajaj
 * Date: 5/5/16
 * Time: 7:32 PM
 */
class InsightsService extends WikiaService
{

	/*
	 * Returns Insights about a given Model.
	 *
	 * @param string $type type of model
	 * @return array
	 */
	public function getInsights($type,$size){
		if(InsightsHelper::isInsightPage($type)){
			$model = InsightsHelper::getInsightModel($type);
			$insightContext = (new InsightsContext($model))->fetchData();
			$insightSorter = new InsightsSorting($model->getConfig());
			$aritcles_ids = $this->truncateTo($insightSorter->getSortedData($insightContext,['sort'=>'pvDiff']),$size);
			return $this->getArticleData($insightContext,$aritcles_ids);
		}
		return [];
	}

	public function getArticleData($articles,$ids){
		foreach($ids as $id){
			$content[] = $articles[$id];
		}
		return $content;
	}

	public function truncateTo($array,$size){
		return array_slice($array,0,$size);
	}
}
