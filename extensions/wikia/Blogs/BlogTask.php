<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright (C) 2009, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class BlogTask extends BatchTask {

	private $mParams;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {
		$this->mType = "blog";
		$this->mVisible = false;
		$this->mTTL = 1800;
		parent::__construct();
		$this->mDebug = true;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author eloy@wikia
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute( $params = null ) {
		global $IP, $wgWikiaLocalSettingsPath, $wgWikiaAdminSettingsPath;

		$this->mParams = unserialize( $params->task_arguments );
		$city_id = $this->mParams["city_id"];
		if( $city_id ) {
			/**
			 * execute maintenance script
			 */
			$cmd = sprintf("SERVER_ID={$city_id} php {$IP}/extensions/wikia/Blogs/maintenance.php --conf {$wgWikiaLocalSettingsPath} --aconf {$wgWikiaAdminSettingsPath}");
			$this->addLog( "Running {$cmd}");
			$this->addLog( $cmd );
			$retval = wfShellExec( $cmd, $status );
			$this->addLog( $retval );
		}

		return true;
	}

    /**
     * getForm
     *
     * this task is not visible in selector so it doesn't have real HTML form
     *
     * @access public
     * @author eloy@wikia
     *
     * @param Title $title: Title struct
     * @param mixes $data: params from HTML form
     *
     * @return false
     */
    public function getForm( $title, $data = false ) {
        return false;
    }

    /**
     * getType
     *
     * return string with codename type of task
     *
     * @access public
     * @author eloy@wikia
     *
     * @return string: unique name
     */
    public function getType() {
        return $this->mType;
    }

    /**
     * isVisible
     *
     * check if class is visible in TaskManager from dropdown
     *
     * @access public
     * @author eloy@wikia
     *
     * @return boolean: visible or not
     */
    public function isVisible() {
        return $this->mVisible;
    }

    /**
     * submitForm
     *
     * since this task is invisible for form selector we use this method for
     * saving request data in database
     *
     * @access public
     * @author eloy@wikia
     *
     * @return true
     */
    public function submitForm() {
        return true;
    }

}
