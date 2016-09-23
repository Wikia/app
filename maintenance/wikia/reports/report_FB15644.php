<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 * 
 * A script generating a list of wikis having a problem described in BugId:15644.
 * 
 * Usage: SERVER_ID=177 php report_FB15644.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php
 */
$dir = realpath( dirname( __FILE__ ) . '/../../' );
include "{$dir}/commandLine.inc";

class report_FB15644 {
    
    /**
     * DB handle
     */
    private $dbObj;
    /**
     * 
     */
    private $data = array();
    /**
     * The constructor
     */
    public function __construct( DatabaseBase $dbObj ) {
        $this->dbObj = $dbObj;
        return null;
    }
    
    /**
     * The main method, traverses the list of wikis and grabs the relevant data
     */
    public function execute() {
        $res = $this->dbObj->select(
                array( 'wikicities.city_list' ),
                array( 'city_id', 'city_dbname', 'city_url' ),
                array( 'city_public' => 1 ),
                __METHOD__,
                array()
        );
        
        $exceptions = array( 'search', 'test', 'wikicities', 'books299' );

        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            if ( in_array( $oRow->city_dbname, $exceptions ) ) {
		continue;
	    }
            $tmpDbObj = wfGetDB( DB_SLAVE, array(), $oRow->city_dbname );
            
            // SELECT rev_timestamp, rev_user_text, rc_user_text FROM revision
            // JOIN recentchanges ON rc_this_oldid = rev_id AND rc_user <> rev_user;
            $fails = $tmpDbObj->select(
                    array( 'revision AS rv', 'recentchanges AS rc' ),
                    array( 'rv.rev_id', 'rv.rev_timestamp', 'rv.rev_user_text', 'rc.rc_user_text' ),
                    array(),
                    __METHOD__,
                    array( 'ORDER BY rv.rev_timestamp DESC' ),
                    array(
                        'recentchanges AS rc' => array( 'JOIN', 'rc.rc_this_oldid = rv.rev_id AND rc.rc_user <> rv.rev_user' )
                    )
            );
            
            if ( is_object( $fails ) ) {
                while ( $oFail = $tmpDbObj->fetchObject( $fails ) ) {
                    $this->data[] = implode(
                            ',',
                            array(
                                $oRow->city_id, $oRow->city_dbname, $oRow->city_url,
                                $oFail->rev_id, $oFail->rev_timestamp, $oFail->rev_user_text, $oFail->rc_user_text
                            )
                    );
                }
	    }
            
            $tmpDbObj->close();
        }
        
        echo implode( "\n", $this->data );
        return null;
    }
}

// the work...
$d = new report_FB15644(
        wfGetDB( DB_MASTER, array(), 'wikicities' )
);
$d->execute();
exit( 0 );