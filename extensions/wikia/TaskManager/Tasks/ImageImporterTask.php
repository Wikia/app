<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Bartek Lapinski <bartek@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */


class ImageImporterTask extends BatchTask {

	public $mType, $mVisible, $mTargetID, $mGrabberID;

	/**
	 * __construct
	 *
	 * constructor
	 *
	 * @access public
	 */
	function __construct ()
	{
        $this->mType = 'imageimporter' ;
		$this->mVisible = true ;
		parent::__construct();

		#--- debugging
		$this->mDebug = true;
	}


	/**
	 * getPreviousTaskDirectory
	 *
	 * get proper folder for previous task
	 *
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @return mixed: path to directory or null if not defined
     */
	public function getPreviousTaskDirectory()
	{
        $oPreviousTask = BatchTask::newFromID( $this->mGrabberID );
        return $oPreviousTask->getTaskDirectory();
	}

    /**
     * checkImageDirectory
     *
     * check if target directory exists. if not create it. if not possible
     * signalize it. We have to have id of target wiki
     *
     * @access public
     * @author eloy@wikia
     *
     * @return boolean: status of operation
     */
    public function checkImageDirectory() {
        $mRetVal = false;
        if (empty( $this->mTargetID )) return $mRetVal;

        wfProfileIn( __METHOD__ );
        $UploadDirectory = WikiFactory::getVarValueByName( "wgUploadDirectory", $this->mTargetID );
        if ( file_exists( $UploadDirectory ) ) {
            if ( is_dir( $UploadDirectory ) ) {
                $this->addLog( "Target {$UploadDirectory} exists and is directory." );
                $mRetVal = true;
            }
            else {
                $this->addLog( "Target {$UploadDirectory} exists but is not directory" );
                $mRetVal = false;
            }
        }
        else {
            $mRetVal = wfMkdirParents($UploadDirectory);
        }

        wfProfileOut( __METHOD__ );
        return $mRetVal;
    }

	/**
	 * execute
	 *
     * get the directory from a finished ImageGrabber task,
     * then run the maintenance script called importImages.php with correct
	 * parameters
	 *
	 * @author bartek@wikia
	 * @author eloy@wikia
	 * @access public
	 *
	 * @param array $params: task params
     *
     * @return boolean: true if success, false otherwise
     */
	public function execute( $params = null )
    {
		global $IP, $wgWikiaLocalSettingsPath;
		$this->mTaskID = $params->task_id;
		$data = unserialize ($params->task_arguments);
		$this->mTargetID = $data ["target_wiki_id"];
		$this->mGrabberID = $data ["grabber_task_id"];

		$sTaskFolder = $this->getPreviousTaskDirectory();
        $this->checkImageDirectory();

        $this->addLog( "commencing importImages script, target wiki id: {$this->mTargetID}" );
		$extensions = "jpg jpeg png gif" ;
		$sCommand = "SERVER_ID={$this->mTargetID} php {$IP}/maintenance/importImages.php {$sTaskFolder} {$extensions} --conf {$wgWikiaLocalSettingsPath}";
		$sResult = wfShellExec( $sCommand, $retval ) ;
        $this->addLog( $sResult );

		if ($retval) {
			$this->addLog ("importImages script failed - returned value was: $retval") ;
			return false ;
		} else {
			$this->addLog ("importImages script executed successfully") ;
			return true ;
		}
	}

	function getForm ($title, $data = false ) {
		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/ImageImporterTask/" );

		/*	populate the list of the image grabber scripts
			and supply it to the form
		*/
		$dbr = wfGetDB( DB_MASTER );
		$dbr->selectDB( "wikicities" );
		$res = $dbr->select (
				"wikia_tasks",
				array ("task_id", "task_arguments") ,
				array(
					"task_type = 'imagegrabber'" ,
					"task_status > 2"
				     ),
				__METHOD__
				) ;

		while ( $row = $dbr->fetchObject( $res ) ) {
			$data ["options"][] = $row->task_id ;
		}

		$oTmpl->set_vars( array(
			"data" => $data ,
			"type" => $this->mType ,
			"title" => $title ,
			"desc" => wfMsg ("imageimportertask_add")
		));

		return $oTmpl->execute( "form" ) ;
	}

	function getType()
	{
		return $this->mType;
	}

	function isVisible()
	{
		return $this->mVisible;
	}

	function submitForm () {
		global $wgRequest, $wgOut, $IP, $wgUser ;

		#---
		# used fields
		# "task-target-wiki" - name of target wiki
		# "task-auto-import" - checkbox, automatically create an image import task after this one
		$grabberTask = $wgRequest->getVal ("task-grabber-list") ;
		$targetWiki = CloseWikiTask::normalizeName( $wgRequest->getText( "task-target-wiki" ));

        #--- check if closed wiki is valid
		$tWikiId = CloseWikiTask::checkWiki( $targetWiki );

		if ( empty($tWikiId) ) {
			$aFormData = array();
			$aFormData["errors"] = array();
			$aFormData["values"] = array(
				"task-grabber-list" => $grabberTask,
				"task-target-wiki" => $targetWiki
			);

			if ( empty($targetWiki) ) {
				$aFormData["errors"]["task-target-wiki"] = "Name <em>{$targetWiki}</em> is not valid wikia domain.";
			}
			return $aFormData;
		}
		else {
            $this->createTask( array(
				"grabber_task_id" => $grabberTask,
				"target_wiki_id" => $tWikiId
			));
			$wgOut->addHTML("<div class=\"successbox\" style=\"clear:both;\">Task added</div><hr style=\"clear: both;\"/>");
			return true ;
		}

	}
}
