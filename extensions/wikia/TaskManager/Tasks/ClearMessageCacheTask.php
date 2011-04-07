<?php

/**
 * @file
 * @package MediaWiki
 * @ingroup BatchTask
 * @author Lucas 'TOR' Garczewsk <tor@wikia-inc.com>
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 * @copyright Copyright © Krzysztof Krzyżaniak for Wikia Inc.
 * @date 2011-04-07
 * @version 1.0
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Will clear rebuild message cache for all wikis, using messaging.wikia.com as a base
 */
class ClearMessageCacheTask extends BatchTask {

	private $mParams, $mWikiId, $mUseTemplate;

	const WIKI_ID = 4036; // CityId of messaging.wikia.com

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {

		parent::__construct();
		$this->mType = "clear-msg-cache";
		$this->mVisible = true;
		$this->mTTL = 1800;
		$this->mDebug = false;
		$this->mUseTemplate = false;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author tor@wikia
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

		/**
		 * execute maintenance script
		 */
		$cmd = sprintf( "SERVER_ID=" . self::WIKI_ID . " php {$IP}/{$command} --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}" );
		$this->addLog( "Running {$cmd}" );
		$retval = wfShellExec( $cmd, $status );
		$this->addLog( $retval );
		
		return true;
	}

	/**
	 * getForm
	 *
	 * @access public
	 * @author tor@wikia
	 * @author eloy@wikia
	 *
	 * @param Title $title: Title struct
	 * @param mixes $data: params from HTML form
	 *
	 * @return false
	 */
	public function getForm( $title, $data = false ) {
		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/ClearMessageCacheTask/" );
		$oTmpl->set_vars( array(
			"data" => $data,
			"type" => $this->mType,
			"title" => $title,
		));
		return $oTmpl->execute( "form" );
	}

	/**
	 * submitForm
	 *
	 * @access public
	 * @author tor@wikia
	 *
	 * @return true
	 */
	public function submitForm() {
		// @TODO maybe check if task is already queued? no use running this twice

		$this->mTaskID = $this->createTask( array() );

		$wgOut->addHTML( Wikia::successbox("Task added") );

		return true;
	}
}
