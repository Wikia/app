<?php

/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Inez Korczynski (inez@wikia.com)
 * @copyright (C) 2007, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */


class PageImporterTask extends BatchTask {
	var $mType, $mVisible ;

	/* constructor */
	function __construct ()
    {
        $this->mType = 'pageimporter' ;
		$this->mVisible = true ;
		parent::__construct () ;
	}

	/**
	 * execute
	 *
	 * Main entry point, TaskManagerExecutor run this method
	 *
	 * @access public
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @param mixed $params default null: task params from wikia_tasks table
	 *
	 * @return boolean: status of operation, true = success, false = failure
	 */
	function execute ($params = null)
    {
        global $wgWikiaLocalSettingsPath;

    	$this->mTaskID = $params->task_id;
        $this->mParams = $params;
		$task_arguments = unserialize($params->task_arguments);
		$this->mSourceTaskId = $task_arguments["source-task-id"];
		$this->mTargetWikiId = $task_arguments["target-wiki-id"];

        #--- get data for previous task
        $oPreviousTask = BatchTask::newFromID( $this->mSourceTaskId );
        if ( is_null($oPreviousTask) ) {
            $this->addLog( "Previous task nr {$this->mSourceTaskId} doesn't exist in database" );
            return false;
        }
        $sWorkDir = $oPreviousTask->getTaskDirectory();

        $this->addLog( "Opennig {$sWorkDir} directory" );

		$i = 0;
		while ( file_exists ( sprintf( "%s/%03d_dump.xml", $sWorkDir, $i ) ) ) {
			$phpFile = "php";
			$importDumpFile = $GLOBALS["IP"]."/maintenance/importDump.php";
			$command = sprintf(
                "SERVER_ID=%s %s %s --conf %s %s/%03d_dump.xml",
                $this->mTargetWikiId,
                $phpFile,
                $importDumpFile,
                $wgWikiaLocalSettingsPath,
                $sWorkDir,
                $i
            );

            $this->addLog( "Running: $command" );
			$out = wfShellExec( $command, $retval );
            $this->addLog( $out );
			$i++;
		}
        if ( empty($i) ) {
            $this->addLog( "Nothing was imported. There is no dump file to process" );
        }
		return true;
	}

    /**
     * getForm
     *
     * Tasks with forms execute this method to get HTML code for form
     *
     * @author Inez Korczynski (inez@wikia.com)
     * @author eloy@wikia
     * @access public
     *
     * @param object $title: instance of Title class
     * @param mixed $data: data already sent by form for resubmitting
     *
     * @return string: HTML code for form
     */
	public function getForm ($title, $data = false ) {
		global $wgOut;

		$dbr = wfGetDB(DB_MASTER);
		$oRes = $dbr->select(
				wfSharedTable( "wikia_tasks" ),
				array( "task_id","task_arguments" ),
				array( "task_type" => "pagegrabberdump", "task_status" => 3 ),
				__METHOD__,
				array( "ORDER BY" => "task_id DESC", "LIMIT" => 50 )
		);

		$aGrabbers = array();

		while( $oRow = $dbr->fetchObject( $oRes )) {
			$args = unserialize($oRow->task_arguments);
			$oRes2 = $dbr->select(
					wfSharedTable( "wikia_tasks" ),
					array("task_arguments"),
					array("task_id" => $args["source-task-id"]),
					__METHOD__
			);
			$oRow2 = $dbr->fetchObject( $oRes2 );
			$args2 = unserialize($oRow2->task_arguments);

			$aGrabbers[] = array(
				"id" => $oRow->task_id,
				"title" => "#{$oRow->task_id} - {$args2['source-wiki-url']}"
			);
		}



        if($oRes) $dbr->freeResult( $oRes );
	if($oRes2) $dbr->freeResult( $oRes2 );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/PageImporterTask/" );
		$oTmpl->set_vars( array(
            "data" => $data ,
            "type" => $this->mType ,
            "title" => $title,
            "grabbers" => $aGrabbers
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

    /**
     * submitForm()
     *
     * Tasks with forms execute this method to put params from form to database
     *
     * @author eloy@wikia
     * @access public
     *
     * @return mixed: true if success, submitted params if error
     */
	function submitForm()
    {
		global $wgRequest, $wgOut;

		$iTaskID = $wgRequest->getVal("task-source-task-id");
		$sTargetWiki = $wgRequest->getVal("task-target-wiki");
        $sTargetWikiID = WikiFactory::DomainToID($sTargetWiki);

		if( !is_numeric( $iTaskID ) || !is_numeric( $sTargetWikiID ) || is_null( $sTargetWikiID ) ) {
			$aFormData = array();
			$aFormData["values"] = array(
                "task-source-task-id" => $taskId,
                "task-target-wiki" => $sTargetWiki
            );

			if(!is_numeric($taskId)) {
				$aFormData["errors"]["task-source-task-id"] = "This field must not be empty and must be integer.";
			}
			if(!is_numeric( $sTargetWikiID ) || is_null( $sTargetWikiID ) ) {
				$aFormData["errors"]["task-target-wiki"] = "This field must not be empty. Domain must be wiki.factory domain.";
			}
			return $aFormData;
		}
        else {
			$this->createTask(
                array(
                	"source-task-id" => $iTaskID,
                	"target-wiki-id" => $sTargetWikiID
                )
            );
			$wgOut->addHTML( Wikia::successbox( "Task added" ));
			return true;
		}
	}
}
