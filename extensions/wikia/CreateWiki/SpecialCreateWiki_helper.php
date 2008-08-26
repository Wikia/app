<?php

/**
 * @package MediaWiki
 * @subpackage CreateWiki
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

#----------------------------------------------------------------------------
#--- classes ----------------------------------------------------------------
#----------------------------------------------------------------------------


/**
 * rebuild messages, it should be only done when is not already done (but
 * I don't know how to)
 */
define("WIKIA_LOCK_CREATED", 1);
define("WIKIA_LOCK_RELEASED", 0);

class CreateWikiLock {

    public $mTable, $mRequestID, $mUser;

    /**
     *  __construct
     *
     *  constructor
     *
     *  @access public
     *  @author eloy@wikia
     *
     *  @return CreateWikiLock object
     */
    public function  __construct()
    {
        global $wgUser;

        $this->mTable = wfSharedTable("city_list_requests_lock");
        $this->mRequestID = null;
        $this->mUser = $wgUser;
    }

    /**
     * newFromID
     *
     * static constructor
     *
     * @author eloy@wikia
     * @access public
     * @static
     *
     * @param integer $request_id: request id from city_list_requests table
     *
     * @return CreateWikiLock object
     */
    static public function newFromID( $request_id )
    {

        $object = new CreateWikiLock;
        $object->mRequestID = $request_id;

        return $object;
    }

    /**
     * create
     *
     * create lock, check first if request is free to lock.
     * algorithm is very naive, no critical section etc.
     *
     * @author eloy@wikia
     * @access public
     *
     * @return boolean: true if lock created, false otherwise
     */
    public function create()
    {
        wfProfileIn( __METHOD__ );
        $bRetVal = true;

        if ($this->isLocked() === false) {
            #--- unlock
            $dbw = wfGetDB( DB_MASTER );
            $dbw->insert(
                $this->mTable,
                array(
                    "request_id" => $this->mRequestID,
                    "user_id" => $this->mUser->getID(),
                    "locked" => WIKIA_LOCK_CREATED,
                    "timestamp" => wfTimestampNow()
                ),
                __METHOD__
            );
            $bRetVal = true;
        }
    }

    /**
     * release
     *
     * release lock, check first if request is locked
     *
     * @author eloy@wikia
     * @access public
     *
     * @return boolean: true if lock released, false otherwise
     */
    public function release()
    {
        wfProfileIn( __METHOD__ );

        $bRetVal = true;
        if ($this->isLocked() === true) {
            #--- unlock
            $dbw = wfGetDB( DB_MASTER );
            $dbw->insert(
                $this->mTable,
                array(
                    "request_id" => $this->mRequestID,
                    "user_id" => $this->mUser->getID(),
                    "locked" => WIKIA_LOCK_RELEASED,
                    "timestamp" => wfTimestampNow()
                ),
                __METHOD__
            );
            $bRetVal = true;
        }
        else {
            #-- not locked
            $bRetVal = false;
        }
        wfProfileOut( __METHOD__ );

        return $bRetVal;
    }

    /**
     * isLocked
     *
     * check if request is locked
     *
     * @author eloy@wikia
     * @access public
     *
     * @return boolean: true if locked, false otherwise
     */
    public function isLocked()
    {
        $oData = $this->getData();

        if (isset( $oData->locked ) && $oData->locked == 1 ) {
            return true;
        }
        return false;
    }

    /**
     * getData
     *
     * get last data from database about lock
     *
     * @author eloy@wikia
     * @access public
     *
     * @return DatabaseRow object or null
     */
    public function getData()
    {
        if ( is_null(  $this->mRequestID ) ) {
            throw new MWException( "request indetifier has to be defined " . __METHOD__ );
        }

        wfProfileIn( __METHOD__ );

        $dbr = wfGetDB( DB_MASTER ); #--- we don't want to slave delays
        $oRow = $dbr->selectRow(
            $this->mTable,
            array( "id", "request_id", "user_id", "locked", "timestamp" ),
            array( "request_id" => $this->mRequestID ),
            __METHOD__,
            array( "ORDER BY" => "timestamp DESC")
        );

        wfProfileOut( __METHOD__ );

        return $oRow;
    }

    /**
     * getID
     *
     * return request id
     *
     * @access public
     * @author eloy@wikia
     *
     * @return integer: request id
     */
    public function getID()
    {
        return $this->mRequestID;
    }

    /**
     * getLocks
     *
     * return array with all locks created/released for request ordered
     * by reversed timestamp
     *
     * @access public
     * @author eloy@wikia
     *
     * @return array of DatabaseRow objects
     */
    public function getLocks()
    {
        if ( is_null(  $this->mRequestID ) ) {
            throw new MWException( "request indetifier has to be defined " . __METHOD__ );
        }

        wfProfileIn( __METHOD__ );

        $aLocks = array();
        $dbr = wfGetDB( DB_MASTER ); #--- we don't want to slave delays
        $oRes = $dbr->select(
            $this->mTable,
            array( "id", "request_id", "user_id", "locked", "timestamp" ),
            array( "request_id" => $this->mRequestID ),
            __METHOD__,
            array( "ORDER BY" => "timestamp DESC")
        );
        while ( $oRow = $dbr->fetchObject( $oRes) ) {
            $aLocks[] = $oRow;
        }
        $dbr->freeResult( $oRes );

        wfProfileOut( __METHOD__ );

        return $aLocks;
    }

    /**
     * removeLocks
     *
     * remove all locks for requests, it's called in background task
     * after final cleanning
     *
     * @access public
     * @author eloy@wikia
     *
     * @return nothing
     */
    public function removeLocks()
    {
        if ( is_null(  $this->mRequestID ) ) {
            throw new MWException( "request indetifier has to be defined " . __METHOD__ );
        }

        wfProfileIn( __METHOD__ );

        $aLocks = array();
        $dbr = wfGetDB( DB_MASTER ); #--- we don't want to slave delays
        $bStatus = $dbr->delete(
            $this->mTable,
            array( "request_id" => $this->mRequestID ),
            __METHOD__
        );

        wfProfileOut( __METHOD__ );

        return $bStatus;
    }
}

#----------------------------------------------------------------------------
#--- functions --------------------------------------------------------------
#----------------------------------------------------------------------------

/**
 * checking for domain availability (by using sql "like" comparing
 */
function wfWCreateCheckName( $name )
{
    global $wgDBname;

    $dbr = wfGetDB( DB_SLAVE );

    #--- switch to shared
    $dbr->selectDB( "wikicities" );

    #--- check name availability
    $aDomains = array();
    $aSkip = array();

    #--- don't check short names
    if (strlen($name) > 2) {

        $names = explode(" ", $name);
        $bSkipCondition = false;
        $aCondition = array();
        if (is_array($names)) {
            foreach ($names as $n) {
                if (!preg_match("/^[\w\.]+$/",$n)) continue;
                $aCondition[] = "city_domain like '%.{$n}.%'";
            }

            if (sizeof($aCondition)) {
                $sCondition = implode(" or ", $aCondition);
            }
            else {
                $bSkipCondition = true;
            }
        }
        else {
            $sCondition = "city_domain like '%.{$name}.%'";
        }

        if ( $bSkipCondition === false ) {
            #--- exact (but with language prefixes)
            $oRes = $dbr->select("city_domains",
                array("*"),
                array($sCondition), __METHOD__,
                array("limit" => 20)
            );

            while ($oRow = $dbr->fetchObject($oRes)) {
                if (preg_match("/^www\./", strtolower($oRow->city_domain))) continue;
                if (preg_match("/wikicities\.com/", strtolower($oRow->city_domain))) continue;
                $aSkip[strtolower($oRow->city_domain)] = 1;
                    $aDomains["exact"][] = $oRow;
            }
            $dbr->freeResult($oRes);
        }

        #--- similar
        $bSkipCondition = false;
        $aCondition = array();
        if (is_array($names)) {
            foreach ($names as $n) {
                if (!preg_match("/^[\w\.]+$/",$n)) continue;
                $aCondition[] = "city_domain like '%{$n}%'";
            }
            if (sizeof($aCondition)) {
                $sCondition = implode(" or ", $aCondition);
            }
            else {
                $bSkipCondition = true;
            }
        }
        else {
            $sCondition = "city_domain like '%{$name}%'";
        }

        if ( $bSkipCondition === false ) {
            $oRes = $dbr->select("city_domains",
                array("*"),
                array($sCondition), __METHOD__,
                array("limit" => 20)
            );

            while ($oRow = $dbr->fetchObject($oRes)) {
                if (preg_match("/^www\./", strtolower($oRow->city_domain))) continue;
                if (preg_match("/wikicities\.com/", strtolower($oRow->city_domain))) continue;
                if (isset($aSkip[strtolower($oRow->city_domain)]) && ($aSkip[strtolower($oRow->city_domain)] == 1)) continue;
                $aDomains["like"][] = $oRow;
            }
            $dbr->freeResult($oRes);
        }
    }

    #--- back to normal database
    $dbr->selectDB( $wgDBname );
    return $aDomains;
}

/**
 * for cooperating with ajax requests
 * format = 1, unordered list <ul><li></li></ul>
 * format = 0, just string
 */
function axWCreateCheckName()
{
    global $wgRequest;

    $sName = $wgRequest->getVal("name");
    $sRequestPage = $wgRequest->getVal("requestPage");

    $like = "";
    $exact = "";

    $aDomains = wfWCreateCheckName( $sName );

    if (isset($aDomains["like"]) && is_array($aDomains["like"])) {
        foreach ( $aDomains["like"] as $key => $domain ) {
            $like .= "<a href=\"http://{$domain->city_domain}/\" target=\"_blank\">{$domain->city_domain}</a> ";
        }
    }
    else {
        $like = "none";
    }
    if (isset($aDomains["exact"]) && is_array($aDomains["exact"])) {
        foreach ( $aDomains["exact"] as $key => $domain ) {
            $exact .= "<a href=\"http://{$domain->city_domain}/\" target=\"_blank\">{$domain->city_domain}</a> ";
        }
    }
    else {
        $exact = "none";
    }

    if (strlen($sName) < 3) {
        $exact = wfMsg("createwikinametooshort");
        $like = "&nbsp;";
    }

    // check whether or not request page already exists
    $oRequestTitle = Title::newFromText( $sRequestPage, NS_MAIN );
/*
echo "<pre>";
print_r($oRequestTitle);
*/
    $oRequestArticle = new Article( $oRequestTitle, 0);
    if(!$oRequestArticle->exists()) {
    	$sRequestPage = "none";
    }

    $aResponse = array(
        "like" => $like,
        "exact" => $exact,
        "requestPage" => $sRequestPage
    );

    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "axWCreateCheckName";

?>
