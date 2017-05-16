<?php

class AdMixExperimentHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		\Wikia::addAssetsToOutput( 'ad_mix_experiment' );

		return true;
	}

}
