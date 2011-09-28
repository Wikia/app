<?php
class SpecialSpamWikisData {
    const DATABASE = 'stats';
    private $db;
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
    
    public function __construct() {
        $this->db = F::app()->wf->getDb( DB_MASTER, array(), self::DATABASE );
        
        foreach ( $this->criteria as $k => $v ) {
            $this->criteria[$k]['data'] = (string) F::app()->wg->memc->get( $this->criteria[$k]['name'] );
        }
    }
    
    public function getCriteria() {
        return $this->criteria;
    }
    
    public function getList($limit = 10, $offset = 0, $wikiName = null, $criteria = array()) {
        $sk = F::app()->wg->User->getSkin();
        $data = array( 'count' => 0, 'items' => array() );
        $link = new Linker();
        
        $where = array();
        
        foreach ( $criteria as $v ) {
            if ( isset( $this->criteria[$v] ) ) {
                $where[ $this->criteria[$v]['column'] ] = 1;
            }
        }
        
        if ( !empty( $wikiName ) ) {
            $where[] = 'city_url >= ' . $this->db->addQuotes( 'http://' . $wikiName );
        }
        
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
        
        if ( 0 == $data['count'] ) {
            return $data;
        }
        
        $res = $this->db->select(
                'noreptemp.spamwikis',
                array( 'city_id', 'city_url', 'city_title', 'city_created', 'city_founding_user' ),
                $where,
                __METHOD__,
                array(
                    'LIMIT' => $limit,
                    'OFFSET' => $offset,
                    'ORDER BY' => 'city_created DESC'
                )
        );
        
        while ( $oRow = $this->db->fetchObject( $res ) ) {
            $user = User::newFromId( $oRow->city_founding_user );
            $mail = $user->getEmail();
            if ( !empty( $mail ) ) {
                $mail = $link->makeExternalLink( 'mailto:' . $user->getEmail(), $user->getEmail() );
            }
            $data['items'][] = array(
                '<input type="checkbox" name="close[' . $oRow->city_id . ']" value="1" />',
                $link->makeExternalLink( $oRow->city_url, $oRow->city_title ),
                $oRow->city_created,
                $sk->makeLinkObj( $user->getUserPage(), $user->getName() ),
                $mail
            );
        }
        
        return $data;
    }
}