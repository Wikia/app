<?php
class SpecialSpamWikisData {
    /*
     * Which db?
     */
    const DATABASE = 'stats';
    /*
     * DB handle
     */
    private $db;
    /*
     * Human readable names of the critera and corresponding noreptemp.spamwikis columns.
     */
    private $criteria = array(
        0 => array(
            'name' => 'specialspamwikis-criteria-users-more-than-one-wiki',
            'column' => 'benchmark_1'
        ),
        1 => array(
            'name' => 'specialspamwikis-criteria-users-non-email-confirmed',
            'column' => 'benchmark_2'
        ),
        2 => array(
            'name' => 'specialspamwikis-criteria-wikis-less-than-five-pages',
            'column' => 'benchmark_3'
        )
    );
    /**
     * The constructor.
     */
    public function __construct() {
        $this->db = F::app()->wf->getDb( DB_MASTER, array(), self::DATABASE );
    }
    /**
     * Returns the list of criteria (to render as a form, etc.)
     */
    public function getCriteria() {
        return $this->criteria;
    }
    /*
     * Fetches and prepares the data for the output.
     */
    public function getList($limit = 10, $offset = 0, $wikiName = null, $criteria = array(), $order = 'city_created DESC') {
        $data = array( 'count' => 0, 'items' => array() );
        $where = array();
        
        // processing parameters for DB query: the criteria
        foreach ( $criteria as $v ) {
            if ( isset( $this->criteria[$v] ) ) {
                $where[ $this->criteria[$v]['column'] ] = 1;
            }
        }
        
        // display wikis having names starting with $wikiName
        if ( !empty( $wikiName ) ) {
            $where[] = 'city_url >= ' . $this->db->addQuotes( 'http://' . $wikiName );
        }
        
        // check for the number of wikis matching the given criteria
        $oRow = $this->db->selectRow(
                'noreptemp.spamwikis',
                'count(0) as cnt',
                $where,
                __METHOD__,
                null
        );
        
        if ( is_object($oRow) ) {
            $data['count'] = $oRow->cnt;
        }
        
        // empty set, so let's give up here
        if ( 0 == $data['count'] ) {
            return $data;
        }
        
        // if one or more wikis match the given criteria, fetch the actual data
        $res = $this->db->select(
                'noreptemp.spamwikis',
                array( 'city_id', 'city_url', 'city_title', 'city_created', 'city_founding_user' ),
                $where,
                __METHOD__,
                array(
                    'LIMIT' => $limit,
                    'OFFSET' => $offset,
                    'ORDER BY' => $order
                )
        );
        
        // process the data
        while ( $oRow = $this->db->fetchObject( $res ) ) {
            // fetch and format the information about the user, who created the wiki
            $user = User::newFromId( $oRow->city_founding_user );
            $mail = $user->getEmail();
            if ( !empty( $mail ) ) {
                $mail = Linker::makeExternalLink( 'mailto:' . $user->getEmail(), $user->getEmail(), false );
            }
            // format the output
            $data['items'][] = array(
                '<input type="checkbox" name="close[' . $oRow->city_id . ']" value="1" />',
                '<b>' . $oRow->city_title . '</b><br /><small>' . Linker::makeExternalLink( $oRow->city_url, $oRow->city_url, false ) . '</small>',
                $oRow->city_created,
                Linker::link( $user->getUserPage(), $user->getName() ),
                $mail
            );
        }
        // return the output
        return $data;
    }
    /*
     * Fetches and prepares the data for the stats subpage.
     */
    public function getStats() {
        
        // first check the cache
        $cache = F::app()->wg->memc->get( __METHOD__ );
        // and return the cached data
        if ( !empty( $cache ) ) {
            return $cache;
        }
        // placeholder for the data
        $data = array();
        // we need data for the last 14 days
        for ( $i = 0; $i <= 13; $i++ ) {
            
            $data[$i] = new StdClass;
            $data[$i]->date = '';
            $data[$i]->cnt_created = 0;
            $data[$i]->cnt_spamwikis = 0;
            $data[$i]->cnt_founders = array();
            
            // the amount of wikis created that day, by status
            $res = $this->db->query( "SELECT DATE(city_created) AS created, city_public, count(city_id) AS cnt FROM wikicities.city_list WHERE date(city_created) = CURDATE() - INTERVAL {$i} DAY GROUP BY city_public ORDER BY city_public DESC" );
            
            while ( $oRow = $this->db->fetchObject( $res ) ) {
                // set the date
                if ( empty( $data[$i]->date ) ) {
                    $data[$i]->date = $oRow->created;
                }
                // update cnt_created
                $data[$i]->cnt_created += $oRow->cnt;
                // update cnt_spamwikis
                if ( -2 == $oRow->city_public ) {
                    $data[$i]->cnt_spamwikis += $oRow->cnt;
                }
            }
            
            // the amount of spam wikis created that day, by user
            $res = $this->db->query( "SELECT city_founding_user, count(city_id) AS cnt FROM wikicities.city_list WHERE city_public = -2 AND date(city_created) = CURDATE() - INTERVAL {$i} DAY GROUP BY city_founding_user" );
            
            while ( $oRow = $this->db->fetchObject( $res ) ) {
                // populate cnt_founders
                $data[$i]->cnt_founders[$oRow->city_founding_user] = $oRow->cnt;
            }
            
            // calculate and preformat data
            $summary = array(
               'sum' => array_sum( $data[$i]->cnt_founders ),
               'count' => count( $data[$i]->cnt_founders ),
               'avg' => 0
            );

            if ( 0 != $summary['count' ] ) {
                $summary['avg'] = sprintf( '%1.2f', $summary['sum'] / $summary['count' ] );
            }
            
            // write the data back to the object (yes, overwrite the previous value)
            $data[$i]->cnt_founders = $summary;
            
            // cache the data
            F::app()->wg->memc->set( __METHOD__, $data, 3600 * 3 /* 3 hours */ );
        }
        
        return $data;
    }
}