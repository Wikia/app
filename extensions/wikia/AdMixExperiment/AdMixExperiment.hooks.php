<?php

class AdMixExperimentHooks {
	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'ad_mix_experiment_js' );
		\Wikia::addAssetsToOutput( 'ad_mix_experiment_scss' );

		return true;
	}

}
