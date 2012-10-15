<?php

/**
 * WikiaApiCreatorReminderEmail
 *
 * remind to wiki creater that he/she created wiki some time ago
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * $Id$
 */

class WikiaApiCreatorReminderEmail extends ApiBase {

	/**
	 * constructor
	 */
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName );
	}

	/**
	 * execute -- main entry point to api method
	 *
	 * use secret hash for checking if api is called by proper engine
	 *
	 * @access public
	 *
	 * @return api result
	 */
	public function execute() {

		global $wgTheSchwartzSecretToken, $wgCityId, $wgServer,
			$wgExtensionMessagesFiles;

		$params = $this->extractRequestParams();
		$status = 0;

		if( isset($params[ "token" ] ) && $params[ "token" ] === $wgTheSchwartzSecretToken ) {

			/**
			 * load i18n
			 */
			$wgExtensionMessagesFiles[ "AutoCreateWiki" ] = dirname(__FILE__) . "/AutoCreateWiki.i18n.php";

			/**
			 * get creator from param
			 */
			$founder = User::newFromId( $params[ "user_id" ] );
			$founder->load();
			/**
			 * get city_founding_user from city_list
			 */
			if( !$founder ) {
				$wiki = WikiFactory::getWikiByID( $wgCityId );
				$founder = User::newFromId( $wiki->city_founding_user );
			}

			Wikia::log( __METHOD__, "user", $founder->getName() );
	      			if( $founder && $founder->isEmailConfirmed() ) {
				if( $founder->sendMail(
					wfMsg( "autocreatewiki-reminder-subject" ),
					wfMsg( "autocreatewiki-reminder-body", array( $founder->getName(), $wgServer ) ),
					null /*from*/,
					null /*replyto*/,
					"AutoCreateWikiReminder",
					wfMsg( "autocreatewiki-reminder-body-HTML", array( $founder->getName(), $wgServer ) )
				) ) {
					$status = 1;
				}
			}
		}
		else {
			$this->dieUsageMsg( array( "sessionfailure" ) );
		}
		$result = array( "status" => $status );
		$this->getResult()->setIndexedTagName($result, 'status');
		$this->getResult()->addValue(null, $this->getModuleName(), $result );

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
		return "Method called from TheSchwartz Queue to remind Wiki Creator about some options";
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getAllowedParams() {
		return array(
			"user_id" => array( APIBASE::PARAM_TYPE => "integer" ),
			"token"   => array( )
		);
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getParamDescription() {
		return array(
			"user_id" => "user_id from user table",
			"token"   => "secret token"
		);
	}

	public function getExamples() {
		return array (
			"api.php?action=awcreminder&user_id=51098&token=secret"
		);
	}

	/**
	 * method demands writing rights
	 */
	public function isWriteMode() {
		return false;
	}
}
