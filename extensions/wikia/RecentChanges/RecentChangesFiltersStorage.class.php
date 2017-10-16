<?php

class RecentChangesFiltersStorage {
	private $user = null;
	function __construct(User $user){
		$app = F::App();
		$this->user = $user;
		$this->memc = $app->wg->Memc;
		$this->namespaces = wfGetNamespaces();
	}

	public function set( $values, $setToAll = false ) {
		if ( $setToAll ) {
			$new = [];
			$this->user->setGlobalPreference( 'RCFilters', null ); // Clear user option, so "all" will work on all wikis (CE-75)
		} else {
			$old = $this->get(false);
			$new = $this->buildUserOption($old, empty($values) ? array():$values );
			$this->user->setGlobalPreference('RCFilters', serialize($new) );
		}
		$this->setCache($new);
		$this->user->saveSettings();
		return $new;
	}

	public function get($onlyFromThisWiki = true) {
		$values = $this->getCache();
		if(is_null($values)) {
			$values = unserialize( $this->user->getGlobalPreference( 'RCFilters' ), [ 'allowed_classes' => false ] );
		}

		if(empty($values)) {
			//if nothing is selected we are selecting all
			return array_keys($this->namespaces);
		}

		if(!$onlyFromThisWiki) {
			return $values;
		}

		$out = array();
		foreach($values as $val) {
			if( isset($this->namespaces[$val])){
				$out[] = $val;
			}
		}

		if(empty($out)) {
			//if nothing is selected we are selecting all
			return array_keys($this->namespaces);
		}

		return $out;
	}

	protected function buildUserOption($old, $new) {
		$new = array_flip($new);

		if(empty($old)) {
			return $new;
		}

		foreach($old as $key => $value) {
			//check if this namespace is from other wiki
			if(!isset($this->namespaces[$value])) {
				$new[$value] = 1;
			}
		}
		return array_keys($new);
	}

	protected function setCache($values){
		$this->memc->set($this->getCacheKey(), $values, 24*60*60);
	}

	protected function getCache() {
		return $this->memc->get($this->getCacheKey(), null);
	}

	protected function getCacheKey() {
		return wfSharedMemcKey( __CLASS__, $this->user->getId());
	}
}
