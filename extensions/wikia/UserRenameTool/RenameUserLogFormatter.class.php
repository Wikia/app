<?php
/**
 * @author: Władysław Bodzek
 *
 * A helper class for the User rename tool
 * @copyright (C) 2010, Wikia Inc.
 * @licence GNU General Public Licence 3.0 or later
 */
class RenameUserLogFormatter {
	static protected function getCommunityUser( $name, $noRedirect = false ) {
		if (is_int($name))
			$name = User::whoIs($name);
		$title = GlobalTitle::newFromText($name, NS_USER, COMMUNITY_CENTRAL_CITY_ID);
		return Xml::element('a',array('href'=>$title->getFullURL(
			$noRedirect ? 'redirect=no' : ''
		)),$name,false);
	}

	static protected function getCommunityTask( $taskId ) {
		$taskId = intval($taskId);
		$title = GlobalTitle::newFromText('TaskManager', NS_SPECIAL, COMMUNITY_CENTRAL_CITY_ID);
		return Xml::element('a',array('href'=>$title->getFullURL(
			"action=log&id={$taskId}&offset=0"
		)),"#{$taskId}",false);
	}

	static protected function getCityLink( $cityId ) {
		global $wgCityId, $wgSitename;
		$domains = WikiFactory::getDomains( $cityId );
		if ($wgCityId == $cityId) {
			// Hack based on the fact we should only ask for current wiki's sitename
			$text = $wgSitename;
		} else {
			// The fallback to return anything
			$text = "[".WikiFactory::IDtoDB($cityId).":{$cityId}]";
		}
		if (!empty($domains))
		{
			$text = Xml::tags('a', array("href" => "http://".$domains[0] ), $text );
		}
		return $text;
	}

	static public function start( $requestor, $oldUsername, $newUsername, $reason, $tasks = array() ) {
		foreach ($tasks as $k => $v){
			$tasks[$k] = self::getCommunityTask($v);
		}

		$text = wfMsgForContent( 'userrenametool-info-started',
			self::getCommunityUser($requestor),
			self::getCommunityUser($oldUsername,true),
			self::getCommunityUser($newUsername),
			$tasks ? implode(', ',$tasks) : '-',
			$reason
		);
		return $text;
	}

	static public function finish( $requestor, $oldUsername, $newUsername, $reason, $tasks = array() ) {
		foreach ($tasks as $k => $v){
			$tasks[$k] = self::getCommunityTask($v);
		}

		$text = wfMsgForContent( 'userrenametool-info-finished',
			self::getCommunityUser($requestor),
			self::getCommunityUser($oldUsername,true),
			self::getCommunityUser($newUsername),
			$tasks ? implode(', ',$tasks) : '-',
			$reason
		);
		return $text;
	}

	static public function fail( $requestor, $oldUsername, $newUsername, $reason, $tasks = array() ) {
		foreach ($tasks as $k => $v){
			$tasks[$k] = self::getCommunityTask($v);
		}

		$text = wfMsgForContent( 'userrenametool-info-failed',
			self::getCommunityUser($requestor),
			self::getCommunityUser($oldUsername,true),
			self::getCommunityUser($newUsername),
			$tasks ? implode(', ',$tasks) : '-',
			$reason
		);
		return $text;
	}

	static public function wiki( $requestor, $oldUsername, $newUsername, $cityId, $reason, $problems = false ) {
		$text = wfMsgForContent(
			$problems ? 'userrenametool-info-wiki-finished-problems' : 'userrenametool-info-wiki-finished',
			self::getCommunityUser($requestor),
			self::getCommunityUser($oldUsername,true),
			self::getCommunityUser($newUsername),
			self::getCityLink($cityId),
			$reason
		);
		return $text;
	}
}