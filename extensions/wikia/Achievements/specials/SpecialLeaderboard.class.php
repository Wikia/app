<?php

class SpecialLeaderboard extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('Achievements');
		parent::__construct('Leaderboard', '' /* no restriction */, true /* listed */);
	}

	function execute($user_id) {
		wfProfileIn(__METHOD__);

		global $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgSupressPageTitle, $wgUser, $wgWikiaBlogLikeUsers;

		$wgSupressPageTitle = true;

		$this->setHeaders();

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Achievements/css/leaderboard.css?{$wgStyleVersion}");

		$dbr = wfGetDB(DB_SLAVE);

		// ranking
		$ranking = array();
		$res = $dbr->select('achievements_counters', 'user_id, score', null, __METHOD__, array('ORDER BY' => 'score desc'));
		while($row = $dbr->fetchObject($res)) {
			$user = User::newFromId($row->user_id);
			if($user && !$user->isBlocked() && !in_array( $user->getName(), $wgWikiaBlogLikeUsers ) ) {
				$ranking[] = array('score' => number_format($row->score), 'name' => htmlspecialchars($user->getName()), 'url' => Masthead::newFromUser($user)->getUrl(), 'userpage_url' => $user->getUserPage()->getLocalURL());
			}
		}

		// recent
		$user_ids = array();
		$recent = array(BADGE_LEVEL_GOLD => array(), BADGE_LEVEL_SILVER => array(), BADGE_LEVEL_BRONZE => array());

		$query = '(SELECT user_id, date, badge_type, badge_lap, badge_level FROM achievements_badges WHERE badge_level = '.BADGE_LEVEL_GOLD.' ORDER BY date DESC, badge_lap DESC LIMIT 6)';
		$query .= 'UNION (SELECT user_id, date, badge_type, badge_lap, badge_level FROM achievements_badges WHERE badge_level = '.BADGE_LEVEL_SILVER.' ORDER BY date DESC, badge_lap DESC LIMIT 6)';
		$query .= 'UNION (SELECT user_id, date, badge_type, badge_lap, badge_level FROM achievements_badges WHERE badge_level = '.BADGE_LEVEL_BRONZE.' ORDER BY date DESC, badge_lap DESC LIMIT 6)';
		$query .= 'ORDER BY date DESC, badge_lap DESC';

		$res = $dbr->query($query);
		while($row = $dbr->fetchObject($res)) {
			$recent[$row->badge_level][] = array('user_id' => $row->user_id, 'badge_type' => $row->badge_type, 'badge_lap' => $row->badge_lap, 'date' => $row->date);
			$user_ids[] = $row->user_id;
		};

		if(count($user_ids) > 0) {
			$users = array();
			$res = $dbr->query('select min(date) as mindate, user_id from achievements_badges where user_id in ('.join(',', array_unique($user_ids)).') group by user_id;');
			while($row = $dbr->fetchObject($res)) {
				$user = User::newFromId($row->user_id);
				if($user && !$user->isBlocked() && !in_array( $user->getName(), $wgWikiaBlogLikeUsers ) ) {
					$users[$row->user_id] = array('mindate' => $row->mindate, 'user' => $user);
				}
			}
		}

		$template = new EasyTemplate(dirname(__FILE__).'/templates');
		$template->set_vars(array(
			'ranking' => $ranking,
			'recent' => $recent,
			'users' => $users,
			'username' => $wgUser->getName(),
			'js_url' => "{$wgExtensionsPath}/wikia/Achievements/js/Achievements.js?{$wgStyleVersion}"
		));
		$wgOut->addHTML($template->render('Leaderboard'));

		wfProfileOut(__METHOD__);
	}

}
