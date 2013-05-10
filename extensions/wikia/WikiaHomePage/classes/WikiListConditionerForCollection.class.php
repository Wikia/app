<?php
class WikiListConditionerForCollection implements WikiListConditioner {
	private $collectionWikisIds;
	
	public function __construct($collectionWikisIds) {
		$this->collectionWikisIds = $collectionWikisIds;
	}
	
	public function getCondition() {
		$app = F::app();
		$db = $app->wf->GetDB(DB_SLAVE, array(), $app->wg->ExternalSharedDB);
		
		return [
			'city_list.city_public' => 1,
			'city_list.city_id in (' . $db->makeList($this->collectionWikisIds) . ')',
			'city_visualization.city_main_image is not null',
			'(city_visualization.city_flags & ' . WikisModel::FLAG_BLOCKED . ') != ' . WikisModel::FLAG_BLOCKED,
		];
	}
}