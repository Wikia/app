<?php

class MoodBarHTMLMailerJob extends Job {

	function __construct( $title, $params, $id = 0 ) {
		parent::__construct( __CLASS__, $title, $params, $id );
	}

	function run() {
		$enotif = new MoodBarHTMLEmailNotification();
		// Get the user from ID (rename safe). Anons are 0, so defer to name.
		if( isset( $this->params['editorID'] ) && $this->params['editorID'] ) {
			$editor = User::newFromId( $this->params['editorID'] );
		// B/C, only the name might be given.
		} else {
			$editor = User::newFromName( $this->params['editor'], false );
			if ( !$editor ) {
				$this->setLastError( $this->params['editor'] . ' is not a valid user' );
				return false;
			}
		}

		$enotif->actuallyNotifyOnRespond(
			$editor,
			$this->title,
			$this->params['timestamp'],
			$this->params['feedback'],
			$this->params['response'],
			$this->params['type'],
			$this->params['responseId']
		);
		return true;
	}

}
