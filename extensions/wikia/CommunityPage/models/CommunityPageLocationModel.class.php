<?php

/**
 * Created by IntelliJ IDEA.
 * User: gautambajaj
 * Date: 6/9/16
 * Time: 12:13 PM
 */
class CommunityPageLocationModel {
	private $wikiService;
	private $user;


	public function __construct(User $user=null)
	{
		$this->user = $user;
		$this->wikiService = new WikiService();
	}

	public function getUserOnCity($city){
		$nearByUsers = [4142476,5069708,24520859,25111458,22439,26154170,27382513,28203289,22872543, 26573805,26348682, 1332155, 27194367, 4346826, 25438171,26138166, 26567626,3106760];
		$result = [];
		foreach ($nearByUsers as $userId){
			$result[] = [
				'userId' => $userId,
				'city' => $city,
			];
		}
		return $result;
	}

	public function getCurrentUserLocation($currentUser){
		return 'Tokyo';
	}
	
	
	
}
