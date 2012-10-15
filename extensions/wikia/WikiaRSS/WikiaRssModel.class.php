<?php 
class WikiaRssModel {
	static private $staticId = 1;
	private $id = 0;
	private $url = '';
	private $charset = '';
	private $maxheads = 5;
	private $short = false;
	private $reverse = false;
	private $dateFormat = false;
	private $highlight = array();
	private $filter = array();
	private $filterout = array();
	private $parseError = false;
	private $nojs = false;
	
	public function __construct($input) {
		$this->parseFields($input);
		$this->id = self::$staticId++;
	}
	
	/**
	 * @brief Returns a div with our class and short information
	 * 
	 * @return String
	 */
	public function getPlaceholder() {
		$output = '';
		$attrs = array();
		$attrs['data-id'] = $this->id;
		$attrs['class'] = 'wikiaRssPlaceholder';
		
		if( $this->parseError === false ) {
			$output = wfMsg('wikia-rss-placeholder-loading');
		} else {
			$output = wfMsg('wikia-rss-error-parse');
		}
		
		$output = Xml::element('div', $attrs, $output);
		
		return $output;
	}
	
	/**
	 * @brief Returns an array with attributes
	 * 
	 * @desc Attributes are parsed from user defined options and from the model itself
	 * 
	 * @return Array
	 */
	public function getRssAttributes() {
		$attrs = array();
		
		foreach(array('id', 'url', 'charset', 'maxheads', 'short', 'reverse', 'dateFormat', 'highlight', 'filter', 'filterout', 'nojs') as $attr) {
			$attrs[$attr] = $this->$attr;
		}
		
		//most of our messages are passed 
		//via php responses for ajax requests
		//this is the only exception
		$attrs['ajaxErrorMsg'] = wfMsg('wikia-rss-error-ajax-loading');
		
		return $attrs;
	}
	
	/**
	 * @brief Parses user's input and sets options of display
	 * 
	 * @param String $input user's defined options passed with <rss> parser tag
	 */
	private function parseFields($input) {
		$app = F::app();
		$fields = explode('|', $input);
		
		if( !empty($fields) ) {
			$this->url = $fields[0];
			
			$args = array();
			for($i=1; $i < sizeof($fields); $i++) {
				$f = $fields[$i];
				
				if( strpos($f, "=") === false ) {
					$args[strtolower(trim($f))] = false;
				} else {
					list($k, $v) = explode("=", $f, 2);
					if( trim($v) == false ) {
						$args[strtolower(trim($k))] = false;
					} else {
						$args[strtolower(trim($k))] = trim($v);
					}
				}
			}
			
			if( isset($args['charset']) ) {
				$this->charset = $args['charset'];
			} else {
				$this->charset = $app->wg->OutputEncoding;
			}
			
			if( isset($args['max']) ) {
				$this->maxheads = intval($args['max']);
			}
			$headcnt = 0;
			
			if( isset($args['short']) ) {
				$this->short = true;
			}
			
			if( isset($args['reverse']) ) {
				$this->reverse = true;
			}
			
			if( isset($args["date"]) ) {
				$this->dateFormat =  $args["date"];
				
				if( empty($this->dateFormat) ) {
				//TODO: maybe better is to get date format from user prefs?
					$this->dateFormat = wfMsg('wikia-rss-date-format');
				}
			}
			
			foreach(array('highlight', 'filter', 'filterout') as $option) {
				if( isset($args[$option]) ) {
					$this->$option = $args[$option];
					$this->$option = str_replace('  ', ' ', $this->$option);
					$this->$option = explode(' ', trim($this->$option));
				}
			}

			if( isset($args['nojs']) ) {
				$this->nojs = true;
			}
			
		} else {
			$this->parseError = true;
		}
	}
}