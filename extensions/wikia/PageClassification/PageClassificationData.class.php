<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * Date: 02.07.13 11:10
 *
 */

class PageClassificationData {


	/**
	 *	Get list of wiki that have classified pages
	 */
	public function getWikiList() {

		$api = new EntityAPIClient();
		$api->setLogLevel( 5 );	
		$response = $api->get( $api->getIndexedWikisEndpoint() );
		$list = array();

		if ( is_array( $response['response'] ) ) {
			$wikis = WikiFactory::getWikisByID( $response['response'] );
			foreach ( $wikis as $wiki ) {
				$list[] = array( 'domain' => $wiki->city_url, 'wikiId' => $wiki->city_id );
			}
		}

		return $list;
	}

	public function getClassifiedArticles() {

		//TODO: STUB
		return array(
			array( 'domain' => 'harrypotter.wikia.com', 'articleId' => 111, 'articleTitle' => 'Harry_Potter', 'entityName' => 'Harry Potter', 'type' => 'Character' )
		);
	}

}