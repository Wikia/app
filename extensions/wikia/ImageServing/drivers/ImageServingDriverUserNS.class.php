<?php 
class ImageServingDriverUserNS extends ImageServingDriverMainNS {

	function formatResult($imageList ,$dbOut, $limit) {
		$out = parent::formatResult($imageList ,$dbOut, $limit);
		foreach($this->getArticlesList() as $key => $value) { 
			$user = explode('/', $value['title']);
			if(!empty($out[$key])) {
				$out[$key] = array($this->getData($user[0])) + array_slice($out[$key], 0, $limit - 1); 
			} else {
				$out[$key] = array($this->getData($user[0]));
			}
		}	
		return $out;
	}
		
	private function getData($user) {
		$cut = $this->imageServing->getCut( 100, 100, "center", false); 
		return array(
			"name" => 'avatar',
			"url" => AvatarService::getAvatarUrl($user, $cut, false, true)
		);
	}
}