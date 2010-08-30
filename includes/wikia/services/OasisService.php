<?php
class OasisService extends Service {

	public function getRandomData($howMany = 1000) {
		$data = array();
		for($i = 0; $i < $howMany; $i++) {
			$data[] = "Random item no. ".rand();
		}
		return $data;
	}
}