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

		global $wgTheSchwartzSecretToken, $wgCityId;

		$params = $this->extractRequestParams();
		$result = array();
		if( isset($params[ "token" ] ) && $params[ "token" ] === $wgTheSchwartzToken ) {
			/**
			 * get city_founding_user from city_list
			 */
			$wiki = WikiFactory::getWikiByID( $wgCityId );
			$founder = User::newFromId( $wiki->city_founding_user );
			/**
			 * for test purpose send email to me, Eloy.wikia
			 */
			$founder = User::newFromId( 51098 );
			if( $founder ) {
				$founder->sendMail(
					wfMsg( "createwiki-reminder-subject" ),
					wfMsg( "createwiki-reminder-body" ),
					null /*from*/,
					null /*replyto*/,
					"AutoCreateWikiReminder",
					wfMsg( "createwiki-reminder-body-HTML" )
				);
			}
		}
		else {
			$this->dieUsageMsg( array( "sessionfailure" ) );
		}

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
		$types  = $this->getEmailTypes();
		return array(
			"user_id"   => array( APIBASE::PARAM_TYPE => "integer" ),
			"token"
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
