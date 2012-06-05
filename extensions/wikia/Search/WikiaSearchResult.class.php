<?php

class WikiaSearchResult {
	protected $id = 0;
	protected $cityId;
	protected $title;
	protected $titleObject;
	protected $thumbnail;
	protected $text;
	protected $url;
	protected $linkUrl;
	protected $canonical = null	;
	protected $vars = array();
	public $score = 0;

	public function __construct($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function getCityId() {
		return $this->cityId;
	}

	public function setCityId($value) {
		$this->cityId = $value;
	}

	public function getText() {
		return $this->text;
	}

	public function setText($value) {
	        $this->text = $this->fixSnippeting($value, true);
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($value) {
	       $this->title = $this->fixSnippeting($value);
	}

	public function getUrl() {
		return $this->url;
	}

	public function getLinkUrl() {

		if (!$this->linkUrl && $this->url) {
			$exploded = explode('/', $this->url);
			$parsed = parse_url($this->url); // can't just use this because it interprets plaintext ? as query string
			foreach ($exploded as $key=>$val)
			{
				if ($val == $parsed['scheme'].':' || $val == $parsed['host']) {
					continue;
				}
				$exploded[$key] = Parser::replaceUnusualEscapes(urlencode($val));
			}
			$this->linkUrl = implode('/', $exploded);
		}

		return $this->linkUrl;
	}

	public function setUrl($value) {
			$this->url = $value;
	}

	public function getCanonical() {
		return $this->canonical;
	}

	public function setCanonical($value) {
		$this->canonical = $value;
	}

	public function hasCanonical() {
		return !empty($this->canonical) ? true : false;
	}

	public function deCanonize() {
		$this->setTitle($this->getCanonical());
		$title = F::app()->wg->EnableCorporatePageExt 
				? GlobalTitle::newFromText($this->getCanonical(), $this->getVar('ns'), $this->cityId) 
				: Title::newFromText($this->getCanonical());
		$this->setUrl(urldecode($title->getFullUrl())); // required to normalize processing
		$this->setCanonical(null);
		return $this;
	}

	public function setScore($score) {
	  $this->score = $score;
	}

	public function getScore() {
	  return $this->score;
	}

	public function setVar($name, $value) {
		$this->vars[$name] = $value;
	}

	public function getVar($name, $default = null) {
		if(isset($this->vars[$name])) {
			return $this->vars[$name];
		}
		else {
			return $default;
		}
	}

	public function getVars() {
		return $this->vars;
	}

	private function fixSnippeting($text, $addEllipses=false) {
		$text = preg_replace('/^(span class="searchmatch">)/', '<$1', 
							preg_replace("/^[[:punct:]] ?/", '',
							preg_replace("/(<\/span>)('s)/i", '$2$1',
							preg_replace('/ +$/', '',
							preg_replace('/ ?\.{1,3}$/', '', 
							preg_replace('/ ?&hellip;$/', '',
							str_replace('�', '', $text)))))));
		return strlen($text) > 0 && $addEllipses 
				? preg_replace('/(<\/span)$/', '$1>', preg_replace('/[[:punct:]]+$/', '', $text)).'&hellip;' 
				: $text;

	}

	protected function getTitleObject() {
	  if (!isset($this->titleObject)) {
	    $this->titleObject = Title::makeTitle( $this->getVar('ns'), 
												preg_replace('/^'.MWNamespace::getCanonicalName($this->getVar('ns')).':/', 
															'', $this->title)
											 );
	  }

	  return $this->titleObject;
	}

	public function getThumbnail() {
	  if ((!isset($this->thumbnail)) && ($this->getVar('ns') == NS_FILE)) {
	    if ($img = wfFindFile($this->getTitleObject())) {
	      if ($thumb = $img->transform( array( 'width' => 120, 'height' => 120 ) )) {
		$this->thumbnail = $thumb;
	      }
	    }

	  }

	  return $this->thumbnail;

	}

}
