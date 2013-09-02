<?php

require_once( dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

require_once( dirname( __FILE__ ) . '/Query_A.class.php' );
require_once( dirname( __FILE__ ) . '/Query_B.class.php' );
require_once( dirname( __FILE__ ) . '/Query_C.class.php' );

$top100WikisBySize = [23556,43339,11557,83063,64030,10171,12716,11845,32379,547090,74842,95,40,2233,147,51687,103977,490,100562,2237,324,30696,4486,2311,2148,98707,119971,39089,2510,52285,1763,60540,110714,131376,3355,323,1657,24816,113,644,125,20,38322,989,4184,119902,280741,416886,615,2751,48406,831,203773,67345,94117,73,4099,1562,1544,31618,196577,304,49812,114,99007,97596,58191,283,129529,984,7708,410,916,93888,44810,374,1706,4630,179,425,3156,2777,101751,2400,174,100073,26,117144,108788,674351,94047,93612,521442,3591,3035,7107,10167,1865,115251,49688];

class Performance extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addOption( "wikiIds", "The username to operate on", false, true );
		$this->mDescription = "Change a user's password";
	}

	/**
	 * @return Query_A[]
	 */
	protected function getVersionsToTest() {
		return [ new Query_A(), new Query_B(), new Query_C() ];
	}

	protected function getQueriesToTest() {
		return [ "fff", "ff", "lis", "john_pric", "mafasas_dfasdfasdf_dfasd"];
	}

	public function execute() {
		global $top100WikisBySize;
		$wikis = $this->getOption( "wikiIds", $top100WikisBySize );
		if( is_string($wikis) ) {
			$wikis = explode( ',', $wikis );
		}

		$linkSuggestVersions = $this->getVersionsToTest();

		foreach( $wikis as $wikiId ) {
			$db = WikiFactory::IDtoDB( $wikiId );
			if ( empty( $db ) ) { continue; }
			foreach( $this->getQueriesToTest() as $query ) {
				foreach( $linkSuggestVersions as $linkSuggestVersion ) {
					$time = $linkSuggestVersion->performQueryTest( $wikiId, $query );
					echo implode( ";", [$db, $linkSuggestVersion->getKey(), $query, $time] ) . "\n";
					usleep(300000);
				}
			}
		}
	}
}

$maintClass = "Performance";
require_once( DO_MAINTENANCE );
