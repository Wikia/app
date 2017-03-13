<?php
class TopTenViewer {

	private $app = null;

	public function __construxt() {
		$this->app = F::app();
	}

	private function getDb() {
		return $this->app->wf->GetDb( DB_SLAVE, array(), $this->app->wg->StatsDB );
	}

	private function getSharedDb() {
		return $this->app->wf->GetDB( DB_SLAVE, array(), $this->app->wg->ExternalSharedDB );
	}
}
