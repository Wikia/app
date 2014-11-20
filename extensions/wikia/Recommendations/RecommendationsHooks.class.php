<?php

class RecommendationsHooks {

	static public function onOutputPageBeforeHTML( OutputPage &$out, &$text ) {
		global $wgEnableRecommendationsExt;

		if ( !empty( $wgEnableRecommendationsExt ) && F::app()->checkSkin( 'venus' ) ) {
			$out->addModules( 'ext.wikia.recommendations' );
		}

		return true;
	}
}
