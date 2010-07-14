<?php
class SpecialLeaderboard extends SpecialPage {

	function  __construct() {
		wfLoadExtensionMessages('Achievements');
		parent::__construct('Leaderboard');
	}


	function execute () {
		global $wgOut, $wgUser, $wgTitle;
		$this->setHeaders();

		$dbr = wfGetDB(DB_MASTER);

		$allTime = array();
		$res = $dbr->query('select user_id, count(*) as cnt from achievements_badges group by user_id order by cnt DESC');
		while($row = $dbr->fetchObject($res)) {
			$user = User::newFromId($row->user_id);
			$allTime[] = array('username' => $user->getName(), 'numberOfBadges' => $row->cnt, 'url' => $user->getUserPage()->getLocalURL());
		}

		$thisWeek = array();
		$res = $dbr->query('select user_id, count(*) as cnt from achievements_badges where data >= date_sub(now(), interval 7 day) group by user_id order by cnt DESC');
		while($row = $dbr->fetchObject($res)) {
			$user = User::newFromId($row->user_id);
			$thisWeek[] = array('username' => $user->getName(), 'numberOfBadges' => $row->cnt, 'url' => $user->getUserPage()->getLocalURL());
		}

		$leaderboardTemplate = new EasyTemplate(dirname(__FILE__).'/templates');
		$leaderboardTemplate->set_vars(array('allTime' => $allTime, 'thisWeek' => $thisWeek));
		$leaderboardHTML = $leaderboardTemplate->render('leaderboard');

		$wgOut->addHtml($leaderboardHTML);
	}

}