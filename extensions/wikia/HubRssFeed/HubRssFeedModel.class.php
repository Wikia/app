<?php
/**
 * Created by JetBrains PhpStorm.
 * User: krzychu
 * Date: 04.10.13
 * Time: 13:21
 * To change this template use File | Settings | File Templates.
 */

class HubRssFeedModel extends WikiaModel{

	/**
	 * @var MarketingToolboxModel
	 */
	private $marketingToolboxModel;



	public function __construct(){
		parent::__construct();
		$this->marketingToolboxModel = new MarketingToolboxModel($this->app);
	}


	public function isValidVerticalId( $verticalId ) {

		$ids = $this->marketingToolboxModel->getVerticalsIds();
		return in_array($verticalId, $ids);

	}

	/**
	 * @param $verticalId
	 * @return array
	 */
	private function getServices($verticalId){

		return [
			'slider'=> new MarketingToolboxModuleSliderService('en',MarketingToolboxModel::SECTION_HUBS,$verticalId),
			'community' => new MarketingToolboxModuleFromthecommunityService('en',MarketingToolboxModel::SECTION_HUBS,$verticalId)
		];

	}


	/**
	 * @param $verticalId
	 *
	 */
	public function getDataFromModules($verticalId) {

		$services = $this->getServices($verticalId);

		foreach ( $services as $k=>&$v ) {
			$data[$k] = $v->loadData($this->marketingToolboxModel,[
				'lang' => 'en',
				'vertical_id' => $verticalId,
				'ts'=>null
			]);
		}

		$out = array();

		foreach($data as &$result) {

			$itemList = array_pop($result);

			if(  is_array($itemList) ) {
				foreach($itemList as &$item) {
					//removing duplicates
					$url = isset($item['articleUrl']) ? $item['articleUrl'] : $item['url'];

					$out[$url] = [
						'title'=> isset($item['shortDesc']) ? $item['shortDesc'] : $item['articleTitle'],
						'description' => isset($item['longDesc']) ? $item['longDesc'] : $item['quote'],
						'img' => isset($item['photoUrl']) ? $item['photoUrl'] : $item['imageUrl'],
					];
				}
			}
		}

		return ['items'=>$out];
	}

}


class InvalidHubAttributeException extends WikiaException{

	public function __construct($attribute){
		parent::__construct("Invalid attribute: '$attribute''");

	}
}