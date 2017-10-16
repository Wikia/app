<?php
class WikiaIFrameTagBuilderHelper extends WikiaTagBuilderHelper {

	public function wrapForMobile( $iframe ) {
		return $this->isMobileSkin() ?
			Html::rawElement( 'script',  ['type' => 'x-wikia-widget'], $iframe ) :
			$iframe;
	}
}
