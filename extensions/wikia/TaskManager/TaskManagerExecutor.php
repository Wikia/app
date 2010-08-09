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

	const DEBUG = true;
	const LIMIT = 50; /* how many tasks at once */

	public $mTasksClasses, $mTaskData;
	private $mAlarmMails = array( "eloy@wikia-inc.com", "ops@wikia-inc.com" );

    /**
     * __construct
     *
     * @return TaskManagerExecutor object
     */
    public function  __construct() {
        global $wgWikiaBatchTasks;
        $this->mTasksClasses = $wgWikiaBatchTasks;
    }

    /**
     * get task from queue and execute
     *
     * main entry point, task executor run this method
     *
     * @access public
     * @author eloy
     *
     * @return nothin
     */
    public function execute() {

		if( wfReadOnly() ) {
			$this->log( "Database is in read-only mode" );
		}
		else {
			$this->log( "Task Manager started" );
			foreach( range(1, self::LIMIT ) as $taskNumber ) {
				$taskClass = $this->getTask();
				if( $taskClass instanceof BatchTask ) {
					/**
					 * lock task
					 */
					$taskId = $this->mTaskData->task_id;
					$this->lockTask( $taskId );
					$taskClass->setId( $taskId );

					/**
					 * execute task
					 */
					$taskClass->addlog(sprintf( "task started: %s", wfTimestamp( TS_DB, time() ) ) );
					$status = $taskClass->execute( $this->mTaskData );
					$taskClass->addlog(sprintf( "task finished: %s", wfTimestamp( TS_DB, time() ) ) );

					/**
					 * unlock task
					 */
					$this->unlockTask( $taskId, $status );
					$this->log( sprintf( "batch(%d) finished task id=%d; type=%s", $taskNumber, $taskId, $taskClass->getType() ) );
				}
				else {
					$this->log( sprintf( "batch(%d) queue is empty", $taskNumber ) );
				}
			}
			$this->log( "Task Manager finished" );
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
		global $wgExternalSharedDB;
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->begin();
		$dbw->update(
			"wikia_tasks",
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
		global $wgExternalSharedDB;
		$iStatus = ( $status === true ) ? TASK_FINISHED_SUCCESS : TASK_FINISHED_ERROR;
		$dbw = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
		$dbw->begin();
		try {
			$dbw->update(
				"wikia_tasks",
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
		global $wgExternalSharedDB;
		$aStarted = array();
		$aRunning = array();
		$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );

		try {
			#--- first check if any task have state TASK_STARTED
			$oRes = $dbr->select(
			array( "wikia_tasks" ),
				array( "*" ),
				array( 
					"task_status" => TASK_STARTED,
					"task_type" => !empty($this->mTasksClasses) ? array_keys($this->mTasksClasses) : ''
				),
				__METHOD__
			);

			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				$aStarted[] = $dbr->addQuotes( $oRow->task_type );
				$aRunning[] = $oRow->task_id;
				$this->log( "Task in progress: id={$oRow->task_id} type={$oRow->task_type}" );
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
			$aCondition["task_type"] = !empty($this->mTasksClasses) ? array_keys($this->mTasksClasses) : '';

			/**
			 * then get first from top sorted by priority and timestamp
			 */
			$oTask = $dbr->selectRow( "wikia_tasks", "*", $aCondition, __METHOD__, array( "ORDER BY" => "task_id") );
		}
		catch( DBConnectionError $e ) {
			$this->log( "Connection error: " . $e->getMessage() );
		}
		catch( DBQueryError $e ) {
			$this->log( "Connection error: " . $e->getMessage() );
		}
		catch( DBError $e ) {
			$this->log( "Connection error: " . $e->getMessage() );
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
				if( $oTask && ! empty( $oTask->getData()->task_started ) ) {
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
		// return UserMailer::send( $to, new MailAddress("ops@wikia-inc.com"), "[TASKMANAGER] Task Manager stucked.", $alarm );
	}

	/**
	 * log
	 */
	public function log( $message ) {
		printf( "%s %s\n", wfTimestamp( TS_DB, time() ), $message );
	}
};
