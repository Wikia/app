<?php
class PortableInfoboxMarkupParserService extends WikiaService {

	protected $markup;
	protected $infoboxData;

	public function __construct($infoboxMarkupXML, $infoboxData) {
		$this->markup = $infoboxMarkupXML;
		$this->infoboxData = $infoboxData;
	}

	public function parse() {
		$infoboxParser = new Wikia\PortableInfobox\Parser\Parser( $this->infoboxData );
		$data = $infoboxParser->getDataFromNodes( $this->parseXMLString() );
		return $data;
	}

	protected function parseXMLString() {
		$xml = simplexml_load_string( $this->markup );
		return $xml;
	}
}
