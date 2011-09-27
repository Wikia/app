<?php
/**
 * Michał Roszka (Mix) <michal@wikia-inc.com>
 * 
 * Usage: SERVER_ID=177 php SpecialSpamWikisCache.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php
 */
$dir = realpath( dirname( __FILE__ ) . '/../../../../maintenance/' );
include "{$dir}/commandLine.inc";

class SpecialSpamWikiCache {
    
    private $dbObj;
    
    public function __construct( DatabaseMysql $dbObj ) {
        $this->dbObj = $dbObj;
        return null;
    }
    
    public function updateCache() {
        /* INSERT INTO noreptemp.spamwikis (city_id, city_sitename, city_url,
         * city_created, city_founding_user, city_title) SELECT city_id, city_sitename,
         * city_url, city_created, city_founding_user, city_title FROM wikicities.city_list
         * WHERE city_public = 1 AND city_id NOT IN (SELECT city_id FROM
         * noreptemp.spamwikis);
         */
        $res = $this->dbObj->select(
                'wikicities.city_list AS c',
                array( 'c.city_id', 'c.city_sitename', 'c.city_url', 'c.city_created', 'c.city_founding_user', 'c.city_title' ),
                array(
                    'c.city_public' => 1,
                    's.city_id is null'
                ),
                __METHOD__,
                array(),
                array(
                    'noreptemp.spamwikis AS s' => array( 'LEFT JOIN', 'c.city_id = s.city_id', )
                )
                
        );
        
        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            $this->dbObject->insert(
                    'noreptemp.spamwikis',
                    array(
                        'city_id' => $oRow->city_id,
                        'city_sitename' =>  $oRow->city_sitename,
                        'city_url' => $oRow->city_url,
                        'city_created' => $oRow->city_created,
                        'city_founding_user' => $oRow->city_founding_user,
                        'city_title' => $oRow->city_title
                    ),
                    __METHOD__
            );
        }
        
        /* DELETE FROM noreptemp.spamwikis WHERE city_id IN (SELECT city_id
         * FROM wikicities.city_list WHERE city_public <> 1);
         */
        $res = $this->dbObj->select(
                'wikicities.city_list',
                array( 'city_id' ),
                array( 'city_public <> 1' ),
                __METHOD__
        );
        
        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            $this->dbObject->delete(
                    'noreptemp.spamwikis',
                    array( 'city_id' => $oRow->city_id ),
                    __METHOD__
            );
        }
        /* UPDATE noreptemp.spamwikis SET benchmark_1 = 1 WHERE benchmark_1 = 0
         * AND city_founding_user IN (SELECT city_founding_user FROM
         * wikicities.city_list GROUP BY city_founding_user HAVING
         * count(city_id) >= 2);
         */
        
        $res = $this->dbObj->select(
                'wikicities.city_list',
                array( 'city_founding_user' ),
                array(),
                __METHOD__,
                array(
                    'GROUP BY city_founding_user',
                    'HAVING count(city_id) >= 2'
                )
         );
        
        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            $this->dbObj->update(
                'noreptemp.spamwikis',
                array( 'benchmark_1' => 1 ),
                array( 'city_id' => $oRow->city_id ),
                __METHOD__,
                array()
            );
        }
        
        /* UPDATE noreptemp.spamwikis SET benchmark_1 = 0 WHERE benchmark_1 = 1
         * AND city_founding_user NOT IN (SELECT city_founding_user FROM
         * wikicities.city_list GROUP BY city_founding_user HAVING
         * count(city_id) >= 2);
         */
        $res = $this->dbObj->select(
                'wikicities.city_list',
                array( 'city_founding_user' ),
                array(),
                __METHOD__,
                array(
                    'GROUP BY city_founding_user',
                    'HAVING count(city_id) < 2'
                )
         );
        
        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            $this->dbObj->update(
                'noreptemp.spamwikis',
                array( 'benchmark_1' => 0 ),
                array( 'city_id' => $oRow->city_id ),
                __METHOD__,
                array()
            );
        }
        
        /* UPDATE noreptemp.spamwikis SET benchmark_2 = 1 WHERE benchmark_2 = 0
         * AND city_founding_user IN (SELECT user_id FROM wikicities.user
         * WHERE user_email_authenticated IS NULL);
         */
        
        $tmpDbObj = F::app()->wf->getDb( DB_SLAVE, array(), 'wikicities' );
        
        $res = $tmpDbObj->select(
                'wikicities.user',
                array( 'user_id' ),
                array( 'user_email_authenticated is null' ),
                __METHOD__
         );
        
        while ( $oRow = $tmpDbObj->fetchObject( $res ) ) {
            $this->dbObj->update(
                'noreptemp.spamwikis',
                array( 'benchmark_2' => 1 ),
                array( 'city_id' => $oRow->city_id ),
                __METHOD__
            );
        }
        
        unset( $tmpDbObj );
        
        /* UPDATE noreptemp.spamwikis SET benchmark_2 = 0 WHERE benchmark_2 = 1
         * AND city_founding_user NOT IN (SELECT user_idFROM wikicities.user
         * WHERE user_email_authenticated IS NULL);
         */
        $res = $this->dbObj->select(
                'wikicities.user',
                array( 'user_id' ),
                array( 'user_email_authenticated is not null' ),
                __METHOD__
         );
        
        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            $this->dbObj->update(
                'noreptemp.spamwikis',
                array( 'benchmark_2' => 0 ),
                array( 'city_id' => $oRow->city_id ),
                __METHOD__
            );
        }

        $res = $this->dbObj->select(
                'wikicities.city_list',
                array( 'city_id', 'city_dbname' ),
                array( 'city_last_timestamp' => '>= ' . F::app()->wg->specialSpamWikisLastUpdate ),
                __METHOD__,
                array()
        );

        while ( $oRow = $this->dbObj->fetchObject( $res ) ) {
            $tmpDbObj = F::app()->wf->getDb( DB_SLAVE, array(), $oRow->city_dbname );
            $pages = $tmpDbObj->selectRow(
                'page',
                'count(1) as cnt',
                array('page_namespace' => 0),
                __METHOD__,
                null
            );
            if ( is_object($pages) ) {
                $pages = $pages->cnt;
            }
            $this->dbObj->update(
                'noreptemp.spamwikis',
                array( 'benchmark_3' => (int) ( 5 >= $pages ) ),
                array( 'city_id' => $oRow->city_id ),
                __METHOD__,
                array()
            );
        }
        
        WikiFactory::setVarByName( 'wgSpecialSpamWikisLastUpdate', F::app()->wg->cityId , time(), 'SpecialSpamWikis update.' );
    }
}

$d = new SpecialSpamWikiCache(
        F::app()->wf->getDb( DB_MASTER, array(), 'stats' )
);

$d->updateCache();

exit( 0 );