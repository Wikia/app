<?php

class InsightsPagesWithoutInfoboxHooks {
	static public function onPagesWithoutInfoboxQueryRecached() {
		F::app()->wg->Memc->delete( wfMemcKey( ApiQueryPagesWithoutInfobox::MCACHE_KEY ) );
		return true;
	}
}
