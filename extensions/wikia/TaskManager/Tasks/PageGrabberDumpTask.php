<?php
/**
 * @package MediaWiki
 * @subpackage BatchTask
 * @author Inez Korczynski (inez@wikia.com)
 * @copyright (C) 2007, Wikia Inc.
 * @license GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

class PageGrabberDumpTask extends BatchTask {
    
	public $mSourceWikiUrl, $mErrors, $mParams, $mPrevWorkDir, $mWorkDir, $mPrevTaskId ;

	/* constructor */
	function __construct () {
		$this->mType = 'pagegrabberdump';
		$this->mVisible = true;
		parent::__construct();
		$this->mDebug = true;
	}

	/**
	 * exportPageList
	 *
	 * dump pages to xml files
	 *
	 * @access public
	 * @author Inez Korczynski (inez@wikia.com)
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @return boolean: status of operation; true if success, false otherwise
	 */
	function exportPageList() {
		$pages = array_map( 'trim', file( $this->mPrevWorkDir . "/pages.txt" ) );
		$batches = array_chunk( $pages, 100 );

		foreach ( $batches as $batchID => $batch ) {
			$sUrl = $this->mSourceWikiUrl . "?title=Special:Export";
			$this->addLog( "Init curl with {$sUrl}");
			$curl = curl_init( $sUrl );
			$postData = 'action=submit&pages=';

			foreach ( $batch as $page ) {
				$postData .= urlencode( $page . "\n" );
			}
			
			$this->addLog("Getting {$sUrl} with {$postData}");
			curl_setopt( $curl, CURLOPT_POSTFIELDS, $postData );
			$fileName = sprintf( "%s/%03d_dump.xml", $this->mWorkDir, $batchID );
			$file = fopen( $fileName, 'w' );
			curl_setopt( $curl, CURLOPT_FILE, $file );
			curl_exec( $curl );
			fclose( $file );
		}
		return true;
	}

	/**
	 * execute
	 *
	 * main entry point
	 *
	 * @author Inez Korczynski (inez@wikia.com)
	 * @access publiic
	 *
	 * @param array $params: task params
	 *
	 * @return boolean: true if success, false otherwise
	 */
	function execute ($params = null) {
		$aArgs = unserialize($params->task_arguments);
		$this->mTaskID = $params->task_id;
		$this->mSourceTaskId = $aArgs["source-task-id"];

		$dbr = wfGetDB(DB_MASTER);
		$oRes = $dbr->select(
				wfSharedTable("wikia_tasks"),
				array("task_arguments"),
				array("task_id" => $this->mSourceTaskId),
				__METHOD__
		);
		$oRow = $dbr->fetchObject($oRes);
		$aArgsSource = unserialize($oRow->task_arguments);
		$this->mSourceUrl = $aArgsSource["source-wiki-url"];

		$oPreviousTask = BatchTask::newFromID($this->mSourceTaskId);
		$this->mPrevWorkDir = $oPreviousTask->getTaskDirectory();
		$this->addLog("Opening previous task directory {$this->mWorkDir}");
		
		$this->mWorkDir = $this->getTaskDirectory();
		$this->mSourceWikiUrl = $this->mSourceUrl;
		if($this->exportPageList()) {
			return true;
		}
		return false;
	}

	/**
	 * @author Inez Korczynski (inez@wikia.com)
	 */
	function getForm ($title, $data = false ) {
		global $wgOut;

		$dbr = wfGetDB(DB_MASTER);
		$oRes = $dbr->select(
				wfSharedTable("wikia_tasks"),
				array("task_id","task_arguments"),
				array("task_type" => "pagegrabber", "task_status" => 3),
				__METHOD__,
				array( "ORDER BY" => "task_id DESC", "LIMIT" => 50 )
		);

		$pageGrabbers = array();

		while($oRow = $dbr->fetchObject($oRes)) {
			if(isset($oRow->task_arguments)) {
				$task_arguments = unserialize($oRow->task_arguments);
				if(isset($task_arguments["source-wiki-url"])) {
					$pageGrabbers[] = array("id" => $oRow->task_id, "title" => "#".$oRow->task_id." - ".$task_arguments["source-wiki-url"]);
				}
			}
		}
				
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/PageGrabberDumpTask/" );
		$oTmpl->set_vars( array(
			"pageGrabbers" => $pageGrabbers,
			"data" => $data,
			"type" => $this->mType,
			"title" => $title
		));
		return $oTmpl->execute( "form" ) ;
	}

	function getType() {
		return $this->mType;
	}

	function isVisible() {
		return $this->mVisible;
	}

	/**
	 * submitForm
	 *
	 * write task parameters to database or return to form if errors
	 *
	 * @access public
	 * @author Inez Korczynski (inez@wikia.com)
	 * @author bartek@wikia
	 * @author eloy@wikia
	 *
	 * @return boolean: status of operation; true if success, false otherwise
	 */
	function submitForm () {
		global $wgRequest, $wgOut;

		$taskId = $wgRequest->getVal("task-source-task-id");

		if(!is_numeric($taskId)) {
			$aFormData["values"]["task-source-task-id"] = $taskId;
			$aFormData["errors"]["task-source-task-id"] = "No task selected";
			return $aFormData;
		} else {
			$this->createTask(
				array(
					"source-task-id" => $taskId,
				)
			);
			$wgOut->addHTML("<div class=\"successbox\" style=\"clear:both;\">Task added</div><hr style=\"clear: both;\"/>");
			return true ;
		}
	}
}
