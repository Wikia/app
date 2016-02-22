<?php

class PortableInfoboxBuilderService extends WikiaService {
	private $typesToCanonicals = [
		'row' => 'data',
		'section-header' => 'header'
	];

	/**
	 * @param $builderData string jsonencoded data object
	 * @param $formatted boolean default true - pass false to get XML without formatting spaces between nodes
	 * @return string
	 * @see PortableInfoboxBuilderServiceTest::translationsDataProvider
	 */
	public function translateDataToMarkup( $builderData, $formatted = true ) {
		$out = "";
		$infobox = json_decode( $builderData );

		if ( $infobox ) {
			$xml = $this->createInfoboxXml( $infobox );
			$out = $this->getFormattedMarkup( $xml, $formatted );
		}

		return $out;
	}

	/**
	 * @param $builderData
	 * @return array json_encoded array representing the infobox markup
	 * @see PortableInfoboxBuilderServiceTest::translationsDataProvider
	 */
	public function translateMarkupToData( $infoboxMarkup ) {
		$jsonObject = [ ];

		$xmlNode = simplexml_load_string( $infoboxMarkup );
		if ( $xmlNode ) {
			$builderNode = \Wikia\PortableInfoboxBuilder\Nodes\NodeBuilder::createFromNode( $xmlNode );
			$jsonObject = $builderNode->asJsonObject( $xmlNode );
		}

		return json_encode( $jsonObject );
	}

	/**
	 * @param $infoboxMarkup string with infobox markup
	 */
	public function isSupportedMarkup( $infoboxMarkup ) {
		$xmlNode = simplexml_load_string( $infoboxMarkup );
		if ( $xmlNode ) {
			$builderNode = \Wikia\PortableInfoboxBuilder\Nodes\NodeBuilder::createFromNode( $xmlNode );
			return $builderNode->isValid();
		}
		return false;
	}

	/**
	 * Determines whether provided array of infobox markups is supported by the builder
	 *
	 * @param $infoboxes
	 * @return bool
	 */
	public function isValidInfoboxArray( $infoboxes ) {
		return count( $infoboxes ) <= 1 && $this->isSupportedMarkup( $infoboxes[0] );
	}


	/**
	 *
	 * @param $infoboxMarkup
	 * @return string
	 */
	public function getDocumentation( $infoboxMarkup, $title ) {
		$infobox = \Wikia\PortableInfobox\Parser\Nodes\NodeFactory::newFromXML( $infoboxMarkup );

		return ( new Wikia\Template\PHPEngine() )
			->setPrefix( dirname( dirname( __FILE__ ) ) . '/templates' )
			->setData( [
				'title' => $title->getText(),
				'sources' => $infobox->getSource()
			] )
			->render( 'PortableInfoboxBuilderService_getDocumentation.php' );
	}

	/**
	 * replaces old infobox with new infobox within template content
	 *
	 * @param $oldInfobox
	 * @param $newInfobox
	 * @param $oldContent
	 *
	 * @return string
	 */
	public function updateInfobox( $oldInfobox, $newInfobox, $oldContent ) {
		return str_replace( $oldInfobox, $newInfobox, $oldContent );
	}

	/**
	 * replaces old infobox doc with new infobox doc within template content
	 *
	 * @param $oldDocumentation
	 * @param $newDocumentation
	 * @param $oldContent
	 *
	 * @return string
	 */
	public function updateDocumentation( $oldDocumentation, $newDocumentation, $oldContent ) {
		return str_replace( $oldDocumentation, $newDocumentation, $oldContent );
	}

	protected function addGroupNode( $data, SimpleXMLElement $xml ) {
		foreach ( $data as $item ) {
			$type = $this->getCanonicalType( $item->type );

			$child = $xml->addChild( $type, is_string( $item->data ) ? (string)$item->data : null );
			if ( is_array( $item->data ) ) {
				$this->addGroupNode( $item->data, $child );
			} else {
				$this->addNode( $item, $child );
			}
		}
	}

	protected function addNode( $node, SimpleXMLElement $xml ) {
		if ( $node->source ) {
			$xml->addAttribute( 'source', $node->source );
		}

		foreach ( $node->data as $key => $value ) {
			if ( !$this->isEmptyNodeValue( $value ) ) {
				// map defaultValue to default, as its js reserved key word
				$key = strcasecmp( $key, 'defaultValue' ) == 0 ? 'default' : $key;

				if ( is_object( $value ) ) {
					$this->addNode( $value, $xml->addChild( $key ) );
				} else {
					$xml->addChild( $key, $value );
				}

			}
		}
	}

	/**
	 * return true if value should be treated as empty
	 *
	 * @param $value
	 * @return bool
	 */
	private function isEmptyNodeValue( $value ) {
		return ( empty( $value ) && $value != '0' );
	}

	/**
	 * @param $type string
	 * @return string
	 */
	protected function getCanonicalType( $type ) {
		mb_convert_case( $type, MB_CASE_LOWER, 'UTF-8' );
		$type = !empty($this->typesToCanonicals[$type]) ? $this->typesToCanonicals[$type] : $type;
		return $type;
	}

	/**
	 * @param $infobox
	 * @return SimpleXMLElement
	 */
	protected function createInfoboxXml( $infobox ) {
		$xml = new SimpleXMLElement( '<' . PortableInfoboxParserTagController::PARSER_TAG_NAME . '/>' );
		foreach ( $infobox as $key => $value ) {
			if ( $key !== 'data' ) {
				$xml->addAttribute( $key, $value );
			}
		}
		$this->addGroupNode( $infobox->data, $xml );
		return $xml;
	}

	/**
	 * @param $xml \SimpleXMLElement
	 * @param $formatted make the output document human-readable (true) or condensed (false)
	 * @param $newChild
	 * @return string
	 */
	protected function getFormattedMarkup( $xml, $formatted ) {
		$newXml = new SimpleXMLElement( '<' . PortableInfoboxParserTagController::PARSER_TAG_NAME . '/>' );
		// import to dom for processing and ability to remove <?xml document header
		$infoboxDom = dom_import_simplexml( $newXml );
		// make the output document human-readable (formatted) or condensed (no additional whitespace)
		$infoboxDom->ownerDocument->formatOutput = $formatted;

		$inGroup = false;
		$currentGroupDom = null;

		foreach ( $xml->children() as $currentChildNode ) {
			$childNodeDom = dom_import_simplexml( $currentChildNode );

			if ( !$inGroup ) {
				if ( $currentChildNode->getName() !== 'header' ) {
					$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $childNodeDom ) );
				} else {
					$currentGroupDom = $this->createGroupDom();
					$currentGroupDom->appendChild( $currentGroupDom->ownerDocument->importNode( $childNodeDom, true ) );
					$inGroup = true;
				}
			} else {
				if ( !in_array( $currentChildNode->getName(), [ 'header', 'title' ] ) ) {
					$currentGroupDom->appendChild( $currentGroupDom->ownerDocument->importNode( $childNodeDom, true ) );
				} else {
					if ( $currentChildNode->getName() === 'header' ) {
						$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $currentGroupDom ) );
						$currentGroupDom = $this->createGroupDom();
						$currentGroupDom->appendChild( $currentGroupDom->ownerDocument->importNode( $childNodeDom, true ) );
					} else {
						$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $currentGroupDom ) );
						$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $childNodeDom ) );
						$inGroup = false;
					}
				}
			}
		}

		if ( !empty( $newChild ) && $inGroup ) {
			$infoboxDom->appendChild( $infoboxDom->ownerDocument->importNode( $currentGroupDom, true ) );
		}

		$out = $infoboxDom->ownerDocument->saveXML( $infoboxDom->ownerDocument->documentElement );
		libxml_clear_errors();

		return $out;
	}

	/**
	 * @param $dom
	 * @param $childNodeDom
	 * @return mixed
	 */
	protected function importNodeToDom( $dom, $childNodeDom ) {
		return $dom->ownerDocument->importNode( $childNodeDom, true );
	}

	/**
	 * @return DOMElement
	 */
	protected function createGroupDom() {
		return dom_import_simplexml(
			new SimpleXMLElement( '<' . \Wikia\PortableInfoboxBuilder\Nodes\NodeGroup::XML_TAG_NAME . '/>' )
		);
	}
}
