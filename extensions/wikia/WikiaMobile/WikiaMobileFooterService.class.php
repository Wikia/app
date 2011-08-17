<?php
/**
 * WikiaMobile Footer
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 */
class WikiaMobileFooterService extends WikiaService {
				
	public function index() {
		$this->ads = $this->sendRequest( 'WikiaMobileAdService', 'index')->toString();
	}
}