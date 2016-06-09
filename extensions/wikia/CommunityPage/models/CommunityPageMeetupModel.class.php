<?php

/**
 * Created by IntelliJ IDEA.
 * User: gautambajaj
 * Date: 6/9/16
 * Time: 12:33 PM
 */
class CommunityPageMeetupModel {

	public function sendMessageToUser($userId,$message){
		//sends $message To $userId
	}
	
	public function sendInvitation($invitation, $userIds){

		foreach ($userIds as $userId){
			$this->sendMessageToUser($userId,$userId);
		}
	}

	
}
