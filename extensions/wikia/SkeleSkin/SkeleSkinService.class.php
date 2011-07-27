<?php
class SkeleSkinService extends WikiaService {
	public function index() {
		$response = $this->sendRequest( 'SkeleSkinWikiHeaderService', 'index' )->toString();
		return false;
	}
}