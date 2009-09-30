<?php

/**
 * WikiaApiReportEmail
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
  * $Id$
 */

$wgAPIModules['theschwartz'] = 'WikiaApiReportEmail';

class WikiaApiReportEmail extends ApiBase {

	/**
	 * constructor
	 */
	public function __construct( $query, $moduleName ) {
		parent::__construct( $query, $moduleName );
	}

	public function execute() {

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
		return "Report email queue status from TheSchwartz";
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getAllowedParams() {
		return array();
	}

	/**
	 * standard api function
	 *
	 * @access public
	 */
	public function getParamDescription() {
		return array();
	}

	public function getExamples() {
		return array (
			"api.php?action=theschwartz"
		);
	}

}
