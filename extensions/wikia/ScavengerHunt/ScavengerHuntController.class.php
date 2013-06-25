<?php

/**
 * ScavengerHunt
 *
 * A ScavengerHunt extension for MediaWiki
 * Alows to create a scavenger hunt game on a wiki
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2011-06-03
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     include("$IP/extensions/wikia/ScavengerHunt/ScavengerHunt_setup.php");
 */

class ScavengerHuntController extends WikiaController {

	/**
	 * @brief returns full hunt datax
	 *
	 * @requestParam int $scavengerHuntHash
	 * @responseParam array $huntData
	 */

	public function getHuntData() {
		$helper = (new ScavengerHunt);
		$hash = $this->getVal( 'scavengerHuntHash', 0 );
		$huntData = array();

		if ( !$helper->isVersionValid( $hash ) ) {
			$huntData = $helper->generateFullInfo();
		}

		$articleIndex = $helper->articleHuntIndex( $this->getVal( 'currentArticleId' ) );
		$this->setVal( 'currentArticleIndex', $articleIndex );

		$huntData['foundArticlesIndexes'] = $helper->getFoundIndexes();

		$this->setVal( 'huntData', $huntData );
	}

	/**
	 * @brief action on found item.
	 * @details Somebody just found an scavengerHunt item.
	 *
	 * @responseParam array $huntData
	 */

	public function itemFound(){
		$helper = (new ScavengerHunt);
		//$hunterId = $helper->getHunterId();
		$articleTitle =  $this->getVal( 'articleTitle', '' );
		$huntData = array();

		if ( !empty( $articleTitle ) ){
			$helper = (new ScavengerHunt);
			$bSuccess = $helper->markItemAsFound( $articleTitle );
			if ( $bSuccess ){
				$huntData = $helper->generateFullInfo();
			}
		}

		$huntData['foundArticlesIndexes'] = $helper->getFoundIndexes();

		$this->setVal( 'huntData', $huntData );
	}

	/**
	 * @brief clears hunt progress.
	 * @details Clears memcache for ScavengerHunt. Used in starting new game.
	 *
	 * @responseParam array $huntData
	 */

	public function clearGameData(){
		$helper = (new ScavengerHunt);
		$helper->resetCache();
	}

	public function pushEntry() {
		$app = F::app();
		$helper = (new ScavengerHunt);
		$this->setVal(
			'result',
			$helper->pushEntry(
				$this->getVal( 'name', '' ),
				$this->getVal( 'email', '' ),
				$this->getVal( 'answer', '' )
			)
		);
	}

	public function getGameCacheValue() {
		$factory = (new ScavengerHuntGames);
		$gameId =  $this->getVal( 'gameId', '' );
		$readWrite =  $this->getVal( 'readwrite', 0 );
		$key = wfSharedMemcKey( 'ScavengerHuntGameIndex', $gameId, ( $readWrite ? 1 : 0 ), ScavengerHuntGames::CACHE_VERSION );

		$this->setVal(
			'key', $key
		);
		$this->setVal(
			'response', unserialize( $factory->getCache()->get( $key ) )
		);
	}

	public function getCurrentUserGameData(){
		$helper = (new ScavengerHunt);
		$this->setVal( 'key', $helper->getCacheKey() );
		$wgMemc = $this->app->getGlobal('wgMemc');
		$memcData = $wgMemc->get( $helper->getCacheKey() );
		$this->setVal( 'val', $memcData );
	}

	public function getHunterId(){
		// needed for overriding browser cache
		$user = $this->app->getGlobal('wgUser');
		$this->setVal(
			'name',
			( $user->isAnon() ) ? '' : $user->getName()
		);
	}
}
