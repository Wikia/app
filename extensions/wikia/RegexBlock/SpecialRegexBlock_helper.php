<?php

/**
 * @package MediaWiki
 * @subpackage CreateWiki
 * @author Bartek, Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: 1.0
 *
 * helper classes & functions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

/**
 * @class RegexBlockData
 * @author Bartek, Moli
 */

class RegexBlockData
{
    var $mTable, $mStatsTable;
    var $mNbrResults;

    public function __construct() {
        $this->mTable = wfSharedTable(REGEXBLOCK_TABLE);
        $this->mStatsTable = wfSharedTable(REGEXBLOCK_STATS_TABLE);
        $this->mNbrResults = 0;
    }    
    
    /* 
     * fetch number of all rows 
     */
    public function fetchNbrResults () {
        global $wgMemc, $wgSharedDB ;

        wfProfileIn( __METHOD__ );

        $this->mNbrResults = 0;
        /* we use memcached here */
        $key = wfForeignMemcKey( $wgSharedDB, "", REGEXBLOCK_SPECIAL_KEY, REGEXBLOCK_SPECIAL_NUM_RECORD );
        $cached = $wgMemc->get ($key);

        if ( empty( $cached ) ) {
            $dbr =& wfGetDB (DB_MASTER) ;
            
            $oRes = $dbr->select(
                $this->mTable,
                array("COUNT(*) as cnt"),
                array("blckby_blocker <> ''"), 
                __METHOD__
            );
            
            if ($oRow = $dbr->fetchObject($oRes)) {
                $this->mNbrResults = $oRow->cnt;
            }
            $dbr->freeResult($oRes);
            $wgMemc->set ($key, $this->mNbrResults, REGEXBLOCK_EXPIRE) ;
        } else {
            $this->mNbrResults = $cached ;
        }
        
        wfProfileOut( __METHOD__ );
        return $this->mNbrResults;
    }
    
    public function getNbrResults() {
        return $this->mNbrResults;
    }
    
    /* 
     * fetch names of all blockers and write them into select's options
     */
    public function fetchBlockers () {
        $blockers_array = array ();
        wfProfileIn( __METHOD__ );

        if (function_exists('wfRegexBlockGetBlockers')) {
            $blockers_array = wfRegexBlockGetBlockers();
        } else {
            global $wgMemc, $wgSharedDB;
            $key = wfForeignMemcKey( $wgSharedDB, "", REGEXBLOCK_BLOCKERS_KEY );
            $cached = $wgMemc->get ($key);

            if (!is_array($cached)) {
                /* get from database */
                $dbr =& wfGetDB (DB_MASTER);
                $oRes = $dbr->select(
                    $this->mTable,
                    array("blckby_blocker"),
                    array("blckby_blocker <> ''"),
                    __METHOD__,
                    array("GROUP BY" => "blckby_blocker")
                );
                while ($oRow = $dbr->fetchObject($oRes)) {
                    $blockers_array[] = $oRow->blckby_blocker;
                }
                $dbr->freeResult($oRes);
                $wgMemc->set( $key, $blockers_array, REGEXBLOCK_EXPIRE );
            } else {
                /* get from cache */
                $blockers_array = $cached;
            }
        }

        wfProfileOut( __METHOD__ );
        return $blockers_array;
    }

    public function getBlockersData($current = "", $username = "", $limit, $offset) {
        global $wgSharedDB, $wgLang, $wgUser;

        wfProfileIn( __METHOD__ );

        $blocker_list = array();
        /* get data and play with data */
        $dbr =& wfGetDB (DB_MASTER) ;
        $conds = array("blckby_blocker <> ''");

        if ( !empty($current) ) {
            $conds = array("blckby_blocker = {$dbr->addQuotes($current)}");
        }

        if ( !empty($username) ) {
            $conds = array("blckby_name like {$dbr->addQuotes('%'.$username.'%')}");
        }

        $oRes = $dbr->select(
            $this->mTable,
            array("blckby_id, blckby_name, blckby_blocker, blckby_timestamp, blckby_expire, blckby_create, blckby_exact, blckby_reason"),
            $conds,
            __METHOD__,
            array("LIMIT" => $limit, "OFFSET" => $offset, "ORDER BY" => "blckby_id desc")
        );

        while ($oRow = $dbr->fetchObject($oRes)) {
            /* */
            $ublock_ip = urlencode ($oRow->blckby_name);
            $ublock_blocker = urlencode ($oRow->blckby_blocker);
            /* */
            $reason = ($oRow->blckby_reason) ? wfMsg('regexblock_reason') . $oRow->blckby_reason : wfMsg('regexblock_generic_reason');
            /* */
            $time = $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->blckby_timestamp ), true );

            /* put data to array */
            $blocker_list[] = array(
                "blckby_name"   => $oRow->blckby_name,
                "exact_match"   => $oRow->blckby_exact,
                "create_block"  => $oRow->blckby_create,
                "blocker"       => $oRow->blckby_blocker,
                "reason"        => $reason,
                "time"          => $time,
                "ublock_ip"     => $ublock_ip,
                "ublock_blocker"=> $ublock_blocker,
                "expiry"        => $oRow->blckby_expire,
                "blckid"        => $oRow->blckby_id
            );
        }
        $dbr->freeResult($oRes);

        wfProfileOut( __METHOD__ );
        return $blocker_list;
    }

    /* fetch number of all stats rows */
    public function fetchNbrStatResults($id) {
        global $wgSharedDB ;

        wfProfileIn( __METHOD__ );
        $nbrStats = 0;

        $dbr =& wfGetDB (DB_SLAVE);
        $oRes = $dbr->select(
            $this->mStatsTable,
            array("COUNT(*) as cnt"),
            array("stats_blckby_id = '".intval($id)."'"),
            __METHOD__
        );

        if ($oRow = $dbr->fetchObject($oRes)) {
            $nbrStats = $oRow->cnt;
        }
        $dbr->freeResult($oRes);

        wfProfileOut( __METHOD__ );
        return $nbrStats;
    }

	/* fetch all logs */
	public function getStatsData ($id, $limit = 50, $offset = 0) {
        global $wgSharedDB ;

        wfProfileIn( __METHOD__ );
	    $stats = array();

	    /* from database */
	    $dbr =& wfGetDB (DB_SLAVE);
        $conds = array("stats_blckby_id = '".intval($id)."'");
        $oRes = $dbr->select(
            $this->mStatsTable,
            array("stats_blckby_id", "stats_user", "stats_blocker", "stats_timestamp", "stats_ip", "stats_match", "stats_dbname"),
            $conds,
            __METHOD__,
            array("LIMIT" => $limit, "OFFSET" => $offset, "ORDER BY" => "stats_timestamp desc")
        );

        while ($oRow = $dbr->fetchObject($oRes)) {
            $stats[] = $oRow;
        }
		$dbr->freeResult($oRes) ;

        wfProfileOut( __METHOD__ );
        return $stats;
	}

    /* fetch record for selected identifier of regex block */
    public function getRegexBlockById($id) {
        global $wgSharedDB ;

        wfProfileIn( __METHOD__ );
        $record = null;
        
        $dbr =& wfGetDB (DB_MASTER);
        $oRes = $dbr->select(
            $this->mTable,
            array("blckby_id", "blckby_name", "blckby_blocker", "blckby_timestamp", "blckby_expire", "blckby_create", "blckby_exact", "blckby_reason"),
            array("blckby_id = '".intval($id)."'"),
            __METHOD__
        );
        
        if ($oRow = $dbr->fetchObject($oRes)) {
            $record = $oRow;
        }
        $dbr->freeResult($oRes);
        
        wfProfileOut( __METHOD__ );
        return $record;
    }

    static public function blockUser($address, $expiry, $exact, $creation, $reason) {
        global $wgUser;

        wfProfileIn( __METHOD__ );
        /* make insert */
        $dbw =& wfGetDB( DB_MASTER );
        $name = $wgUser->getName() ;

        $oRes = $dbw->replace( 
            wfSharedTable(REGEXBLOCK_TABLE),
            array( "blckby_id", "blckby_name" ),
            array(
                "blckby_id"         => "null",
                "blckby_name"       => $address, 
                "blckby_blocker"    => $name, 
                "blckby_timestamp"  => wfTimestampNow(),
                "blckby_expire"     => $expiry,
                "blckby_exact"      => intval($exact),
                "blckby_create"     => intval($creation),
                "blckby_reason"     => $reason
            ),
            __METHOD__
        );

        wfProfileOut( __METHOD__ );
        return true;
    }

    static public function getExpireValues() {
        $expiry_values = explode(",", wfMsg('regexblock_expire_duration')); 
        $expiry_text = array("1 hour","2 hours","4 hours","6 hours","1 day","3 days","1 week","2 weeks","1 month","3 months","6 months","1 year","infinite");
        
        if (!function_exists("array_combine")) {
            function array_combine($a,$b) {
                $out = array();
                foreach($a as $k => $v) {
                    $out[$v] = $b[$k];
                }
                return $out;
            }            
        }
        
        return array_combine($expiry_text, $expiry_values);
    }
    
    static function isValidRegex($text) {
        return (sprintf("%s",@preg_match("/{$text}/",'regex')) === '');
    }    
}
