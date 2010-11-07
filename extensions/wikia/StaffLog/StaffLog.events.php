<?php 
class StaffLogger {
	static public function log($type,$action,$userId,$userName,$userdstId,$userNamedst,$comment = "") {
		global $wgSitename,$wgCityId,$wgExternalDatawareDB;
		$dbw =  wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$now = wfTimestampNow();
		$data = array(
			'slog_type' => $type,
			'slog_action' => $action,
			'slog_timestamp' => $dbw->timestamp( $now ),
			'slog_user' => $userId,
			'slog_user_namedst' => $userNamedst,
			'slog_user_name' =>  $userName,
			'slog_userdst' => $userdstId,
			'slog_comment' => $comment,
			'slog_site' => $wgSitename,
			'slog_city' => $wgCityId
		);
		$dbw->insert( 'wikiastaff_log', $data, __METHOD__ );
	}
	
	static public function setupStafflog() {
		global $wgHooks;
		$wgHooks['BlockIpStaffPowersCancel'][] = 'StaffLogger::eventlogBlockIp';
		$wgHooks['PiggybackLogOut'][] = 'StaffLogger::eventlogPiggybackLogOut';
		$wgHooks['PiggybackLogIn'][] = 'StaffLogger::eventlogPiggybackLogIn'; 
	}

	static public function eventlogPiggybackLogIn($user,$userdst) {
		self::log("piggyback","login",$user->getID(),$user->getName(),$userdst->getID(),$userdst->getName());		
		return true;
	}
	
	static public function eventlogPiggybackLogOut($user,$userdst) {
		self::log("piggyback","logout",$user->getID(),$user->getName(),$userdst->getID(),$userdst->getName());		
		return true;
	}
	
	static public function  eventlogBlockIp( $block,$user ) {
		self::log("block","block",$user->getID(),$user->getName(),$block->mUser,$block->mAddress,$block->mReason);
		return true;
	}
}
StaffLogger::setupStafflog();
