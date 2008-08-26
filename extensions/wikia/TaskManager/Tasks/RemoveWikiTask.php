<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 *
 * @todo: move user_groups from source to target
 */

/**
CREATE TABLE `city_list_deleted` (
  `city_id` int(9) NOT NULL,
  `city_dbname` varchar(31) NOT NULL,
  `city_sitename` varchar(255) NOT NULL,
  `city_url` varchar(255) NOT NULL,
  `city_created` datetime default NULL,
  `city_founding_user` int(5) default NULL,
  `city_adult` tinyint(1) default '0',
  `city_public` int(1) NOT NULL default '1',
  `city_additional` text,
  `city_description` text,
  `city_title` varchar(255) default NULL,
  `city_founding_email` varchar(255) default NULL,
  `city_lang` varchar(7) NOT NULL default 'en',
  `city_umbrella` varchar(255) default NULL,
  `city_useshared` tinyint(1) default '1',
  `city_deleted_timestamp` varchar(14) default '19700101000000',
  `city_factory_timestamp` varchar(14) default '19700101000000',
) ENGINE=InnoDB
**/
if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class RemoveWikiTask extends BatchTask {

    var $mType, $mVisible, $mData, $mParams, $mUploadDirectory;

	/**
	 * contructor
	 *
	 * @access public
	 * @author eloy
	 *
	 * @return RemoveWikiTask object
	 */
	public function  __construct() {
		$this->mType = "removewiki";
		$this->mVisible = true;
		parent::__construct();
	}

	/**
	 * execute
	 *
	 * Main entry point, TaskManagerExecutor run this method
	 *
	 * @access public
	 * @author eloy
	 *
	 * @param mixed $params default null: task params from wikia_tasks table
	 *
	 * @return boolean: status of operation, true = success, false = failure
	 */
	public function execute( $params = null ) {

		$this->mData = $params;
		echo "Hi! its ".__METHOD__."\n";
		$this->mParams = unserialize( $this->mData->task_arguments );

		#--- set task id for future use (logs, for example)
		$this->mTaskID = $this->mData->task_id;
		return true;
	}

    /**
     * @access public
     * @author eloy@wikia
     *
     * @param $title mixed - Title object
     * @param $data array default null - unserialized arguments for task
     *
     * @return string HTML form for task
     */
    public function getForm( $title, $data = null ) {
        global $wgOut;

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/CloseWikiTask/" );
        $oTmpl->set_vars( array(
            "data" => $data,
            "type" => $this->mType,
            "title" => $title,
        ));
        return $oTmpl->execute( "form" );
    }

    function getType() {
        return $this->mType;
    }

    function isVisible() {
        return $this->mVisible;
    }

    function submitForm() {
        global $wgRequest, $wgOut, $wgUser;

        #---
        # used fields
        # "task-c-wiki" - name of closed wiki
        # "task-export" - checkbox, export articles to parent
        # "task-p-wiki" - name of parent wiki
        $bExport = $wgRequest->getCheck( "task-export" );
        $sCWiki = self::normalizeName( $wgRequest->getText( "task-c-wiki" ));

        #--- check if closed wiki is valid
        $iCWikiId = self::checkWiki( $sCWiki );

        #--- check if parent wiki is valid
        $iPWikiId = self::checkWiki( $sPWiki );

        if (empty($iCWikiId) || (empty($iPWikiId) && $bExport === true) ) {
            $aFormData = array();
            $aFormData["errors"] = array();
            $aFormData["values"] = array(
                "task-export" => $bExport,
                "task-c-wiki" => $sCWiki,
                "task-p-wiki" => $sPWiki
            );

            if (empty( $iCWikiId )) {
                $aFormData["errors"]["task-c-wiki"] = "Name <em>{$sCWiki}</em> is not valid wikia domain.";
            }
            if (empty($iPWikiId) && $bExport === true) {
                $aFormData["errors"]["task-p-wiki"] = "Name <em>{$sPWiki}</em> is not valid wikia domain.";
            }
            return $aFormData;
        }
        else {
            #--- all correct, put data into database
            $this->mTaskID = $this->createTask(array(
                "export" => $bExport,
                "source_wikia_id" => $iCWikiId,
                "target_wikia_id" => $iPWikiId
            ));
            $wgOut->addHTML( Wikia::successbox("Task added") );

        }
        return true;
    }


    /**
     * dumpXML
     *
     * dump database as XML file
     *
     * @access private
     * @author eloy@wikia
     *
     * @return void
     */
    private function dumpXML() {
        global $wgWikiaLocalSettingsPath, $IP;

        $iWikiID = $this->mParams["source_wikia_id"];
        $sTaskDirectory = $this->getTaskDirectory();
        $sDumpFile = sprintf("%s/dump.xml.bz2", $sTaskDirectory );
        $sCommand = sprintf(
            "SERVER_ID=%d php %s/maintenance/dumpBackup.php --full --quiet --output=bzip2:%s --conf %s",
            $iWikiID,
            $IP,
            $sDumpFile,
            $wgWikiaLocalSettingsPath
        );
        return wfShellExec( $sCommand );
    }

    /**
     * dumpSQL
     *
     * dump database as SQL file
     *
     * @access private
     * @author eloy@wikia
     *
     * @return void
     */
    private function dumpSQL() {
        global $wgWikiaLocalSettingsPath;


        $iWikiID = $this->mParams["source_wikia_id"];
        $sDBName = WikiFactory::IDtoDB($iWikiID);
        $sTaskDirectory = $this->getTaskDirectory();
        $sDumpFile = sprintf("%s/dump.sql.bz2", $sTaskDirectory );

		/**
		 * get current slave database ip address
		 */
		$dbr = wfGetDB( DB_SLAVE );
        // wfShellExec( "SERVER_ID={$this->mTargetID} php $IP/maintenance/runJobs.php --conf {$wgWikiaLocalSettingsPath}" );
    }

    /**
     * packImages
     *
     * pack images to tar.gz file, remove then directory
     *
     * @access private
     * @author eloy@wikia
     *
     * @return void
     */
    private function packImages()
    {
        #--- get images directory;
        $this->mUploadDirectory = WikiFactory::getVarValueByName( "wgUploadDirectory", $this->mParams["source_wikia_id"] );

        $sTaskDirectory = $this->getTaskDirectory();
        $sImageFile = sprintf("%s/images.tar.gz", $sTaskDirectory );

        #--- check if $sImageFile is writable
        #--- check if $this->mUploadDirectory exists
        $sCommand = sprintf( "/bin/tar cfz %s %s", $sImageFile, $sTaskDirectory );
        wfShellExec( $sCommand );

        #--- tar cfz /tmp/images.tar.gz /images/sanfrancisco/images
    }
};
