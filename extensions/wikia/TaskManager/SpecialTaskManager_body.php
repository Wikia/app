<?php

/**
 * @package MediaWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2007-2009, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n";
	exit( 1 ) ;
}


/**
 * @addtogroup SpecialPage
 */
class TaskManagerPage extends SpecialPage {

	public $mTitle, $mAction, $mTasks, $mLoadPager;

	/**
	 * contructor
	 */
	public function  __construct() {
		#--- we use 'createwiki' restriction
		parent::__construct( "TaskManager"  /*class*/, 'taskmanager' /*restriction*/ );
		$this->mTasks = array();
		$this->mLoadPager = true;
	}

	/**
	 * execute
	 *
	 * main entry point
	 * @author eloy@wikia.com
	 *
	 * @param string $subpage: subpage of Title
	 *
	 * @return nothing
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest, $wgWikiaBatchTasks;

		$this->setHeaders();
		// SUS-288: Check permissions before checking for block
		$this->checkPermissions();
		$this->checkReadOnly();
		$this->checkIfUserIsBlocked();

		$wgOut->setPageTitle( wfMsg('taskmanager_title') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$this->mTitle = Title::makeTitle( NS_SPECIAL, "TaskManager" );

		$this->mAction= $wgRequest->getVal( "action" );
		if ( $this->mAction ) {
			switch ($this->mAction) {
				case "task":
					#--- get task type and class
					$sClass = $wgRequest->getText("wpType", null);
					if ( is_subclass_of( $sClass, "BatchTask" )) {
						$oObject = new $sClass();
						#--- get form for this class
						$wgOut->addHTML( $oObject->getForm( $this->mTitle ));
					}
					$wgOut->addHTML(Xml::element("a", array( "href"=>
						$this->mTitle->getLocalUrl(),
						wfMsg("taskmanager_tasklist")
					)));

					break;

				case "save":
					#--- get task type and class
					$sType = $wgRequest->getText("wpType", null);
					$sClass = $wgWikiaBatchTasks[$sType];
					if ( is_subclass_of( $sClass, "BatchTask" )) {
						$oObject = new $sClass();
						$aFormData = $oObject->submitForm();

						if ( $aFormData === true ) {
							#--- all correct, show new task form
							$this->loadTaskForm();
						}
						else {
							#--- errors, show again form for choosen task
							$wgOut->addHTML( $oObject->getForm( $this->mTitle, $aFormData ));
						}
					}
					$wgOut->addHTML(Wikia::linkTag(
						$this->mTitle->getLocalUrl(),
						wfMsg("taskmanager_tasklist")
					));
					break;

				/**
				 * get task form for given id, NOTE - it should check if
				 * task is editable or not
				 */
				case "edit":
					$oTask = $this->loadTaskData( $wgRequest->getVal("id") );
					#--- nothing so far
					break;

				/**
				 * remove task from database, carefull - without confirmation
				 * so far
				 */
				case "remove":
					#--- check if task exists
					$oTask = $this->loadTaskData( $wgRequest->getVal("id") );

					if (!empty( $oTask->task_id )) {
						$this->removeTask( $oTask->task_id );
						$wgOut->addHTML(Wikia::successbox("Task nr {$oTask->task_id} removed"));
					}
					else {
						$wgOut->addHTML(Wikia::errorbox("Task doesn't exists"));
					}
					$this->loadTaskForm();
					$this->loadPager();
					break;

				/**
				 * start task, possible only when task in TASK_WAITING state
				 */
				 case "start":
					#--- check if task exists
					$oTask = $this->loadTaskData( $wgRequest->getVal("id") );
					if (!empty( $oTask->task_id ) && $oTask->task_status == TASK_WAITING ) {
						$this->changeTaskStatus( $oTask->task_id, TASK_QUEUED );
						$wgOut->addHTML( Wikia::successbox("Task nr {$oTask->task_id} queued") );
					}
					else {
						$wgOut->addHTML( Wikia::errorbox("Task doesn't exists") );
					}
					$this->loadTaskForm();
					$this->loadPager();
					break;

				/**
				 * stop task, possible only when task in TASK_QUEUED state
				 */
				case "stop":
					#--- check if task exists
					$oTask = $this->loadTaskData( $wgRequest->getVal("id") );
					if (!empty( $oTask->task_id ) && $oTask->task_status == TASK_QUEUED ) {
						$this->changeTaskStatus( $oTask->task_id, TASK_WAITING );
						$wgOut->addHTML( Wikia::successbox("Task nr {$oTask->task_id} paused") );
					}
					else {
						$wgOut->addHTML( Wikia::errorbox("Task doesn't exists") );
					}
					$this->loadTaskForm();
					$this->loadPager();
					break;

				/**
				 * terminate running task
				 */
				case "finish":
					$oTaskData = $this->loadTaskData( $wgRequest->getVal("id") );
					if (!empty( $oTaskData->task_id )) {
						$oTask  = BatchTask::newFromData( $oTaskData );
						$oTask->closeTask();
						$wgOut->addHTML( Wikia::successbox("Task nr {$oTaskData->task_id} stopped") );
					}
					else {
						$wgOut->addHTML( Wikia::errorbox("Task doesn't exists") );
					}
					$this->loadTaskForm();
					$this->loadPager();
					break;

				/**
				 * show log for closed task
				 */
				case "log":
					#--- check if task exists
					$oTaskData = $this->loadTaskData( $wgRequest->getVal("id") );
					if (!empty( $oTaskData->task_id )) {
						$oTask  = BatchTask::newFromData( $oTaskData );
						$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
						$oTmpl->set_vars( array(
							"events" => $oTask->getLog( true /*wantarray*/ )
						));
						$wgOut->addHTML( $oTmpl->render( "log" ) );
					}
					$this->loadTaskForm();
					$this->loadPager();
					break;

				/**
				 * default action, just show task form
				 */
				default:
					$this->loadTaskForm();
					break;
			}
		}
		else {
			$this->loadTaskForm();
			$this->loadPager();
		}
	}

	/**
	 * load task data from database
	 *
	 * @access private
	 *
	 * @param integer $id task id in database
	 *
	 * @return mixed	row from database or null if no data
	 */
	private function loadTaskData( $id ) {
		global $wgExternalSharedDB;
		$fname = __METHOD__;
		wfProfileIn( $fname );
		$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$oRow = $dbr->selectRow( "wikia_tasks", "*", array( "task_id" => $id ), $fname );
		wfProfileOut( $fname );
		return $oRow;
	}

	/**
	 * remove task from database
	 *
	 * @access private
	 *
	 * @param integer $id task id in database
	 *
	 * @return boolean status of operation
	 */
	private function removeTask( $id ) {
		global $wgExternalSharedDB;
		$fname = __METHOD__;
		wfProfileIn( $fname );
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$status = $dbw->delete( "wikia_tasks", array( "task_id" => $id ), $fname );
		$dbw->commit();
		wfProfileOut( $fname );
		return $status;
	}

	/**
	 * change in database status of task
	 *
	 * @access private
	 *
	 * @param integer $id  task id in database
	 * @param integer $status new status for task
	 *
	 * @return boolean  status of operation
	 */
	private function changeTaskStatus( $id, $status ) {
		global $wgExternalSharedDB;
		$fname = __METHOD__;
		wfProfileIn( $fname );
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$sth = $dbw->update( "wikia_tasks", array( "task_status" => $status ), array( "task_id" => $id ), $fname );
		wfProfileOut( $fname );
		return $sth;
	}

	/**
	 * generate and display HTML form for task
	 *
	 * @access private
	 *
	 * @return nothing
     */
	private function loadTaskForm() {
		global $wgUser;
		if( !$wgUser->isAllowed('taskmanager-action') ) {
			return;
		}

		global $wgOut, $wgWikiaBatchTasks;

		/**
		 * first check which task types should be visible
		 */
		$aTypes = array();
		if( is_array( $wgWikiaBatchTasks )) {
			foreach( $wgWikiaBatchTasks as $type => $class ) {
				$oObject = new $class;
				if( $oObject->isVisible() === true ) {
					$aTypes[$type] = $class;
				}
			}
		}
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"types" => $aTypes,
			"title" => $this->mTitle
		));
		$wgOut->addHTML( $oTmpl->render( "taskform" ) );
	}

	/**
	 * generate and display pager with tasks list
	 *
	 * @access private
	 */
	private function loadPager() {
		global $wgOut;

		/**
		 * init pager
		 */
		$oPager = new TaskManagerPager;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"limit"     => $oPager->getForm(),
			"body"      => $oPager->getBody(),
			"nav"       => $oPager->getNavigationBar()
		));
		$wgOut->addHTML( $oTmpl->render("pager") );
	}
}

class TaskManagerPager extends TablePager {
	var $mFieldNames = null;
	var $mMessages = array();
	var $mQueryConds = array();
	var $mTitle;

	/**
	 * constructor
	 */
	function __construct() {
		global $wgExternalSharedDB;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "TaskManager" );
		$this->mDefaultDirection = true;
		parent::__construct();
		$this->mDb = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
	}

	/**
	 * getFieldNames
	 *
	 * @access public
	 */
	function getFieldNames() {
		if ( !$this->mFieldNames ) {
			$this->mFieldNames = array();
			$this->mFieldNames["task_id"] = "#";
			$this->mFieldNames["task_type"] = "Type";
			$this->mFieldNames["task_status"] = "Status";
			$this->mFieldNames["task_added"] = "Added";
			$this->mFieldNames["task_user_id"] = "User";
			$this->mFieldNames["task_started"] = "Started";
			$this->mFieldNames["task_finished"] = "Finished";
			$this->mFieldNames["task_actions"] = "Actions";
		}

		return $this->mFieldNames;
	}

	/**
	 * isFieldSortable
	 *
	 * @param string $field  field name
	 *
	 * @return boolean  if $field is sortable or not
	 */
	function isFieldSortable( $field ) {
		static $sortable = array( "task_type", "task_id", "task_user_id", "task_status", "task_added" );
		return in_array( $field, $sortable );
	}

	/**
	 * formatValue
	 *
	 * @param string $field  field name
	 * @param mixed  $value  value of field
	 *
	 * @return string  HTML code for row
	 */
	function formatValue( $field, $value ) {
		global $wgRequest;

		switch ($field) {
			case "task_status":
				$taskId = $this->mCurrentRow->task_id;
				$name   = BatchTask::getStatusName( $value );
				$offset = $wgRequest->getVal( "offset", 0 );
				$return = sprintf( "<a href=\"%s\">%s</a>",
					$this->mTitle->getLocalUrl( "action=log&id={$taskId}&offset={$offset}"),
					$name
				);

			case "task_actions":
				$iTaskID = $this->mCurrentRow->task_id;
				$iTaskStatus = $this->mCurrentRow->task_status;
				$sRetval = "";

				global $wgUser;
				if( !$wgUser->isAllowed('taskmanager-action') ) {
					return "";
				}
				$offset = $wgRequest->getVal( "offset", "" );
				if( $offset !== "" ) {
					$offset = "&offset={$offset}";
				}

				switch ( $iTaskStatus ) {
					case TASK_WAITING:
						$sRetval .= sprintf(
							"<a href=\"%s\">
								<img src=\"/skins/common/images/media-playback-start.png\" title=\"Start\" />
							</a>",
							$this->mTitle->getLocalUrl( "action=start&id={$iTaskID}{$offset}" ));
						break;

					case TASK_STARTED:
						$sRetval .= sprintf(
						"<a href=\"%s\">
							<img src=\"/skins/common/images/media-playback-stop.png\" title=\"Stop\" />
						</a>",
						$this->mTitle->getLocalUrl( "action=finish&id={$iTaskID}{$offset}" ));
						break;

					case TASK_QUEUED:
						$sRetval .= sprintf(
						"<a href=\"%s\">
							<img src=\"/skins/common/images/media-playback-pause.png\" title=\"Stop\" />
						</a>",
						$this->mTitle->getLocalUrl( "action=stop&id={$iTaskID}{$offset}"));
						break;

					case TASK_FINISHED_SUCCESS:
						break;

					case TASK_FINISHED_ERROR:
						break;

					case TASK_FINISHED_UNDO:
						break;
				}
				$sRetval .= sprintf(
					"<a href=\"%s\">
						<img src=\"/skins/common/images/process-stop.png\" title=\"Remove\" />
					</a>",
					$this->mTitle->getLocalUrl( "action=remove&id={$iTaskID}{$offset}")
				);
				return $sRetval;
				break;

			case "task_added":
			case "task_started":
			case "task_finished":
				if (empty($value)) {
					return "<em>not yet</em>";
				}
				else {
					return wfTimestamp( TS_EXIF, $value );
				}
				break;

			case "task_type":
				$Task = BatchTask::newFromID( $this->mCurrentRow->task_id );
				if( is_null( $Task ) ) {
					$description = Xml::element( "span", null, "Unknown type" );
				}
				else {
					$description = "<span>". $Task->getDescription( ) . "</span>";
				}
				return $description;
			break;


			case "task_user_id":
				if( $value ) {
					$oUser = User::newFromId( $value );
					$label = sprintf("<a href=\"%s\">%s</a>", $oUser->getUserPage()->getLocalUrl(), $oUser->getName());
				}
				else {
					$label = "<b>Anonymous</b>";
				}
				return $label;
				break;

			default:
				return $value;
		}
	}

	/**
	 * formatRow
	 *
	 * more fancy FormatRow method
	 *
	 * @param object $row: database row class
	 */
	function formatRow( $row ) {
		$s = "<tr>\n";
		$fieldNames = $this->getFieldNames();
		$this->mCurrentRow = $row;  # In case formatValue needs to know
		foreach( $fieldNames as $field => $name ) {
			$value = isset( $row->$field ) ? $row->$field : null;
			$formatted = strval( $this->formatValue( $field, $value ) );
			if( $formatted == '' ) {
				$formatted = '&nbsp;';
			}
			$class = 'tablepager-col-' . htmlspecialchars( $row->task_status );
			$style = in_array($field, array("task_type", "task_status"))
				? "text-align: left"
				: "";
			$s .= "<td class=\"{$class}\" style=\"{$style}\">{$formatted}</td>\n";
		}
		$s .= "</tr>\n";
		return $s;
	}

	/**
	 * getDefaultSort
	 *
	 * @access public
	 *
	 * @return string: name of table using in sorting
	 */
	public function getDefaultSort() {
		return "task_id";
	}

	#--- getQueryInfo -------------------------------------------------------
	function getQueryInfo() {

		/**
		 * get filters from session
		 */
		return array(
			"tables" => "wikia_tasks",
			"fields" => array("*"),
			"conds" => $this->mQueryConds
		);
	}

	#--- getForm() -------------------------------------------------------
	function getForm() {
		global $wgWikiaBatchTasks, $wgRequest;

		$aSorting = array();
		$iStatus = $wgRequest->getVal( "wpStatus" );
		$sType = $wgRequest->getArray( "wpType" );

		#--- get data from session
		if (!empty($_SESSION["taskmanager.filters"])) {
			$aSorting = $_SESSION["taskmanager.filters"];
		}

		if (!is_null($iStatus)) {
			if ( $iStatus != -1 ) {
				$aSorting["task_status"] = $iStatus;
			}
			else {
				unset($aSorting["task_status"]);
			}
		}

		if (!is_null($sType) || $wgRequest->wasPosted()) {
			if ( count($sType) != 0 ) {
				$aSorting["task_type"] = $sType;
			}
			else {
				unset($aSorting["task_type"]);
			}
		}

		$this->mQueryConds = $aSorting;
		$_SESSION["taskmanager.filters"] = $aSorting;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title" => $this->mTitle,
			"types" => $wgWikiaBatchTasks,
			"current" => $this->mQueryConds,
			"statuses" => BatchTask::getStatuses(),
		));
		return $oTmpl->render( "form" );
	}
}
