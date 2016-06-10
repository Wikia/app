<?php

/**
 * Created by IntelliJ IDEA.
 * User: gautambajaj
 * Date: 6/9/16
 * Time: 12:33 PM
 */
class CommunityPageMeetupModel {

	const MEETUP_MCACHE_KEY ='currentEvent';

	public function sendMessageToUser($userId,$message){
		//sends $message To $userId
	}
	
	public function sendInvitation($invitation, $userIds){

		foreach ($userIds as $userId){
			$this->sendMessageToUser($userId,$userId);
		}
	}

	public function getNearByUsers($currentUserLocation){
		return (new CommunityPageLocationModel())->getUserOnCity($currentUserLocation);
	}
	
	public function saveEvent($createdBy, $location, $time, $description){
		$key = wfMemcKey(self::MEETUP_MCACHE_KEY);

		$value = $createdBy . ':' . $location . ':' . $time . ':' . $description;

		F::app()->wg->Memc->set( $key, $value);
	}

	public function getEvent(){

		$key = wfMemcKey(self::MEETUP_MCACHE_KEY);
		$value = F::app()->wg->Memc->get($key);

		if($value){
			$params = explode(':',$value);
			$event[] = [
				'createdBy' => $params[0],
				'location' => $params[1],
				'time' => $params[2],
				'description' => $params[3],
			];
			return $event;
		}

		return null;
	}

	public function deleteEvent(){

		$key = wfMemcKey(self::MEETUP_MCACHE_KEY);
		F::app()->wg->Memc->delete($key);
	}
}
