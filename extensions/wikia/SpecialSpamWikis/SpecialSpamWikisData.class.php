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
        $sk = F::app()->wg->User->getSkin();
        $data = array( 'count' => 0, 'items' => array() );
        
        // required for link formatting
        $link = new Linker();
        
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
                $mail = $link->makeExternalLink( 'mailto:' . $user->getEmail(), $user->getEmail() );
            }
            // format the output
            $data['items'][] = array(
                '<input type="checkbox" name="close[' . $oRow->city_id . ']" value="1" />',
                '<b>' . $oRow->city_title . '</b><br /><small>' . $link->makeExternalLink( $oRow->city_url, $oRow->city_url ) . '</small>',
                $oRow->city_created,
                $sk->makeLinkObj( $user->getUserPage(), $user->getName() ),
                $mail
            );
        }
        // return the output
        return $data;
    }
}