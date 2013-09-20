<?php
/**
 * User: artur
 * Date: 06.06.13
 * Time: 16:02
 */

class WikiPageCountServiceFactory {
	public function get( ) {
		$config = (new Wikia\Search\QueryService\Factory)->getSolariumClientConfig();
		return new WikiPageCountService( new Solarium_Client($config) );
	}
}
