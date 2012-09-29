<?php

/**
 * TaskManager task to go through a list of images and delete them.
 *
 * Mostly copied from MultiWikiDeleteTask
 *
 * @author tor
 * @date 2012-03-09
 *
 * @todo rewrite from shell exec to internal GlobalArticle::delete() call
 * @todo flag all images by user and by wiki after deletion
 */

class ImageReviewTask extends BatchTask {
	var $mType, $mVisible, $mArguments, $mMode, $mAdmin;
	var $records, $title, $namespace;
	var $mUser, $mUsername;

	/* constructor */
	function __construct( $params = array() ) {
		$this->mType = 'imagereview';
		$this->mVisible = false; // do not show form for this task
		$this->mParams = $params;
		$this->mTTL = 86400; // 24 hours
		$this->records = 1000; // TODO: needed?
		parent::__construct();
	}

	function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath;
		/*  go with each supplied wiki and delete the supplied article
			load all configs for particular wikis before doing so
			(from wikifactory, not by _obsolete_ maintenance scripts
			and from LocalSettings as worked on fps)
		 */

		$this->mTaskID = $params->task_id;
		$oUser = User::newFromId( $params->task_user_id );

		if ( $oUser instanceof User ) {
			$oUser->load();
			$this->mUser = $oUser->getName();
		} else {
			$this->log("Invalid user - id: " . $params->task_user_id );
			return true;
		}

		$data = unserialize($params->task_arguments);

		foreach ( $data['page_list'] as $imageData ) {
			$retval = "";

			list( $wikiId, $imageId) = $imageData;

			$dbname = WikiFactory::getWikiByID( $wikiId );
			if ( !$dbname ) continue;

			$title = GlobalTitle::newFromId( $imageId, $wikiId );

			if ( !is_object( $title ) ) {
				$this->log( 'Apparently the article does not exist anymore' );
				continue;
			}

			$city_url = WikiFactory::getVarValueByName( "wgServer", $wikiId );
			if ( empty($city_url) ) continue;

			$city_path = WikiFactory::getVarValueByName( "wgScript", $wikiId );

			$city_lang = WikiFactory::getVarValueByName( "wgLanguageCode", $wikiId );
			$reason = wfMsgExt( 'imagereview-reason', array( 'language' => $city_lang ) );

			$sCommand  = "perl /usr/wikia/backend/bin/run_maintenance --id={$wikiId} --script=wikia/deleteOn.php ";
			$sCommand .= "-- ";
			$sCommand .= "-u " . escapeshellarg( $this->mUser ) . " ";
			$sCommand .= "-t " . escapeshellarg( $title->getPrefixedText() ) . " ";
			if ( $reason ) {
				$sCommand .= "-r " . escapeshellarg( $reason ) . " ";
			}

			$actual_title = wfShellExec($sCommand, $retval);

			if ($retval) {
				$this->addLog('Article deleting error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $actual_title);
			} else {
				$this->addLog('Removed: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($actual_title)  . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
			}

			$this->flagUser( $imageId, $wikiId );
			$this->flagWiki( $wikiId );
		}

		return true;
	}

	function flagUser( $imageId, $wikiId ) {
	}

	function flagWiki( $wikiId ) {
	}

	function getForm( $title, $errors = false ) {}

	function submitForm() {} 
}
