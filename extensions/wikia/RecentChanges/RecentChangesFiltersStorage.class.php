<?php 

class RecentChangesFiltersStorage {
	private $user = null;
	function __construct(User $user){
		$app = F::App();
		$this->user = $user;
		$this->memc = $app->wg->Memc;
		$this->namespaces = $app->wf->GetNamespaces();
	}
	
	public function set($values){
		$old = $this->get(false);
		$new = $this->buildUserOption($old, $values);
		$this->user->setOption('RCFilters', serialize($new) );
		$this->setCache($new);
		$this->user->saveSettings();
		return $new;
	}
	
	public function get($onlyFromThisWiki = true) {
		$values = $this->getCache();
		if(empty($values)) {
			$values = unserialize( $this->user->getOption('RCFilters') );
		}
		
		if(!$onlyFromThisWiki) {
			return $values;
		}
		
		if(empty($values)) {
			return array();
		}
		
		$out = array();
		foreach($values as $val) {
			if(!empty($this->namespaces[$val])){
				$out[] = $val;	
			}
		}
		
		return $out;
	}
	
	public function getWithLabel($onlyFromThisWiki = true){
		$filters = array_flip($this->get($onlyFromThisWiki));
		$out = $this->namespaces;
		foreach($out as $key => $val) {
			if(empty($filters[$key])) {
				unset($out[$key]);
			} 
		}
		return $out;
	}
	
	protected function buildUserOption($old, $new) {
		if(empty($old)) {
			return $new;
		}
		
		$new = array_flip($new);
		$old = array_flip($old); 
		
		foreach($old as $key => $value) {
			//check if this namespace is from other wiki
			if(empty($this->namespaces[$key])) {
				$new[$value] = 1;
			}
		}
		
		return array_keys($new);
	}
	
	protected function setCache($values){
		$this->memc->set($this->getCacheKey(), $values, 24*60*60);
	}
	
	protected function getCache() {
		$this->memc->get($this->getCacheKey(), null);
	}
	
	protected function getCacheKey() {
		return wfSharedMemcKey( __CLASS__, $this->user->getId());
	}
}