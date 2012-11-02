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

		$taskStatus = true;

		$this->mTaskID = $params->task_id;
		$oUser = User::newFromId( $params->task_user_id );

		if ( $oUser instanceof User ) {
			$oUser->load();
			$this->mUser = $oUser->getName();
		} else {
			$this->log("Invalid user - id: " . $params->task_user_id );
			return false;
		}

		$data = unserialize($params->task_arguments);

		foreach ( $data['page_list'] as $imageData ) {
			$retval = "";

			list( $wikiId, $imageId) = $imageData;

			if ( !WikiFactory::isPublic( $wikiId ) ) {
				$this->log( "Wiki ID $wikiId has been disabled" );
				$taskStatus = false;
				continue;
			}

			$dbname = WikiFactory::getWikiByID( $wikiId );
			if ( !$dbname ) {
				$this->log( "Did not find database for wiki ID $wikiId" );
				$taskStatus = false;
				continue;
			}

			$city_url = WikiFactory::getVarValueByName( "wgServer", $wikiId );
			if ( empty($city_url) ) {
				$this->log( "Could not determine URL for wiki ID $wikiId" );
				$taskStatus = false;
				continue;
			}

			$city_path = WikiFactory::getVarValueByName( "wgScript", $wikiId );

			$city_lang = WikiFactory::getVarValueByName( "wgLanguageCode", $wikiId );
			$reason = wfMsgExt( 'imagereview-reason', array( 'language' => $city_lang ) );

			$sCommand  = "perl /usr/wikia/backend/bin/run_maintenance --id={$wikiId} --script=wikia/deleteOn.php ";
			$sCommand .= "-- ";
			$sCommand .= "-u " . escapeshellarg( $this->mUser ) . " ";
			$sCommand .= "--id " . $imageId . " ";
			if ( $reason ) {
				$sCommand .= "-r " . escapeshellarg( $reason ) . " ";
			}

			$actual_title = wfShellExec($sCommand, $retval);

			if ( $retval !== 0 ) {
				$this->addLog('Article deleting error! (' . $city_url . '). Error code returned: ' .  $retval . ' Error was: ' . $actual_title);
				$taskStatus = false;
			} else {
				$this->addLog('Removed: <a href="' . $city_url . $city_path . '?title=' . wfEscapeWikiText($actual_title)  . '">' . $city_url . $city_path . '?title=' . $actual_title . '</a>');
			}

			$this->flagUser( $imageId, $wikiId );
			$this->flagWiki( $wikiId );
		}

		if ( !$taskStatus ) $this->sendNotification();

		return $taskStatus;
	}

	function sendNotification() {
		$recipients = array(
			'tor@wikia-inc.com',
			'sannse@wikia-inc.com',
		);

		$subject = 'ImageReview deletion failed: #' . $this->mTaskID;
		$body = Title::newFromText( 'TaskManager', NS_SPECIAL )->getFullUrl( array(
			'action' => 'log',
			'id' => $this->mTaskID,
			'offset' => 0,
		) );

		foreach ( $recipients as $address ) {
			$to[] = new MailAddress( $address );
		}

		$from = new MailAddress( $recipients[0] );

		UserMailer::send( $to, $from, $subject, $body );
	}

	function flagUser( $imageId, $wikiId ) {
	}

	function flagWiki( $wikiId ) {
	}

	function getForm( $title, $errors = false ) {}

	function submitForm() {} 
}
