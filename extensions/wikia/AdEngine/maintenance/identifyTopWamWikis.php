<?php

/**
 * Script that identifies top WAM wikis and updates WikiFactory variable based on that
 *
 * @author Piotr Gabryjeluk <rychu@wikia-inc.com>
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

/**
 * Maintenance script class
 */
class IdentifyTopWamWikis extends Maintenance {

	const VAR_TO_SET = 'wgAdDriverWikiIsTop1000';
	const TOP_NUMBER_OF_WIKIS = 1000;

	private function getTopWamWikiIds( $count ) {
		$wamService = new WAMService();
		$inputOptions = [
			'limit' => $count,
			'sortColumn' => 'wam',
			'sortDirection' => 'DESC',
		];
		$wikis = $wamService->getWamIndex( $inputOptions )['wam_index'];

		$wikiIds = [];
		foreach ( $wikis as $wiki ) {
			$wikiIds[] = $wiki['wiki_id'];
		}

		return $wikiIds;
	}

	public function execute() {
		$wikiFactory = new WikiFactory();
		$varId = $wikiFactory->getVarIdByName( self::VAR_TO_SET );
		if ( $varId === false ) {
			throw new ErrorException( 'No such variable: ' . self::VAR_TO_SET );
		}

		$newTopWikiIds = $this->getTopWamWikiIds( self::TOP_NUMBER_OF_WIKIS );
		$oldTopWikiIds = array_keys( $wikiFactory->getListOfWikisWithVar( $varId, 'bool', '=', true ) );

		foreach ( $newTopWikiIds as $wikiId ) {
			if ( array_search( $wikiId, $oldTopWikiIds ) === false ) {
				$wikiFactory->setVarById( $varId, $wikiId, true, __METHOD__ );
				echo '+' . $wikiId . PHP_EOL;
			}
		}

		foreach ( $oldTopWikiIds as $wikiId ) {
			if ( array_search( $wikiId, $newTopWikiIds ) === false ) {
				$wikiFactory->removeVarById( $varId, $wikiId, __METHOD__ );
				echo '-' . $wikiId . PHP_EOL;
			}
		}
	}
}

$maintClass = "IdentifyTopWamWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );
