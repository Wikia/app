<?php

/**
 * WikiaApiReportEmail
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
  * $Id$
 */

/**

use these tables on dataware database:

CREATE TABLE `emails` (
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `send_from` tinytext NOT NULL,
  `send_to` tinytext NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `city_id` int(9) unsigned NOT NULL,
  `success` tinyint(3) unsigned NOT NULL,
  `failure_reason` tinytext,
  `type_id` tinyint(3) unsigned DEFAULT NULL,
  KEY `emails_send_to` (`send_to`(255)),
  KEY `emails_send_date` (`send_date`),
  KEY `emails_user_id` (`user_id`)
) ENGINE=InnoDB;

CREATE TABLE `email_types` (
  `id` tinyint(3) unsigned NOT NULL,
  `type` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

INSERT INTO email_types VALUES( 0, 'unknown' );
INSERT INTO email_types VALUES( 1, 'AutoCreateWiki' );
INSERT INTO email_types VALUES( 2, 'BoardNotificationEmail' );
INSERT INTO email_types VALUES( 3, 'ConfirmAccount' );
INSERT INTO email_types VALUES( 4, 'ConfirmationMail' );
INSERT INTO email_types VALUES( 5, 'EmailUser' );
INSERT INTO email_types VALUES( 6, 'GenericEditPage' );
INSERT INTO email_types VALUES( 7, 'GiftNotificationEmail' );
INSERT INTO email_types VALUES( 8, 'GlobalWatchlist' );
INSERT INTO email_types VALUES( 9, 'InviteContacts' );
INSERT INTO email_types VALUES( 10, 'LinkEx' );
INSERT INTO email_types VALUES( 11, 'NewUserNotification' );
INSERT INTO email_types VALUES( 12, 'NssMySQLAuth' );
INSERT INTO email_types VALUES( 13, 'Poke' );
INSERT INTO email_types VALUES( 14, 'ProblemReport' );
INSERT INTO email_types VALUES( 15, 'ReConfirmationMail' );
INSERT INTO email_types VALUES( 16, 'RelationshipAcceptEmail' );
INSERT INTO email_types VALUES( 17, 'RelationshipRemoveEmail' );
INSERT INTO email_types VALUES( 18, 'RelationshipRequestEmail' );
INSERT INTO email_types VALUES( 19, 'SendToAFriend' );
INSERT INTO email_types VALUES( 20, 'SpecialContact' );
INSERT INTO email_types VALUES( 21, 'TemporaryPassword' );
INSERT INTO email_types VALUES( 22, 'TodoTask' );
INSERT INTO email_types VALUES( 23, 'UserMailer' );
INSERT INTO email_types VALUES( 24, 'UserRightsNotification' );
INSERT INTO email_types VALUES( 25, 'UserSystemMessages' );
INSERT INTO email_types VALUES( 26, 'Watchlist' );

**/

class WikiaApiReportEmail extends ApiBase {


	/**
	 * constructor
	 */
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName );
	}

	/**
	 * execute -- main entry point to api method
	 *
	 * we rely here that user is logged in previous api login action, we just
	 * check permission for reporting
	 *
	 * @access public
	 *
	 * @return api result,
	 */
	public function execute() {

		global $wgExternalDatawareDB, $wgTheSchwartzToken;

		$wgTheSchwartzToken = "test";

		$params = $this->extractRequestParams();
		$result = array();

		if( isset($params[ "token" ] ) && $params[ "token" ] === $wgTheSchwartzToken ) {
			if( is_null( $params[ "from" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "from" ) );
			}
			if( is_null( $params[ "to" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "to" ) );
			}
			if( is_null( $params[ "type" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "type" ) );
			}
			if( is_null( $params[ "user_id" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "user_id" ) );
			}
			if( is_null( $params[ "city_id" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "city_id" ) );
			}
			if( is_null( $params[ "success" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "success" ) );
			}
			if( is_null( $params[ "timestamp" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "timestamp" ) );
			}

			wfProfileIn( __METHOD__ );
			$types  = $this->getEmailTypes();
			$date   = date( "Y-m-d H:i:s", $params[ "timestamp" ] );
			$reason = is_null( $params[ "reason" ] ) ? "" : $params[ "reason" ];
			$type   = isset( $types[ $params[ "type" ] ] )
				? $types[ $params[ "type" ] ]
				: 0;

			$dbw = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
			$sth = $dbw->insert(
				"emails",
				array(
					"send_date"      => $date,
					"send_from"      => $params[ "from" ],
					"send_to"        => $params[ "to" ],
					"user_id"        => $params[ "user_id" ],
					"city_id"        => $params[ "city_id" ],
					"success"        => $params[ "success" ],
					"type_id"        => $type,
					"failure_reason" => $reason,
				)
			);
			$result = ( $sth ) ? array( "status" => 1 ) : array( "status" => 0 );
			wfProfileOut( __METHOD__ );
		}
		else {
			$this->dieUsageMsg( array( "sessionfailure" ) );
		}
		$this->getResult()->setIndexedTagName($result, 'page');
		$this->getResult()->addValue(null, $this->getModuleName(), $result );
	}

	/**
	 * get email types from database or cache
	 *
	 * @access private
	 *
	 * @return array
	 */
	private function getEmailTypes() {
		global $wgMemc, $wgExternalDatawareDB;

		wfProfileIn( __METHOD__ );
		/**
		 * first from cache
		 */
		$emailTypes = $wgMemc->get( wfSharedMemcKey( "apireportemail", "types" ) );
		if( !is_array( $emailTypes ) || !count( $emailTypes ) ) {
			/**
			 * if not then from database
			 */
			$emailTypes = array();
			$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
			$sth = $dbr->select(
				array( "email_types" ),
				array( "*" ),
				null,
				__METHOD__
			);
			while( $row = $dbr->fetchObject( $sth ) ) {
				$emailTypes[ $row->type ] = $row->id;
			}
			$wgMemc->set( wfSharedMemcKey( "apireportemail", "types" ), $emailTypes, 3600 );
		}
		wfProfileOut( __METHOD__ );

		return $emailTypes;
	}

	public function getVersion() {
		return __CLASS__ . ': $Id$';
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getDescription() {
		return "Report email queue status from TheSchwartz Queue";
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getAllowedParams() {
		$types  = $this->getEmailTypes();
		return array(
			"to"        => array( ),
			"from"      => array( ),
			"type"      => array( APIBASE::PARAM_TYPE => array_keys( $types ) ),
			"token"     => array( ),
			"success"   => array( APIBASE::PARAM_TYPE => array( 0, 1 ) ),
			"city_id"   => array( APIBASE::PARAM_TYPE => "integer" ),
			"user_id"   => array( APIBASE::PARAM_TYPE => "integer" ),
			"reason"    => array( ),
			"timestamp" => array( ),
		);
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getParamDescription() {
		return array(
			"to"        => "To: email address",
			"from"      => "From: email address",
			"type"      => "Type of email",
			"user_id"   => "user_id from user table",
			"city_id"   => "city_id from city_list table",
			"success"   => "Operation succeded or not",
			"token"     => "Secret token",
			"reason"    => "Tells reason whe operation was not succeded",
			"timestamp" => "Send date and time as unix time"
		);
	}

	public function getExamples() {
		return array (
			"api.php?action=theschwartz"
		);
	}

	/**
	 * method demands writing rights
	 */
	public function isWriteMode() {
		return true;
	}
}
