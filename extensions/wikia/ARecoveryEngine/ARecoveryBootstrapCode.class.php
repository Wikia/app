<?php
class ARecoveryBootstrapCode {
	
	public static function getHeadBootstrapCode() {
		if ((new ARecoveryModule)->isPageFairRecoveryEnabled()) {
			$bootstrap = new PageFairBootstrapCode();
			return $bootstrap->getHeadCode();
		}
		return '<!-- Recovery bootstrap disabled / head -->';
	}
	
	//TODO: move sourcepoint bootstrap here
	public static function getTopBodyBootstrapCode() {
		if ((new ARecoveryModule)->isPageFairRecoveryEnabled()) {
			$bootstrap = new PageFairBootstrapCode();
			return $bootstrap->getTopBodyCode();
		}
		return '<!-- Recovery bootstrap disabled / top body -->';
	}
	
	public static function getBottomBodyBootstrapCode() {
		if ((new ARecoveryModule)->isPageFairRecoveryEnabled()) {
			$bootstrap = new PageFairBootstrapCode();
			return $bootstrap->getBottomBodyCode();
		}
		return '<!-- Recovery bootstrap disabled / bottom body -->';
	}
	
	public static function getSlotMarker( $slotName ) {
		if ((new ARecoveryModule)->isPageFairRecoveryEnabled()) {
			return PageFairBootstrapCode::getSlotMarker( $slotName );
		}
		return '';
	}
}
