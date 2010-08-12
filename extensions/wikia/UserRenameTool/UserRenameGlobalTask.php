<?php
if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class UserRenameGlobalTask extends BatchTask {

	private $mParams;

	/**
	 * contructor
	 * @access public
	 */
	public function  __construct() {
		$this->mType = "renameuser_global";
		$this->mVisible = true;
		parent::__construct();
		
		$this->mDebug = false;
	}

	/**
	 * execute
	 *
	 * entry point for TaskExecutor
	 *
	 * @access public
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 *
	 * @param mixed $params default null - task data from wikia_tasks table
	 *
	 * @return boolean - status of operation
	 */
	public function execute( $params = null ) {
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
