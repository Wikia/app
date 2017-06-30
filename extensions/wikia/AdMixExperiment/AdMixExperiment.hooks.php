<?php

class AdMixExperimentHooks {
	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'ad_mix_experiment_js' );

		return true;
	}

}
