<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 * 
 * A script populating the noreptemp.spamwikis table with the current data.
 * 
 * Usage:
 * 
 * SERVER_ID=177 php CommunityQuiz.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php
 * or
 * SERVER_ID=177 php CommunityQuiz.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --date=1978-08-21
 */
$dir = realpath( dirname( __FILE__ ) . '/../' );
include "{$dir}/commandLine.inc";

class CommunityQuiz {
    /**
     * The length of the time period.
     */
    const LENGTH_DAYS = 7;
    /**
     * Criteria: Revisions range.  Wikis from the of the range won't be included in the report.
     */
    const MIN_REVISIONS = 5;
    const MAX_REVISIONS = 50;
    /**
     * DB handle
     */
    private $dbObj;
    /**
     * The start of the time period.
     */
    private $date;
    /**
     * Output data
     */
    private $output = array();
    /**
     * The constructor
     */
    public function __construct( DatabaseBase $dbObj, $date ) {
        $this->dbObj = $dbObj;
        $this->date = $date;
        return null;
    }
    /**
     * The main method, fetches some information on wikis created within a given time period.
     */
    public function execute() {
        // Get a list of wikis created within a given time period.
        $res = $this->dbObj->select(
                array( 'wikicities.city_list' ),
                array( 'city_url', 'city_dbname', 'city_founding_user', 'DATE(city_created) AS city_created' ),
                array(
                    'city_lang' => 'en',
                    'city_created BETWEEN \'' . $this->date . ' 00:00:00\' AND DATE_ADD( \'' . $this->date . ' 00:00:00\', INTERVAL ' . self::LENGTH_DAYS . ' DAY )'
                ),
                __METHOD__,
                array( 'ORDER BY city_created ASC')
        );

        // Empty set, terminate.
        if ( 0 == $this->dbObj->numRows( $res ) ) {
            echo "No wikis found.\n";
            return null;
        }

        // Get some meaningful information on each wiki.
        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            // How many wikis has the user created?
            $oneWiki = $this->dbObj->selectRow(
                    array( 'wikicities.city_list' ),
                    array( 'count(1) AS cnt' ),
                    array( 'city_founding_user' => $oRow->city_founding_user ),
                    __METHOD__,
                    array()
            );
            // Ignore users who created more than one wiki
            if ( 1 < $oneWiki->cnt ) {
                continue;
            }

            // Connect to the wiki's DB
            $tmpDbObj = wfGetDB( DB_SLAVE, array(), $oRow->city_dbname );
            // Revisions made by the founder.
            $revisions = $tmpDbObj->selectRow(
                    'revision',
                    'count(1) as cnt',
                    array( 'rev_user' => $oRow->city_founding_user ),
                    __METHOD__,
                    array()
            );
            if ( is_object( $revisions ) ) {
		// skip users who made self::MIN_REVISIONS revisions or less
		if ( self::MIN_REVISIONS >= $revisions->cnt ) {
			$tmpDbObj->close();
			continue;
		}
                
                $tmp = new StdClass;
                $tmp->url = $oRow->city_url;
                $tmp->created = $oRow->city_created;
                $tmp->founder_id = $oRow->city_founding_user;
                $tmp->founder_edits = $revisions->cnt;
                
                // Revisions have to be made on at least MIN_DAYS different days.
                $tmp->founder_days_active = 0;
                $revisions = $tmpDbObj->select(
                        'revision',
                        'DISTINCT DATE( rev_timestamp ) AS date',
                        array( 'rev_user' => $oRow->city_founding_user ),
                        __METHOD__,
                        array()
                );
                
                if ( is_object( $revisions ) ) {
                    $tmp->founder_days_active = $tmpDbObj->numRows( $revisions );
                }
                
		if ( 2 > $tmp->founder_days_active ) {
			$tmpDbObj->close();
			continue;
		}
                
                // Get some additional information on the founder.
                $user = $this->dbObj->selectRow(
                        array( 'wikicities.user' ),
                        array( 'user_name', 'user_real_name', 'user_email', 'user_email_authenticated' ),
                        array( 'user_id' => $oRow->city_founding_user ),
                        __METHOD__,
                        array()
                );

                if ( is_object( $user ) ) {
                    $tmp->founder_name = $user->user_name;
                    $tmp->founder_real_name = $user->user_real_name;
                    $tmp->founder_email = $user->user_email;
                } else {
                    $tmp->founder_name = 'unknown';
                    $tmp->founder_real_name = 'unknown';
                    $tmp->founder_email = 'unknown';
                }

                // Filter out non-email confirmed users
                if ( empty( $user->user_email_authenticated ) ) {
                    unset( $tmp );
                }

                if ( isset( $tmp ) ) {
                    $this->output[] = $tmp;
                    unset( $tmp );
                }
            }
            $tmpDbObj->close();
        }
        // Output as CSV
        echo "\"#\",\"Created\",\"URL\",\"Edits\",\"Days active\",\"Founder ID\",\"Founder name\",\"Founder real name\",\"Founder email\"\n";
        foreach ( $this->output as $k => $v ) {
            printf(
                    "\"%d\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                    $k,
		    $v->created,
                    $v->url,
                    $v->founder_edits,
                    $v->founder_days_active,
                    $v->founder_id,
                    $v->founder_name,
                    $v->founder_real_name,
                    $v->founder_email
            );
        }
	return null;
    }
}

// the work...
if ( !isset( $options['date'] ) ) {
    $date = date('Y-m-d');
} else {
    $matches = array();
    if ( !preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $options['date'], $matches ) ) {
        echo "Invalid date format. YYYY-MM-DD expected.\n";
        exit( 1 );
    }
    if ( !checkdate( $matches[2], $matches[3], $matches[1] ) ) {
        echo "Invalid YYYY-MM-DD date.\n";
        exit( 1 );
    }
    $date = $options['date'];
}

$d = new CommunityQuiz( wfGetDB( DB_SLAVE, array(), 'wikicities' ), $date );
$d->execute();
exit( 0 );
