<?php

/**
 * @package MediaWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: BatchTask.php 5982 2007-10-02 14:07:24Z eloy $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 );
}

/**
 * @name wgWikiaBatchTasks
 *
 * global variable, array for storing task names and classes
 */
global $wgWikiaBatchTasks;
global $wgWikiaTaskDirectory;

define( "TASK_WAITING", 0 );            #--- new task, freshly added
define( "TASK_QUEUED", 1 );             #--- task started in TaskManager (queued)
define( "TASK_STARTED", 2 );            #--- task started in TaskManagerExecutor
define( "TASK_FINISHED_SUCCESS", 3 );   #--- task finished with success
define( "TASK_FINISHED_ERROR", 4 );     #--- task finished with error
define( "TASK_FINISHED_UNDO", 5 );     #--- task finished but undone later

/**
 * base class for all background tasks
 *
 * @class BatchTask
 * @author eloy@wikia
 *
 */
abstract class BatchTask {

    public static $mStatuses = array(
        TASK_WAITING => "Waiting for start",
        TASK_STARTED => "Running",
        TASK_QUEUED => "Queued",
        TASK_FINISHED_SUCCESS => "Finished, status OK",
        TASK_FINISHED_ERROR => "Finished, status ERROR",
        TASK_FINISHED_UNDO => "Finished, status UNDO",
    );

    const DEFAULT_TTL = 86400; #--- one day
    public $mDebug, $mTaskID, $mData, $mTTL;

    /**
     * contructor
     */
    function  __construct() {
        $this->mDebug = false;
        $this->mTaskID = null;
        $this->mData = null;
    }

    /**
     * get HTML form for Task, $title is Title object used in action
     * and errors array returned from submitForm
     */
    abstract function getForm( $title, $errors = false );

    /**
     * @return type of task, for dropdown selector
     */
    abstract function getType();

    /**
     * if true is show in dropdown box on TaskManager page
     */
    abstract function isVisible();

    /**
     * @return true if form is submitted with success
     *      array otherwise, array contains:
     * array(
     *      errors = array(
     *          "form_field" => "error in Field, field is empty" );
     *      ),
     *      values = array(
     *          "form_field" => value_of_field
     *      )
     * );
     */
    abstract function submitForm();


    /**
     * @return string message for given status number (if defined)
     */
    public function getStatusName( $status ) {
        if (isset( self::$mStatuses[$status] )) {
            return self::$mStatuses[$status];
        }
        else {
            return $status;
        }
    }

    /**
     * getStatuses
     *
     * get array with available statuses
     *
     * @access public
     * @author eloy@wikia
     * @static
     *
     * @return array static array $mStatuses
     */
    static public function getStatuses( )
    {
        return self::$mStatuses;
    }

    /**
     * newFromID
     *
     * read task data from database, create new object type BatchTask
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param integer $taskID: task id from wikia_tasks table
     *
     * @return object BatchTask or null if doesn't exists
     */
    static public function newFromID( $taskID ) {
        global $wgWikiaBatchTasks;

        wfProfileIn( __METHOD__ );

        $retval = null;

        $dbr = wfGetDB( DB_MASTER );

        $oTask = $dbr->selectRow(
            wfSharedTable( "wikia_tasks" ),
            array( "*" ),
            array( "task_id" => $taskID ),
            __METHOD__
        );

        $sClass = $wgWikiaBatchTasks[ $oTask->task_type ];
        if ( is_subclass_of( $sClass, "BatchTask" )) {
            $oObject = new $sClass();
            $oObject->setID( $oTask->task_id );
            $oObject->mData = $oTask;
            $retval =  $oObject;
        }
        wfProfileIn( __METHOD__ );

        return $retval;
    }

    /**
     * newFromData
     *
     * task data is already read from database, create new object type BatchTask
     *
     * @access public
     * @static
     * @author eloy@wikia
     *
     * @param object $oTask: task data from wikia_tasks table
     *
     * @return object BatchTask or null if doesn't exists
     */
    static public function newFromData( $oTask ) {
        global $wgWikiaBatchTasks;

        $sClass = $wgWikiaBatchTasks[ $oTask->task_type ];
        if ( is_subclass_of( $sClass, "BatchTask" )) {
            $oObject = new $sClass();
            $oObject->setID( $oTask->task_id );
            $oObject->mData = $oTask;
            return $oObject;
        }
        else {
            return null;
        }
    }

    /**
     * getID
     *
     * return task identifier, it should be set in execute method or
     * in createTask
     *
     * @author eloy@wikia
     * @access public
     *
     * @return integer - task id
     */
    public function getID() {
        return $this->mTaskID;
    }

    /**
     * setID
     *
     * set task identifier, will be used in other methods
     *
     * @author eloy@wikia
     * @access public
     *
     * @param integer $id Task identifier in database
     *
     * @return void
     */
    public function setID( $id )
    {
        $this->mTaskID = $id;
    }

    /**
     * getTaskDirectory
     *
     * directory for task combined from id and type, create if no exists
     *
     * @access public
     * @author eloy@wikia
     *
     * @return string: path to directory
     */
    public function getTaskDirectory()
    {
        return self::TaskDirectory( $this->getType(), $this->getID() );
    }

    /**
     * addLog
     *
     * add log line to database with timestamp if task identifier is set
     *
     * @author eloy@wikia
     * @access public
     *
     * @param string $line  - line with information
     * @param string $timestamp default null - timestamp to set in MW oformat
     */
    public function addLog( $line, $timestamp = null )
    {
        if (is_null($this->mTaskID)) {
            return false; #--- task id not defined
        }
        wfProfileIn( __METHOD__ );
        $sTimestamp = is_null($timestamp) ? wfTimestampNow() : $timestamp;
        $dbw = wfGetDB( DB_MASTER );
        $dbw->insert(
            wfSharedTable( "wikia_tasks_log" ),
            array(
              "task_id"         => $this->mTaskID,
              "log_timestamp"   => $sTimestamp,
              "log_line"        => $line
            ),
            __METHOD__
        );
        if ( !empty( $this->mDebug )) {
            echo "{$sTimestamp}: {$line}\n";
        }
        wfProfileOut( __METHOD__ );
    }

    /**
     * getLog
     *
     * get log for task stored in database
     *
     * @author eloy@wikia
     * @access public
     *
     * @param boolean $wantarray default false Format of log
     *
     * @return string or mixed or null
     */
    public function getLog( $wantarray = false )
    {
        if (is_null($this->mTaskID)) {
            return false; #--- task id not defined
        }
        wfProfileIn( __METHOD__ );
        $dbr = wfGetDB( DB_MASTER );
        $oRes = $dbr->select(
            wfSharedTable( "wikia_tasks_log" ),
            array( "*" ),
            array( "task_id" => $this->mTaskID ),
            __METHOD__,
            array( "ORDER BY" => "log_timestamp" )
        );
        if (empty( $wantarray )) {
            $mRetval = "";
        }
        else {
            $mRetval = array();
        }
        while ( $oRow = $dbr->fetchObject( $oRes ) ) {
            if (empty( $wantarray )) {
                $mRetval = sprintf(
                    "%s id=%s log=%s\n",
                    wfTimestamp( TS_EXIF, $oRow->log_timestamp ),
                    $oRow->task_id,
                    $oRow->log_line
                );
            }
            else {
                $mRetval[] = $oRow;
            }
        }
        $dbr->freeResult( $oRes );
        wfProfileOut( __METHOD__ );

        return $mRetval;
    }

    /**
     * createTask
     *
     * add task to database, usually run by submitForm
     *
     * @access public
     * @author eloy@wikia
     *
     * @param mixed $params: array with task arguments
     * @param integer $status default TASK_WAITING: initial status of task
     *
     * @return integer: id of added task or null
     */
    public function createTask( $params, $status = TASK_WAITING ) {
        global $wgUser;

        wfProfileIn( __METHOD__ );
        $dbw = wfGetDB( DB_MASTER );
        $dbw->insert(
            wfSharedTable( "wikia_tasks" ),
            array(
               "task_user_id" => $wgUser->getID(),
               "task_type" => $this->getType(),
               "task_priority" => 1,
               "task_status" => $status,
               "task_added" => wfTimestampNow(),
               "task_started" => "",
               "task_finished" => "",
               "task_arguments" => serialize( $params )
            ),
            __METHOD__
        );
        wfProfileOut( __METHOD__ );

        $this->mTaskID = $dbw->insertId();
        return $this->mTaskID;
    }


    /**
     * closeTask
     *
     * mark task as finished, no matter in which state it is
     *
     * @access public
     * @author eloy@wikia
     *
     * @param integer $success default true: set to false if you want to close
     *      with failure status
     *
     * @return void
     */
    public function closeTask( $success = true ) {
        if (is_null($this->mTaskID)) {
            return false; #--- task id not defined
        }
        wfProfileIn( __METHOD__ );

        $status = ( $success === true )
            ? TASK_FINISHED_SUCCESS
            : TASK_FINISHED_ERROR;

        $dbw = wfGetDB( DB_MASTER );
        $dbw->update(
            wfSharedTable( "wikia_tasks" ),
            array(
               "task_status" => $status,
               "task_finished" => wfTimestampNow(),
            ),
            array(
                "task_id" => $this->mTaskID
            ),
            __METHOD__
        );

        wfProfileOut( __METHOD__ );
    }

    /**
     * TaskDirectory
     *
     * directory for task combined from id and type, create if no exists
     *
     * @access public
     * @author eloy@wikia
     * @static
     *
     * @return string: path to directory
     */
    static public function TaskDirectory( $type, $id ) {
        global $wgWikiaTaskDirectory;

        wfProfileIn( __METHOD__ );

        $sDirectoryPath = sprintf("%s/%s-%s", $wgWikiaTaskDirectory, $type, $id );
        $sRetval = $sDirectoryPath;
        wfMkdirParents( $sDirectoryPath );

        wfProfileOut( __METHOD__ );

        return $sRetval;
    }

    /**
     * getDescription
     *
     * description of task, used in task listing. By default it will return
     * task type. Simple accessor, should be replaced in child.
     *
     * @access public
     * @author eloy@wikia
     *
     * @return string: task description
     */
    public function getDescription() {
        return $this->getType();
    }

    /**
     * getTTL
     *
     * simple accessor
     *
     * every task has timeout value, after that time task will be closed with
     * error
     *
     * @access public
     * @author eloy
     *
     * @return integer: return defalt time to live in secons
     */
    public function getTTL() {
        return empty( $this->mTTL ) ? self::DEFAULT_TTL : $this->mTTL;
    }

    /**
     * getData
     *
     * simple accessor
     *
     * every task has timeout value, after that time task will be closed with
     * error
     *
     * @access public
     * @author eloy
     *
     * @return mixed: null if not set, database object otherwise
     */
    public function getData() {
        return $this->mData;
    }

};


/**
 * extAddBatchTask
 *
 * Add task to autoloader and fill wgWikiaBatchTasks array
 *
 * @param string $file Filename containing task class
 * @param string $shortName Short name of task
 * @param string $className task class name
 *
 * @return void
 */
function extAddBatchTask( $file, $shortName, $className )
{
    global $wgWikiaBatchTasks, $wgAutoloadClasses;

    $wgWikiaBatchTasks[$shortName] = $className;
    $wgAutoloadClasses[$className] = $file;
}
