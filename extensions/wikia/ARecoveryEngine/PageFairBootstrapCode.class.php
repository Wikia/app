<?php
class PageFairBootstrapCode {

	public static $recoverableSlots = [
		'TOP_LEADERBOARD' => 1,
		'TOP_RIGHT_BOXAD' => 1
	];
	private $resourceLoader = null;

	public function __construct() {
		$this->resourceLoader = new ResourceLoaderAdEnginePageFairRecoveryModule();
	}

	public function getHeadCode() {
		return $this->resourceLoader->getScriptObserver();
	}

	public function getTopBodyCode() {
		return $this->resourceLoader->getScriptWrapper();
	}

	public function getBottomBodyCode() {
		return $this->resourceLoader->getScriptLoader();
	}

	public static function getSlotMarker( $slotName ) {
		if ( isset( static::$recoverableSlots[ $slotName ] ) ) {
			return ' adonis­-marker';
		}
		return '';
	}
}
