<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * Date: 02.07.13 11:10
 *
 */

class PageClassificationData extends WikiaModel {


	/**
	 *	Get list of wiki that have classified pages
	 */
	public function getWikiList() {

		//TODO: STUB
		$wikis = array(
			array( 'domain' => 'callofduty.wikia.com', 'wikiId' => 123 ),
			array( 'domain' => 'harrypotter.wikia.com', 'wikiId' => 122 ),
		);

		return $wikis;
	}

	public function getClassifiedArticles() {

		//TODO: STUB
		return array(
			array( 'domain' => 'harrypotter.wikia.com', 'articleId' => 111, 'articleTitle' => 'Harry_Potter', 'entityName' => 'Harry Potter', 'type' => 'Character' )
		);
	}

}