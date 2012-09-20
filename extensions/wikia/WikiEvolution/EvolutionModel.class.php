<?php

require_once ( '../../../maintenance/commandLine.inc' );
define("HOWMANYCATEGORIES", 150000);
define("CATEGORIESTOARTICLE", 30);


class EvolutionModel {

	private $wikiName;
	private $wikiColor;
	private $revisionsData;
	private $biggestCategories;
	private $articlesCache = array();
	private $downloadedAvatars = array();


	public function __construct($wgDBname) {
		$this->wikiName = $wgDBname ;
		$this->msg("Collecting Wiki's colors...");
		$this->setWikiColor();
		$this->msg("Collecting Wiki's logo...");
		$this->downloadWordmark();
		$this->msg("Collecting revisions data...");
		$this->loadRevisionsData();
		$this->msg("Collecting " . HOWMANYCATEGORIES . " biggest categories...");
		$this->loadBiggestCategories(HOWMANYCATEGORIES);
	}


	private function setWikiColor() {
		$wiki_colors = SassUtil::getOasisSettings();
		$wiki_color = substr($wiki_colors["color-buttons"], 1);
		$this->wikiColor = strtoupper($wiki_color);
	}


	private function downloadWordmark() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$wordmark = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());

		$folder_path = $this->wikiName ;
		if (!is_dir($folder_path)) {
			mkdir($folder_path, 0700);
		}
		$file_path = $folder_path . '/wordmark.png';
		if( file_exists($file_path) ) {
			system("rm " . $file_path);
		}
		file_put_contents( $file_path, Http::get($wordmark) );
		if( file_get_contents($file_path) == '' ) {
			system("rm " . $file_path);
			system("cp default_wordmark.png " . $file_path);
		}
	}


	private function loadRevisionsData() {
		global $wgExternalSharedDB;
		$db = wfGetDb(DB_SLAVE);
		$result = $db->select(
			array( 'r' => 'revision', 'page' ),
			array( 'r.rev_timestamp', 'r.rev_user_text', 'page.page_title', 'r.rev_minor_edit', 'r.rev_len', 'page.page_id' ),
			array(),
			__METHOD__,
			array ( 'ORDER BY' => 'r.rev_timestamp ASC' ),
			array ( 'page' => array('LEFT JOIN', 'r.rev_page=page.page_id') )
		);
		$this->revisionsData = $result;
	}


	private function loadBiggestCategories($how_much = 25) {
		$as = new ApiService;
		$params = array(
			"action" => "query",
			"list" => "querypage",
			"qppage" => "Mostpopularcategories",
			"qplimit" => $how_much
		);
		$res = $as->call( $params );

		$res_part = $res["query"]["querypage"]["results"];

		$categories = array();

		foreach( $res_part as $part ) {
			$categories[] = $part["title"];
		}								

		$this->biggestCategories = $categories;
	}


	public function formARow() {
		if( $row = $this->revisionsData->fetchObject() ) {
			$page_id = $row->page_id;
			$page_title = $row->page_title;
			$rev_len = $row->rev_len;
			$user_name = $row->rev_user_text;

			if( !( $this->checkIfArticleIsInCache($page_id) ) ) {
				if( !( $this->initializeCache($page_id, $page_title, $rev_len) ) ) {
					return 'skip';
				} else {
					$processedRow["action"] = 'added' ;
				}
			} else {
				if( !($this->atriclesCache[$page_id]["is_article"]) ) {
					return 'skip';
				} else {
					$processedRow["action"] = $this->updateCacheAndReturnAction($page_id, $rev_len, $row->rev_minor_edit);
				}
			}

			$processedRow["title"] = $page_title;

			$processedRow["color"] = $this->atriclesCache[$page_id]["actual_color"];
			$processedRow["category"] = $this->atriclesCache[$page_id]["category"];

			$processedRow["timestamp"] = wfTimestamp( TS_UNIX, $row->rev_timestamp);

			if( !( $this->isIp($user_name) ) ) {
				$processedRow["user_name"] = $user_name;
			} else {
				$processedRow["user_name"] = 'Anonym' ;
			}

			$this->getAvatar($processedRow["user_name"]);

			$processedRow["size"] = $rev_len;

			return $processedRow;
		} else {
			return NULL;
		}
	}


	private function checkIfArticleIsInCache($page_id) {
		if( isset( $this->atriclesCache[$page_id] ) ) {
			return true;
		} else {
			return false;
		}
	}


	private function initializeCache($page_id, $page_title, $rev_len) {
		if( !( $title = Title::newFromID( $page_id ) ) ) {
			$this->atriclesCache[$page_id]["is_article"] = false;
			return false;
		}
		if( $title->getNamespace() == NS_MAIN ) {
			$this->atriclesCache[$page_id]["is_article"] = true;
		} else {
			$this->atriclesCache[$page_id]["is_article"] = false;
			return false;
		}
		$this->atriclesCache[$page_id]["articles_length"] = $rev_len;
		$this->atriclesCache[$page_id]["actual_color"] = $this->wikiColor;
		$this->atriclesCache[$page_id]["category"] = $this->getAllCategoriesInOrder( $this->getArticlesCategories($page_title, $page_id) );
		return true;
	}


	private function updateCacheAndReturnAction($page_id, $rev_len, $minor_edit) {
		if( $this->atriclesCache[$page_id]["actual_color"] != "FFFFFF" ) {
			$this->atriclesCache[$page_id]["actual_color"] = $this->setColor( $minor_edit, $this->atriclesCache[$page_id]["actual_color"] );
		}
		if( $rev_len > $this->atriclesCache[$page_id]["articles_length"] ) {
			return "added" ;
		} else if ($rev_len < $this->atriclesCache[$page_id]["articles_length"]) {
			return 'deleted';
		} else {
			return 'modified';
		}
	}


	private function setColor($minor_edit, $actual_color) {

		$red = hexdec( substr($actual_color, 0, -4) );
		$green = hexdec( substr($actual_color, 2, -2) );
		$blue = hexdec( substr($actual_color, -2) );

		if ($minor_edit) {
			$converter = 50;
		} else {
			$converter = 100;
		}

		$red = $red + $converter;
		$green = $green + $converter;
		$blue = $blue + $converter;

		$red = $this->setLengthOfHexColorString( dechex($red), 2);
		$green = $this->setLengthOfHexColorString( dechex($green), 2);
		$blue = $this->setLengthOfHexColorString( dechex($blue), 2);

		$wiki_color = strtoupper($red . $green . $blue);

		return $wiki_color;
	}


	private function setLengthOfHexColorString($str, $len) {
		if( strlen($str) < $len ) {
			return str_pad($str, $len, "0", STR_PAD_LEFT);
		} else if( strlen($str) > $len ) {
			$result = '';
			for( $i=0; $i<$len; $i++) {
				$result = $result . "F";
			}
			return $result;
		} else {
			return $str;
		}
	}


	private function getArticlesCategories($page_title, $page_id) {
		$as = new ApiService;
		$params = array(
			"action" => "query",
			"prop" => "categories",
			"titles" => "$page_title"
		);
		$res = $as->call( $params );
		$res_part = $res["query"]["pages"];
		$filled_indexes = array_keys( $res_part );
		$categories = array();
		$part = $res_part[$filled_indexes[0]];
		if( $this->indexIsInArray("categories", $part) ) {
			$category = $part["categories"];

			foreach( $category as $cat ) {
				$splited = explode( ':', $cat["title"] );
				$categories[] = $splited[1];
			}
		}

		return $categories;
	} // end of getArticlesCategories method

/*
	private function getOneCategory($this_articles_categories) {
		$intersect_res = array_intersect( $this->biggestCategories, $this_articles_categories );
		if ($intersect_res != NULL) {
			foreach( $intersect_res as $intersect_element ) {
				if ($intersect_element) {
					return $intersect_element . '/' ;
				}
			}
		} else {
			return NULL;
		}
	}
*/

	private function getAllCategoriesInOrder($this_articles_categories) {
		$intersect_res = array_intersect( $this->biggestCategories, $this_articles_categories );
		if ($intersect_res != NULL) {
			$intersect_res = array_slice($intersect_res, 0);
			$result = '';
			foreach( $intersect_res as $element ) {
				if ($element) {
					$result = $result . $element . '/' ;
				}
			}
			return $result;
		} else {
			return NULL;
		}
	}


	private function getXCategoriesInOrder($this_articles_categories, $how_many) {
		$intersect_res = array_intersect( $this->biggestCategories, $this_articles_categories );
		if ($intersect_res != NULL) {
			$sliced_categs = array_slice($intersect_res, 0, $how_many);
			$result = '';
			foreach( $sliced_categs as $element ) {
					$result = $result . $element . '/' ;
			}
			return $result;
		} else {
			return NULL;
		}
	}

	
	private function getAvatar($user_name) {

		if( !($this->checkIfAvatarIsDownloaded($user_name)) ) {
			$folder_path = $this->wikiName ;
			if (!is_dir($folder_path)) {
				mkdir($folder_path, 0700);
			}
			$folder_path = $folder_path . '/avatars' ;
			if (!is_dir($folder_path)) {
				mkdir($folder_path, 0700);
			}
			$file_path = $folder_path . '/' . $user_name . '.png';
			if( !( file_exists($file_path) ) ) {
				$avatar = AvatarService::getAvatarurl($user_name, 50);
				file_put_contents($file_path, Http::get($avatar));
				$this->downloadedAvatars[$user_name] = true;
			}
		}
	}


	private function checkIfAvatarIsDownloaded($user_name) {
		if( isset( $this->downloadedAvatars[$user_name] ) ) {
			return true;
		} else {
			return false;
		}
	}


	private function indexIsInArray($index, $array) {
		$filled_indexes = array_keys( $array );
		if( in_array($index, $filled_indexes) ) {
			return true;
		} else {
			return false;
		}
	}


	private function isIp($str) {
		return filter_var($str, FILTER_VALIDATE_IP);
	}


	private function msg($msg) {
		print "\n".$msg . "\n";
	}




} // end of EvolutionModel class

