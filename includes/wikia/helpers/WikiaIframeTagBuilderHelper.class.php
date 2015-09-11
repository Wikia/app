<?php
class WikiaIframeTagBuilderHelper extends WikiaTagBuilderHelper {

	public function isMobileSkin( ) {
		return F::app()->checkSkin( [ 'wikiamobile', 'mercury' ] );
	}

	public function wrapForMobile( $iframe ) {
		return $this->isMobileSkin() ?
			Html::rawElement( 'script',  ['type' => 'x-wikia-widget'], $iframe ) :
			$iframe;
	}
}
