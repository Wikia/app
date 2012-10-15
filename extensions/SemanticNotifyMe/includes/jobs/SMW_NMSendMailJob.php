<?php
/**
 * SMW_NMSendMailJob.php
 *
 * This job is triggered whenever a notify-me page was saved or removed.
 *
 * @author ning
 *
 */
if ( !defined( 'MEDIAWIKI' ) ) {
  die( "This file is part of the Semantic NotifyMe Extension. It is not a valid entry point.\n" );
}

class SMW_NMSendMailJob extends Job {

	/**
	 * Creates a NMSendMailJob
	 *
	 * @param Title $title
	 */
	function __construct( $title, $params ) {
		wfDebug( __METHOD__ . " " . get_class( $this ) . " \r\n" );
		wfProfileIn( __METHOD__ );
		parent::__construct( get_class( $this ), Title::newMainPage(), $params );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Run a SMW_NMSendMailJob job
	 * @return boolean success
	 */
	function run() {
		wfDebug( __METHOD__ );
		wfProfileIn( __METHOD__ );

		UserMailer::send(
			$this->params['to'],
			$this->params['from'],
			$this->params['subj'],
			$this->params['body'],
			$this->params['replyto']
		);

		wfProfileOut( __METHOD__ );
		return true;
	}
}
