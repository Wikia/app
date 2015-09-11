<?php
class WikiaIFrameTagBuilderHelper extends WikiaTagBuilderHelper {

	public function isMobileSkin( ) {
		return F::app()->checkSkin( 'wikiamobile' );
	}

	public function wrapForMobile( $iframe ) {
		return $this->isMobileSkin() ?
			Html::rawElement( 'script',  ['type' => 'x-wikia-widget'], $iframe ) :
			$iframe;
	}
}
