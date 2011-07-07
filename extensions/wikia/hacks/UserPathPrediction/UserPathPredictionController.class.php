<?php

/**
 * User Path Prediction controller
 * 
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */

class UserPathPredictionController extends WikiaController {
	public function init() {
		//TODO: initialization code here
	}
	
	public function getPath() {
		$startId;
		$count;
		
		$result = array (
					array (
							"A"=>array ( 
								'text' => "Dragon_Age:_Origins",
							 	'id' => 49880 
							),
							"B"=>array ( 
								'text' => "Village_of_Honnleath",
								'id' => 2349
							),
							"Count" => 123
						),
					array (
							"A"=>array (
								'text' => "Dragon_Age_II",
								'id' => 49880
							),
							"B"=>array (
								'text' => "Lothering",
								'id' => 5008
							),
							"Count" => 12
						),
					array (
							"A"=>array (
								'text' => "Wayward_son",
								'id' => 49196
							),
							"B"=>array (
								'text'=>"Sleep",
								'id'=>2447
							),
							"Count" => 19
						),
					array (
							"A"=>array (
								'text'=>"Portal:Dragon_Age",
								'id'=>38621
							),
							"B"=>array (
								'text'=>"Korcari_Wilds",
								'id'=>5606
							),
							"Count"=>1
					)
				);

		$this->setVal( 'articles', $result );
	}
	
}