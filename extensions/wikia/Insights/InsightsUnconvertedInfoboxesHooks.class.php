<?php

class InsightsUnconvertedInfoboxesHooks {
	static public function onUnconvertedInfoboxesQueryRecached() {
		F::app()->wg->Memc->delete( wfMemcKey( ApiQueryUnconvertedInfoboxes::MCACHE_KEY ) );
		return true;
	}
}
