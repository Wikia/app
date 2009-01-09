<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Lapinski <bartek@wikia.com> for Wikia.com
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @copyright (C) 2007-2009, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 */

class MultiDeleteTask extends BatchTask {
	var $mType, $mVisible, $mArguments, $mMode, $mAdmin;
	var $mUser, $mUsername;

	/* constructor */
	function __construct($single = false) {
		$this->mType = 'multidelete';
		$this->mVisible = false; //we don't show form for this, it already exists
		parent::__construct ();
	}

	function execute($params = null) {
		global $IP, $wgWikiaLocalSettingsPath;
		/*	go with each supplied wiki and delete the supplied article
			load all configs for particular wikis before doing so
			(from wikifactory, not by _obsolete_ maintenance scripts
			and from LocalSettings as worked on fps)
		*/

		$this->mTaskID = $params->task_id;
		$oUser = User::newFromId( $params->task_user_id );
		$oUser->load();
		$this->mUser = $oUser->getName();

		$data = unserialize($params->task_arguments);
		$articlesData = $data['articles'];
		$username = escapeshellarg($data['username']);
		$this->addLog('Starting task.');
		$this->addLog('List of deleted articles (by ' . $this->mUser . ' as ' . $username . '):');

		foreach ($articlesData as $wikiId => $articles) {
			foreach ($articles as $article) {
				$namespace = $article['namespace'];
				$reason = $article['reason'] ? ('-r ' . escapeshellarg($article['reason'])) : '';
				$sCommand = "SERVER_ID=$wikiId php $IP/maintenance/wikia/deleteOn.php -u $username -t " . escapeshellarg($article['title']) . " -n $namespace $reason --conf " . escapeshellarg ($wgWikiaLocalSettingsPath);
				$city_url = WikiFactory::getVarValueByName('wgServer', $wikiId);
				if (empty($city_url)) {
					$city_url = "wiki id in WikiFactory: $wikiId";
				}

				$city_path  = WikiFactory::getVarValueByName('wgScript', $wikiId);
				$actual_title = wfShellExec($sCommand, $retval);

				if ($retval) {
					$this->addLog('Article deleting error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $actual_title);
				} else {
					$this->addLog('<a href="' . $city_url . $city_path . '?title=' . $actual_title  . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
				}
			}
		}
		return true;
	}

	function getType() {
		return $this->mType;
	}

	function isVisible() {
		return $this->mVisible;
	}

	function getForm ($title, $errors = false ) {
		return true;
	}

	function submitForm() {
		global $wgRequest, $wgOut, $IP, $wgUser;

		$articles = $this->mArguments;
		$mode = $this->mMode;
		$username = $this->mUsername;
		$tempUser = User::newFromName($username);

		$sParams = serialize(array(
					'articles' => $articles ,
					'username' => $username ,
					'mode' => $mode ,
					'admin' => $this->mAdmin
					));

		$dbw = wfGetDB( DB_MASTER );
		$dbw->selectDB( 'wikicities' );

		$dbw->insert( 'wikia_tasks', array(
					'task_user_id' => $wgUser->getID(),
					'task_type' => $this->mType,
					'task_priority' => 1,
					'task_status' => 1,
					'task_added' => wfTimestampNow(),
					'task_started' => '',
					'task_finished' => '',
					'task_arguments' => $sParams
					));
		$task_id = $dbw->insertId();
		$dbw->commit();
		return $task_id;
	}

	/**
	 * getDescription
	 *
	 * description of task, used in task listing.
	 *
	 * @access public
	 * @author eloy@wikia, bartek@wikia, marooned@wikia-inc
	 *
	 * @return string: task description
	 */
	public function getDescription() {
		$desc = $this->getType();
		if( !is_null( $this->mData ) ) {
			$args = unserialize( $this->mData->task_arguments );
			$mode = $args['mode'];
			$admin = $args['username'];

			$oUser = User::newFromName ($admin);
			if (is_object ($oUser)) {
				$oUser->load();
				$userLink = $oUser->getUserPage()->getLocalUrl();
				$userName = $oUser->getName();
			} else {
				$userLink = '';
				$userName = '<i>unknown</i>';
			}
			$desc = sprintf(
				'multidelete as user: <a href="%s">%s</a>',
				$userLink,
				$userName
		   );
		}
		return $desc;
	}
}