<?php
/*
 * Author: Inez Korczynski
 */

if (!defined('MEDIAWIKI')) {
	die();
}

class WikiaApiBlogs extends ApiBase {

	public function __construct($main, $action) {
		parent :: __construct($main, $action);
	}

	public function execute() {
		global $wgParser ;
		$summarylength = $page_id = null;

		extract($this->extractRequestParams());
		
		$params = array(
		  "type" => "array",
		  "timestamp" => true,
		  "summary" => true,
		  "summarylength" => (int) $summarylength,
		);
			
		$cats = BlogTemplateClass::parseTag( "<pages>".((int) $page_id)."</pages>", $params, $wgParser );
		
		if ( empty($cats) ) {
			$cats = array();
		}
		
		foreach ( $cats as $page_id => $cat ) {
			if ( !empty($cat['category'] ) ) {
				$this->getResult()->setIndexedTagName($cats[$page_id]['category'], 'cat_url');				
			}
		}

		$this->getResult()->setIndexedTagName($cats, 'id');
		$this->getResult()->addValue(null, 'blogpage', $cats);
	}

	public function getAllowedParams() {
		return array (
			'page_id' => null,
			'summarylength' => null,
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: WikiaApiBlogs.php 17065 2006-10-17 02:11:29Z yurik $';
	}
}
