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
		$infoboxDom = $this->createInfoboxDom( $formatted );

		$inGroup = false;
		$currentGroupDom = null;

		foreach ( $xml->children() as $currentChildNode ) {
			$childNodeDom = dom_import_simplexml( $currentChildNode );

			if ( !$inGroup ) {
				if ( $currentChildNode->getName() !== 'header' ) {
					// regular non-group node
					$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $childNodeDom ) );
				} else {
					// header node starting a group; we create an empty group and append the current node (header) to it
					$currentGroupDom = $this->createGroupDom();
					$currentGroupDom->appendChild( $currentGroupDom->ownerDocument->importNode( $childNodeDom, true ) );
					$inGroup = true;
				}
			} else {
				if ( !in_array( $currentChildNode->getName(), [ 'header', 'title' ] ) ) {
					// regular node inside of a group
					$currentGroupDom->appendChild( $currentGroupDom->ownerDocument->importNode( $childNodeDom, true ) );
				} elseif ( $currentChildNode->getName() === 'header' ) {
					// header node starting a group

					// we close the current group and append it to the infobox dom...
					$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $currentGroupDom ) );

					// and initialize a new group
					$currentGroupDom = $this->createGroupDom();
					$currentGroupDom->appendChild( $currentGroupDom->ownerDocument->importNode( $childNodeDom, true ) );
				} else {
					// title node, terminating the group and returning to regular flow
					$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $currentGroupDom ) );
					$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $childNodeDom ) );
					$inGroup = false;
				}

			}
		}

		// make sure to add the last unterminated group
		if ( !empty( $currentGroupDom ) && $inGroup ) {
			$infoboxDom->appendChild( $this->importNodeToDom( $infoboxDom, $currentGroupDom ) );
		}

		$out = $infoboxDom->ownerDocument->saveXML( $infoboxDom->ownerDocument->documentElement );
		libxml_clear_errors();

		return $out;
	}

	/**
	 * Deep imports a domNode to a document
	 * @param $domDocument
	 * @param $childNodeDom
	 * @return mixed
	 */
	protected function importNodeToDom( $domDocument, $childNodeDom ) {
		return $domDocument->ownerDocument->importNode( $childNodeDom, true );
	}

	/**
	 * @return DOMElement
	 */
	protected function createGroupDom() {
		return dom_import_simplexml(
			new SimpleXMLElement( '<' . \Wikia\PortableInfoboxBuilder\Nodes\NodeGroup::XML_TAG_NAME . '/>' )
		);
	}

	/**
	 * @param $formatted make the document human-readable (true) or condensed (false)
	 * @return DOMElement
	 */
	protected function createInfoboxDom( $formatted ) {
		// make the output document human-readable (formatted) or condensed (no additional whitespace)
		$newXml = new SimpleXMLElement( '<' . PortableInfoboxParserTagController::PARSER_TAG_NAME . '/>' );
		$infoboxDom = dom_import_simplexml( $newXml );
		$infoboxDom->ownerDocument->formatOutput = $formatted;
		return $infoboxDom;
	}
}
