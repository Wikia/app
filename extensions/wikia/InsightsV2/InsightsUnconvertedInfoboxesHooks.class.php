<?php

class InsightsUnconvertedInfoboxesHooks {
	static public function onUnconvertedInfoboxesQueryRecached() {
		F::app()->wg->Memc->delete( wfMemcKey( PortableInfoboxQueryService::MCACHE_KEY ) );
		return true;
	}
}
