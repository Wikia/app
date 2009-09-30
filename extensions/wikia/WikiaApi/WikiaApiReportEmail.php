<?php

/**
 * WikiaApiReportEmail
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
  * $Id$
 */

$wgAPIModules['theschwartz'] = 'WikiaApiReportEmail';

/**

use these tables on dataware database:

CREATE TABLE emails (
	send_date TIMESTAMP NOT NULL INDEX,
	from VARCHAR NOT NULL,
	to VARCHAR NOT NULL INDEX
	success integer  not null  / set 1 for success 0 for failure
	failure_reason tinytext,
	type INTEGER references email_types( id )
);

CREATE TABLE email_types (
	id int primary key
	type varchar not null
)
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
	 */
	public function execute() {

		global $wgUser;

		$params = $this->extractRequestParams();
		$result = array();

		if( $wgUser->isAllowed( "theschwartz-report" ) || 1 ) { // enabled for testing
			if( is_null( $params[ "from" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "from" ) );
			}
			if( is_null( $params[ "to" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "to" ) );
			}
			if( is_null( $params[ "type" ] ) ) {
				$this->dieUsageMsg( array( "missingparam", "type" ) );
			}
		}
		else {
			$this->dieUsageMsg( array( "sessionfailure" ) );
		}
		$this->getResult()->addValue(null, $this->getModuleName(), $result);
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
		return array(
			"from"    => array(),
			"to"      => array(),
			"type"    => array(),
			"success" => array( APIBASE::PARAM_TYPE => "integer" ) 
		);
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getParamDescription() {
		return array(
			"from"    => "From: email address",
			"to"      => "To: email address",
			"type"    => "Type of email e.g. watchlist",
			"success" => "Operation succeded or not"
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
