<?php
namespace Wikia\JsonFormat;

require_once 'JsonFormatWorker.setup.php';


class JsonFormatWorker {

	/** @var HtmlParser */
	protected $htmlParser;
	/** @var JsonFormatSimplifier */
	protected $service;
	protected $html;

	public function __construct() {
		$this->htmlParser = new HtmlParser(false);
		$this->htmlSimplifier = new JsonFormatSimplifier(false);
	}

	public function setHtml( $html ) {
		$this->html = $html;
	}

	public function process() {
		$text = '';
		if ( isset( $this->html ) ) {
			$jsonSimple = $this->htmlParser->parse( $this->html );
			$text = $this->htmlSimplifier->simplifyToSnippet( $jsonSimple );
		}
		return $text;
	}
}
