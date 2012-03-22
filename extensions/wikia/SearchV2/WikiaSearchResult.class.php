<?php

class WikiaSearchResult {
	protected $id = 0;
	protected $cityId;
	protected $title;
	protected $text;
	protected $url;
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
		$this->text = $value;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($value) {
		$this->title = $value;
	}

	public function getUrl() {
		return $this->url;
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

}
