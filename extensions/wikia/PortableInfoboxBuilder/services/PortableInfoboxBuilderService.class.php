<?php

class PortableInfoboxBuilderService {
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
	 * @param $infoboxMarkup
	 * @return array representing the infobox markup
	 * @throws \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException
	 * @see PortableInfoboxBuilderServiceTest::translationsDataProvider
	 */
	public function translateMarkupToData( $infoboxMarkup ) {
		$jsonObject = new stdClass();
		$xmlNode = $this->getSimpleXml( $infoboxMarkup );

		if ( $xmlNode ) {
			$builderNode = \Wikia\PortableInfoboxBuilder\Nodes\NodeBuilder::createFromNode( $xmlNode );
			$jsonObject = $builderNode->asJsonObject( $xmlNode );
		}

		return $jsonObject;
	}

	/**
	 * @param $infoboxMarkup string with infobox markup
	 * @return bool
	 */
	public function isSupportedMarkup( $infoboxMarkup ) {
		$xmlNode = $this->getSimpleXml( $infoboxMarkup );

		if ( $xmlNode !== false ) {
			$builderNode = \Wikia\PortableInfoboxBuilder\Nodes\NodeBuilder::createFromNode( $xmlNode );
			return $builderNode->isValid();
		}
		return false;
	}

	/**
	 * Determines whether provided array of infobox markups is supported by the builder
	 * (no infoboxes here is also considered a valid option)
	 *
	 * @param $infoboxes
	 * @return bool
	 */
	public function isValidInfoboxArray( $infoboxes ) {
		return empty( $infoboxes ) || ( count( $infoboxes ) === 1 && $this->isSupportedMarkup( $infoboxes[ 0 ] ) );
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
				'sources' => $infobox->getSources()
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

	private function addGroupNode( $data, SimpleXMLElement $xml ) {
		foreach ( $data as $item ) {
			$type = $this->getCanonicalType( $item->type );
			$child = $xml->addChild( $type, isset( $item->data ) && is_string( $item->data )
				? htmlspecialchars ( (string) $item->data )
				: null );
			$this->addNode( $item, $child );
		}
	}

	private function addNode( $node, SimpleXMLElement $xml ) {
		if ( property_exists( $node, 'source' ) ) {
			$xml->addAttribute( 'source', $node->source );
		}

		if ( $this->containsEnabledCollapsibleAttribute( $node ) ) {
			$xml->addAttribute( 'section_collapsible', true );
		}

		if ( $this->containsValidDataAttribute( $node ) ) {
			foreach ( $node->data as $key => $value ) {
				if ( !$this->isEmptyNodeValue( $value ) ) {
					// map defaultValue to default, as its js reserved key word
					$key = strcasecmp( $key, 'defaultValue' ) == 0 ? 'default' : $key;

					if ( is_object( $value ) ) {
						$this->addNode( $value, $xml->addChild( $key ) );
					} else {
						$xml->addChild( $key, htmlspecialchars( $value ));
					}
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
	private function getCanonicalType( $type ) {
		mb_convert_case( $type, MB_CASE_LOWER, 'UTF-8' );
		$type = !empty( $this->typesToCanonicals[ $type ] ) ? $this->typesToCanonicals[ $type ] : $type;
		return $type;
	}

	/**
	 * @param $infobox
	 * @return SimpleXMLElement
	 */
	private function createInfoboxXml( $infobox ) {
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
	 * @param $xml \SimpleXMLElement SimpleXML object representing the entire infobox in linear structure
	 * @param $formatted boolean make the output document human-readable (true) or condensed (false)
	 * @return string
	 */
	private function getFormattedMarkup( $xml, $formatted ) {
		$infoboxDom = $this->createInfoboxDom( $xml, $formatted );
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

					$collapsible = $this->isCollapsible( $currentChildNode );

					// this attribute is not supported in header tag
					$childNodeDom->removeAttribute( 'section_collapsible' );

					$currentGroupDom = $this->createGroupDom( $childNodeDom, $collapsible );

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

					$collapsible = $this->isCollapsible( $currentChildNode );

					// this attribute is not supported in header tag
					$childNodeDom->removeAttribute( 'section_collapsible' );

					// and initialize a new group
					$currentGroupDom = $this->createGroupDom( $childNodeDom, $collapsible );
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
	private function importNodeToDom( $domDocument, $childNodeDom ) {
		return $domDocument->ownerDocument->importNode( $childNodeDom, true );
	}

	/**
	 * @param $childNodeDom
	 * @param $collapsible boolean
	 * @return DOMElement
	 */
	private function createGroupDom( $childNodeDom, $collapsible ) {
		$groupElem = new SimpleXMLElement( '<' . \Wikia\PortableInfoboxBuilder\Nodes\NodeGroup::XML_TAG_NAME . '/>' );

		if ( $collapsible ) {
			$groupElem->addAttribute( 'collapse', 'open' );
		}

		$groupDom = dom_import_simplexml( $groupElem );
		$groupDom->appendChild( $groupDom->ownerDocument->importNode( $childNodeDom, true ) );
		return dom_import_simplexml( $groupElem );
	}

	private function isCollapsible( $node ) {
		return ( bool )$node[ 'section_collapsible' ];
	}

	/**
	 * @param $xml \SimpleXMLElement SimpleXML object representing the entire infobox in linear structure
	 * @param $formatted boolean make the document human-readable (true) or condensed (false)
	 * @return DOMElement
	 */
	private function createInfoboxDom( $xml, $formatted ) {
		// make the output document human-readable (formatted) or condensed (no additional whitespace)
		$newXml = new SimpleXMLElement( '<?xml version="1.0" encoding="utf-8"?><' . PortableInfoboxParserTagController::PARSER_TAG_NAME . '/>' );
		$infoboxDom = dom_import_simplexml( $newXml );
		$infoboxDom->ownerDocument->formatOutput = $formatted;

		// propagate the top infobox node attributes
		foreach ( $xml->attributes() as $attribute => $value ) {
			$infoboxDom->setAttribute( $attribute, $value );
		}

		return $infoboxDom;
	}

	/**
	 * @param $node
	 * @return bool
	 */
	private function containsValidDataAttribute( $node ) {
		return property_exists( $node, 'data' ) && ( is_array( $node->data ) || is_object( $node->data ) );
	}

	/**
	 * @param $node
	 * @return bool
	 */
	private function containsEnabledCollapsibleAttribute( $node ) {
		return property_exists( $node, 'collapsible' ) && $node->collapsible;
	}

	/**
	 * @param $infoboxMarkup
	 * @return SimpleXMLElement
	 */
	private function getSimpleXml( $infoboxMarkup ) {
		$global_libxml_setting = libxml_use_internal_errors();
		libxml_use_internal_errors( true );
		$xmlNode = simplexml_load_string( $infoboxMarkup );
		libxml_use_internal_errors( $global_libxml_setting );
		return $xmlNode;
	}
}
