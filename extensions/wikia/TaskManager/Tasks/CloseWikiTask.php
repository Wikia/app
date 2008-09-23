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

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$wgAutoloadClasses["WikiMover"] = $GLOBALS["IP"]."/extensions/wikia/WikiFactory/Mover/WikiMover.php";
$wgAutoloadClasses["Wikia"] = $GLOBALS["IP"]."/includes/wikia/Wikia.php";

class CloseWikiTask extends BatchTask {

    var $mType, $mVisible, $mData, $mParams, $mUploadDirectory;

    /**
     * contructor
     */
    function  __construct()
    {
        $this->mType = "closewiki";
        $this->mVisible = true;
        parent::__construct();
    }

    function execute( $params = null )
    {
        global $IP;

        $this->mData = $params;
        echo "Hi! its ".__METHOD__."\n";
        $this->mParams = unserialize( $this->mData->task_arguments );

        #--- set task id for future use (logs, for example)
        $this->mTaskID = $this->mData->task_id;

        if ( $this->mParams["export"] == 1 ) {
            $oWikiMover = WikiMover::newFromIDs( $this->mParams["source_wikia_id"], $this->mParams["target_wikia_id"] );
            $oWikiMover->load();
            $oWikiMover->move();
            #--- redirect to target database
            $oWikiMover->redirect();

            #--- get log from WikiMover and write into database
            foreach ( $oWikiMover->getLog( true ) as $log ) {
                $this->addLog( $log["info"], $log["timestamp"] );
            }
        }
        else {
            #--- redirect to notreal.wikia.com
			if ( !empty($this->mParams['source_wikia_id']) ) {
				WikiFactory::setPublicStatus(0, $this->mParams['source_wikia_id']);
			}
        }

        #--- dump database to xml
        $this->dumpXML();

        #--- dump database to sql
        //$this->dumpSQL();

        #--- close mailling list

        #--- pack images to tar.gz file
        $this->packImages();
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
    public function getForm( $title, $data = null )
    {
        global $wgOut;

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/CloseWikiTask/" );
        $oTmpl->set_vars( array(
            "data" => $data,
            "type" => $this->mType,
            "title" => $title,
        ));
        return $oTmpl->execute( "form" );
    }

    function getType()
    {
        return $this->mType;
    }

    function isVisible()
    {
        return $this->mVisible;
    }

    function submitForm()
    {
        global $wgRequest, $wgOut, $wgUser;

        #---
        # used fields
        # "task-c-wiki" - name of closed wiki
        # "task-export" - checkbox, export articles to parent
        # "task-p-wiki" - name of parent wiki
        $bExport = $wgRequest->getCheck( "task-export" );
        $sCWiki = self::normalizeName( $wgRequest->getText( "task-c-wiki" ));
        $sPWiki = self::normalizeName( $wgRequest->getText( "task-p-wiki" ));

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

    static function normalizeName( $name )
    {
        return Wikia::fixDomainName( $name );
    }

    /**
     * check if domain exist and is active
     * return false if doesn't exist
     * return 0 if exist but not active
     * return id if exists and active
     */
    static function checkWiki( $name )
    {

        $dbr = wfGetDB( DB_MASTER );
        $dbr->selectDB( "wikicities" );
        $oRow = $dbr->selectRow(
            array( "city_list", "city_domains" ),
            array( "city_public", "city_list.city_id"),
            array(
                "city_list.city_id = city_domains.city_id",
                "city_domain" => $name
            ),
            __METHOD__
        );

        if ( empty($oRow->city_id) ) {
            return false;
        }
        elseif ( $oRow->city_public != 1 ) {
            return 0;
        }
        else {
            return $oRow->city_id;
        }
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
    private function dumpXML()
    {
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
	}

	/**
	 * packImages
	 *
	 * pack images to tar.gz file, remove then directory
	 *
	 * @access private
	 * @author eloy@wikia
	 *
	 * @return boolean status of wfShellExec
	 */
	private function packImages() {
		#--- get images directory;
		$this->mUploadDirectory = WikiFactory::getVarValueByName( "wgUploadDirectory", $this->mParams["source_wikia_id"] );

		$sTaskDirectory = $this->getTaskDirectory();
		$sImageFile = sprintf("%s/images.tar.gz", $sTaskDirectory );

		#--- check if $sImageFile is writable
		#--- check if $this->mUploadDirectory exists
		$sCommand = sprintf( "/bin/tar cfz %s %s", $sImageFile, $sTaskDirectory );
		wfShellExec( $sCommand );
	}
};
