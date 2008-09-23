<?php

/**
 * @package MediaWiki
 * @subpackage SpecialTaskManager
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

#--- base class for BatchTask
require_once( dirname(__FILE__) . "/BatchTask.php" );


class TaskManagerExecutor {

	const LOGFILE = "/tmp/taskmanager.log";
	const DEBUG = true;
	public $mTasksClasses, $mTaskData;
	private $mAlarmMails = array( "eloy@wikia-inc.com", "ops@wikia-inc.com" );

    /**
     * __construct
     *
     * @return TaskManagerExecutor object
     */
    public function  __construct() {
        global $wgWikiaBatchTasks, $wgDebugLogGroups;
        if( self::DEBUG === true ) {
            $wgDebugLogGroups["taskmanager"] = self::LOGFILE;
        }
        else {
            if( isset($wgDebugLogGroups["taskmanager"]) ) {
                unset($wgDebugLogGroups["taskmanager"]);
            }
        }
        $this->mTasksClasses = $wgWikiaBatchTasks;
    }

    /**
     * execute
     *
     * main entry point, task executor run this method
     *
     * @access public
     * @author eloy
     *
     * @return nothin
     */
    public function execute()
    {
        #--- get task from queue
        echo "started ".wfTimestampNow()."\n";

        $oTask = $this->getTask();
        if ( !empty( $this->mTaskData->task_id )) {
            $oTask->addlog("task started:".wfTimestampNow());
            $this->lockTask( $this->mTaskData->task_id );

            #--- execute should return true when success or false when error
            $bStatus = $oTask->execute( $this->mTaskData );
            $this->unlockTask( $this->mTaskData->task_id, $bStatus );
            $oTask->addlog("task finished:".wfTimestampNow());
        }
        else {
            echo "Queue is empty! Great success!\n";
        }
    }

	/**
	 * lockTask
	 *
	 * mark task as running
	 *
	 * @access private
	 * @author eloy@wikia-inc.com
	 *
	 * @param integer $taskid: task identifier from wikia_tasks table
	 *
	 * @return boolean: status of operation
	 */
	private function lockTask( $taskid ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$dbw->update(
			wfSharedTable("wikia_tasks"),
			array(
				"task_status" => TASK_STARTED,
				"task_started" => wfTimestampNow()
			),
			array( "task_id" => $taskid ),
			__METHOD__
		);
		return $dbw->commit();
	}

	/**
	 * unlockTask
	 *
	 * mark task as finished,
	 *
	 * @access private
	 * @author eloy@wikia-inc.com
	 *
	 * @param integer $taskid: task identifier from wikia_tasks table
	 * @param boolean $status: status of operation
	 *
	 * @return boolean: status of operation
	 */
	private function unlockTask( $taskid, $status ) {
		$iStatus = ( $status === true ) ? TASK_FINISHED_SUCCESS : TASK_FINISHED_ERROR;
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		try {
			$dbw->update(
				wfSharedTable("wikia_tasks"),
				array(
					"task_status" => $iStatus,
					"task_finished" => wfTimestampNow()
				),
				array( "task_id" => $taskid ),
				__METHOD__
			);
			$dbw->commit();
		}
		catch (DBConnectionError $e) {
			wfDebugLog( "taskmanager", "Connection error: " . $e->getMessage(), true );
		} catch (DBQueryError $e) {
			wfDebugLog( "taskmanager", "Query error: " . $e->getMessage(), true );
		} catch (DBError $e) {
			wfDebugLog( "taskmanager", "Database error: " . $e->getMessage(), true );
		}
	}

	/**
	 * getTask
	 *
	 * get first task from the queue, skip types which are currently run
	 * return task class or false is class is uknown
	 *
	 * @access private
	 * @author eloy@wikia-inc.com
	 *
	 * @return boolean: status of operation
	 */
	private function getTask() {
		global $wgDebugLogGroups;

		$aStarted = array();
		$aRunning = array();
		$dbr = wfGetDB( DB_MASTER );

		$dbr->begin();
		try {
			#--- first check if any task have state TASK_STARTED
			$oRes = $dbr->select(
			array( wfSharedTable("wikia_tasks") ),
				array( "*" ),
				array( "task_status" => TASK_STARTED),
				__METHOD__
			);

			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				$aStarted[] = $dbr->addQuotes( $oRow->task_type );
				$aRunning[] = $oRow->task_id;
				echo "Task in progress: id={$oRow->task_id} type={$oRow->task_type}\n";
			}
			$dbr->freeResult( $oRes );

			if( count($aStarted) ) {
				$sCondition = implode(",", $aStarted );
				$aCondition = array( "task_type NOT IN ({$sCondition})" );
			}
			else {
				$aCondition = null;
			}
			$aCondition["task_status"] = TASK_QUEUED;

			#--- then get first from top sorted by priority and timestamp
			$oTask = $dbr->selectRow(
			array( wfSharedTable("wikia_tasks") ),
				array( "*" ),
				$aCondition,
				__METHOD__,
				array( "ORDER BY" => "task_priority, task_added")
			);
			$dbr->commit();
		}
		catch (DBConnectionError $e) {
			wfDebugLog( "taskmanager", "Connection error: " . $e->getMessage(), true );
		} catch (DBQueryError $e) {
			wfDebugLog( "taskmanager", "Query error: " . $e->getMessage(), true );
		} catch (DBError $e) {
			wfDebugLog( "taskmanager", "Database error: " . $e->getMessage(), true );
		}

		/**
		 * check TTL of tasks, close if needed
		 */
		if( count( $aRunning ) ) {
			$this->checkTTL( $aRunning );
		}

		/**
		 * eventually run task from queue
		 */
		if( isset( $oTask->task_type ) ) {
			if( isset($this->mTasksClasses[ $oTask->task_type ]) ) {
				$this->mTaskData = $oTask;
				$oClass = new $this->mTasksClasses[$oTask->task_type];
				return $oClass;
			}
		}
		return false;
	}

	/**
	 * checkTTL
	 *
	 * check grace period time for task type i.e. how long task can live
	 * if time to live is longer that TTL value finish it with ERROR status
	 *
	 * @access public
	 * @author eloy@wikia-inc.com
	 *
	 * @param array $ids: identifiers of running tasks
	 *
	 * @return nothing
	 */
	public function checkTTL( $ids ) {
		if( is_array( $ids ) ) {
			foreach( $ids as $taskid ) {
				$oTask = BatchTask::newFromID( $taskid );
				print_r( $oTask );
				if( ! empty( $oTask->getData()->task_started ) ) {
					$ttl = $oTask->getTTL();
					$run =  wfTimestamp(TS_UNIX, $oTask->getData()->task_started);
					$now = wfTimestamp();
					if( ( $now - $run ) > $ttl ) {
						#--- kill him!
						$oTask->addLog( "TTL exceeded. Finished by task manager" );
						$oTask->closeTask( false );
						/**
						 * alarm mail to ops
						 */
						$this->alarmMail( $oTask );
					}
					else {
						wfDebugLog(
							"taskmanager",
							sprintf(
								"Task %d (%s) live %ds, need %ds to kill.",
								$oTask->getData()->task_id,
								$oTask->getData()->task_type,
								($now-$run),
								$ttl
							),
							true
						);
					}
				}
				else {
					wfDebugLog( "taskmanager", "strange error happen, in running task starting time is empty", true );
				}
			}
		}
	}

	/**
	 * alarmMail
	 *
	 * send email when task is finished because TTl expiration
	 *
	 * @access private
	 * @author eloy@wikia-inc.com
	 *
	 * @param array $ids: identifiers of running tasks
	 *
	 * @return nothing
	 */
	private function alarmMail( $task ) {
		$Template = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$Template->set_vars( array( "task" => $task ));
		$alarm = $Template->execute( "alarm" );
		$to = array();

		foreach( $this->mAlarmMails as $email ) {
			$to[] = new MailAddress( $email );
		}
		return UserMailer::send( $to, new MailAddress("nobody@wikia.com"), "[TASKMANAGER] Task Manager stucked.", $alarm );
	}
};
